<?
Component::factory(
    [
        "name" => "form", "view" => "auth"
    ], 
    [
        "target" => ["name" => "user", "module" => "user"]
    ]
)->render();
