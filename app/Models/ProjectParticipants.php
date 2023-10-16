<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectParticipants extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'created_at',
        'updated_at'
    ];

    protected $table = 'project_participants';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
