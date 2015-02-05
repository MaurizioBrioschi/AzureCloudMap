<?php

namespace ridesoft\Azure;

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
     */
    public function download($dir, $file,$destinationFilename) {
        try {
            // Get blob.
            $blob = $this->blobRestProxy->getBlob($dir, $file);
            file_put_contents($destinationFilename,stream_get_contents($blob->getContentStream()));
        }catch(ServiceException $e){
            // Handle exception based on error codes and messages.
            // Error codes and messages are here: 
            // http://msdn.microsoft.com/it-it/library/windowsazure/dd179439.aspx
            $code = $e->getCode();
            $error_message = $e->getMessage();
            echo $code . ": " . $error_message . "<br />";
        }
    }
}
