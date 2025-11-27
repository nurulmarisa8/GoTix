<div class="bg-white rounded-lg border border-gray-200 p-8 text-center shadow-sm">
    <div class="mx-auto inline-flex items-center justify-center w-28 h-28 rounded-full bg-indigo-50 text-indigo-600 mb-4">
        <!-- simple calendar icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
    </div>

    <h3 class="text-lg font-semibold text-gray-900 mb-2">No events matched</h3>
    <p class="text-sm text-gray-500 mb-4">We couldn't find any events for your current search or filters. Try clearing filters or search again.</p>

    <div class="flex justify-center gap-3">
        <a href="{{ route('events.index') }}" class="px-4 py-2 rounded-lg border border-gray-300 text-sm text-gray-700 bg-white hover:bg-gray-50">Show All Events</a>
        @if(request()->filled('search') || request()->filled('sort'))
            <a href="{{ route('events.index') }}" class="px-4 py-2 rounded-lg text-sm text-white bg-indigo-600 hover:bg-indigo-700">Clear filters</a>
        @endif
    </div>
</div>
