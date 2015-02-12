<?php

namespace ridesoft\AzureCloudMap;

use WindowsAzure\Common\ServiceException;

/**
 * IO class for Microsoft Azure in PHP function
 *
 * @author maurizio brioschi <maurizio.brioschi@ridesoft.org>
 */
class AzureIO extends AzureMapping {

    /**
     * Download from the Azure cloud the blob in the container
     * @param string $dir is the container
     * @param string $file is the blob
     * @param string $destinationFilename
     * @return boolean
     */
    public function download($dir, $file, $destinationFilename) {
        try {
            // Get blob.
            $blob = $this->blobRestProxy->getBlob($dir, $file);
            file_put_contents($destinationFilename, stream_get_contents($blob->getContentStream()));
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
    public function scandir($dir) {
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
    public function unlink($dir, $file) {
        try {
            $this->blobRestProxy->deleteBlob($dir, $file);
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
    public function rmdir($dir) {
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
     * Copies file
     * @param type $dest_dir the container
     * @param type $dest_blob the blob
     * @param type $local_file 
     * @return boolean
     */
    public function copy($dest_dir, $dest_blob, $local_file) {
        $content = fopen($local_file, "r");
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
    public function mkdir($dir,$access='cb', array $metadata=array()) {
        $createContainerOptions = new CreateContainerOptions();
        switch ($access)    {
            case 'cb':
                $createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);
                break;
            case 'b':
                $createContainerOptions->setPublicAccess(PublicAccessType::BLOBS_ONLY);
                break;
            default:
                $createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);            
        }
        
        foreach($metadata as $key=>$value) {
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
