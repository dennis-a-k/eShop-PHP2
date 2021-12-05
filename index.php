<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/index.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/autoloader.php';

try {
    App::init();
} catch (Exception $e) {
    echo $e->getMessage();
}
