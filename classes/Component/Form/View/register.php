<?php
$fields = Component\Form\Main::get_field();
$path_rest = Component\Form\Main::get_target()->create_rest_url();
?>
<div class="error-password">Неверный логин или пароль</div>
<div class="error-login">Такой пользователь уже существует!</div>
<div class="register">
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
        echo View::get_instance()->include("fields/varchar", "", "form", ["required" => true, "form_name" => "Подтверждение пароля", "name_column" => "password_confirm"]);
    ?>
    <input register__button type="submit" value="Отправить">
</div>


<?Layout::get_instance()->set_static("register.js")?>