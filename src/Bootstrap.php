<?php

namespace App;

require __DIR__ . '/../vendor/autoload.php';

use App\Template\Renderer;
use DI\Container;
use Symfony\Component\Routing\RequestContext;
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

$diContainer = new Container();
$diContainer->set(Request::class, Request::createFromGlobals());
$diContainer->set(Response::class, new Response());
$diContainer->set(Environment::class, function (){
   $loader = new FilesystemLoader(__DIR__ . '/../templates');
   return new Environment($loader);
});
$diContainer->set(Renderer::class, create(Renderer::class)->constructor(\DI\get(Environment::class)));

$routeInfo = require_once(__DIR__ . '/Router.php');
$controller = $routeInfo['_controller'];
$method = $routeInfo['_route'];

$response = $diContainer->call([$controller, $method], [
    'controllerName' => $routeInfo['_controller'],
    'method' => $routeInfo['_route'],
    'parameters' => $routeInfo
]);
$response->send();
