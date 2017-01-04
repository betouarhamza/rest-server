<?php
require_once 'database.php';
require_once 'routing.php';

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

$config = new Configuration();
$connectionParams = [
    'dbname' => DB_NAME,
    'user' => DB_USER,
    'host' => DB_HOST,
    'password' => DB_PASSWORD,
    'charset' => DB_CHARSET,
    'driver' => 'pdo_mysql',
];

$database = DriverManager::getConnection($connectionParams, $config);