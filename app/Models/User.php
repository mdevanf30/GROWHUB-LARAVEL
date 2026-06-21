<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    
    protected $table = 'users';

    
    protected $primaryKey = 'user_id';

    
    public $incrementing = true;
    protected $keyType = 'int';

    
    protected $fillable = [
        'full_name',
        'birth_date',
        'email_address',
        'home_address',
        'phone_number',
        'password',
        'rating',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}