<?php
require_once "../vendor/autoload.php";

$env = parse_ini_file("../.env");

define("DB_CONNECTION", $env['DB_CONNECTION']);
define("DB_HOST", $env['DB_HOST']);
define("DB_DATABASE", $env['DB_DATABASE']);
define("DB_PASS", $env['DB_PASS']);
define("DB_USER", $env['DB_USER']);
