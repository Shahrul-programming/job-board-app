<div x-data="{}" x-cloak>
    <!-- Modal -->
    <div
        x-show="$wire.showModal"
        x-transition:enter="transition-all duration-500 ease-out"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition-all duration-300 ease-in"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <!-- Modal Backdrop -->
        <div
            x-transition:enter="transition-opacity duration-300 ease-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-200 ease-in"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-all duration-300 animate-in fade-in"
            wire:click="closeModal"></div>

        <!-- Modal Content -->
        <div
            x-transition:enter="transition-all duration-600 ease-out delay-100"
            x-transition:enter-start="opacity-0 translate-y-8 scale-95 rotate-1"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100 rotate-0"
            x-transition:leave="transition-all duration-400 ease-in"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100 rotate-0"
            x-transition:leave-end="opacity-0 translate-y-8 scale-95 -rotate-1"
            class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 shadow-xl max-w-lg w-full max-h-[90vh] overflow-y-auto border border-gray-200 dark:border-gray-700">
            <!-- Modal Header -->
            <div
                x-transition:enter="transition-all duration-400 ease-out delay-200"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition-all duration-200 ease-in"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-4"
                class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white animate-pulse">
                    Edit Job
                </h3>
                <button wire:click="closeModal"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all duration-200 hover:scale-110 hover:rotate-90 p-2 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20">
                    <svg class="w-6 h-6 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div
                x-transition:enter="transition-all duration-500 ease-out delay-300"
                x-transition:enter-start="opacity-0 translate-y-6"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition-all duration-300 ease-in"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-6"
                class="p-6 max-h-96 overflow-y-auto">
                <form wire:submit.prevent="update" class="space-y-4">
                    <!-- Job Title -->
                    <div
                        x-transition:enter="transition-all duration-400 ease-out delay-400"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition-all duration-200 ease-in"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Job Title
                        </label>
                        <input type="text"
                               id="title"
                               wire:model="title"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500 hover:shadow-md focus:shadow-lg"
                               placeholder="Enter job title">
                        @error('title')
                            <span class="text-red-500 text-sm mt-1 animate-in slide-in-from-top-2 duration-200">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Company -->
                    <div
                        x-transition:enter="transition-all duration-400 ease-out delay-500"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition-all duration-200 ease-in"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-4">
                        <label for="company" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Company
                        </label>
                        <input type="text"
                               id="company"
                               wire:model="company"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500 hover:shadow-md focus:shadow-lg"
                               placeholder="Enter company name">
                        @error('company')
                            <span class="text-red-500 text-sm mt-1 animate-in slide-in-from-top-2 duration-200">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div
                        x-transition:enter="transition-all duration-400 ease-out delay-600"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition-all duration-200 ease-in"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-4">
                        <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Location
                        </label>
                        <input type="text"
                               id="location"
                               wire:model="location"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500 hover:shadow-md focus:shadow-lg"
                               placeholder="Enter location">
                        @error('location')
                            <span class="text-red-500 text-sm mt-1 animate-in slide-in-from-top-2 duration-200">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div
                        x-transition:enter="transition-all duration-400 ease-out delay-700"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition-all duration-200 ease-in"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea id="description"
                                  wire:model="description"
                                  rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500 hover:shadow-md focus:shadow-lg resize-none"
                                  placeholder="Enter job description"></textarea>
                        @error('description')
                            <span class="text-red-500 text-sm mt-1 animate-in slide-in-from-top-2 duration-200">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div
                x-transition:enter="transition-all duration-400 ease-out delay-800"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition-all duration-200 ease-in"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-4"
                class="flex items-center justify-end p-6 border-t border-gray-200 dark:border-gray-700 space-x-3">
                <button type="button"
                        wire:click="closeModal"
                        class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                    Cancel
                </button>
                <button wire:click="update" class="px-6 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                    Update Job
                </button>
            </div>
        </div>
    </div>
</div>
