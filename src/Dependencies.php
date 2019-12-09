<?php

use DI\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

$diContainer = new Container();
$diContainer->set(Request::class, Request::createFromGlobals());
$diContainer->set(Response::class, new JsonResponse());

return $diContainer;
