<?php
//TODO - for production env, this API should be forbidden
require __DIR__.'/../bootstrap/autoload.php';

//require("vendor/autoload.php");
$swagger = \Swagger\scan(__DIR__ . '/../app');
header('Content-Type: application/json');
echo $swagger;