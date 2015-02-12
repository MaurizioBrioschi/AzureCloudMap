# AzureCloudMap

PHP Utility library to interface with Microsoft Azure Cloud API filesystem that works as in Laravel 4.2 as in pure php.

## Use it in Laravel

### Install

Add to your laravel application composer:
```
"repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:ridesoft/AzureCloudMap.git" 
        }
     ],
"require": {
        "ridesoft/AzureCloudMap": "0.2.*"
    },
```
Type composer install or composer update.

In your app/config/app.php add in array providers:
```
'ridesoft\AzureCloudMap\AzureCloudMapServiceProvider'
```
and in array aliases:
```
'AzureIO'           => 'ridesoft\AzureCloudMap\Facades\AzureIO'
```

now publish your configuration with:
```
php artisan config:publish ridesoft/azurecloudmap
```
#### Functions mapped

**To download a blob:**
```
AzureIO::download($dir, $file, $destinationFilename);
```
*$dir* is the name of the container

*$file* is the name of the blob

*$destinationFilename* is the path in which download the blob

**To list all blobs in a container:**
```
AzureIO::scandir($dir);
```
*$dir* is the container

**To delete a blob:**
```
AzureIO::unlink($dir, $file);
```
*$dir* is the container

*$file* is the blob

**To remove a container:**
```
AzureIO::rmdir($dir);
```
*$dir* is the container

**To copy a local file to azure cloud**
```
AzureIO::copy($dest_dir, $dest_blob, $local_file)
```
*$dest_dir* is the container

*$dest_blob* is the name of the blob

*$local_file* is the path of the local file

**To create a new container**
```
AzureIO::mkdir($dir,$access='cb', array $metadata=array())
```
## Use it pure PHP
### Install

Add to your laravel application composer:
```
"repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:ridesoft/AzureCloudMap.git" 
        }
     ],
"require": {
        "ridesoft/AzureCloudMap": "0.2.*"
    },
```
Type composer install or composer update.

or

just download or clone this library

#### How use it

**In the folder examples you can find some useful examples for the function mapped:**

```
/**
 * Download from the Azure cloud the blob in the container
 * @param string $dir is the container
 * @param string $file is the blob
 * @param string $destinationFilename
 * @return boolean
 */
public function download($dir, $file, $destinationFilename)
```
```
/**
 * List files and directories inside the specified container
 * @param string $dir the container
 * @return array
 */
public function scandir(string $dir)
```
```
/**
 * Delete a blob
 * @param string $dir the container
 * @param type $file is the blob
 * @return boolean
 */
public function unlink(string $dir, $file)
```
```
/**
 * delete container
 * @param string $dir the container
 * @return boolean
 */
public function rmdir(string $dir)
```
```
/**
 * Copy files
 * @param type $dest_dir the container
 * @param type $dest_blob the blob
 * @param type $local_file 
 * @return boolean
 */
public function copy(string $dest_dir, string $dest_blob, string $local_file)
```
```
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
public function mkdir($dir,$access='cb', array $metadata=array())
```
