<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function create(Course $course)
    {
        if ($course->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('user.topics.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        if ($course->user_id !== auth()->id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'nullable|integer',
        ]);
        
        if (!isset($validated['order'])) {
            $validated['order'] = $course->topics()->max('order') + 1;
        }
        
        $course->topics()->create($validated);
        
        return redirect()->route('courses.show', $course)
            ->with('success', 'Topic created successfully!');
    }

    public function show(Topic $topic)
    {
        if ($topic->course->user_id !== auth()->id()) {
            abort(403);
        }
        
        $topic->load(['attempts' => function($query) {
            $query->latest();
        }, 'progress']);
        
        return view('user.topics.show', compact('topic'));
    }

    public function edit(Topic $topic)
    {
        if ($topic->course->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('user.topics.edit', compact('topic'));
    }

    public function update(Request $request, Topic $topic)
    {
        if ($topic->course->user_id !== auth()->id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'nullable|integer',
        ]);
        
        $topic->update($validated);
        
        return redirect()->route('topics.show', $topic)
            ->with('success', 'Topic updated successfully!');
    }

    public function destroy(Topic $topic)
    {
        if ($topic->course->user_id !== auth()->id()) {
            abort(403);
        }
        
        $courseId = $topic->course_id;
        $topic->delete();
        
        return redirect()->route('courses.show', $courseId)
            ->with('success', 'Topic deleted successfully!');
    }
}