<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        $courses = auth()->user()->courses()
            ->with('track')
            ->orderBy('semester')
            ->get();
        
        return view('user.courses.index', compact('courses'));
    }

    public function create()
    {
        $tracks = Track::orderBy('order')->get();
        return view('user.courses.create', compact('tracks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'track_id' => 'required|exists:tracks,id',
            'code' => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'semester' => 'required|integer|min:1|max:8',
            'description' => 'nullable|string',
        ]);
        
        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(6);
        
        Course::create($validated);
        
        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully!');
    }

    public function show(Course $course)
    {
        if ($course->user_id !== auth()->id()) {
            abort(403);
        }
        
        $course->load(['topics' => function($query) {
            $query->orderBy('order');
        }]);
        
        return view('user.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        if ($course->user_id !== auth()->id()) {
            abort(403);
        }
        
        $tracks = Track::orderBy('order')->get();
        return view('user.courses.edit', compact('course', 'tracks'));
    }

    public function update(Request $request, Course $course)
    {
        if ($course->user_id !== auth()->id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'track_id' => 'required|exists:tracks,id',
            'code' => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'semester' => 'required|integer|min:1|max:8',
            'description' => 'nullable|string',
        ]);
        
        if ($validated['name'] !== $course->name) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(6);
        }
        
        $course->update($validated);
        
        return redirect()->route('courses.show', $course)
            ->with('success', 'Course updated successfully!');
    }

    public function destroy(Course $course)
    {
        if ($course->user_id !== auth()->id()) {
            abort(403);
        }
        
        $course->delete();
        
        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully!');
    }
}