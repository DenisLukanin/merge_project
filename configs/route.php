<?php
return [
    [
        'url' => '/(?<module>[^/]*)/rest/(?<rest>[^/]*)/(?<action>[^/]*)/(?<id>[^/]*)/',
        "controller" => "\Rest",
        "action" => "dispatch",
     ],
     [
         'url' => '/(?<module>[^/]*)/rest/(?<rest>[^/]*)/(?<action>[^/]*)/',
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