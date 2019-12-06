<?php

use DI\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Template\Renderer;

use function DI\get;
use function DI\create;

$diContainer = new Container();
$diContainer->set(Request::class, Request::createFromGlobals());
$diContainer->set(Response::class, new Response());
$diContainer->set(
    Environment::class,
    function () {
        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        return new Environment($loader);
    }
);
$diContainer->set(Renderer::class, create(Renderer::class)->constructor(Environment::class));

return $diContainer;
