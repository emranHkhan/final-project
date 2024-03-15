<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactPageInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_page_email',
        'contact_page_address',
        'contact_page_mobile'
    ];
}
