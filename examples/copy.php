<?php
require __DIR__.'/../vendor/autoload.php';
use ridesoft\AzureCloudMap\AzureIO;
$config = require_once 'src/config/config.php';
$azure = new AzureIO($config);
$azure->copy('pdf', 'skateboard.pdf', '/home/maurizio/Desktop/CVEU_2015.pdf');

