<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image_url',
        'publisher',
        'event_date',
        'source_url',
        'published',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];
}
