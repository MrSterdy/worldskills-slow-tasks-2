<?php

namespace WSCrop;

$namespace = "WSCrop";
$classpath = "/";

spl_autoload_register(function ($classname) use ($namespace, $classpath) {
    $classname = str_replace($namespace, "", $classname);
    $filename = preg_replace("#\\\\#", "/", $classname).".php";
    $fullpath = __DIR__."/".$classpath."/$filename";
    if (file_exists($fullpath)) {
        include_once $fullpath;
    }
});