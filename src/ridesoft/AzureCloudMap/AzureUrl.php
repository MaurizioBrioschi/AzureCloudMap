<?php

namespace ridesoft\AzureCloudMap;

/**
 * Class to interface with Microsoft Azure that start from blog url
 *
 * @author maurizio brioschi <maurizio.brioschi@ridesoft.org>
 */
class AzureUrl extends AzureMapping {
    /**
     * download a blob from its url and save it the the destination
     * @param type $url
     * @param type $destinationFilename
     * @return boolean
     */
    public function download($url, $destinationFilename) {

        try {
            $dir = $this->getContainer($url);
            $file = $this->getBlobName($url);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }

        try {
            return parent::getBlob($dir, $file, $destinationFilename);
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
     * delete a blob from the url
     * @param type $url
     * @return boolean
     */
    public function delete($url){
        try {
            $dir = $this->getContainer($url);
            $file = $this->getBlobName($url);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        
        try {
            return parent::deleteBlob($dir, $file);
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
     * remove container from url
     * @param type $dir
     * @return boolean
     */
    public function deleteContainer($url)   {
        try {
            $dir = $this->getContainer($url);
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        
        try {
            return parent::removeContainer($dir);
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
     * add a file in the url blob
     * @param type $path 
     * @param type $url
     * @return boolean
     */
    public function addBlob($url,$path){
        try {
            $dir = $this->getContainer($url);
            $file = $this->getBlobName($url);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        
        try {
            return parent::copyInBlob($dir, $file, $path);
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
     * add container from its url
     * @param type $url
     * @param type $access
     * @param array $metadata
     * @return boolean
     */
    public function addContainer($url,$access='cb', array $metadata = array()){
        try {
            $dir = $this->getContainer($url);
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        
        try {
            return parent::createContainer($dir, $access, $metadata);
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
     * list files in a container starting from the url
     * @param type $url
     * @return boolean
     */
    public function viewBlobs($url)  {
        try {
            $dir = $this->getContainer($url);
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        
        try {
            return parent::listContainer($dir);
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
