<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';  // Ensure the table name is correct
    protected $primaryKey = 'user_id';  // Ensure the primary key is correct
    public $incrementing = true;        // Ensure the key is incrementing
    protected $keyType = 'int';         // Set the key type

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',  // Make sure this field is included
        'last_name',
        'user_type',
        'account_status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', // Changed from password_hash to password
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'skills' => 'array',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class, 'user_id');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'user_id');
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }
}
