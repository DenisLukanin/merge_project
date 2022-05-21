<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?Layout::get_instance()->set_statics(["vue.min.js", "product_detail.js", "product_detail.css"]);
    Layout::get_instance()->get_static_style();
    $id = Route::get_instance()->get_params("product_id");
    $product = new Product($id)?>
    <title>Document</title>
</head>
<body>
    
<div class="container" id="app" v-cloak  >
    <product product_id="<?=$product->id?>"></product>
</div>
<?
Layout::get_instance()->get_static_script();
?>
</body>
</html>
