<?php

session_start();

if (isset($_GET['markId'])) {
    require '../Class/loadModels.php';
} else {
    require '../router/route.php';
}

