<?php
namespace ridesoft\AzureCloudMap;

use WindowsAzure\Common\ServicesBuilder;
/**
 * Base class for mapping Microsoft Azure Api
 *
 * @author maurizio brioschi <maurizio.brioschi@ridesoft.org>
 */
abstract class AzureMapping {
    protected $config;
    protected $blobRestProxy;
    /**
     * 
     * @param @param  Illuminate\Config\Repository  $config
     */
    public function __construct($config) {
        $this->config = $config;
        $this->blobRestProxy = ServicesBuilder::getInstance()->createBlobService($config["azure"]["connectionstring"]);
    }
}
