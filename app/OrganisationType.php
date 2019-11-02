<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganisationType extends Model
{
    public function organisations()
    {
        return $this->hasOne(Organisation::class);
    }
}
