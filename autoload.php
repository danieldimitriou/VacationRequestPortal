<?php

spl_autoload_register(function ($class) {
    // Convert namespace separators to directory separators
    $classFile = str_replace('\\', '/', $class);
    $filePath = __DIR__ . '/'.$classFile . '.php';

    // Check if the file exists
    if (file_exists($filePath)) {
        require_once $filePath;
    }
});