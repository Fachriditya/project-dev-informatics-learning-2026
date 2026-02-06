<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Track extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'order',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

        public function user()
    {
        return $this->belongsTo(User::class);
    }
}