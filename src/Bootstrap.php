<?php

namespace App;

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\ArticleController;
use App\Template\Renderer;
use DI\Container;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use function DI\create;

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

$diContainer = new Container();
$diContainer->set(Request::class, Request::createFromGlobals());
$diContainer->set(Response::class, new Response());
$diContainer->set(Environment::class, function (){
   $loader = new FilesystemLoader(__DIR__ . '/../templates');
   return new Environment($loader);
});
$diContainer->set(Renderer::class, create(Renderer::class)->constructor(\DI\get(Environment::class)));

$matcher = new UrlMatcher($routes, $requestContext);
$routeInfo = $matcher->matchRequest($diContainer->get(Request::class));

$controller = $routeInfo['_controller'];
$method = $routeInfo['_route'];

$response = $diContainer->call([$controller, $method]);
$response->send();
