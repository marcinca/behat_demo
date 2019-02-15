<?php
/**
 * Middleware basic httpauth for all paths
 */
$app->add(new Tuupola\Middleware\HttpBasicAuthentication([
    "path" => "/auth",
    "secure" => false,
    "users" => [
        "user" => getenv("USER_PASSWORD")
    ]
]));