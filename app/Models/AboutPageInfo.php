<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutPageInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'about_page_title',
        'about_page_banner',
        'about_company_history',
        'about_company_vision'
    ];
}
