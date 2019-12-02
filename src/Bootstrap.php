<?php

namespace App;

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\ArticleController;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

error_reporting(E_ALL);

const ENV = 'local';

$whoopsErrorHandler = new \Whoops\Run();
if(ENV === 'local') {
    $whoopsErrorHandler->prependHandler(new \Whoops\Handler\PrettyPageHandler());
} else {
    $whoopsErrorHandler->prependHandler(function ($e){
        echo 'Error Page and Developer notification';
    });
}
$whoopsErrorHandler->register();

$route1 = new Route('/articles', ['_controller' => ArticleController::class]);
$route2 = new Route('/articles/{slug}', ['_controller' => ArticleController::class]);
$routes = new RouteCollection();
$routes->add('index', $route1);
$routes->add('show', $route2);

$requestContext = new RequestContext();
$requestContext->fromRequest(Request::createFromGlobals());

$request = Request::createFromGlobals();
$response = new Response();

$matcher = new UrlMatcher($routes, $requestContext);
$routeInfo = $matcher->matchRequest($request);

$controller = new $routeInfo['_controller']($response);
$method = $routeInfo['_route'];
$controller->$method();

$response->prepare($request);
$response->send();
