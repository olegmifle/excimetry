<?php

declare(strict_types=1);

namespace Excimetry\Backend;

use Excimetry\Profiler\ExcimerLog;
use Excimetry\Exporter\ExporterInterface;

/**
 * Backend for sending profile data to a remote server via HTTP.
 */
class HttpBackend extends AbstractBackend
{
    /**
     * @var string The URL to send the data to
     */
    private string $url;

    /**
     * @var array Additional headers to include in the request
     */
    private array $headers = [];

    /**
     * @var int The timeout for the request in seconds
     */
    private int $timeout = 30;

    /**
     * Create a new HttpBackend instance.
     * 
     * @param ExporterInterface $exporter The exporter to use
     * @param string $url The URL to send the data to
     * @param array $headers Additional headers to include in the request
     */
    public function __construct(
        ExporterInterface $exporter,
        string $url,
        array $headers = []
    ) {
        parent::__construct($exporter);

        $this->url = $url;
        $this->headers = $headers;
    }

    /**
     * {@inheritdoc}
     */
    public function send(ExcimerLog $log): bool
    {
        if ($this->async) {
            // Send asynchronously
            $this->sendAsync($log);
            return true;
        }

        return $this->sendWithRetries($log);
    }

    /**
     * {@inheritdoc}
     */
    protected function doSend(ExcimerLog $log): bool
    {
        // Export the data
        $data = $this->exporter->export($log);

        // Set up the request
        $ch = curl_init($this->url);

        // Set the headers
        $headers = array_merge([
            'Content-Type: ' . $this->exporter->getContentType(),
            'Content-Length: ' . strlen($data),
        ], $this->headers);

        // Set the options
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->timeout,
        ]);

        // Execute the request
        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        // Close the connection
        curl_close($ch);

        // Check for errors
        if ($response === false) {
            error_log("HTTP request failed: {$error}");
            return false;
        }

        // Check the status code
        if ($statusCode < 200 || $statusCode >= 300) {
            error_log("HTTP request failed with status code {$statusCode}: {$response}");
            return false;
        }

        return true;
    }

    /**
     * Send the profile data asynchronously.
     * 
     * @param ExcimerLog $log The profile data to send
     */
    protected function sendAsync(ExcimerLog $log): void
    {
        // Export the data
        $data = $this->exporter->export($log);

        // Build the command
        $command = $this->buildCurlCommand($data);

        // Execute the command in the background
        $this->executeInBackground($command);
    }

    /**
     * Build the curl command for sending the data.
     * 
     * @param string $data The data to send
     * @return string The curl command
     */
    private function buildCurlCommand(string $data): string
    {
        // Escape the data for the shell
        $escapedData = escapeshellarg($data);

        // Build the headers
        $headers = array_merge([
            'Content-Type: ' . $this->exporter->getContentType(),
        ], $this->headers);

        $headerArgs = '';
        foreach ($headers as $header) {
            $headerArgs .= ' -H ' . escapeshellarg($header);
        }

        // Build the command
        return "curl -X POST{$headerArgs} -d {$escapedData} " . escapeshellarg($this->url);
    }

    /**
     * Execute a command in the background.
     * 
     * @param string $command The command to execute
     */
    private function executeInBackground(string $command): void
    {
        if (PHP_OS_FAMILY === 'Windows') {
            pclose(popen("start /B {$command} >NUL 2>NUL", 'r'));
        } else {
            exec("{$command} >/dev/null 2>&1 &");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isAvailable(): bool
    {
        // Check if the URL is reachable
        $ch = curl_init($this->url);

        curl_setopt_array($ch, [
            CURLOPT_NOBODY => true,
            CURLOPT_TIMEOUT => 5,
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result !== false;
    }

    /**
     * Set the URL to send the data to.
     * 
     * @param string $url The URL
     * @return self
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Get the URL to send the data to.
     * 
     * @return string The URL
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Set the headers to include in the request.
     * 
     * @param array $headers The headers
     * @return self
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * Get the headers to include in the request.
     * 
     * @return array The headers
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Set the timeout for the request.
     * 
     * @param int $timeout The timeout in seconds
     * @return self
     */
    public function setTimeout(int $timeout): self
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * Get the timeout for the request.
     * 
     * @return int The timeout in seconds
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }
}
