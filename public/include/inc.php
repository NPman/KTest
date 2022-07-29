<?php
define('ROOT_DIR', realpath(__DIR__ . '/../../'));

require_once ROOT_DIR . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(ROOT_DIR);
$dotenv->load();

$appConfig = new \Kelnik\AppConfig(
    $_ENV['DB_TYPE'],
    $_ENV['DB_HOST'],
    $_ENV['DB_NAME'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASSWORD'],
);

\Kelnik\App::init($appConfig);
