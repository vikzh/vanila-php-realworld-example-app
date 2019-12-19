<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use App\Controllers\ArticleController;
use App\Controllers\UserController;

return function (RoutingConfigurator $routes) {
    $routes->add('index', 'articles')->controller(ArticleController::class);
    $routes->add('show', 'articles/{slug}')->controller(ArticleController::class);

    $routes->add('store', 'users')->methods(['POST'])->controller(UserController::class);
    $routes->add('login', 'login')->methods(['POST'])->controller(UserController::class);
};
