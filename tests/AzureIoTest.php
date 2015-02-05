<?php
use \ridesoft\Azure\AzureIO;

/**
 * Description of AzureIoTest
 *
 * @author maurizio brioschi <maurizio.brioschi@ridesoft.org>
 */
class AzureIoTest extends PHPUnit_Framework_TestCase{
    protected $azure;
    protected $config;
    
    protected function setUp() {
        parent::setUp();
        $this->config = require_once 'src/config/config.php';
        $this->azure = new AzureIO($this->config['azure']['connectionstring']);
    }
    /**
     * @dataProvider downloadWrongProvider
     */
    public function testFalseDownload($container,$file,$destination)  {
        $this->assertFalse($this->azure->download($container,$file,$destination));
        
    }
    
    /**
     * @dataProvider downloadCorrectProvider
     */
    public function testDownload($container,$file,$destination)  {
        $this->assertTrue($this->azure->download($container,$file,$destination));
        unlink($destination);
    }
    
    
    
    public function downloadCorrectProvider(){
        return [
            [
                'pdf','e3e50cf02910fe819538030ce2dd498f/MW_vol_10.pdf','MW_vol_10.pdf'
            ]
        ];
    }
    
    public function downloadWrongProvider(){
        return [
            [
                'pdf','skate.pdf','isshit.pdf'
            ]
        ];
    }
}
