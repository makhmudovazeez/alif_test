<?php

use App\Router\Route;

$app = new Route();

$app::get('/', 'MainController', 'index');

$app->run();