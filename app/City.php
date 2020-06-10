<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

    protected $fillable = [
        'name'
    ];

    public function internship()
    {
        return $this->hasOne(Internship::class);
    }

    public function volunteering()
    {
        return $this->hasOne(Volunteering::class);
    }

    public function offer()
    {
        return $this->hasOne(Offer::class);
    }

    public function organisation()
    {
        return $this->hasOne(Organisation::class);
    }

    public function event()
    {
        return $this->hasOne(Event::class);
    }

    public function getNameAttribute($value)
    {
        if (\App::isLocale('be')) {
            return $this->attributes['name_be'];
        }
        return $this->attributes['name'];
    }
}
