<?
$required = View::get_instance()->required;
$form_name = View::get_instance()->form_name;
$name_column = View::get_instance()->name_column;
?>

<label for="<?= $form_name ?>"><?= $form_name ?></label>
<input type="text" name="<?= $name_column ?>" id="<?= $form_name ?>" <?= $required ? "required" : "" ?>>