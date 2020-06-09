<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalaryType extends Model
{
    protected $table = 'salary_types';

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
