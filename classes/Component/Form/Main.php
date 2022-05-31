<?php
namespace Component\Form;

class Main extends \Component {

    public static function get_field(){
        $model = self::get_target();
        return static::validate($model->get_form_fields());
    }

    private static function validate($fields){
        $types = [];
        foreach($fields as $name_column => $values_column) {
            if(array_key_exists("form_type", $values_column)) {
                $types[$name_column]["type"] = $values_column["form_type"];
            }
            else {
                $types[$name_column]["type"] = $values_column["type"];
            }
            $types[$name_column]["label"] = $values_column["label"];
            !$values_column["null_default"] == \Db::T_NULL ? $types[$name_column]["required"] = true : $types[$name_column]["required"] = false;
            $types[$name_column]["name_column"] = $name_column;
        };
        return $types;
    }
}