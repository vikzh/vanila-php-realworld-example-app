<?php

use DI\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Helpers\JwtHelper;

$diContainer = new Container();
$diContainer->set(Request::class, Request::createFromGlobals());
$diContainer->set(Response::class, new JsonResponse());
$diContainer->set(JwtHelper::class, new JwtHelper());

return $diContainer;
