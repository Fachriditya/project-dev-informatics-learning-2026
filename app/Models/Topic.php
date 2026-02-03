<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'order',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function attempts()
    {
        return $this->hasMany(TopicAttempt::class);
    }

    public function progress()
    {
        return $this->hasOne(TopicProgress::class);
    }

    public function studyLogs()
    {
        return $this->hasMany(StudyLog::class);
    }
}