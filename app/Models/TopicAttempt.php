<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TopicAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'attempt_ke',
        'content',
        'review',
        'grade',
        'letter_grade',
        'is_passed',
        'refleksi',
    ];

    protected $casts = [
        'is_passed' => 'boolean',
        'grade' => 'float',
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function quizzes()
    {
        return $this->hasMany(TopicQuiz::class, 'attempt_id');
    }

    public function studyLog()
    {
        return $this->hasOne(StudyLog::class, 'attempt_id');
    }
}