<?php
spl_autoload_register(function ($class_name) {
    $path_class = './class/'.$class_name.'.class.php';
    // echo $path;
    require $path_class;
});

require_once('./html/header.html');


require_once('./html/form_search.html');


require_once('./html/form_depot.html');



require_once('./html/footer.html');
