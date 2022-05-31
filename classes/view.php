<?php

class View {
    private static $instance;
    private static $module;
    private static $name;
    private static $id;
    private static $info;
    private static $param;
    private static function root_path() {
        return $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR;
    }
    private static function classes_path() {
        return $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "classes" . DIRECTORY_SEPARATOR;
    }





    public static function get_instance(): View {
        if (self::$instance === NULL){

            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function dispatch(){

        $matches = Route::get_instance()->get_params();
        if($matches["module"]){
            self::$module = $matches["module"];
        }
        else {
            self::$module = "Main";
        }
        if($matches["name"]){
            self::$name = $matches["name"];
        }
        else {
            self::$name = "index";
        }
        if($matches["id"]){
            self::$id = $matches["id"];
        }
        if($matches["info"]){
            self::$info = $matches["info"];
        }
        self::render(self::$name, self::$module);
    }

    public static function render($name, $module = "", $param = []) {
        self::$param["content"] = self::include($name, $module, $param);
        include self::root_path(). "view" . DIRECTORY_SEPARATOR . "main.php";
    }

    public static function include($name, $module = "", $component = "", $param = []) {
        $path_view = self::classes_path();
        if($module) {
            $path_view .= "module" . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR. "view". DIRECTORY_SEPARATOR . $name . ".php";
        }
        if($component) {
            $path_view .= "component" . DIRECTORY_SEPARATOR . $component . DIRECTORY_SEPARATOR. "view". DIRECTORY_SEPARATOR . $name . ".php";
        }
        if($param) {
            foreach($param as $key => $value){
                self::$param["$key"] = $value;
            }
        }
        if(file_exists($path_view)) {
            ob_start();
            include $path_view;
            return ob_get_clean();
        } else {
            throw new Exception("Page not found", 404);
        }
    }

    public function __get($name) {
        if(in_array($name, array_keys(self::$param))){
            return self::$param[$name];
        }
    }

    public function __set($name, $value) {

        return self::$param[$name] = $value;
    }

    
    private function __clone()
    {
        throw new Exception("No clone", 1);
        
    }
    public function __wakeup()
    {
        throw new Exception("No unserialize", 1);
        
    }
}
?>