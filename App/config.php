<?php

return [
    "db" => [
        "dsn" => "mysql:host=mysql;dbname=project3;charset=utf8mb4",
        "user" => "root",
        "pass" => "12345",
    ],
    "paths" => [
        "uploads" => __DIR__ . "/../public/uploads/"
    ],
    "cookie" => [
        "name" => "session_cookie"
    ]
];