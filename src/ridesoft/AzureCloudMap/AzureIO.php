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
    public function copy($dest_dir, $dest_blob,$local_file) {
        $content = fopen($local_file, "r");
        try {
            //Upload blob
            $this->blobRestProxy->createBlockBlob($dest_dir, $dest_blob, $content);
            return true;
        } catch (ServiceException $e) {
            return false;
        }
    }

}
