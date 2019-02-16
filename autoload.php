<?php
spl_autoload_register(function ($class_name) {
    $path_class = './class'.$class_name.'.class.php';
    // echo $path;
    require $path_class;
});

// spl_autoload_register(function (php_name) {
//    $path_php = './php'.$php_name.'.php'
// }
// )
