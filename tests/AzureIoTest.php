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
     * @depends testCopyDir
     */
    public function testScandir()   {
         $azure = new AzureIO($this->config);
         $objects = $azure->scandir('test');
         $this->assertContains('copyDir/dir1/dir2/testDir2file1.txt',$objects);
         $this->assertContains('copyDir/dir1/testDir1file1.txt',$objects);
         $this->assertContains('copyDir/dir1/testDir1file2.txt',$objects);
         $this->assertContains('copyDir/dir3/testDir3file1.txt',$objects);
         
         $objects2 = $azure->scandir('test/dir1');
         $this->assertContains('dir2/testDir2file1.txt',$objects2);
         $this->assertContains('testDir1file1.txt',$objects2);
         $this->assertContains('testDir1file2.txt',$objects2);
         $this->assertNotContains('copyDir/dir3/testDir3file1.txt', $objects2);
         
    }
    /**
     * @depends testCopyDir
     */
//    public function testDownloadDir()   {
//        $azure = new AzureIO($this->config);
//        $this->assertTrue($azure->get('test/dir','testDir1file1.txt', 'tests/downloaddir'));
//        die();
//    }
    
    /**
     * @depends testMkdir
     */
    public function testCopyandScanDirDownload()  {
        $azure = new AzureIO($this->config);
        $this->assertTrue($azure->copy('test','skate.txt','tests/test.txt'));
        $objects = $azure->scandir('test');
        $this->assertGreaterThan(0, count($objects));
        $this->assertTrue($azure->get('test/skate.txt','tests/destroy.txt'));
        $this->assertTrue(file_exists('tests/destroy.txt'));
        unlink('tests/destroy.txt');
    }
    /**
     * @depends testCopyandScanDirDownload
     */
    public function testRename()    {
        $azure = new AzureIO($this->config);
        $this->assertTrue($azure->rename('test/skate.txt', 'belfalu.txt'));
        $this->assertTrue($azure->get('test','belfalu.txt','tests/ziotom.txt'));
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
