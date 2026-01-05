<?php

    spl_autoload_register(function ($class){
        //base do app
        $baseDir = __DIR__ . '/app/';

        $path = $baseDir .  str_replace('\\', "/", $class) . ".php";

        if(file_exists($path)) require_once $path;
    });