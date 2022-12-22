<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

// TODO: Move this to a config file
const LIMIT_CHARACTERS = 20;

class BlogPost extends Model
{
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getShortDescriptionAttribute()
    {
        return Str::words(strip_tags($this->description), LIMIT_CHARACTERS);
    }

    /**
     * Be very careful when echoing content that is supplied by users of your application. 
     * 
     * @see https://laravel.com/docs/5.6/blade#displaying-data
     */
    public function getDescriptionWithHtmlAttribute()
    {
        return Str::of($this->description)->toHtmlString();
    }

    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('F jS, Y');
    }
}
