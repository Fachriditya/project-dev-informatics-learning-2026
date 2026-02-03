<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TopicQuiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'attempt_id',
        'type',
        'question',
        'answer',
        'answer_key',
    ];

    public function attempt()
    {
        return $this->belongsTo(TopicAttempt::class, 'attempt_id');
    }
}