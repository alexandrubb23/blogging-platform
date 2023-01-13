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
    public function getShortDescriptionAttribute(): string
    {
        $description = strip_tags($this->description);
        $limit = config('posts.limit_description', 20);
        return Str::limit($description, $limit, '...');
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
    public function getFormattedDateAttribute2()
    {
        return Carbon::parse($this->publishedAt)->format(config('posts.date_format'));
    }

    public function getFormattedDateAttribute(): string
    {
        $format = config('posts.date_format', 'Y-m-d');
        $carbon = Carbon::parse($this->publishedAt);

        return $carbon->format($format);
    }


    /**
     * Check if the post is published.
     * 
     * @return bool
     */
    public function getIsPublishedAttribute(): bool
    {
        return (bool) $this->publishedAt;
    }
}
