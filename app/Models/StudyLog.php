<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudyLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'topic_id',
        'attempt_id',
        'studied_at',
    ];

    protected $casts = [
        'studied_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function attempt()
    {
        return $this->belongsTo(TopicAttempt::class, 'attempt_id');
    }
}