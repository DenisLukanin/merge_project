<?php

class Component {
    private static $params = [];
    private static $component_name;
    private static $view_name;

    public static function factory(array $info_about_component, array $params =[]) {
        if(!array_key_exists("name", $info_about_component)) {
            throw new Exception(500, "Dont exists name");
        }

        self::$component_name = $info_about_component["name"];
        self::$view_name = $info_about_component["view"];

        $namespace = "\\Component\\" . ucfirst(self::$component_name) . "\\Main";
        return new $namespace($params);
    }

    public function __construct($params){
        self::$params = $params;
    }

    public static function get_target() {
        $model = Model::factory(self::$params["target"]);
        return $model;
    }


    public function render() {
        echo View::get_instance()->include(self::$view_name, "", self::$component_name);
    }
}