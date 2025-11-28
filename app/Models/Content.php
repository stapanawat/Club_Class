<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'type',
        'teaser',
        'excerpt',
        'body',
        'video_url',
        'thumbnail_url',
        'views',
        'category_id',
    ];

    // ⭐ 1) ความสัมพันธ์ Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // ⭐ 2) ความสัมพันธ์ Tags (Many-to-Many)
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'content_tag', 'content_id', 'tag_id');
    }
}
