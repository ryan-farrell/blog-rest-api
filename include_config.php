<?php

include_once 'vendor/autoload.php';

use Dotenv\Dotenv;

$oDotenv = Dotenv::createImmutable(__DIR__);
$oDotenv->load();
