<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Allow mass assignment for these fields
    protected $fillable = [
        'category',
        'title',
        'slug',
        'subtitle',
        'content'
    ];

    // Optional default values
    protected $attributes = [
        'subtitle' => '',
        'content' => '',
    ];

    // No constructor needed — Eloquent handles instantiation
}
