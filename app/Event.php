<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Date\Date;
use Illuminate\Support\Str;
use League\HTMLToMarkdown\HtmlConverter;

class Event extends Model
{
    use Notifiable;
    protected $fillable = [
        'title',
        'city_id',
        'address',
        'date_start',
        'date_finish',
        'age',
        'type_id',
        'description',
        'image',
        'location',
        'status',
        'organisation_id',
        'published_at'
    ];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    public function type()
    {
        return $this->belongsTo(EventType::class);
    }

    public function descriptionMarkdown()
    {
        $converter = new HtmlConverter(array('strip_tags' => true));
        $converter->getConfig()->setOption('bold_style', '*');
        $converter->getConfig()->setOption('use_autolinks', false);

        $html = $this->description;
        $markdown = $converter->convert($html);

        return $markdown;
    }

    public function url()
    {
        $url = url("/events/".$this->id);
        return $url;
    }

    public function moderatorUrl()
    {
        $url = url("/admin/events/".$this->id."/edit");
        return $url;
    }

    public function getPreviewDesc()
    {
//        $str = str_replace("</p>", "<br>", );
//        $str = str_replace("</a>", " ", $str);
//        $str = str_replace("</li>", "<br>", $str);
//        $str = str_replace("&nbsp;", ' ', strip_tags($str, '<br>'));
//        $str = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $str);
//        $str = strip_tags($str);
//        $out = strlen($str) > 120 ? mb_substr($str,0,120,'utf-8')."..." : $str;
        $desc = $this->description;
        $str = preg_replace('/\s+/', ' ', clean($desc));
        $pattern = '/<p(.*?)>((.*?)+)\<\/p>/';
        $replacement = '${2}<br/>';

        //$out = preg_replace($pattern, $replacement, $str);
        //$out = Str::limit($out,80,'...');


        $out = Str::limit($str,80,'...');
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

    protected $dates = ['published_at', 'date_start', 'date_finish'];

    public function getPublishedAtAttribute($date)
    {
        return new Date($date);
    }

    public function getDateStartAttribute($date)
    {
        return new Date($date);
    }

    public function getDateFinishAttribute($date)
    {
        return new Date($date);
    }

    public function getLocationAttribute($location)
    {
        $location = trim($location, "()");
        $explode_location = array_map('floatval' ,explode(',', $location));

        return $explode_location;
    }

    public function getTimeBeforeArchiving () {
        return (\Carbon\Carbon::parse($this->date_start));
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    protected $casts = [
        'published_at' => 'datetime',
        'date_start' => 'datetime',
        'date_finish' => 'datetime',
    ];
}
