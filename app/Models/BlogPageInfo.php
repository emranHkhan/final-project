<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPageInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'blogs_page_title',
        'blogs_page_banner'
    ];
}
