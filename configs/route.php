<?php
return [
    
    [
        "url" => "/catalog/",
        "path" => "catalog/index.php"
    ],
    [
        "url" => "/catalog/(?<product_id>[^/]*)/",
        "path" => "catalog/detail.php"
    ],
    [
        "url" => "/catalog/rest/product/(?<product_id>[^/]*)/",
        "path" => "catalog/rest.php"
    ],
]
?>