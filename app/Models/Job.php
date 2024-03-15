<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'salary',
        'location',
        'tags',
        'company_id',
        'category_id',
        'status'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function candidates()
    {
        return $this->belongsToMany(Candidate::class, 'candidate_job', 'job_id', 'candidate_id');
    }
}
