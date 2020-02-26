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

    public function getNameAttribute($value)
    {
        if (\App::isLocale('be')) {
            return $this->attributes['name_be'];
        }
        return $this->attributes['name_be'];
    }
}
