<?php
use ridesoft\AzureCloudMap\AzureIO;
use ridesoft\AzureCloudMap\AzureUrl;

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
    
    public function testCopyDir()   {
        $azure = new AzureIO($this->config);
        $this->assertTrue($azure->CopyDir('test', 'tests/copyDir'));
    }
    
    /**
     * @depends testMkdir
     */
    public function testCopyandScanDirDownload()  {
        $azure = new AzureIO($this->config);
        $this->assertTrue($azure->copy('test','skate.txt','tests/test.txt'));
        $objects = $azure->scandir('test');
        $this->assertGreaterThan(0, count($objects));
        $this->assertTrue($azure->getBlob('test','skate.txt','tests/destroy.txt'));
        $this->assertTrue(file_exists('tests/destroy.txt'));
        unlink('tests/destroy.txt');
    }
    /**
     * @depends testCopyandScanDirDownload
     */
    public function testRename()    {
        $azure = new AzureIO($this->config);
        $this->assertTrue($azure->rename('test/skate.txt', 'belfalu.txt'));
        $this->assertTrue($azure->getBlob('test','belfalu.txt','tests/ziotom.txt'));
        $this->assertTrue(file_exists('tests/ziotom.txt'));
        unlink('tests/ziotom.txt');
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
