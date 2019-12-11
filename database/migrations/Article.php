<?php

namespace Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('articles', function ($table) {
    $table->increments('id');
    $table->string('slug');
    $table->string('title');
    $table->string('description');
    $table->text('body');
    $table->timestamps();
});
