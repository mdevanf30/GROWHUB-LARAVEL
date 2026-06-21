<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;
    protected $table = 'umkm';
    protected $primaryKey = 'umkm_id';
    protected $fillable = [
        'user_id',
        'business_name',
        'description',
        'supporting_file',
        'category',
        'address',
        'phone_number',
        'rating',
    ];
    public function projects()
    {
        return $this->hasMany(Project::class, 'umkm_id', 'umkm_id');
    }
}

