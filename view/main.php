<?php 
    if(isset($_COOKIE["auth_cookie"])) {
        $auth_cookie = Db::get_instance()->select("cookie", "token = '" . $_COOKIE["auth_cookie"]. "'", 1);
        $auth_user = $auth_cookie->fetch(PDO::FETCH_ASSOC);
    }
    ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?Layout::get_instance()->get_static_style();?>
    <title><?=View::get_instance()->title;?></title>
</head>
<body>
    
<?php 
    if($auth_user["login"]){
        echo $auth_user["login"]."<br>";?>

        <a href="/user/rest/user/logout">Выйти</a>

    <?php } else { ?>
        <a href="/user/view/auth">Авторизация</a><br>
        <a href="/user/view/register">Регистрация</a><br>
    <?php } 
    echo View::get_instance()->content;
?>
<?Layout::get_instance()->get_static_script();?>
</body>
</html>

