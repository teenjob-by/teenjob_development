<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;
use Illuminate\Support\Str;

class Downloading_email extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'email'
    ];
}
