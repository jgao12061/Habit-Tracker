<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    protected $fillable = [
        'title',
        'category',
        'user_id',
        'streak',
        'is_active',
        'description',
        'last_completed_at',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}