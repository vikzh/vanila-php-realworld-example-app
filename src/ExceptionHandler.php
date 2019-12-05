<?php

use Whoops\Run;

const ENV = 'local';

$whoopsErrorHandler = new Run();
if(ENV === 'local') {
    $whoopsErrorHandler->prependHandler(new \Whoops\Handler\PrettyPageHandler());
} else {
    $whoopsErrorHandler->prependHandler(function ($e){
        echo 'Error Page and Developer notification';
    });
}
$whoopsErrorHandler->register();
