<?php


Layout::get_instance()->set_statics(["catalog.css", "delete_product.js", ]);



// $content = [
//     [
//         "title" => "Бодрящий Americano",
//         "photo" => "../static/img/americano.jpeg",
//         "price" => 100,
//         "description" => "Попробовав Americano с утра, больше не захочется начинать день по другому",
//     ],
//     [
//         "title" => "Классический Capuchino",
//         "photo" => "../static/img/capuchino.jpg",
//         "price" => 200,
//         "description" => "Самый популярный вид кофе Capuchino, лучший способ скоротать ожидание.",
//     ],
//     [
//         "title" => "Воздушный Latte",
//         "photo" => "../static/img/latte.jpg",
//         "price" => 300,
//         "description" => "Напиток которым можно наслаждаться каждый день",
//     ],
//     [
//         "title" => "Ароматный Amaretto",
//         "photo" => "../static/img/amareto.jpg",
//         "price" => 350,
//         "description" => "Неповторимый вкус бразильского Amaretto не оставить вас равнодушными.",
//     ],
// ];

// foreach ($content as $value){
//     $product = Model::factory(["name" => "product", "module" => "catalog"]);
//     $product->set($value);
//     $product->save();
// }

$product = Model::factory(["name" => "product", "module" => "catalog"]);
$products_list = $product->find_all();

?>

<div class="container">
    <a href="<?=$product->create_view_url()?>">Создать товар</a>
    <ul class="catalog_list">
        <?php foreach($products_list as $product) {?>
            <li class="catalog_item" product_id="<?= $product->id ?>">
                <div class="catalog_item_photo" style="background-image: url('<?= "../" .$product->photo ?> ');">
                    <a href="/catalog/view/product/<?= $product->id ?>/" class="catalog_item_photo_link">
                    </a>
                    <span class="delete_icon" delete_elem >x</span>
                </div>
                <div class="flex_wrap">
                    <a href="/catalog/view/product/<?= $product->id ?>/" class="catalog_item_title_link">
                    <h3 class="catalog_item_title"><?= $product->title ?></h3>
                    </a>
                    <span class="catalog_item_price"><?= $product->price ?> р.</span>
                </div>
                <p class="catalog_item_description">
                    <?= $product->description ?>
                </p>
            </li>

        <?php }?>
    </ul>
    


</div>