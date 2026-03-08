<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->has('track')) {
            return redirect()->route('tracks.index');
        }
        
        $selectedTrack = Track::findOrFail($request->track);
        
        $courses = auth()->user()->courses()
            ->with('track')
            ->withCount('topics')
            ->where('track_id', $selectedTrack->id)
            ->orderBy('semester')
            ->get();
        
        return view('user.courses.index', compact('courses', 'selectedTrack'));
    }

    public function create(Request $request)
    {
        if (!$request->has('track')) {
            return redirect()->route('tracks.index');
        }
        
        $selectedTrack = Track::findOrFail($request->track);
        $tracks = Track::orderBy('order')->get();
        
        return view('user.courses.create', compact('tracks', 'selectedTrack'));
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
        
        return redirect()->route('courses.index', ['track' => $validated['track_id']])
            ->with('success', 'Course created successfully!');
    }

    public function edit(Course $course)
    {
        if ($course->user_id !== auth()->id()) {
            abort(403);
        }
        
        $course->load('track'); // Load track relationship
        
        return view('user.courses.edit', compact('course'));
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
        
        return redirect()->route('courses.index', ['track' => $course->track_id])
            ->with('success', 'Course updated successfully!');
    }

    public function destroy(Course $course)
    {
        if ($course->user_id !== auth()->id()) {
            abort(403);
        }
        
        $trackId = $course->track_id;
        $course->delete();
        
        return redirect()->route('courses.index', ['track' => $trackId])
            ->with('success', 'Course deleted successfully!');
    }
}