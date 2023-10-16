<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityParticipants extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'user_id',
        'created_at',
        'updated_at'
    ];

    protected $table = 'activity_participants';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activities::class);
    }
}
