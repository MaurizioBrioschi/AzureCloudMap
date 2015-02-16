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
    public function getBlob($dir, $file, $destinationFilename){
        return parent::getBlob($dir, $file, $destinationFilename);
    }
    /**
     * List files and directories inside the specified container
     * @param string $dir the container
     * @return array
     */
    public function scandir($dir){
        return parent::listContainer($dir);
    }
    /**
     * Deletes a blob
     * @param string $dir the container
     * @param type $file is the blob
     * @return boolean
     */
    public function unlink($dir, $file){
        return parent::deleteBlob($dir, $file);
    }
    /**
     * delete container
     * @param string $dir the container
     * @return boolean
     */
    public function rmdir($dir){
        return parent::removeContainer($dir);
    }
    /**
     * Copy file
     * @param type $dest_dir the container
     * @param type $dest_blob the blob
     * @param type $local_file 
     * @return boolean
     */
    public function copy($dest_dir, $dest_blob, $local_file){
        return parent::copyInBlob($dest_dir, $dest_blob, $local_file);
    }
    /**
     * Copy recursively a directory into azure
     * @param type $dest_dir
     * @param type $dest_blob
     * @param type $local_dir
     */
    public function copyDir($dest_dir, $local_dir) {
        if(is_dir($local_dir)){       
            $dir = explode('/', $local_dir);
            $this->createContainer($dest_dir.'/'.end($dir));
            $objects = scandir($local_dir);
            foreach($objects as $object){
                if($object!='.' && $object!='..')   {
                    if(is_dir($local_dir.'/'.$object)){                      
                        $this->copyDir($dest_dir.'/'.end($dir), $local_dir.'/'.$object);
                    }else{
                        $this->copy($dest_dir.'/'.end($dir), $object, $local_dir.'/'.$object);
                    }
                }
            }
            return true;
        }
        throw new \Exception("The directory ($local_dir) to copy is not a directory.");
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
        return parent::createContainer($dir, $access, $metadata);
    }
}
