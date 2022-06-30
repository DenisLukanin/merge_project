<?php 

namespace Module\User\Rest;


class User{
    public function action_register_confirm(){
        $token_confirm = $_SERVER["QUERY_STRING"];
        $model = \Model::factory(["name" => "user", "module" => "user"]);
        $user = $model->find("token_confirm = '". $token_confirm ."'");
        \Db::get_instance()->update("user", $user->id, ["active" => 1]);
        $redirect = \Config::get_config("redirect_form", "register");
        header("Location: /$redirect");
    }

    public function action_register(){
        
        $columns = (array) json_decode(file_get_contents('php://input'));
        $model = \Model::factory(["name" => "user", "module" => "user"]);
        $user = $model->find("login = '". $columns["login"] ."'");
        if($user->login) {
            echo json_encode([
                'success' => 'false'
            ]);
        } else {
            $token = md5(time());
            $token_confirm = md5(time());
            mail($columns["login"],"Подтверждение регистрации", "http://merge/user/rest/user/register_confirm?$token_confirm");
            $columns["token_confirm"] = $token_confirm;
            setcookie("auth_cookie", $token, time() + (3600 * 24 * 365), "/");
            \Db::get_instance()->insert("cookie", ["token" => $token, "login" => $columns["login"]]);
            $columns["password"] = password_hash($columns["password"],PASSWORD_DEFAULT);
            $model->set($columns);
            $model->save();
            echo json_encode([
                'success' => 'true',
                'redirect_url' => \Config::get_config("redirect_form", "register")
            ]);
        }
        
    }
    public function action_auth(){
        $columns = (array) json_decode(file_get_contents('php://input'));
        $model = \Model::factory(["name" => "user", "module" => "user"]);
        $user = $model->find("login = '". $columns['login'] ."'");
        if(password_verify($columns["password"], $user->password)){
            $token = md5(time());
            setcookie("auth_cookie", $token, time() + (3600 * 24 * 365), "/");
            \Db::get_instance()->insert("cookie", ["token" => $token, "login" => $columns["login"]]);
            echo json_encode([
                'success' => 'true',
                'redirect_url' => \Config::get_config("redirect_form", "register")
            ]);
        }else {
            echo json_encode([
                'success' => 'false',
            ]);
        }
    }
    public function action_logout(){
        unset($_COOKIE["auth_cookie"]);
        setcookie('auth_cookie', null, -1, '/');
        $redirect = \Config::get_config("redirect_form", "register");
        header("Location: /$redirect");
    }
    
}
?>