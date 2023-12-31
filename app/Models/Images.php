<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'url',
        'status',
        'activity',
        'user_id',
        'created_at',
        'updated_at'
    ];

    
}
