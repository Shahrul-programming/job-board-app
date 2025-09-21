<div x-data="{ mounted: false }" x-init="$nextTick(() => mounted = true)" class="max-w-2xl mx-auto">
    <div
        x-show="mounted"
        x-transition:enter="transition-all duration-600 ease-out"
        x-transition:enter-start="opacity-0 translate-y-8 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition-all duration-400 ease-in"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-8 scale-95"
        class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700">
        <form wire:submit.prevent="save">
            <!-- Form Header -->
            <div
                x-show="mounted"
                x-transition:enter="transition-all duration-500 ease-out delay-100"
                x-transition:enter-start="opacity-0 translate-x-8"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition-all duration-300 ease-in"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 translate-x-8"
                class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Create New Job</h2>
                <p class="text-gray-600 dark:text-gray-400">Fill in the details below to post a new job listing</p>
            </div>

            <!-- Job Title -->
            <div
                x-show="mounted"
                x-transition:enter="transition-all duration-400 ease-out delay-200"
                x-transition:enter-start="opacity-0 translate-y-6"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition-all duration-200 ease-in"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-6">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Job Title *
                </label>
                <input
                    type="text"
                    id="title"
                    wire:model="title"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500 hover:shadow-md focus:shadow-lg"
                    placeholder="Enter job title"
                    required
                >
                @error('title')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400 animate-in slide-in-from-top-2 duration-200">{{ $message }}</p>
                @enderror
            </div>

            <!-- Company -->
            <div
                x-show="mounted"
                x-transition:enter="transition-all duration-400 ease-out delay-300"
                x-transition:enter-start="opacity-0 translate-y-6"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition-all duration-200 ease-in"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-6">
                <label for="company" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Company *
                </label>
                <input
                    type="text"
                    id="company"
                    wire:model="company"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500 hover:shadow-md focus:shadow-lg"
                    placeholder="Enter company name"
                    required
                >
                @error('company')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400 animate-in slide-in-from-top-2 duration-200">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location Field -->
            <div
                x-show="mounted"
                x-transition:enter="transition-all duration-400 ease-out delay-400"
                x-transition:enter-start="opacity-0 translate-y-6"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition-all duration-200 ease-in"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-6">
                <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Location *
                </label>
                <input
                    type="text"
                    id="location"
                    wire:model="location"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500 hover:shadow-md focus:shadow-lg"
                    placeholder="Enter job location"
                    required
                >
                @error('location')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400 animate-in slide-in-from-top-2 duration-200">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description Field -->
            <div
                x-show="mounted"
                x-transition:enter="transition-all duration-400 ease-out delay-500"
                x-transition:enter-start="opacity-0 translate-y-6"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition-all duration-200 ease-in"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-6">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Description
                </label>
                <textarea
                    id="description"
                    wire:model="description"
                    rows="4"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500 hover:shadow-md focus:shadow-lg resize-none"
                    placeholder="Enter job description"
                ></textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400 animate-in slide-in-from-top-2 duration-200">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div
                x-show="mounted"
                x-transition:enter="transition-all duration-400 ease-out delay-600"
                x-transition:enter-start="opacity-0 translate-y-6"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition-all duration-200 ease-in"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-6"
                class="flex justify-end space-x-3 pt-4">
                <button
                    type="button"
                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-200 hover:shadow-md hover:scale-105"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 dark:bg-blue-700 border border-transparent rounded-md hover:bg-blue-700 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 transition-all duration-200 hover:shadow-md hover:scale-105 active:scale-95 relative overflow-hidden"
                >
                    <span wire:loading.remove class="relative z-10">Create Job</span>
                    <span wire:loading class="relative z-10 flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Creating...
                    </span>
                    <div wire:loading class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-700 animate-pulse"></div>
                </button>
            </div>
        </form>
    </div>
</div>
