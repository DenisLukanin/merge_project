<?php 
include "bootstrap.php";
Layout::get_instance()->set_static("catalog.css");
Layout::get_instance()->get_static_style();

// Db::get_instance()->create_table("test", ["id" => [Db::T_INT, Db::A_I, Db::P_KEY]]);
// aa(Db::get_instance()->table_exists("test2"));
// Db::get_instance()->insert("test", [
//     "id" => "27",
// ]);
$data = Db::get_instance()->select("test");
print_r($data->fetch());
?>