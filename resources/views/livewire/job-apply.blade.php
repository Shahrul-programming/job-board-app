<div x-data="{ showModal: @entangle('showModal'), job: @entangle('job') }" 
     x-cloak
     @redirect-to-login.window="window.location.href = '{{ route('login') }}'">
    <!-- Application Modal -->
    <div
        x-show="showModal"
        x-transition:enter="transition-all duration-500 ease-out"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition-all duration-300 ease-in"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 z-60 overflow-y-auto">
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

        <!-- Modal Container -->
        <div class="flex min-h-full items-center justify-center p-4">
            <!-- Modal Content -->
            <div
                x-transition:enter="transition-all duration-600 ease-out delay-100"
                x-transition:enter-start="opacity-0 translate-y-8 scale-95 rotate-1"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100 rotate-0"
                x-transition:leave="transition-all duration-400 ease-in"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100 rotate-0"
                x-transition:leave-end="opacity-0 translate-y-8 scale-95 -rotate-1"
                class="relative bg-white dark:bg-gray-800 rounded-lg shadow-2xl max-w-4xl w-full border border-gray-200 dark:border-gray-700">
                <!-- Modal Header -->
                <div
                    x-transition:enter="transition-all duration-400 ease-out delay-200"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition-all duration-200 ease-in"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-4"
                    class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                            Apply for Position
                        </h2>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">
                            {{ $job?->title }} at {{ $job?->company }}
                        </p>
                    </div>
                    <button wire:click="closeModal"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all duration-200 hover:scale-110 hover:rotate-90 p-2 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20 flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Scrollable Form Content -->
                <div class="max-h-[70vh] overflow-y-auto">
                    <!-- Form -->
                    <form wire:submit="submitApplication" class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Personal Information Section -->
                            <div
                                x-transition:enter="transition-all duration-500 ease-out delay-300"
                                x-transition:enter-start="opacity-0 translate-x-8"
                                x-transition:enter-end="opacity-100 translate-x-0"
                                x-transition:leave="transition-all duration-300 ease-in"
                                x-transition:leave-start="opacity-100 translate-x-0"
                                x-transition:leave-end="opacity-0 translate-x-8"
                                class="space-y-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                                        Personal Information
                                    </h3>

                                    <!-- Full Name -->
                                    <div
                                        x-transition:enter="transition-all duration-400 ease-out delay-400"
                                        x-transition:enter-start="opacity-0 translate-y-4"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition-all duration-200 ease-in"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 translate-y-4">
                                        <label for="full_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Full Name *
                                        </label>
                                        <input type="text" id="full_name" wire:model="full_name"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500 hover:shadow-md focus:shadow-lg">
                                        @error('full_name') <span class="text-red-500 text-sm animate-in slide-in-from-top-2 duration-200">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Email -->
                                    <div
                                        x-transition:enter="transition-all duration-400 ease-out delay-500"
                                        x-transition:enter-start="opacity-0 translate-y-4"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition-all duration-200 ease-in"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 translate-y-4">
                                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Email Address *
                                        </label>
                                        <input type="email" id="email" wire:model="email"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500 hover:shadow-md focus:shadow-lg">
                                        @error('email') <span class="text-red-500 text-sm animate-in slide-in-from-top-2 duration-200">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Phone Number -->
                                    <div
                                        x-transition:enter="transition-all duration-400 ease-out delay-600"
                                        x-transition:enter-start="opacity-0 translate-y-4"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition-all duration-200 ease-in"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 translate-y-4">
                                        <label for="phone_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Phone Number *
                                        </label>
                                        <input type="tel" id="phone_number" wire:model="phone_number"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500 hover:shadow-md focus:shadow-lg">
                                        @error('phone_number') <span class="text-red-500 text-sm animate-in slide-in-from-top-2 duration-200">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <!-- Professional Information -->
                                <div
                                    x-transition:enter="transition-all duration-400 ease-out delay-700"
                                    x-transition:enter-start="opacity-0 translate-y-6"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition-all duration-200 ease-in"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 translate-y-6">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                                        Professional Information
                                    </h3>

                                    <!-- Resume Upload -->
                                    <div
                                        x-transition:enter="transition-all duration-400 ease-out delay-800"
                                        x-transition:enter-start="opacity-0 translate-y-4"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition-all duration-200 ease-in"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 translate-y-4"
                                        class="mb-4">
                                        <label for="resume" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Resume/CV * <span class="text-gray-500">(PDF, DOC, DOCX - Max 10MB)</span>
                                        </label>
                                        <input type="file" id="resume" wire:model="resume" accept=".pdf,.doc,.docx"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500 hover:shadow-md focus:shadow-lg file:mr-4 file:py-2 file:px-4 file:rounded-l-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        @error('resume') <span class="text-red-500 text-sm animate-in slide-in-from-top-2 duration-200">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Cover Letter -->
                                    <div
                                        x-transition:enter="transition-all duration-400 ease-out delay-900"
                                        x-transition:enter-start="opacity-0 translate-y-4"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition-all duration-200 ease-in"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 translate-y-4"
                                        class="mb-4">
                                        <label for="cover_letter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Cover Letter
                                        </label>
                                        <textarea id="cover_letter" wire:model="cover_letter" rows="4"
                                                  placeholder="Write your cover letter here, or upload a file below..."
                                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500 hover:shadow-md focus:shadow-lg resize-none"></textarea>
                                        @error('cover_letter') <span class="text-red-500 text-sm animate-in slide-in-from-top-2 duration-200">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Cover Letter File Upload -->
                                    <div
                                        x-transition:enter="transition-all duration-400 ease-out delay-1000"
                                        x-transition:enter-start="opacity-0 translate-y-4"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition-all duration-200 ease-in"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 translate-y-4"
                                        class="mb-4">
                                        <label for="cover_letter_path" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Or Upload Cover Letter <span class="text-gray-500">(PDF, DOC, DOCX - Max 10MB)</span>
                                        </label>
                                        <input type="file" id="cover_letter_path" wire:model="cover_letter_path" accept=".pdf,.doc,.docx"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500 hover:shadow-md focus:shadow-lg file:mr-4 file:py-2 file:px-4 file:rounded-l-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                        @error('cover_letter_path') <span class="text-red-500 text-sm animate-in slide-in-from-top-2 duration-200">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- LinkedIn URL -->
                                    <div
                                        x-transition:enter="transition-all duration-400 ease-out delay-1100"
                                        x-transition:enter-start="opacity-0 translate-y-4"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition-all duration-200 ease-in"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 translate-y-4"
                                        class="mb-4">
                                        <label for="linkedin_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            LinkedIn Profile URL
                                        </label>
                                        <input type="url" id="linkedin_url" wire:model="linkedin_url"
                                               placeholder="https://linkedin.com/in/yourprofile"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500 hover:shadow-md focus:shadow-lg">
                                        @error('linkedin_url') <span class="text-red-500 text-sm animate-in slide-in-from-top-2 duration-200">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Portfolio URL -->
                                    <div
                                        x-transition:enter="transition-all duration-400 ease-out delay-1200"
                                        x-transition:enter-start="opacity-0 translate-y-4"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition-all duration-200 ease-in"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 translate-y-4"
                                        class="mb-4">
                                        <label for="portfolio_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Portfolio/Website URL
                                        </label>
                                        <input type="url" id="portfolio_url" wire:model="portfolio_url"
                                               placeholder="https://yourwebsite.com"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500 hover:shadow-md focus:shadow-lg">
                                        @error('portfolio_url') <span class="text-red-500 text-sm animate-in slide-in-from-top-2 duration-200">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Application Specific Section -->
                            <div
                                x-transition:enter="transition-all duration-500 ease-out delay-300"
                                x-transition:enter-start="opacity-0 translate-x-8"
                                x-transition:enter-end="opacity-100 translate-x-0"
                                x-transition:leave="transition-all duration-300 ease-in"
                                x-transition:leave-start="opacity-100 translate-x-0"
                                x-transition:leave-end="opacity-0 translate-x-8"
                                class="space-y-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                                        Application Details
                                    </h3>

                                    <!-- Why Interested -->
                                    <div
                                        x-transition:enter="transition-all duration-400 ease-out delay-500"
                                        x-transition:enter-start="opacity-0 translate-y-4"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition-all duration-200 ease-in"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 translate-y-4"
                                        class="mb-4">
                                        <label for="why_interested" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Why are you interested in this position? *
                                        </label>
                                        <textarea id="why_interested" wire:model="why_interested" rows="4"
                                                  placeholder="Tell us why you're excited about this opportunity..."
                                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500 hover:shadow-md focus:shadow-lg resize-none"></textarea>
                                        @error('why_interested') <span class="text-red-500 text-sm animate-in slide-in-from-top-2 duration-200">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Expected Salary -->
                                    <div
                                        x-transition:enter="transition-all duration-400 ease-out delay-600"
                                        x-transition:enter-start="opacity-0 translate-y-4"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition-all duration-200 ease-in"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 translate-y-4"
                                        class="mb-4">
                                        <label for="expected_salary" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Expected Salary
                                        </label>
                                        <input type="text" id="expected_salary" wire:model="expected_salary"
                                               placeholder="e.g., $50,000 - $60,000 per year"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500 hover:shadow-md focus:shadow-lg">
                                        @error('expected_salary') <span class="text-red-500 text-sm animate-in slide-in-from-top-2 duration-200">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Available Start Date -->
                                    <div
                                        x-transition:enter="transition-all duration-400 ease-out delay-700"
                                        x-transition:enter-start="opacity-0 translate-y-4"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition-all duration-200 ease-in"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 translate-y-4"
                                        class="mb-4">
                                        <label for="available_start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Available Start Date *
                                        </label>
                                        <input type="date" id="available_start_date" wire:model="available_start_date"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-gray-400 dark:hover:border-gray-500 hover:shadow-md focus:shadow-lg">
                                        @error('available_start_date') <span class="text-red-500 text-sm animate-in slide-in-from-top-2 duration-200">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Willing to Relocate -->
                                    <div
                                        x-transition:enter="transition-all duration-400 ease-out delay-800"
                                        x-transition:enter-start="opacity-0 translate-y-4"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition-all duration-200 ease-in"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 translate-y-4"
                                        class="mb-4">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="willing_to_relocate" wire:model="willing_to_relocate"
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition-all duration-200 hover:scale-110">
                                            <label for="willing_to_relocate" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                                I am willing to relocate for this position
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div
                            x-transition:enter="transition-all duration-400 ease-out delay-1300"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition-all duration-200 ease-in"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-4"
                            class="flex items-center justify-end pt-6 border-t border-gray-200 dark:border-gray-700 space-x-3">
                            <button type="button" wire:click="closeModal"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-all duration-200 hover:shadow-md hover:scale-105 flex-shrink-0">
                                Cancel
                            </button>
                            <button type="submit"
                                    wire:loading.attr="disabled"
                                    class="px-6 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-all duration-200 hover:shadow-md hover:scale-105 active:scale-95 disabled:opacity-50 relative overflow-hidden flex-shrink-0">
                                <span wire:loading.remove>Submit Application</span>
                                <span wire:loading class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Submitting...
                                </span>
                                <div wire:loading class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-700 animate-pulse"></div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if (session()->has('message'))
        <div class="fixed top-4 right-4 z-50 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded animate-in slide-in-from-right duration-300">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="fixed top-4 right-4 z-50 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded animate-in slide-in-from-right duration-300">
            {{ session('error') }}
        </div>
    @endif
</div>
