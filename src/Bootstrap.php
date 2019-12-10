<?php

namespace App;

require __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);

require_once __DIR__ . '/ExceptionHandler.php';

require_once __DIR__ . '/Database.php';

$diContainer = require_once(__DIR__ . '/Dependencies.php');

$routeInfo = require_once(__DIR__ . '/Router.php');

$controller = $routeInfo['_controller'];
$method = $routeInfo['_route'];

$response = $diContainer->call([$controller, $method], [
    'controllerName' => $routeInfo['_controller'],
    'method' => $routeInfo['_route'],
    'parameters' => $routeInfo
]);

$response->send();
