
<?php

include "./bootstrap.php";

try{
    Route::get_instance()->load_file();
} catch (Exception $e){
    $error_file_path = "./errors/".$e->getCode().".php";
    if (file_exists($error_file_path)){
        include $error_file_path;
    } else {
        echo "Ошибка не обработана";
    }
}

?>