<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Jenssegers\Date\Date;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use League\HTMLToMarkdown\HtmlConverter;

class Offer extends Model
{
    use Notifiable;
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
        'salary',
        'salary_type_id',
        'work_time_type_id',
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

    public function url()
    {
        switch ($this->offer_type) {
            case 0:
                $url = url("/volunteerings-for-teens/".$this->id);
                break;
            case 1:
                $url = url("/internships-for-teens/".$this->id);
                break;
            case 2:
                $url = url("/jobs-for-teens/".$this->id);
                break;
        }

        return $url;
    }

    public function moderatorUrl()
    {
        switch ($this->offer_type) {
            case 0:
                $url = url("/admin/volunteerings/".$this->id."/edit");
                break;
            case 1:
                $url = url("/admin/internships/".$this->id."/edit");
                break;
            case 2:
                $url = url("/admin/jobs/".$this->id."/edit");
                break;
        }

        return $url;
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

    public function descriptionMarkdown()
    {
        $converter = new HtmlConverter(array('strip_tags' => true));
        $converter->getConfig()->setOption('bold_style', '*');
        $converter->getConfig()->setOption('use_autolinks', false);

        $html = $this->description;
        $markdown = $converter->convert($html);

        return $markdown;
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

    public function type()
    {
        if($this->offer_type == 0)
            return 'volunteering';
        if($this->offer_type == 1)
            return 'internship';
        return 'job';
    }

    public function salaryType()
    {
        return $this->belongsTo(SalaryType::class);
    }

    public function workTimeType()
    {
        return $this->belongsTo(WorkTimeType::class);
    }

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
