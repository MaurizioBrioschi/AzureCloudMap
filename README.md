# AzureCloudMap
PHP Utilities for Azure cloud API filesystem

Permit to inteface with Microsoft Azure cloud using same function similar in PHP.


## Install

Clone it
```
clone git@github.com:ridesoft/AzureCloudMap.git
```
and run composer install after have updated it
```
composer self-update
```
or
```
sudo composer self-update
```
and then 
```
sudo composer install
```

## Use
Set in src/config/config.php your parameters and import autoload in your file:
```
require __DIR__.'/../vendor/autoload.php';
```
Create an instance of AzureCloudMap:
```
use \ridesoft\Azure\AzureIO;

$config = require_once 'src/config/config.php';
$azure = new AzureIO($this->config['azure']['connectionstring']);
```
now you can use:

### Functions

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
 * Deletes a blob
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
 * Copies file
 * @param type $dest_dir the container
 * @param type $dest_blob the blob
 * @param type $local_file 
 * @return boolean
 */
public function copy(string $dest_dir, string $dest_blob, string $local_file)
```

### todo
Implements new functions and test

