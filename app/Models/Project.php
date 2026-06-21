<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'project';
    protected $primaryKey = 'project_id';
    protected $fillable = [
        'umkm_id',
        'project_title',
        'category',
        'description',
        'project_budget',
        'deadline',
        'project_address',
        'requirements',
        'reference_file',
        'status',
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'umkm_id', 'umkm_id');
    }

    /**
     * Relationship dengan ProjectApplicant
     */
    public function applicants()
    {
        return $this->hasMany(ProjectApplicant::class, 'project_id', 'project_id');
    }
}