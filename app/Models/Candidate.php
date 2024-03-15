<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = ['candidate_info', 'user_id'];

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'candidate_job', 'candidate_id', 'job_id');
    }
}
