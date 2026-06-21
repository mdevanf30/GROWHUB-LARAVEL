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

    public function isAdmin(): bool
    {
        $adminEmails = ['admin@growhub.com', 'admin@gmail.com'];
        return in_array($this->email_address, $adminEmails) || str_ends_with($this->email_address, 'growhubadmin.gmail.com');
    }
}