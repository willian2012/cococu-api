<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image',
        'cost',
        'start_date',
        'duration',
        'status',
        'participants_count',
        'created_at',
        'updated_at'
    ];
}
