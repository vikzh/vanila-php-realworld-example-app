<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

$capsule->addConnection([
    'driver' => 'sqlite',
    'database' => __DIR__ . '/../mydb.db'
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();
