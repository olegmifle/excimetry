<?php

declare(strict_types=1);

namespace Excimetry\Tests\Unit\Exporter;

use Excimetry\Exporter\SpeedscopeExporter;
use Excimetry\Profiler\ExcimerLog;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the SpeedscopeExporter class.
 */
final class SpeedscopeExporterTest extends TestCase
{
    /**
     * Sample raw log data for testing.
     */
    private const SAMPLE_RAW_LOG = <<<EOT
main;App\Controller\HomeController;index 1
main;App\Service\ReportGenerator;generate;render 2
main;App\Service\ReportGenerator;generate;Database\QueryBuilder;run 3
EOT;

    /**
     * Test exporting with default options.
     */
    public function testExportWithDefaults(): void
    {
        $log = new ExcimerLog(self::SAMPLE_RAW_LOG);
        $exporter = new SpeedscopeExporter();
        
        $result = $exporter->export($log);
        
        // Decode the JSON to check its structure
        $data = json_decode($result, true);
        
        // Check the basic structure
        $this->assertIsArray($data);
        $this->assertArrayHasKey('version', $data);
        $this->assertArrayHasKey('shared', $data);
        $this->assertArrayHasKey('profiles', $data);
        $this->assertArrayHasKey('activeProfileIndex', $data);
        $this->assertArrayHasKey('exporter', $data);
        
        // Check the profile name
        $this->assertArrayHasKey('name', $data['profiles'][0]);
        $this->assertSame('Excimer Profile', $data['profiles'][0]['name']);
    }
    
    /**
     * Test exporting with a custom profile name.
     */
    public function testExportWithCustomProfileName(): void
    {
        $log = new ExcimerLog(self::SAMPLE_RAW_LOG);
        $exporter = new SpeedscopeExporter('Custom Profile Name');
        
        $result = $exporter->export($log);
        
        // Decode the JSON to check its structure
        $data = json_decode($result, true);
        
        // Check the profile name
        $this->assertArrayHasKey('name', $data['profiles'][0]);
        $this->assertSame('Custom Profile Name', $data['profiles'][0]['name']);
    }
    
    /**
     * Test setting and getting the profile name.
     */
    public function testSetAndGetProfileName(): void
    {
        $exporter = new SpeedscopeExporter();
        $this->assertSame('Excimer Profile', $exporter->getProfileName());
        
        $exporter->setProfileName('New Profile Name');
        $this->assertSame('New Profile Name', $exporter->getProfileName());
    }
    
    /**
     * Test getting the content type.
     */
    public function testGetContentType(): void
    {
        $exporter = new SpeedscopeExporter();
        $this->assertSame('application/json', $exporter->getContentType());
    }
    
    /**
     * Test getting the file extension.
     */
    public function testGetFileExtension(): void
    {
        $exporter = new SpeedscopeExporter();
        $this->assertSame('json', $exporter->getFileExtension());
    }
    
    /**
     * Test exporting an empty log.
     */
    public function testExportEmptyLog(): void
    {
        $log = new ExcimerLog('');
        $exporter = new SpeedscopeExporter();
        
        $result = $exporter->export($log);
        
        // Decode the JSON to check its structure
        $data = json_decode($result, true);
        
        // Check the basic structure
        $this->assertIsArray($data);
        $this->assertArrayHasKey('version', $data);
        $this->assertArrayHasKey('shared', $data);
        $this->assertArrayHasKey('profiles', $data);
        
        // Check that the frames array is empty
        $this->assertEmpty($data['shared']['frames']);
        
        // Check that the events array is empty
        $this->assertEmpty($data['profiles'][0]['events']);
    }
    
    /**
     * Test that the exported JSON is valid.
     */
    public function testExportedJsonIsValid(): void
    {
        $log = new ExcimerLog(self::SAMPLE_RAW_LOG);
        $exporter = new SpeedscopeExporter();
        
        $result = $exporter->export($log);
        
        // Decode the JSON to check that it's valid
        $data = json_decode($result, true);
        
        $this->assertNotNull($data);
        $this->assertIsArray($data);
    }
    
    /**
     * Test that the exported JSON includes metadata.
     */
    public function testExportedJsonIncludesMetadata(): void
    {
        $metadata = ['foo' => 'bar', 'baz' => 'qux'];
        $log = new ExcimerLog(self::SAMPLE_RAW_LOG, $metadata);
        $exporter = new SpeedscopeExporter();
        
        $result = $exporter->export($log);
        
        // Decode the JSON to check that it includes the metadata
        $data = json_decode($result, true);
        
        $this->assertArrayHasKey('metadata', $data);
        $this->assertSame($metadata, $data['metadata']);
    }
}