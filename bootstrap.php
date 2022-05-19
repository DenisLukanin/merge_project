 
<?php

spl_autoload_register(function($path){ 
    $path = str_replace("\\", "/", $path);
    $class_path = __DIR__."\\classes\\".$path.".php";
    if (file_exists($class_path)){
        include $class_path;
    }
}
);


function aa($value){
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
};
function aar($value){
    echo "<pre>";
    print_r($value);
    echo "</pre>";
};



?>