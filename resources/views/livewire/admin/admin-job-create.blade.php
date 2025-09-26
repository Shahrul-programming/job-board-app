<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
    <!-- Header -->
    <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Create New Job</h3>
            <div class="text-sm text-gray-500 dark:text-gray-400">Admin Panel</div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="mx-4 mt-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-300 px-3 py-2 rounded-md text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mx-4 mt-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300 px-3 py-2 rounded-md text-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- Compact Form -->
    <form wire:submit.prevent="save" class="p-4 space-y-3">
        <!-- Job Title & Company (2 columns) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Job Title *
                </label>
                <input type="text" 
                       id="title" 
                       wire:model="title"
                       class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                       placeholder="e.g. Senior Software Engineer"
                       required>
                @error('title') 
                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> 
                @enderror
            </div>

            <div>
                <label for="company" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Company *
                </label>
                <input type="text" 
                       id="company" 
                       wire:model="company"
                       class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                       placeholder="e.g. Tech Company Inc"
                       required>
                @error('company') 
                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> 
                @enderror
            </div>
        </div>

        <!-- Location -->
        <div>
            <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Location *
            </label>
            <input type="text" 
                   id="location" 
                   wire:model="location"
                   class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                   placeholder="e.g. Kuala Lumpur, Malaysia"
                   required>
            @error('location') 
                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> 
            @enderror
        </div>

        <!-- Description (compact textarea) -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Description *
            </label>
            <textarea id="description" 
                      wire:model="description"
                      rows="3"
                      class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                      placeholder="Enter job description (max 1000 characters)"
                      required></textarea>
            @error('description') 
                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> 
            @enderror
            <div class="mt-1 text-right text-xs text-gray-500 dark:text-gray-400">
                {{ strlen($description) }}/1000 characters
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between items-center pt-2 border-t border-gray-100 dark:border-gray-700">
            <button type="button" 
                    wire:click="clear"
                    class="px-3 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-600 hover:bg-gray-200 dark:hover:bg-gray-500 rounded-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500">
                Clear Form
            </button>
            
            <button type="submit" 
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-50"
                    class="px-4 py-1.5 text-sm font-medium text-white bg-blue-600 dark:bg-blue-700 hover:bg-blue-700 dark:hover:bg-blue-600 rounded-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 flex items-center">
                <span wire:loading.remove>Create Job</span>
                <span wire:loading class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-3 w-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Creating...
                </span>
            </button>
        </div>
    </form>
</div>