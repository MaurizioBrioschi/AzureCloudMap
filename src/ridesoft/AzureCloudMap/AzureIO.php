<?php

namespace ridesoft\AzureCloudMap;


/**
 * IO class for Microsoft Azure in PHP function 
 * works like path methods using container and blob
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
    public function download($dir, $file, $destinationFilename){
        return parent::download($dir, $file, $destinationFilename);
    }
    /**
     * List files and directories inside the specified container
     * @param string $dir the container
     * @return array
     */
    public function scandir($dir){
        return parent::scandir($dir);
    }
    /**
     * Deletes a blob
     * @param string $dir the container
     * @param type $file is the blob
     * @return boolean
     */
    public function unlink($dir, $file){
        return parent::unlink($dir, $file);
    }
    /**
     * delete container
     * @param string $dir the container
     * @return boolean
     */
    public function rmdir($dir){
        return parent::rmdir($dir);
    }
    /**
     * Copy files
     * @param type $dest_dir the container
     * @param type $dest_blob the blob
     * @param type $local_file 
     * @return boolean
     */
    public function copy($dest_dir, $dest_blob, $local_file){
        return parent::copy($dest_dir, $dest_blob, $local_file);
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
    public function mkdir($dir, $access = 'cb', array $metadata = array()){
        return parent::mkdir($dir, $access, $metadata);
    }
}
