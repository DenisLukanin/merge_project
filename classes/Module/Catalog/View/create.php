<?
Component::factory(
    [
        "name" => "form"
    ], 
    [
        "target" => ["name" => "product", "module" => "catalog"]
    ]
)->render();
