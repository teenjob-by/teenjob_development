<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Internship extends Model
{
    protected $fillable = [
        'title',
        'city_id',
        'speciality',
        'age',
        'type',
        'description',
        'contact',
        'phone',
        'email',
        'alt_phone',
        'status',
        'published_at',
        'organisation_id'
    ];

    protected $dates = ['published_at'];

    public function getPublishedAtAttribute($date)
    {
        return new Date($date);
    }

    public function speciality()
    {
        return $this->belongsTo(OfferSpecialization::class,'speciality')->first();
    }

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
