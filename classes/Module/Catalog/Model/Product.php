<?php
namespace Module\Catalog\Model;

    class Product extends \Model{
        
        protected $table_name = "product";

        protected $table_columns = [
            "id" => [
                "type" => \Db::T_INT,
                "null_default" => \Db::T_NOT_NULL,
            ],
            "title" => [
                "type" => \Db::T_VARCHAR,
                "null_default" => \Db::T_NOT_NULL,
                "lable" => "Заголовок",
            ],
            "description" => [
                "type" => \Db::T_VARCHAR,
                "null_default" => \Db::T_NULL,
                "lable" => "Описание",
                "form_type" => \Db::T_TEXTAREA
            ],
            "photo" => [
                "type" => \Db::T_VARCHAR,
                "null_default" =>\Db::T_NULL,
            ],
            "price" => [
                "type" => \Db::T_INT,
                "null_default" => \Db::T_NOT_NULL,
                "lable" => "Цена",
            ],
        ];
    }

?>