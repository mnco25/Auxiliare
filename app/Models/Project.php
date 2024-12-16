<?php
// app/Models/Project.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'user_id',  // To track which entrepreneur created it
        'title',
        'description',
        'funding_goal',
        'category',
        'start_date',
        'end_date',
        'status',
        'current_funding'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getProgressPercentage()
    {
        if ($this->funding_goal <= 0) {
            return 0;
        }
        
        $percentage = ($this->current_funding / $this->funding_goal) * 100;
        return min(100, round($percentage)); // Ensures percentage doesn't exceed 100
    }
}
