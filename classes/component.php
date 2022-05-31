<?php

class Component {
    private static $params = [];

    public static function factory(array $info_about_component, array $params =[]) {
        if(!array_key_exists("name", $info_about_component)) {
            throw new Exception(500, "Dont exists name");
        }

        $name = $info_about_component["name"];
        $namespace = "\\Component\\" . ucfirst($name) . "\\Main";
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
        echo View::get_instance()->include("index", "", "Form");
    }
}