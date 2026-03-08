<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $totalCourses = $user->courses()->count();
        $totalTopics = $user->courses()->withCount('topics')->get()->sum('topics_count');
        $completedTopics = $user->topicProgress()->where('is_completed', true)->count();
        
        $currentStreak = 0;
        
        $recentActivity = $user->studyLogs()
            ->with('topic.course')
            ->latest()
            ->take(5)
            ->get();
        
        $tracks = \App\Models\Track::withCount(['courses' => function($query) use ($user) {
            $query->where('user_id', $user->id);
        }])->orderBy('order')->get();
        
        return view('user.dashboard', compact(
            'totalCourses',
            'totalTopics',
            'completedTopics',
            'currentStreak',
            'recentActivity',
            'tracks'
        ));
    }
}