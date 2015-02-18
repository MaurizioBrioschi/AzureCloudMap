<?php

namespace ridesoft\AzureCloudMap;

/**
 * IO class for Microsoft Azure in IO php style functions
 *
 * @author maurizio brioschi <maurizio.brioschi@ridesoft.org>
 */
class AzureIO extends AzureMapping {

    /**
     * Download from the Azure cloud the blob in the container
     * @deprecated since version 0.4.3
     * @param string $dir is the container
     * @param string $file is the blob
     * @param string $destinationFilename
     * @return boolean
     */
    public function getBlob($dir, $file='', $destinationFilename=null) {
        return parent::getBlob($dir, $file, $destinationFilename);
    }
    /**
     * Download from the Azure cloud the blob in the container
     * @param string $destinationFilename
     * @param string $path is the container
     * @return boolean
     */
    public function get($path, $destinationFilename=null){
        return parent::getBlob($path, '', $destinationFilename);
    }
    /**
     * List files and directories inside the specified container
     * @param string $dir the container
     * @return array
     */
    public function scandir($dir) {
        return parent::listContainer($dir);
    }

    /**
     * Deletes a blob
     * @param string $dir the container
     * @param type $file is the blob
     * @return boolean
     */
    public function unlink($dir, $file = '') {
        return parent::deleteBlob($dir, $file);
    }

    /**
     * delete container
     * @param string $dir the container
     * @return boolean
     */
    public function rmdir($dir) {
        return parent::removeContainer($dir);
    }

    /**
     * Copy file
     * @param type $dest_dir the container
     * @param type $dest_blob the blob
     * @param type $local_file 
     * @return boolean
     */
    public function copy($dest_dir, $dest_blob, $local_file) {
        return parent::copyInBlob($dest_dir, $dest_blob, $local_file);
    }

    /**
     * Copy recursively a directory into azure
     * @param type $dest_dir
     * @param type $dest_blob
     * @param type $local_dir
     */
    public function copyDir($dest_dir, $local_dir) {
        if (is_dir($local_dir)) {
            $dir = explode('/', $local_dir);
            $this->createContainer($dest_dir . '/' . end($dir));
            $objects = scandir($local_dir);
            foreach ($objects as $object) {
                if ($object != '.' && $object != '..') {
                    if (is_dir($local_dir . '/' . $object)) {
                        $this->copyDir($dest_dir . '/' . end($dir), $local_dir . '/' . $object);
                    } else {
                        $this->copy($dest_dir . '/' . end($dir), $object, $local_dir . '/' . $object);
                    }
                }
            }
            return true;
        }
        throw new \Exception("The directory ($local_dir) to copy is not a directory.");
    }

    /**
     * rename a azure blob
     * @param type $azure_blob
     * @param type $new_label
     */
    public function rename($azure_blob, $new_label) {
        $explosion = explode('/', $azure_blob);
        $count_explosion = count($explosion);
        if ($count_explosion > 0) {
            $dir = $explosion[0];
            $file = '';
            $copydir = $dir; //container to copy
            for ($i = 1; $i < $count_explosion; $i++) {
                if ($i < ($count_explosion - 1)) {
                    $copydir .= '/' . $explosion[$i];
                }
                $file .= $explosion[$i] . "/";
            }
        }
        $file = substr($file, 0, strlen($file) - 1);
        try {
            mkdir('azure_tmp');
            if ($this->getBlob($dir, $file, 'azure_tmp/' . $new_label)) {
                $this->unlink($dir, $file);
                $this->copy($copydir, $new_label, 'azure_tmp/' . $new_label);
                exec('rm -rf azure_tmp');
                return true;
            }
        } catch (ServiceException $ex) {
            return false;
        }
        
        rmdir('azure_tmp');
        return false;
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
    public function mkdir($dir, $access = 'cb', array $metadata = array()) {
        return parent::createContainer($dir, $access, $metadata);
    }

}
