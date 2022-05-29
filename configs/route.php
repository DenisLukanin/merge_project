<?php
return [
    
    // [
    //     "url" => "/catalog/",
    //     "path" => "catalog/index.php"
    // ],
    // [
    //     "url" => "/catalog/(?<product_id>[^/]*)/",
    //     "path" => "catalog/detail.php"
    // ],
    // [
    //     "url" => "/catalog/rest/product/(?<product_id>[^/]*)/",
    //     "path" => "catalog/rest.php"
    // ],

    [
        'url' => '/(?<module>[^/]*)/rest/(?<rest>[^/]*)/(?<action>[^/]*)/(?<id>[^/]*)/',
        "controller" => "\Rest",
        "action" => "dispatch",
     ],
     [
         'url' => '/(?<module>[^/]*)/view/(?<name>[^/]*)/(?<id>[^/]*)/(?<info>[^/]*)/',
         'controller' => '\View',
         'action' => 'dispatch',
     ],
     [
         'url' => '/(?<module>[^/]*)/view/(?<name>[^/]*)/(?<id>[^/]*)/',
         'controller' => '\View',
         'action' => 'dispatch',
     ],
     [
         'url' => '/(?<module>[^/]*)/view/(?<name>[^/]*)/',
         'controller' => '\View',
         'action' => 'dispatch',
     ],
     [
         'url' => '/(?<module>[^/]*)/view/',
         'controller' => '\View',
         'action' => 'dispatch',
     ],
]
?>