<?php
class Rest {
    private static $matches;
    private static $model;


    
    public static function dispatch(){
        self::$matches = \Route::get_instance()->get_params();
        $class = '\\module\\' . self::$matches["module"] . "\\" . 'rest' . "\\" . self::$matches["rest"];
        $action = "action_" . self::$matches["action"];
        
        if(class_exists($class)) {
            $rest = new $class;
            if(method_exists($class, $action)) {
                self::before();
                self::$model = $rest->$action();
                self::after();
            }
            else
            {
                throw new Exception("Page not found", 404);
            }
        }
        else
        {
            throw new Exception("Page not found", 404);
        }

    }
    
    public static function before() {}

    public static function after() {
        if(self::$model) {
            
            echo self::$model->get_json();
        }
    }
}
?>