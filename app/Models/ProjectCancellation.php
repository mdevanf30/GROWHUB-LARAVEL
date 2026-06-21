<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCancellation extends Model
{
    use HasFactory;

    protected $table = 'project_cancellations';
    protected $primaryKey = 'cancellation_id';
    protected $fillable = [
        'project_id',
        'cancelled_by',
        'cancelled_by_type',
        'reason',
        'status',
        'admin_notes',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'project_id');
    }

    public function cancelledBy()
    {
        return $this->belongsTo(User::class, 'cancelled_by', 'user_id');
    }
}
