<?php 

namespace Module\Catalog\Rest;


class Product{
    public function action_get() {
        $id = \Route::get_instance()->get_params("id");
        $model = \Model::factory(["name" => "product", "module" => "catalog", "id" => $id]);
        return $model;
    }
    public function action_delete() {
        $id = \Route::get_instance()->get_params("id");
        $model = \Model::factory(["name" => "product", "module" => "catalog", "id" => $id]);
        $model->delete($id); 

    }
    public function action_create(){
        $columns = $_POST;
        $model = \Model::factory(["name" => "product", "module" => "catalog"]);
        $model->set($columns);
        $model->save();
        header("Location: /catalog/view/");
    }
}
?>