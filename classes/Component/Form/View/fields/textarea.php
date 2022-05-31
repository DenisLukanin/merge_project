<?
$required = View::get_instance()->required;
$form_name = View::get_instance()->form_name;
$name_column = View::get_instance()->name_column;
?>

<label for="<?= $form_name ?>"><?= $form_name ?></label>
<textarea name="<?= $name_column ?>" <?= $required ? "required" : "" ?>  id="<?= $form_name ?>" cols="30" rows="10"></textarea>