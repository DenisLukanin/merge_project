<?php
$id = Route::get_instance()->get_params("product_id");
$model = new Product($id);
echo $model->get_json();