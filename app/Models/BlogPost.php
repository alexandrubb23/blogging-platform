<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'publishedAt',
        'external_post_id'
    ];

    /**
     * Post user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post's short description.
     * 
     * @return string
     */
    public function getShortDescriptionAttribute()
    {
        return Str::words(strip_tags($this->description), config('posts.limit_description'));
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

    /**
     * Get the post's created_at date in a human readable format.
     * 
     * @return string
     */
    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->publishedAt)->format(config('posts.date_format'));
    }

    /**
     * Check if the post is published.
     * 
     * @return bool
     */
    public function getIsPublishedAttribute()
    {
        return $this->publishedAt !== null;
    }
}
