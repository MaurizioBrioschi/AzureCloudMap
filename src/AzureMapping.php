<?php
namespace ridesoft\Azure;

use WindowsAzure\Common\ServicesBuilder;
/**
 * Base class for mapping Microsoft Azure Api
 *
 * @author maurizio brioschi <maurizio.brioschi@ridesoft.org>
 */
abstract class AzureMapping {
    protected $connectionstring;
    protected $blobRestProxy;
    
    public function __construct($connectionString) {
        $this->connectionstring = Config::get($connectionString);
        $this->blobRestProxy = ServicesBuilder::getInstance()->createBlobService($this->connectionstring);
    }
}
