<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectApplicant extends Model
{
    use HasFactory;

    protected $table = 'project_applicants';
    protected $primaryKey = 'application_id';
    protected $fillable = [
        'project_id',
        'user_id',
        'cover_letter',
        'portfolio_file',
        'status',
        'decided_at',
    ];

    protected $casts = [
        'decided_at' => 'datetime',
    ];

    /**
     * Relationship dengan Project
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'project_id');
    }

    /**
     * Relationship dengan User (Freelancer)
     */
    public function freelancer()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
