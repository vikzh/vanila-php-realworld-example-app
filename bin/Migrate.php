<?php

$_SERVER['PATH_INFO'] = '/migrate';

require __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../src/Database.php';

include_once __DIR__ . '/../database/migrations/Article.php';
include_once __DIR__ . '/../database/migrations/User.php';
