<?php
$fields = Component\Form\Main::get_field();
$path_rest = Component\Form\Main::get_target()->auth_rest_url();
if(!$_COOKIE["auth_cookie"]){
?>
<div class="error-auth">Неверный логин или пароль</div>
<div class="auth">
<?php
    foreach($fields as $field) {
        switch($field["type"]) {
            case Db::T_VARCHAR: 
                echo View::get_instance()->include("fields/varchar", "", "form", ["required" => $field["required"], "form_name" => $field["label"], "name_column" => $field["name_column"]]); 
                break;
            case Db::T_INT: 
                echo View::get_instance()->include("fields/int", "", "form", ["required" => $field["required"], "form_name" => $field["label"], "name_column" => $field["name_column"]]); 
                break;
            case Db::T_TEXTAREA: 
                echo View::get_instance()->include("fields/textarea", "", "form", ["required" => $field["required"], "form_name" => $field["label"] , "name_column" => $field["name_column"]]); 
                break;
        }
    }
?>
<input auth__button type="submit" value="Отправить">
</div>
<?} else {?>
    <div class="login">Вы уже залогенены</div>
<? }
Layout::get_instance()->set_static("auth.js");
?>
<!-- 123sanekphp sanekphp@gmail.com -->
<!-- bOAIXj9uIFVpxUxqk7Ex -->
