<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('tracks.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                @if($selectedTrack)
                    <span class="w-4 h-4 rounded-full" style="background-color: {{ $selectedTrack->color }};"></span>
                @endif
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $selectedTrack ? $selectedTrack->name : 'My Courses' }}
                </h2>
            </div>
            <a href="{{ route('courses.create', request()->query()) }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                + Add Course
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mt-6">
                @if($courses->isEmpty())
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                        <div class="p-16 text-center">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">
                                No courses yet
                            </h3>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Get started by creating your first course{{ $selectedTrack ? ' in this track' : '' }}.
                            </p>
                            <div class="mt-8">
                                <a href="{{ route('courses.create', request()->query()) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition">
                                    + Create Course
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Group by Semester --}}
                    @php
                        $coursesBySemester = $courses->groupBy('semester')->sortKeys();
                    @endphp

                    <div class="space-y-6">
                        @foreach($coursesBySemester as $semester => $semesterCourses)
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                                <div class="p-6">
                                    <div class="flex items-center gap-3 mb-6">
                                        @if($selectedTrack)
                                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-lg text-sm font-bold text-white" 
                                                  style="background-color: {{ $selectedTrack->color }};">
                                                {{ $semester }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-lg text-sm font-bold text-white bg-gray-500">
                                                {{ $semester }}
                                            </span>
                                        @endif
                                        <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100">
                                            Semester {{ $semester }}
                                        </h3>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            ({{ $semesterCourses->count() }} {{ Str::plural('course', $semesterCourses->count()) }})
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        @foreach($semesterCourses as $course)
                                            <div class="p-6 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl transition-all">
                                                <div class="flex flex-col h-full">
                                                    {{-- Header with Edit Button --}}
                                                    <div class="flex items-start justify-between mb-3">
                                                        <div class="flex items-center gap-2">
                                                            @if($course->track)
                                                                <span class="w-3 h-3 rounded-full" style="background-color: {{ $course->track->color }};"></span>
                                                            @endif
                                                            <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-semibold bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-200">
                                                                {{ $course->code }}
                                                            </span>
                                                        </div>
                                                        
                                                        {{-- Edit Button --}}
                                                        <a href="{{ route('courses.edit', $course) }}" 
                                                           class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors"
                                                           title="Edit course">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                            </svg>
                                                        </a>
                                                    </div>

                                                    {{-- Course Name (clickable to show/topics) --}}
                                                    <a href="{{ route('courses.show', $course) }}" class="block mb-3">
                                                        <h4 class="font-semibold text-lg text-gray-900 dark:text-gray-100 hover:text-gray-600 dark:hover:text-gray-300 transition-colors line-clamp-2">
                                                            {{ $course->name }}
                                                        </h4>
                                                    </a>

                                                    {{-- Description --}}
                                                    @if($course->description)
                                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3 flex-grow">
                                                            {{ $course->description }}
                                                        </p>
                                                    @else
                                                        <div class="flex-grow"></div>
                                                    @endif

                                                    {{-- Footer --}}
                                                    <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600">
                                                        <a href="{{ route('courses.show', $course) }}" 
                                                           class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                            </svg>
                                                            <span class="font-medium">{{ $course->topics_count ?? 0 }} {{ Str::plural('topic', $course->topics_count ?? 0) }}</span>
                                                        </a>
                                                        @if(!$selectedTrack && $course->track)
                                                            <span class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-[150px]">
                                                                {{ $course->track->name }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>