<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectProgress extends Model
{
    use HasFactory;

    protected $table = 'project_progress';
    protected $primaryKey = 'progress_id';
    protected $fillable = [
        'project_id',
        'freelancer_id',
        'current_stage',
        'project_link',
        'project_file',
        'payment_proof',
        'payment_status',
        'rating_for_freelancer',
        'rating_for_umkm',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'project_id');
    }

    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id', 'user_id');
    }
}
