<?php
use ridesoft\AzureCloudMap\AzureUrl;

/**
 * Description of AzureIoTest
 *
 * @author maurizio brioschi <maurizio.brioschi@ridesoft.org>
 */
class AzureUrlTest extends PHPUnit_Framework_TestCase{
    protected $config;
    
    protected function setUp() {
        $this->config = require 'src/config/config.php';     
    }
    
    public function testAddContainer()  {
        $azure = new AzureUrl($this->config);
        $this->assertTrue($azure->addContainer($this->config['azure']['base_url'].'/pizza'));
    }
    /**
     * @depends testAddContainer
     */
    public function testAddBlob()   {
        $azure = new AzureUrl($this->config);
        $this->assertTrue($azure->addBlob($this->config['azure']['base_url'].'/pizza/ciao.txt','tests/test.txt'));
    }
    /**
     * @depends testAddContainer
     */
    public function testViewBlobs() {
        $azure = new AzureUrl($this->config);    
        $this->assertGreaterThan(0,count($azure->viewBlobs($this->config['azure']['base_url'].'/pizza')));
    }   
     /**
     * @depends testAddBlob
     */
    public function testDownload(){
        $azure = new AzureUrl($this->config);    
        $this->assertTrue($azure->download($this->config['azure']['base_url'].'/pizza/ciao.txt', 'tests/snowboard.txt'));
        $this->assertTrue(file_exists('tests/snowboard.txt'));
        unlink('tests/snowboard.txt');
    }
    /**
     * @depends testAddBlob
     */
    public function testRename()    {
        $azure = new AzureUrl($this->config);
        $this->assertTrue($azure->renameBlob($this->config['azure']['base_url'].'/pizza/ciao.txt', 'flip360.txt'));
        $this->assertTrue($azure->download($this->config['azure']['base_url'].'/pizza/flip360.txt', 'tests/stocazzo.txt'));
        $this->assertTrue(file_exists('tests/stocazzo.txt'));
        unlink('tests/stocazzo.txt');
    }
    /**
     * @depends testRename
     */
    public function testDeleteBlob()    {
        $azure = new AzureUrl($this->config);    
        $this->assertTrue($azure->delete($this->config['azure']['base_url'].'/pizza/flip360.txt'));
    }
    /**
     * @depends testAddContainer
     */
    public function testDeleteContainer()    {
        $azure = new AzureUrl($this->config);    
        $this->assertTrue($azure->deleteContainer($this->config['azure']['base_url'].'/pizza'));
    }
}
