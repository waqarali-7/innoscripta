<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    // Fields allowed for mass assignment
    protected $fillable = [
        'title',
        'description',
        'content',
        'published_at',
        'source',
        'author',
        'url',
        'url_to_image',
        'category',
    ];
}
