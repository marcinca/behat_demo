<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/version', ApiController::class . ':version');
$app->get('/[{name}]', ApiController::class . ':default');
