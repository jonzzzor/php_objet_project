<?php
spl_autoload_register(function ($class_name) {
    $path_class = './class'.$class_name.'.class.php';
    // echo $path;
    require $path_class;
});

// header("Content-type: application/xhtml+xml");
