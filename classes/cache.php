<?php

class Cache {
    private static function path_cache_folder(){
        return $_SERVER["DOCUMENT_ROOT"]."/cache/";
    } 

    static function caching($key, $value = null){
        $path = self::path_cache_folder() . md5($key) . ".txt";
        if(!file_exists($path)){
            if($value){
                file_put_contents($path, serialize($value));
                return "Данные записаны";
            } 
            return false;
        } else {
            if($value){
                file_put_contents($path, serialize($value));
                return "Данные перезаписаны";
            } 
            return unserialize(file_get_contents($path));
        }
    }
    static function delete_cache($key){
        $path = self::path_cache_folder() . md5($key) . ".txt";
        if(file_exists($path)){
            unlink($path);
        }
    }
}

?>