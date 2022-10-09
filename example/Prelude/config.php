<?php declare(strict_types=1);

// default global config values
$_ENV['DB_TYPE'] ??= 'mysql';
$_ENV['DB_NAME'] ??= 'gar';
$_ENV['DB_HOST'] ??= 'localhost';
$_ENV['DB_PORT'] ??= '3306';
$_ENV['DB_USER'] ??= 'local';
$_ENV['DB_PASS'] ??= 'password';
$_ENV['DB_BUFF'] ??= 10;

$_ENV['LOG_QUERY_RESULTS'] ??= true;
$_ENV['LOG_PATH'] ??= __DIR__ . '/../Logs/';
