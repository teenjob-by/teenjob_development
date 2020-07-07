<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GlobalMetric extends Model
{
    protected $table = 'global_metrics';

    protected $fillable = [
        'name',
        'value'
    ];

}
