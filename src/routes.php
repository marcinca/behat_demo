<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/version', ApiController::class . ':version');
$app->map(['get','post'], '/login', ApiController::class . ':login');
$app->get('/[{name}]', ApiController::class . ':default');
