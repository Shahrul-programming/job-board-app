<div x-data="{ mounted: false }" x-init="$nextTick(() => mounted = true)" class="w-full mb-5">
    <!-- Search Input Section -->
    <div 
        x-show="mounted"
        x-transition:enter="transition-all duration-600 ease-out"
        x-transition:enter-start="opacity-0 translate-y-8 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition-all duration-400 ease-in"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-8 scale-95"
        class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6 hover:shadow-lg transition-shadow duration-200">
        <div class="relative">
            <div 
                x-show="mounted"
                x-transition:enter="transition-all duration-500 ease-out delay-200"
                x-transition:enter-start="opacity-0 translate-x-8"
                x-transition:enter-end="opacity-100 translate-x-0"
                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="text"
                   wire:model.live="search"
                   placeholder="Search for jobs, companies, or locations..."
                   x-show="mounted"
                   x-transition:enter="transition-all duration-600 ease-out delay-300"
                   x-transition:enter-start="opacity-0 translate-y-4"
                   x-transition:enter-end="opacity-100 translate-y-0"
                   class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-all duration-200 hover:shadow-sm focus:shadow-md">
        </div>

        @if($search)
            <div 
                x-show="mounted"
                x-transition:enter="transition-all duration-500 ease-out delay-400"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition-all duration-300 ease-in"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-4"
                class="mt-3 flex items-center text-sm text-gray-600 dark:text-gray-400">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Searching for: "{{ $search }}"
                <button wire:click="clearSearch" class="ml-2 text-blue-500 hover:text-blue-700 text-xs hover:scale-105 transition-all duration-200">
                    Clear
                </button>
            </div>
        @endif
    </div>

    @if (config('app.debug'))
        <!-- Component Lifecycle Logs (Debug Mode Only) -->
        <div 
            x-show="mounted"
            x-transition:enter="transition-all duration-500 ease-out delay-500"
            x-transition:enter-start="opacity-0 translate-y-8"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="mt-4 bg-gray-50 dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Search Component Lifecycle Log:</h3>
            <div class="text-xs text-gray-600 dark:text-gray-400 space-y-1 font-mono max-h-32 overflow-y-auto">
                @foreach ($log as $entry)
                    <div 
                        x-transition:enter="transition-all duration-300 ease-out"
                        x-transition:enter-start="opacity-0 scale-90"
                        x-transition:enter-end="opacity-100 scale-100"
                        class="py-1 px-2 bg-white dark:bg-gray-800 rounded border border-gray-100 dark:border-gray-700">{{ $entry }}</div>
                @endforeach
            </div>
        </div>
    @endif
</div>
