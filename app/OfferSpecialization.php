<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferSpecialization extends Model
{
    protected $table = 'offer_specializations';

    protected $fillable = [
        'name'
    ];

    public function speciality()
    {
        return $this->hasMany(Event::class);
    }

}
