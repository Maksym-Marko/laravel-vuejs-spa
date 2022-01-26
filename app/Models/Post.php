<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_author',
        'post_content',
        'post_title',
        'post_excerpt',
        'post_status',
        'post_slug',
        'post_type'
    ];

}
