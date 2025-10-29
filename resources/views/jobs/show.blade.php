@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <!-- Job Details -->
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">{{ $job->title }}</h1>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Company</h3>
                            <p class="text-lg text-gray-900 dark:text-gray-100">{{ $job->company }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Location</h3>
                            <p class="text-lg text-gray-900 dark:text-gray-100">{{ $job->location }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Job Type</h3>
                            <p class="text-lg text-gray-900 dark:text-gray-100">{{ ucfirst($job->job_type) }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Salary</h3>
                            <p class="text-lg text-gray-900 dark:text-gray-100">${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Description</h3>
                        <div class="prose prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                            {!! $job->description !!}
                        </div>
                    </div>

                    @if($job->requirements)
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Requirements</h3>
                        <div class="prose prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                            {!! nl2br(e($job->requirements)) !!}
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between border-t border-gray-200 dark:border-gray-700 pt-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Posted {{ $job->created_at->diffForHumans() }}
                    </div>
                    
                    <div class="flex space-x-3">
                        <a href="{{ route('jobs.index') }}" 
                           class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                            Back to Jobs
                        </a>
                        
                        @auth
                            <!-- Job Apply trigger for Livewire component -->
                            <button onclick="applyForJob({{ $job->id }})"
                                    class="px-6 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                                Apply Now
                            </button>
                        @else
                            <div class="flex space-x-2">
                                <a href="{{ route('login', ['redirect' => request()->url()]) }}" 
                                   class="px-4 py-2 text-sm font-medium text-blue-600 border border-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    Login to Apply
                                </a>
                                <a href="{{ route('register', ['redirect' => request()->url()]) }}" 
                                   class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                                    Register & Apply
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@auth
    <!-- Include Livewire components for authenticated users -->
    <livewire:job-apply />
@endauth

<script>
    function applyForJob(jobId) {
        Livewire.dispatch('open-job-apply', { jobId: jobId });
    }

    // Smart handler that detects which modal is open and routes accordingly
    // MUST be defined BEFORE modals load
    window.handleAiUseResponse = function(promptId) {
        console.log('handleAiUseResponse called with prompt ID:', promptId);
        
        // Check which modal is open by checking display style
        const jobDescModal = document.getElementById('aiModal');
        const coverLetterModal = document.getElementById('coverLetterAiModal');
        
        const isJobDescModalOpen = jobDescModal && (
            window.getComputedStyle(jobDescModal).display !== 'none' && 
            !jobDescModal.classList.contains('hidden')
        );
        
        const isCoverLetterModalOpen = coverLetterModal && (
            window.getComputedStyle(coverLetterModal).display !== 'none'
        );
        
        console.log('Job desc modal open:', isJobDescModalOpen);
        console.log('Cover letter modal open:', isCoverLetterModalOpen);
        
        if (isCoverLetterModalOpen && typeof window.handleCoverLetterUseResponse === 'function') {
            console.log('Routing to cover letter handler');
            window.handleCoverLetterUseResponse(promptId);
        } else if (isJobDescModalOpen && typeof window.handleUseResponse === 'function') {
            console.log('Routing to job description handler');
            window.handleUseResponse(promptId);
        } else {
            console.error('No appropriate handler found or modal not detected');
            console.log('Available handlers:', {
                handleCoverLetterUseResponse: typeof window.handleCoverLetterUseResponse,
                handleUseResponse: typeof window.handleUseResponse
            });
        }
    };

    // Cover Letter AI Modal functions - defined globally before Livewire component loads
    window.isCoverLetterModalOpen = false;

    window.openCoverLetterAiModal = function() {
        console.log('=== OPENING COVER LETTER AI MODAL ===');
        const modal = document.getElementById('coverLetterAiModal');
        
        if (!modal) {
            console.error('❌ Cover letter AI modal element not found!');
            return;
        }
        
        console.log('✅ Modal element found');
        
        // FORCE display with important attributes
        modal.style.display = 'block';
        modal.style.opacity = '1';
        modal.style.visibility = 'visible';
        modal.style.zIndex = '99999';
        
        console.log('Modal opened successfully');
        
        window.isCoverLetterModalOpen = true;
        document.body.style.overflow = 'hidden';
        
        // Load AI component with job context
        loadCoverLetterAiComponent();
    };

    window.closeCoverLetterAiModal = function() {
        const modal = document.getElementById('coverLetterAiModal');
        if (!modal) return;
        
        modal.style.display = 'none';
        window.isCoverLetterModalOpen = false;
        document.body.style.overflow = 'auto';
    };

    function loadCoverLetterAiComponent() {
        const jobTitle = '{{ $job->title ?? "" }}';
        const company = '{{ $job->company ?? "" }}';
        
        let contextPrompt = `Generate a professional cover letter for ${jobTitle} position at ${company}. `;
        contextPrompt += 'The cover letter should express enthusiasm for the role, highlight relevant skills, ';
        contextPrompt += 'and explain why the candidate is a great fit. Keep it professional, concise (300-400 words / max 2000 characters), ';
        contextPrompt += 'and persuasive. IMPORTANT: Response must not exceed 2000 characters.';
        
        fetch('/ai-component-modal', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                context: contextPrompt
            })
        })
        .then(response => {
            console.log('Fetch response status:', response.status);
            return response.text();
        })
        .then(html => {
            console.log('Received HTML:', html.substring(0, 200) + '...');
            const container = document.getElementById('coverLetterAiModalContent');
            if (container) {
                container.innerHTML = html;
                console.log('HTML inserted into container');
            } else {
                console.error('Container not found');
            }
        })
        .catch(error => {
            console.error('Error loading AI component:', error);
            const container = document.getElementById('coverLetterAiModalContent');
            if (container) {
                container.innerHTML = `
                    <div class="text-center py-8 text-red-600 dark:text-red-400">
                        <p>Error loading AI Generator. Please try again.</p>
                        <button onclick="loadCoverLetterAiComponent()" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Retry
                        </button>
                    </div>
                `;
            }
        });
    }

    window.handleCoverLetterUseResponse = function(promptId) {
        console.log('handleCoverLetterUseResponse called with prompt ID:', promptId);
        
        fetch(`/get-ai-prompt/${promptId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.response) {
                console.log('AI Response fetched successfully');
                useCoverLetterAiResponse(data.response);
            } else {
                alert('Failed to fetch AI response. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error fetching AI response:', error);
            alert('Error fetching AI response. Please try again.');
        });
    };

    function useCoverLetterAiResponse(response) {
        console.log('useCoverLetterAiResponse called with:', response);
        
        const coverLetterField = document.getElementById('cover_letter');
        if (coverLetterField) {
            // Truncate to max 5000 characters (validation limit) with warning
            let finalResponse = response;
            if (response.length > 5000) {
                finalResponse = response.substring(0, 4997) + '...';
                console.warn('Response truncated from', response.length, 'to 5000 characters');
            }
            
            // Set textarea value
            coverLetterField.value = finalResponse;
            
            // Trigger multiple events to ensure Livewire picks up the change
            coverLetterField.dispatchEvent(new Event('input', { bubbles: true }));
            coverLetterField.dispatchEvent(new Event('change', { bubbles: true }));
            
            // Directly update Livewire component if available
            const livewireComponent = coverLetterField.closest('[wire\\:id]');
            if (livewireComponent) {
                const wireId = livewireComponent.getAttribute('wire:id');
                if (window.Livewire && window.Livewire.find(wireId)) {
                    console.log('Updating Livewire component directly');
                    window.Livewire.find(wireId).set('cover_letter', finalResponse);
                }
            }
            
            console.log('Response inserted into cover letter field');
            
            // Close modal
            window.closeCoverLetterAiModal();
            
            // Show success notification
            const successDiv = document.createElement('div');
            successDiv.className = 'fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md shadow-lg z-[80]';
            const message = response.length > 5000 
                ? 'AI-generated cover letter has been inserted (truncated to fit limit)!' 
                : 'AI-generated cover letter has been inserted!';
            successDiv.innerHTML = `<div class="flex items-center"><svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>${message}</div>`;
            document.body.appendChild(successDiv);
            setTimeout(() => successDiv.remove(), 5000);
        } else {
            console.error('Cover letter field not found');
            alert('Error: Cover letter field not found in the form');
        }
    }
</script>

<!-- Cover Letter AI Generator Modal - Outside Livewire Component -->
<div id="coverLetterAiModal" 
     class="fixed inset-0 overflow-y-auto" 
     style="display: none; z-index: 9999;">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black backdrop-blur-sm" 
         style="opacity: 0.75; z-index: 9998;"
         onclick="window.closeCoverLetterAiModal()"></div>
    
    <!-- Modal Content Container - Centered -->
    <div class="fixed inset-0 flex items-center justify-center p-4" 
         style="z-index: 9999; pointer-events: none;">
        <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-2xl max-w-3xl w-full p-6" 
             style="pointer-events: auto; z-index: 10000;">
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">AI Cover Letter Generator</h3>
                <button type="button" 
                        onclick="window.closeCoverLetterAiModal()" 
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="mt-4">
                <div id="coverLetterAiModalContent">
                    <!-- Livewire component will be loaded here -->
                    <div class="text-center py-8">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
                        <p class="mt-4 text-gray-600 dark:text-gray-400">Loading AI Generator...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection