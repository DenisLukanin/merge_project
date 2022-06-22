<?
$required = View::get_instance()->required;
$form_name = View::get_instance()->form_name;
$name_column = View::get_instance()->name_column;
?>

<label for="<?= $form_name ?>"><?= $form_name ?></label>
<input type="<?= $name_column == "password" || $name_column == "password_confirm" ? "password" : "text" ?>" name="<?= $name_column ?>" id="<?= $name_column ?>" <?= $required ? "required" : "" ?>>