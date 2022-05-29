<?php 

namespace Catalog\Rest;

use Catalog\Model\Product as Model_Product;

class Product{
    public function action_get() {
        $id = \Route::get_instance()->get_params("id");
        // $model = \Model::factory(["name" => "product", "module" => "catalog", "id" => $id]);
        $model = new Model_Product($id);
        return $model;
    }
    public function action_delete() {
        $id = \Route::get_instance()->get_params("id");
        $model = new Model_Product();
        $model->delete($id); 

    }
}
?>