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
     * @dataProvider downloadProvider
     */
    public function testDownload($container,$file,$destination)  {
        $this->azure->download($container,$file,$destination);
        $this->assertTrue(file_exists('MW_vol_10.pdf'));
        unlink($destination);
    }
    
    public function downloadProvider(){
        return [
            [
                'pdf','test.pdf','test.pdf'
            ]
        ];
    }
}
