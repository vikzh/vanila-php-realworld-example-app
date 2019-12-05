<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use App\Controllers\ArticleController;

return function (RoutingConfigurator $routes) {
    $routes->add('index', '/articles')->controller(ArticleController::class);
    $routes->add('show', '/articles/{slug}')->controller(ArticleController::class);
};
