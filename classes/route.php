<?php
class Route {
    public static $instance;
    private $rules = [];
    private $url;
    private $params = [];

    public static function get_instance(): Route {
        if (self::$instance === null){
            self::$instance = new self();
        }
        
        return self::$instance;
    }

    private function __construct() {
        $this->rules = Config::get_config("route");
        $this->url = $_SERVER["REDIRECT_URL"];
    }

    public function load_file() {
        foreach($this->rules as $rule) {
            $template_preg = "#^{$rule["url"]}$#";
            $template_matches = preg_match($template_preg, $this->url, $matches);
            if($template_matches) {
                $this->set_params($matches);
                if($rule["path"]) {
                    include $rule["path"];
                    return;
                }
                if($rule["controller"]) {
                    $this->controller_func_execute($rule["controller"], $rule["action"]);
                    return;
                }
            }
            // throw new Exception("Page not found", 404);
        }
    }

    
    private function controller_func_execute(string $controller, string $action = '') {
        if(method_exists($controller, $action)){
            $function = $controller . "::{$action}";
            call_user_func($function);
        } else {
            echo "Такого метода нет";
        }
    }

    private function set_params(array $matches){
        // echo __METHOD__."<br>";
        foreach($matches as $name => $value){
            if(!is_numeric($name)){
                $this->params[$name] = $value;
            }
        }
    }

    public function get_params(string $key_param = "") {
        if($key_param) {
            if(isset($this->params[$key_param])) {
                return $this->params[$key_param];
            }
        }
        else
        {
            return $this->params;
        }
        
    }

    private function __clone() {
        throw new Exception("No clone", 1);
    }
    private function __wakeup()
    {
        throw new Exception("No unserialize", 1);
    }
}