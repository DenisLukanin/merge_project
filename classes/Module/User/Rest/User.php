<?php 

namespace Module\User\Rest;


class User{
    public function action_register(){
        
        $columns = (array) json_decode(file_get_contents('php://input'));
        $model = \Model::factory(["name" => "user", "module" => "user"]);
        $user = $model->find("login = '". $columns["login"] ."'");
        if($user->login) {
            echo json_encode([
                'success' => 'false'
            ]);
        } else {
            session_start();
            $columns["password"] = password_hash($columns["password"],PASSWORD_DEFAULT);
            $model->set($columns);
            $model->save();
            $_SESSION["user"]  = $columns["login"];
            echo json_encode([
                'success' => 'true',
                'redirect_url' => \Config::get_config("redirect_form", "register")
            ]);
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