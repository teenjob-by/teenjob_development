<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganisationType extends Model
{
    public function organisations()
    {
        return $this->hasOne(Organisation::class);
    }

    public function getNameAttribute($value)
    {
        if (\App::isLocale('be')) {
            return $this->attributes['name_be'];
        }
        return $this->attributes['name'];
    }
}
