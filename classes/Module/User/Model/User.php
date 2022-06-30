<?php
namespace Module\User\Model;

    class User extends \Model{
        
        protected $table_name = "user";

        protected $table_columns = [
            "id" => [
                "type" => \Db::T_INT,
                "null_default" => \Db::T_NOT_NULL,
            ],
            "login" => [
                "type" => \Db::T_VARCHAR,
                "null_default" => \Db::T_NOT_NULL,
                "label" => "Логин",
            ],
            "password" => [
                "type" => \Db::T_VARCHAR,
                "null_default" => \Db::T_NOT_NULL,
                "label" => "Пароль",
            ],
            "status" => [
                "type" => \Db::T_VARCHAR . " DEFAULT 'user'",
                "null_default" => \Db::T_NOT_NULL,
            ],
            "active" => [
                "type" => \Db::T_INT . " DEFAULT '0'",
                "null_default" => \Db::T_NOT_NULL,
            ],
            "token_confirm" => [
                "type" => \Db::T_VARCHAR,
                "null_default" => \Db::T_NULL,
            ],
        ];
    }

?>