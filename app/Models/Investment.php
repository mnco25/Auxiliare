<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Investment extends Model
{
    use HasFactory;

    protected $primaryKey = 'investment_id';

    protected $fillable = [
        'investor_id',
        'project_id',
        'investment_amount',
        'investment_status',
        'investment_date'
    ];

    protected $dates = [
        'investment_date',
        'created_at',
        'updated_at'
    ];

    public function investor()
    {
        return $this->belongsTo(User::class, 'investor_id', 'user_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}