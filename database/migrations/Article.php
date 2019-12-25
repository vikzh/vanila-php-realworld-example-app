<?php

namespace Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('articles', function ($table) {
    $table->increments('id');
    $table->integer('user_id');
    $table->string('slug')->unique();
    $table->string('title');
    $table->string('description');
    $table->text('body');
    $table->timestamps();

    $table->foreign('user_id')
        ->references('id')
        ->on('users')
        ->onDelete('cascade');
});
