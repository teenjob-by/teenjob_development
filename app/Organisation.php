<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Organisation extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'organisations';

    protected $fillable = [
        'name', 'email', 'city_id', 'password', 'link', 'phone', 'contact', 'unique_identifier', 'type', 'role', 'request', 'alt_phone', 'alt_email', 'status', 'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getType()
    {
        return $this->belongsTo(OrganisationType::class,'type', 'id');
    }

    public function internships()
    {
        return $this->hasMany(Internship::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function volunteerings()
    {
        return $this->hasMany(Volunteering::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new Notifications\MailResetPasswordNotification($token));
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
