<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
        'publisher',
        'event_date',
        'source_url',
        'published',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('assets/image/placeholder.png');
        }
        if (\Illuminate\Support\Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }
}
