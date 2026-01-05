<?php

    function url(string $path = ''): string{
        $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        return $base . '/' . ltrim($path, '/');
    }