<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Article extends Eloquent
{
    protected $fillable = ['slug', 'text'];
}
