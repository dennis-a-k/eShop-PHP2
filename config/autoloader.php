<?php
//Автоподключение своих классов в разных папках
spl_autoload_register(function($class) {
    $dirs = ['controllers', 'models'];
    $found = false;

    foreach ($dirs as $dir) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $dir . '/' . strtolower($class) . '.class.php')) {
            include_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $dir . '/' . strtolower($class) . '.class.php';
            $found = true;
        }
    }

    if (!$found) {
        //throw new Exception('Не удалось подключить класс ' . $class);
        header("Location: /");
    }
});
