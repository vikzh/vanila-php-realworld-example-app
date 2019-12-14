<?php

use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Request;

$requestContext = new RequestContext();
$requestContext->fromRequest(Request::createFromGlobals());

$fileLocator = new FileLocator([__DIR__]);
$loader = new PhpFileLoader($fileLocator);
$routes = $loader->load('ApiRoutes.php');
$routes->addPrefix('/api');
$matcher = new UrlMatcher($routes, $requestContext);
return $matcher->matchRequest(Request::createFromGlobals());
