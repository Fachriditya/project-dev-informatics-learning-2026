<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('All Tracks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-4">
                @foreach($tracks as $track)
                    <a href="{{ route('courses.index', ['track' => $track->id]) }}" 
                       class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg hover:shadow-lg transition-shadow duration-200">
                        <div class="p-6 flex items-center gap-4">
                            <span class="w-4 h-4 rounded-full shrink-0" style="background-color: {{ $track->color }};"></span>
                            <div class="flex-1">
                                <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100">
                                    {{ $track->name }}
                                </h3>
                                @if($track->description)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        {{ $track->description }}
                                    </p>
                                @endif
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $track->courses()->where('user_id', auth()->id())->count() }} courses
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>