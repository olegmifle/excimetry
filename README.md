# Excimetry

Excimetry is a PHP profiling library that provides a bridge between the ext-excimer extension and OpenTelemetry. It offers a simple and flexible way to profile PHP applications and export the results to various formats and backends.

## Features

- **Simple Configuration**: Easy setup with sensible defaults
- **Flexible Profiling**: Control when and how profiling happens
- **Multiple Export Formats**:
  - Collapsed format (for flamegraph tools)
  - Speedscope JSON (for interactive flame graphs)
  - OpenTelemetry OTLP (for integration with observability platforms)
- **Multiple Backends**:
  - Local file storage
  - HTTP/GRPC export to OpenTelemetry Collector
  - Pyroscope integration
- **OpenTelemetry Integration**: Connect profiles with traces and metrics
- **Command-line Tools**: Profile PHP scripts from the command line

## Requirements

- PHP 8.2 or higher
- ext-excimer extension

## Installation

```bash
composer require excimetry/excimetry
```

To use the command-line tool globally:

```bash
composer global require excimetry/excimetry
```

## Basic Usage

```php
use Excimetry\Profiler\ExcimerProfiler;
use Excimetry\Exporter\SpeedscopeExporter;
use Excimetry\Backend\FileBackend;

// Create a profiler
$profiler = new ExcimerProfiler([
    'period' => 0.01, // 10ms sampling period
    'mode' => 'wall',  // Wall time profiling
]);

// Start profiling
$profiler->start();

// Your code to profile here
// ...

// Stop profiling
$profiler->stop();

// Get the profile
$log = $profiler->getLog();

// Export to speedscope format and save to a file
$exporter = new SpeedscopeExporter('My Profile');
$backend = new FileBackend($exporter, 'profiles');
$backend->send($log);
```

## Command-line Profiling

Profile a PHP script from the command line:

```bash
excimetry-profile --period=0.01 --format=speedscope path/to/script.php
```

Options:
- `--period=<seconds>`: Sampling period in seconds (default: 0.01)
- `--mode=<mode>`: Profiling mode: wall or cpu (default: wall)
- `--format=<format>`: Output format: speedscope or collapsed (default: speedscope)
- `--output=<dir>`: Output directory (default: profiles)
- `--help`: Display help message

## OpenTelemetry Integration

```php
use Excimetry\OpenTelemetry\OpenTelemetryIntegration;

// Create an integration with the OpenTelemetry Collector
$integration = OpenTelemetryIntegration::create(
    'http://localhost:4318', // OpenTelemetry Collector URL
    'my-service'             // Service name
);

// Start profiling
$integration->start();

// Your code to profile here
// ...

// Stop profiling and send to OpenTelemetry
$integration->stop();
```

## Pyroscope Integration

```php
use Excimetry\Profiler\ExcimerProfiler;
use Excimetry\Exporter\CollapsedExporter;
use Excimetry\Backend\PyroscopeBackend;

// Create a profiler
$profiler = new ExcimerProfiler();

// Start profiling
$profiler->start();

// Your code to profile here
// ...

// Stop profiling
$profiler->stop();

// Get the profile
$log = $profiler->getLog();

// Send to Pyroscope
$exporter = new CollapsedExporter();
$backend = new PyroscopeBackend(
    'http://localhost:4040', // Pyroscope server URL
    'my-application',        // Application name
    ['env' => 'production']  // Labels
);
$backend->send($log);
```

## Advanced Usage

### Custom Metadata

```php
$profiler = new ExcimerProfiler();
$profiler->addMetadata('version', '1.0.0');
$profiler->addMetadata('environment', 'production');
```

### Async Export

```php
$backend = new HttpBackend($exporter, 'http://example.com/profiles');
$backend->setAsync(true);
$backend->send($log); // Returns immediately, sends in background
```

### Retry Configuration

```php
$backend = new HttpBackend($exporter, 'http://example.com/profiles');
$backend->setRetryConfig(5, 1000); // 5 retries, 1 second delay
$backend->send($log);
```

## License

This project is licensed under the Apache License 2.0 - see the LICENSE file for details.