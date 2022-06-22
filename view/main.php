<?php 
    session_start()
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
    if($_SESSION["user"]){
        echo $_SESSION["user"]."<br>";?>

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

