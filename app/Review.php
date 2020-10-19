<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;
use Illuminate\Support\Str;
use League\HTMLToMarkdown\HtmlConverter;

class Review extends Model
{
    public $timestamps = true;
    protected $table = 'reviews';

    protected $fillable = [
        'email', 'name', 'last_name', 'type', 'organisation_name', 'grade', 'text', 'photo_url'
    ];

    public function moderatorUrl()
    {
        return url("/admin/reviews/".$this->id."/edit");
    }

    public function descriptionMarkdown()
    {
        $converter = new HtmlConverter(array('strip_tags' => true));
        $converter->getConfig()->setOption('bold_style', '*');
        $converter->getConfig()->setOption('use_autolinks', false);

        $html = $this->text;
        $markdown = $converter->convert($html);

        return $markdown;
    }
}
