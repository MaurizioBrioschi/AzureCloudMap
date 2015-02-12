<?php
use ridesoft\AzureCloudMap\AzureIO;

/**
 * Description of AzureIoTest
 *
 * @author maurizio brioschi <maurizio.brioschi@ridesoft.org>
 */
class AzureIoTest extends PHPUnit_Framework_TestCase{
    protected $config;
    
    protected function setUp() {
        $this->config = require 'src/config/config.php';     
    }
    /**
     * @dataProvider mkdirProvider
     */
    public function testMkdir($dir,$access,$metadata) {
        $azure = new AzureIO($this->config);
        $this->assertTrue($azure->mkdir($dir,$access,$metadata));
    }
    /**
     * @depends testMkdir
     */
    public function testCopyandScanDirDownload()  {
        $azure = new AzureIO($this->config);
        $this->assertTrue($azure->copy('test','skate.txt','tests/test.txt'));
        $objects = $azure->scandir('test');
        $this->assertGreaterThan(0, count($objects));
        $this->assertTrue($azure->download('test','skate.txt','tests/destroy.txt'));
        $this->assertTrue(file_exists('tests/destroy.txt'));
        unlink('tests/destroy.txt');
    }
    
    /**
     * @dataProvider mkdirProvider
     */
    public function testMkdirFail($dir,$access,$metadata) {
        $azure = new AzureIO($this->config);
        $this->assertFalse($azure->mkdir($dir,$access,$metadata));
    }
    /**
     * @depends testCopyandScanDirDownload
     */
    public function unlink($dir, $file){
        $azure = new AzureIO($this->config);
        $azure->unlink('test', 'skate.txt');
        $objects = $azure->scandir('test');
        $this->assertEquals(0, count($objects));
    }
    /**
     * @dataProvider mkdirProvider
     */
    public function rmdir($dir){
        $azure = new AzureIO($this->config);
        $azure->rmdir($dir);
    }
    
    public function mkdirProvider() {
        return [
              ['test','cb',[]],
              ['test2','b',[]],
              ['test3','cb',['author'=>'Mauri']]
        ];
    }
}
