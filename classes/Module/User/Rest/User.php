<?php 

namespace Module\User\Rest;


class User{
    public function action_create(){
        $columns = $_POST;
        if($columns["password"] !== $columns["password_confirm"]) {
            header("Location: /user/view/register");
        } else {
            $columns["password"] = md5($columns["password"]);
            $model = \Model::factory(["name" => "user", "module" => "user"]);
    
            $model->set($columns);
            $model->save();
            header("Location: /catalog/view/");
        }
    }
    public function action_auth(){
        session_start();
        $columns = $_POST;
        $model = \Model::factory(["name" => "user", "module" => "user"]);
        $user = $model->find("login = '". $columns['login'] ."'");
        if($user->password == md5($columns["password"])){
            $_SESSION["user"]  = $user->login;

        }; 
    }
    public function action_logout(){
        session_start();
        unset($_SESSION["user"]);
        header("Location: /catalog/view/");
    }
    
}
?>