<?php

namespace src\controllers;

class Home
{
    public function index($params)
    {
        $users = all("users");

        return [
            "view" => "home.php",
            "data" => ["title" => "home",
                        "users" => $users]
        ];
    }
}