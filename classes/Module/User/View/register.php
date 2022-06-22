<?
Component::factory(
    [
        "name" => "form", "view" => "register"
    ], 
    [
        "target" => ["name" => "user", "module" => "user"]
    ]
)->render();
