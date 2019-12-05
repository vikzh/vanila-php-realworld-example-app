<?php

use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Matcher\UrlMatcher;

$fileLocator = new FileLocator([__DIR__]);
$loader = new PhpFileLoader($fileLocator);
$routes = $loader->load('Routes.php');
$matcher = new UrlMatcher($routes, $requestContext);
return $matcher->matchRequest(\Symfony\Component\HttpFoundation\Request::createFromGlobals());
