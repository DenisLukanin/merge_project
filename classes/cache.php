<?php

class Cache {
    

    private static function get_cache_path($cache_directory ,$key){
        $root_path = $_SERVER["DOCUMENT_ROOT"]."/cache/". $cache_directory;
        if (!is_dir($root_path)){
            mkdir($root_path, 0777, true);
        }
        return $root_path . md5($key);
    } 

    static function set($key, $value, $cache_directory){
        $path = self::get_cache_path($cache_directory, $key);
        return file_put_contents($path, serialize($value)) !== false;
    }

    static function get($key, $cache_directory){
        $path = self::get_cache_path($cache_directory, $key);
        if (file_exists($path)){
            return unserialize(file_get_contents($path));
        }
    }

    static function delete($key,$cache_directory){
        $path = self::get_cache_path($cache_directory, $key);
        if(file_exists($path)){
            return unlink($path);
        }
    }
}

?>