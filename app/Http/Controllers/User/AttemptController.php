<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use App\Models\TopicAttempt;
use Illuminate\Http\Request;

class AttemptController extends Controller
{
    
    public function create(Topic $topic)
    {
        if ($topic->course->user_id !== auth()->id()) {
            abort(403);
        }
        
        $attemptNumber = $topic->attempts()->count() + 1;
        
        return view('user.attempts.create', compact('topic', 'attemptNumber'));
    }

    public function store(Request $request, Topic $topic)
    {
        if ($topic->course->user_id !== auth()->id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'content' => 'nullable|file|mimes:pdf|max:10240', // 10MB max
            'review' => 'nullable|string',
        ]);
        
        $attemptNumber = $topic->attempts()->count() + 1;
        
        $attemptData = [
            'attempt_ke' => $attemptNumber,
            'review' => $validated['review'] ?? null,
        ];
        
        if ($request->hasFile('content')) {
            $path = $request->file('content')->store('contents', 'public');
            $attemptData['content'] = $path;
        }
        
        $attempt = $topic->attempts()->create($attemptData);
        
        return redirect()->route('attempts.show', $attempt)
            ->with('success', 'Attempt created successfully!');
    }

    public function show(TopicAttempt $attempt)
    {
        if ($attempt->topic->course->user_id !== auth()->id()) {
            abort(403);
        }
        
        $attempt->load('quizzes');
        
        return view('user.attempts.show', compact('attempt'));
    }
}