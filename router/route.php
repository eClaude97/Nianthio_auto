<?php

use App\DbConfig;

session_start();

require "../vendor/autoload.php";
$DbConfig = new DbConfig();
define("CONNECT", $DbConfig->Connect());
define('ROOT', dirname(__DIR__));

$page = $_GET['p'] ?? 'home.index';

$items = explode('.', $page);

if ($items[0] === 'admin') {
    $controller = "App\Controllers\Admin\\" . ucfirst($items[1]) . "Controller";
    $action = $items[2];
} else {
    $controller = "App\Controllers\\" . ucfirst($items[0]) . "Controller";
    $action = $items[1];
}
if (class_exists($controller) && method_exists($controller, $action)) {
    $controller = new $controller();
    $controller->$action();
} else {
    header('location: page404.php');
}