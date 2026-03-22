<?php

include_once(__DIR__.'/../vendor/autoload.php');

//date_default_timezone_set('UTC');
date_default_timezone_set('Asia/Bangkok');

if (!\Monkeycar\Helper::isDev()) {
    ini_set('display_errors', 0);
    //error_reporting(0);
}
