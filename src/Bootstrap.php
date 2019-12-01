<?php

namespace App;

require __DIR__ . '/../vendor/autoload.php';

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

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
$response = new \Symfony\Component\HttpFoundation\Response();
$response->setContent('Test text');
$response->prepare($request);
$response->send();
