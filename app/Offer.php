<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Jenssegers\Date\Date;
use Illuminate\Support\Str;

class Offer extends Model
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
        'offer_type',
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

    public function getPreviewDesc()
    {
//        $str = str_replace("</p>", "<br>", $this->description);
//        $str = str_replace("</a>", " ", $str);
//        $str = str_replace("</li>", "<br>", $str);
//        $str = str_replace("&nbsp;", ' ', strip_tags($str, '<br>'));
//        $str = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $str);
//        $out = strlen($str) > 300 ? mb_substr($str,0,299,'utf-8')."..." : $str;


        $desc = $this->description;
        $str = preg_replace('/\s+/', ' ', clean($desc));

        $out = Str::limit($str,200,'...');
        $out  = clean($out);
        return $out;
    }

    public function getSeoMeta()
    {

        $desc = $this->description;
        $str = preg_replace('/\s+/', ' ', clean($desc));
        $out = Str::limit($str,120,'...');
        $out  = clean($out);
        $out = strip_tags($out);

        return $out;
    }

    public function getTimeBeforeArchiving () {
        return (\Carbon\Carbon::parse($this->published_at)->addMonth());
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
