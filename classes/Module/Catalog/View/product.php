<?
    Layout::get_instance()->set_statics(["vue.min.js", "product_detail.js", "product_detail.css"]);
    $id = Route::get_instance()->get_params("id");
    $product = Model::factory(["name" => "product", "module" => "catalog", "id" => $id]);
    View::get_instance()->title = "Товар";
?>

<div class="container" id="app" v-cloak  >
    <product product_id="<?=$product->id?>"></product>
</div>