<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TopicProgress extends Model
{
    use HasFactory;

    protected $table = 'topic_progress';

    protected $fillable = [
        'user_id',
        'topic_id',
        'is_completed',
        'completed_at',
        'total_attempts',
        'best_grade',
        'best_letter_grade',
        'is_remidi',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'is_remidi' => 'boolean',
        'best_grade' => 'float',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}