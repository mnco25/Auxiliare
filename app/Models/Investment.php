<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $fillable = [
        'investor_id',
        'project_id',
        'investment_amount',
        'investment_status'
    ];

    public function investor()
    {
        return $this->belongsTo(User::class, 'investor_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}