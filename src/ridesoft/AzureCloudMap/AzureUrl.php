<?php

namespace ridesoft\AzureCloudMap;

/**
 * Class to interface with Microsoft Azure that start from blog url
 *
 * @author maurizio brioschi <maurizio.brioschi@ridesoft.org>
 */
class AzureUrl extends AzureMapping {
    /**
     * Analize the url and get the relative path
     * @param type $url
     * @return string
     * @throws Exception
     */
    protected function analizeUrl($url) {
        if (strstr($url, $this->config['azure']['base_url']) == false) {
            throw new Exception("Url: $url is not a valid url");
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
            throw new Exception("The url doesn't contain a valid container");
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
    protected function getBlob($url) {
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
            throw new Exception("The url doesn't contain a valid blob");
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * download a blob from its url and save it the the destination
     * @param type $url
     * @param type $destinationFilename
     * @return boolean
     */
    public function download($url, $destinationFilename) {

        try {
            $dir = $this->getContainer($url);
            $file = $this->getBlob($url);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }

        try {
            return parent::download($dir, $file, $destinationFilename);
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
