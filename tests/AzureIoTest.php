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
     * @depends testCopyandScanDirDownload
     */
    public function testDownloadUrl(){
        $azure = new AzureIO($this->config);
        $this->assertTrue($azure->copy('test','snowboard.txt','tests/test.txt'));
        $this->assertTrue($azure->copy('test','subdirectory/snowboard.txt','tests/test.txt'));
        $this->assertTrue($azure->downloadUrl($this->config['azure']['base_url'].'/test/snowboard.txt', 'tests/snowboard.txt'));
        $this->assertTrue($azure->downloadUrl($this->config['azure']['base_url'].'/test/subdirectory/snowboard.txt', 'tests/snowboard2.txt'));
        $this->assertTrue(file_exists('tests/snowboard2.txt'));
        $this->assertTrue(file_exists('tests/snowboard.txt'));
        unlink('tests/snowboard2.txt');
        unlink('tests/snowboard.txt');
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
    public function testUnlink(){
        $azure = new AzureIO($this->config);
        $this->assertTrue($azure->copy('test','dick.txt','tests/test.txt'));
        $this->assertTrue($azure->unlink('test', 'dick.txt'));
        
    }
    /**
     * @dataProvider mkdirProvider
     */
    public function testRmdir($dir,$access,$metadata){
        $azure = new AzureIO($this->config);
        $this->assertTrue($azure->rmdir('test'));
        $this->assertTrue($azure->rmdir('test2'));
        $this->assertTrue($azure->rmdir('test3'));
        
        $this->assertFalse($azure->mkdir($dir,$access,$metadata));
        
    }
    
    public function mkdirProvider() {
        return [
              ['test','cb',[]],
              ['test2','b',[]],
              ['test3','cb',['author'=>'Mauri']]
        ];
    }
}
