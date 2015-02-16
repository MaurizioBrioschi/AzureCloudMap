<?php
namespace ridesoft\AzureCloudMap;

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;
use WindowsAzure\Blob\Models\CreateContainerOptions;
use WindowsAzure\Blob\Models\PublicAccessType;
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
    
    /**
     * Analize the url and get the relative path
     * @param type $url
     * @return string
     * @throws Exception
     */
    protected function analizeUrl($url) {
        if (strstr($url, $this->config['azure']['base_url']) == false) {
            throw new \Exception("Url: $url is not a valid url");
        }
        return str_replace($this->config['azure']['base_url'] . "/", "", $url);
    }
    /**
     * get the container from the url
     * @param type $url
     * @return type
     * @throws \ridesoft\AzureCloudMap\Exception
     * @throws Exception
     */
    protected function getContainer($url) {
        try {
            $explosion = explode("/", $this->analizeUrl($url));
            if (count($explosion) > 0) {
                return $explosion[0];
            }
            throw new \Exception("The url doesn't contain a valid container");
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    /**
     * get the blob from the url
     * @param type $url
     * @return string
     * @throws \ridesoft\AzureCloudMap\Exception
     * @throws Exception
     */
    protected function getBlobName($url) {
        try {
            $explosion = explode("/", $this->analizeUrl($url));
            $count_explosion = count($explosion);
            if ($count_explosion > 1) {
                $file = $explosion[1];
                for ($i = 2; $i < $count_explosion; $i++) {
                    $file .= "/" . $explosion[$i];
                }
                return $file;
            }
            throw new \Exception("The url doesn't contain a valid blob");
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    /**
     * Download from the Azure cloud the blob in the container
     * @param string $dir is the container
     * @param string $file is the blob
     * @param string $destinationFilename
     * @return boolean
     */
    protected function getBlob($dir, $file='', $destinationFilename=null) {
        try {
            
            // Get blob.
            $explosion = explode('/', $dir);
            $count_explosion = count($explosion);
            if(count($explosion)>0) {
                $dir = $explosion[0];
                $prefile = '';
                for($i=1;$i<$count_explosion;$i++){
                    $prefile .= $explosion[$i]."/";
                }
            }
            $file =  $prefile.$file;
            $blob = $this->blobRestProxy->getBlob($dir,$file);
            try{
                if(is_null($destinationFilename)){
                    $destinationFilename = $file;
                }
                file_put_contents($destinationFilename, stream_get_contents($blob->getContentStream()));
                
            } catch (Exception $ex) {
                throw $ex;
            }
            
            return true;
        } catch (ServiceException $e) {
            // Handle exception based on error codes and messages.
            // Error codes and messages are here: 
            // http://msdn.microsoft.com/it-it/library/windowsazure/dd179439.aspx
            $code = $e->getCode();
            $error_message = $e->getMessage();
            echo $code . ": " . $error_message . "<br />";
            return false;
        }
    }
    

    /**
     * List files and directories inside the specified container
     * @param string $dir the container
     * @return array
     */
    protected function listContainer($dir) {
        try {
            $blob_list = $this->blobRestProxy->listBlobs($dir);
            $blobs = $blob_list->getBlobs();
            $objects = [];
            foreach ($blobs as $blob) {
                array_push($objects, $blob);
            }
            return $objects;
        } catch (Exception $ex) {
            // Handle exception based on error codes and messages.
            // Error codes and messages are here: 
            // http://msdn.microsoft.com/it-it/library/windowsazure/dd179439.aspx
            $code = $e->getCode();
            $error_message = $e->getMessage();
            echo $code . ": " . $error_message . "<br />";
            return null;
        }
    }

    /**
     * Deletes a blob
     * @param string $dir the container
     * @param type $file is the blob
     * @return boolean
     */
    protected function deleteBlob($dir, $file) {
        try {
            $this->blobRestProxy->deleteBlob($dir, $file);
            return true;
        } catch (ServiceException $e) {
            // Handle exception based on error codes and messages.
            // Error codes and messages are here: 
            // http://msdn.microsoft.com/it-it/library/windowsazure/dd179439.aspx
            $code = $e->getCode();
            $error_message = $e->getMessage();
            echo $code . ": " . $error_message . "<br />";
            return false;
        }
    }

    /**
     * delete container
     * @param string $dir the container
     * @return boolean
     */
    protected function removeContainer($dir) {
        try {
            // Delete container.
            $this->blobRestProxy->deleteContainer($dir);
            return true;
        } catch (ServiceException $e) {
            // Handle exception based on error codes and messages.
            // Error codes and messages are here: 
            // http://msdn.microsoft.com/it-it/library/windowsazure/dd179439.aspx
            $code = $e->getCode();
            $error_message = $e->getMessage();
            echo $code . ": " . $error_message . "<br />";
            return false;
        }
    }

    /**
     * Copy file into blob
     * @param type $dest_dir the container
     * @param type $dest_blob the blob
     * @param type $local_file 
     * @return boolean
     */
    protected function copyInBlob($dest_dir, $dest_blob, $local_file) {
        try {
             $content = fopen($local_file, "r");
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return false;
        }

        try {
            //Upload blob    
            $this->blobRestProxy->createBlockBlob($dest_dir, $dest_blob, $content);
            return true;
        } catch (ServiceException $e) {
            // Handle exception based on error codes and messages.
            // Error codes and messages are here: 
            // http://msdn.microsoft.com/it-it/library/windowsazure/dd179439.aspx
            $code = $e->getCode();
            $error_message = $e->getMessage();
            echo $code . ": " . $error_message . "<br />";
            return false;
        }
    }

    /**
     * create a container
     * @param type $dir name of container
     * @param type $access can be cb(CONTAINER_AND_BLOBS) or b (BLOBS_ONLY)
     * CONTAINER_AND_BLOBS:     
     * Specifies full public read access for container and blob data.
     * proxys can enumerate blobs within the container via anonymous 
     * request, but cannot enumerate containers within the storage account.
     *
     * BLOBS_ONLY:
     * Specifies public read access for blobs. Blob data within this 
     * container can be read via anonymous request, but container data is not 
     * available. proxys cannot enumerate blobs within the container via 
     * anonymous request.
     * If this value is not specified in the request, container data is 
     * private to the account owner.
     * @return boolean
     */
    protected function createContainer($dir, $access = 'cb', array $metadata = array()) {
        $createContainerOptions = new CreateContainerOptions();
        switch ($access) {
            case 'cb':
                $createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);
                break;
            case 'b':
                $createContainerOptions->setPublicAccess(PublicAccessType::BLOBS_ONLY);
                break;
            default:
                $createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);
        }

        foreach ($metadata as $key => $value) {
            $createContainerOptions->addMetaData($key, $value);
        }

        try {
            // Create container.
            $this->blobRestProxy->createContainer($dir, $createContainerOptions);
            return true;
        } catch (ServiceException $e) {
            // Handle exception based on error codes and messages.
            // Error codes and messages are here: 
            // http://msdn.microsoft.com/it-it/library/windowsazure/dd179439.aspx
            $code = $e->getCode();
            $error_message = $e->getMessage();
            echo $code . ": " . $error_message . "<br />";
            return false;
        }
    }
    
   
}
