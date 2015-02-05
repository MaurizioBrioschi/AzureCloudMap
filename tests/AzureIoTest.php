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
    
    public function testScandir()   {
        $objects = $this->azure->scandir('pdf');
        $this->assertArrayHasKey('shit',$objects);
    }
    
    public function testCopy()  {
        $this->azure->copy('pdf','rock/test.php','/home/maurizio/Desktop/test.pdf');
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
                'pdf','ciao.pdf','rock.pdf'
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
