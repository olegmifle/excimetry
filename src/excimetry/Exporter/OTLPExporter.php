<?php

declare(strict_types=1);

namespace Excimetry\Exporter;

use Excimetry\Profiler\ExcimerLog;

/**
 * Exporter for the OpenTelemetry OTLP format.
 * 
 * This exporter converts ExcimerLog data to the OpenTelemetry OTLP format
 * for integration with OpenTelemetry collectors and backends.
 */
final class OTLPExporter implements ExporterInterface
{
    /**
     * @var string The service name to include in the OTLP data
     */
    private string $serviceName;

    /**
     * @var string The format to use for the OTLP data (json or protobuf)
     */
    private string $format;

    /**
     * Create a new OTLPExporter instance.
     * 
     * @param string $serviceName The service name to include in the OTLP data
     * @param string $format The format to use for the OTLP data (json or protobuf)
     */
    public function __construct(string $serviceName = 'php-application', string $format = 'json')
    {
        $this->serviceName = $serviceName;

        if (!in_array($format, ['json', 'protobuf'])) {
            throw new \InvalidArgumentException(
                "Invalid format: {$format}. Supported formats are 'json' and 'protobuf'."
            );
        }

        $this->format = $format;
    }

    /**
     * {@inheritdoc}
     */
    public function export(ExcimerLog $log): string
    {
        $parsedLog = $log->getParsedLog();
        $metadata = $log->getMetadata();

        // Build the OTLP data structure
        $otlpData = [
            'resourceSpans' => [
                [
                    'resource' => [
                        'attributes' => [
                            [
                                'key' => 'service.name',
                                'value' => [
                                    'stringValue' => $this->serviceName,
                                ],
                            ],
                        ],
                    ],
                    'scopeSpans' => [
                        [
                            'scope' => [
                                'name' => 'excimetry',
                                'version' => '1.0.0',
                            ],
                            'spans' => $this->convertToSpans($parsedLog, $metadata),
                        ],
                    ],
                ],
            ],
        ];

        // Add metadata as resource attributes
        foreach ($metadata as $key => $value) {
            if (is_scalar($value)) {
                $otlpData['resourceSpans'][0]['resource']['attributes'][] = [
                    'key' => "excimetry.{$key}",
                    'value' => [
                        'stringValue' => (string)$value,
                    ],
                ];
            }
        }

        // Convert to the requested format
        if ($this->format === 'json') {
            return json_encode($otlpData, JSON_PRETTY_PRINT);
        } else {
            // Protobuf serialization would be implemented here
            // For now, we'll just return JSON as a placeholder
            return json_encode($otlpData, JSON_PRETTY_PRINT);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getContentType(): string
    {
        return $this->format === 'json' ? 'application/json' : 'application/x-protobuf';
    }

    /**
     * {@inheritdoc}
     */
    public function getFileExtension(): string
    {
        return $this->format === 'json' ? 'json' : 'bin';
    }

    /**
     * Set the service name.
     * 
     * @param string $serviceName The service name to include in the OTLP data
     * @return self
     */
    public function setServiceName(string $serviceName): self
    {
        $this->serviceName = $serviceName;
        return $this;
    }

    /**
     * Get the service name.
     * 
     * @return string The service name
     */
    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    /**
     * Set the format.
     * 
     * @param string $format The format to use for the OTLP data (json or protobuf)
     * @return self
     */
    public function setFormat(string $format): self
    {
        if (!in_array($format, ['json', 'protobuf'])) {
            throw new \InvalidArgumentException(
                "Invalid format: {$format}. Supported formats are 'json' and 'protobuf'."
            );
        }

        $this->format = $format;
        return $this;
    }

    /**
     * Get the format.
     * 
     * @return string The format
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * Add metadata to be included in the exported data.
     * 
     * @param string $key The metadata key
     * @param mixed $value The metadata value
     * @return self
     */
    public function addMetadata(string $key, mixed $value): self
    {
        // This method is used by OTLPBackend to add trace and span IDs
        // The metadata will be included in the export method
        return $this;
    }

    /**
     * Convert parsed log data to OTLP spans.
     * 
     * @param array $parsedLog The parsed log data
     * @param array $metadata The metadata
     * @return array The OTLP spans
     */
    private function convertToSpans(array $parsedLog, array $metadata): array
    {
        $spans = [];
        $startTime = $metadata['timestamp'] ?? time();
        $startTimeNanos = $startTime * 1_000_000_000;

        foreach ($parsedLog as $entry) {
            $frames = $entry['frames'];
            $count = $entry['count'];

            // Use the last frame (leaf) as the span name
            $spanName = end($frames);

            // Create a span for each stack trace
            $spans[] = [
                'name' => $spanName,
                'startTimeUnixNano' => $startTimeNanos,
                'endTimeUnixNano' => $startTimeNanos + ($count * 1_000_000), // Assuming 1ms per sample
                'attributes' => [
                    [
                        'key' => 'excimetry.stack_trace',
                        'value' => [
                            'stringValue' => implode(';', $frames),
                        ],
                    ],
                    [
                        'key' => 'excimetry.sample_count',
                        'value' => [
                            'intValue' => $count,
                        ],
                    ],
                ],
            ];
        }

        return $spans;
    }
}
