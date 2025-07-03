<?php

declare(strict_types=1);

namespace Excimetry\CLI;

use Excimetry\Profiler\ExcimerProfiler;
use Excimetry\Exporter\CollapsedExporter;
use Excimetry\Exporter\SpeedscopeExporter;
use Excimetry\Backend\FileBackend;

/**
 * Command-line tool for profiling PHP scripts.
 */
final class ProfileCommand
{
    /**
     * @var string The script to profile
     */
    private string $script;
    
    /**
     * @var array Command-line options
     */
    private array $options;
    
    /**
     * @var ExcimerProfiler The profiler instance
     */
    private ExcimerProfiler $profiler;
    
    /**
     * Create a new ProfileCommand instance.
     * 
     * @param string $script The script to profile
     * @param array $options Command-line options
     */
    public function __construct(string $script, array $options = [])
    {
        $this->script = $script;
        $this->options = $options;
        
        // Create the profiler
        $profilerOptions = [
            'period' => $options['period'] ?? 0.01,
            'mode' => $options['mode'] ?? 'wall',
        ];
        
        $this->profiler = new ExcimerProfiler($profilerOptions);
    }
    
    /**
     * Run the command.
     * 
     * @return int The exit code
     */
    public function run(): int
    {
        // Check if the script exists
        if (!file_exists($this->script)) {
            echo "Error: Script not found: {$this->script}\n";
            return 1;
        }
        
        // Start the profiler
        $this->profiler->start();
        
        // Run the script
        $exitCode = $this->runScript();
        
        // Stop the profiler
        $this->profiler->stop();
        
        // Get the profile
        $log = $this->profiler->getLog();
        
        // Save the profile
        $this->saveProfile($log);
        
        return $exitCode;
    }
    
    /**
     * Run the script.
     * 
     * @return int The exit code
     */
    private function runScript(): int
    {
        // Build the command
        $command = escapeshellcmd(PHP_BINARY) . ' ' . escapeshellarg($this->script);
        
        // Add any arguments
        if (isset($this->options['args'])) {
            $command .= ' ' . $this->options['args'];
        }
        
        // Run the command
        $exitCode = 0;
        passthru($command, $exitCode);
        
        return $exitCode;
    }
    
    /**
     * Save the profile.
     * 
     * @param mixed $log The profile log
     * @return void
     */
    private function saveProfile(mixed $log): void
    {
        // Determine the format
        $format = $this->options['format'] ?? 'speedscope';
        
        // Create the exporter
        $exporter = match ($format) {
            'collapsed' => new CollapsedExporter(),
            'speedscope' => new SpeedscopeExporter(),
            default => new SpeedscopeExporter(),
        };
        
        // Determine the output directory
        $outputDir = $this->options['output'] ?? 'profiles';
        
        // Create the backend
        $backend = new FileBackend($exporter, $outputDir);
        
        // Send the profile
        $result = $backend->send($log);
        
        if ($result) {
            echo "Profile saved to {$outputDir}\n";
        } else {
            echo "Error: Failed to save profile\n";
        }
    }
    
    /**
     * Parse command-line arguments.
     * 
     * @param array $argv Command-line arguments
     * @return array Parsed options
     */
    public static function parseArgs(array $argv): array
    {
        $script = null;
        $options = [];
        
        // Skip the first argument (the command name)
        array_shift($argv);
        
        // Parse the arguments
        $i = 0;
        while ($i < count($argv)) {
            $arg = $argv[$i];
            
            if (strpos($arg, '--') === 0) {
                // Option
                $option = substr($arg, 2);
                $value = true;
                
                // Check if the option has a value
                if (strpos($option, '=') !== false) {
                    [$option, $value] = explode('=', $option, 2);
                } elseif ($i + 1 < count($argv) && strpos($argv[$i + 1], '--') !== 0) {
                    // The next argument is the value
                    $value = $argv[$i + 1];
                    $i++;
                }
                
                $options[$option] = $value;
            } else {
                // Script
                $script = $arg;
                
                // Any remaining arguments are passed to the script
                $i++;
                if ($i < count($argv)) {
                    $options['args'] = implode(' ', array_slice($argv, $i));
                    break;
                }
            }
            
            $i++;
        }
        
        return [
            'script' => $script,
            'options' => $options,
        ];
    }
    
    /**
     * Display usage information.
     * 
     * @return void
     */
    public static function displayUsage(): void
    {
        echo "Usage: excimetry-profile [options] <script> [script-args]\n";
        echo "\n";
        echo "Options:\n";
        echo "  --period=<seconds>   Sampling period in seconds (default: 0.01)\n";
        echo "  --mode=<mode>        Profiling mode: wall or cpu (default: wall)\n";
        echo "  --format=<format>    Output format: speedscope or collapsed (default: speedscope)\n";
        echo "  --output=<dir>       Output directory (default: profiles)\n";
        echo "  --help               Display this help message\n";
    }
}