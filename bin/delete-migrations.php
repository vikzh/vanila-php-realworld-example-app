<?php

require __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../src/Database.php';

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->dropAllTables();
