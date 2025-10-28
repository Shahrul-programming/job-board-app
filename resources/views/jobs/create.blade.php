@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">Create New Job</h1>
                <p class="mt-1 text-sm text-gray-600">Fill in the details below to create a new job posting.</p>
            </div>

            <form action="{{ route('admin.jobs.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Job Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Job Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('title') border-red-300 @enderror" 
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Company -->
                <div>
                    <label for="company" class="block text-sm font-medium text-gray-700">Company</label>
                    <input type="text" name="company" id="company" value="{{ old('company') }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('company') border-red-300 @enderror" 
                           required>
                    @error('company')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('location') border-red-300 @enderror" 
                           required>
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Job Type -->
                <div>
                    <label for="job_type" class="block text-sm font-medium text-gray-700">Job Type</label>
                    <select name="job_type" id="job_type" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('job_type') border-red-300 @enderror" 
                            required>
                        <option value="">Select Job Type</option>
                        <option value="full-time" {{ old('job_type') == 'full-time' ? 'selected' : '' }}>Full Time</option>
                        <option value="part-time" {{ old('job_type') == 'part-time' ? 'selected' : '' }}>Part Time</option>
                        <option value="contract" {{ old('job_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                        <option value="internship" {{ old('job_type') == 'internship' ? 'selected' : '' }}>Internship</option>
                    </select>
                    @error('job_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Salary Range -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="salary_min" class="block text-sm font-medium text-gray-700">Minimum Salary (RM)</label>
                        <input type="number" name="salary_min" id="salary_min" value="{{ old('salary_min') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('salary_min') border-red-300 @enderror" 
                               min="0" step="100">
                        @error('salary_min')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="salary_max" class="block text-sm font-medium text-gray-700">Maximum Salary (RM)</label>
                        <input type="number" name="salary_max" id="salary_max" value="{{ old('salary_max') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('salary_max') border-red-300 @enderror" 
                               min="0" step="100">
                        @error('salary_max')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Job Description -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">Job Description</label>
                        <div class="flex items-center space-x-2">
                            <button type="button" 
                                    onclick="importLastAiResult()" 
                                    title="Import your latest AI-generated job description"
                                    class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                                </svg>
                                Import AI Result
                            </button>
                            <button type="button" 
                                    onclick="openAiModal()" 
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                Generate with AI
                            </button>
                        </div>
                    </div>
                    
                    <!-- Hidden input for form submission -->
                    <input type="hidden" name="description" id="description" value="{{ old('description') }}" required>
                    
                    <!-- Tiptap Editor Container -->
                    <div id="tiptap-editor" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500 @error('description') border-red-300 @enderror">
                        <!-- Toolbar -->
                        <div class="border-b border-gray-200 bg-gray-50 px-3 py-2 flex flex-wrap gap-1">
                            <button type="button" data-action="bold" class="tiptap-btn" title="Bold (Ctrl+B)">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M6 4v12h4.5c1.21 0 2.21-.28 3-1.04.79-.76 1.21-1.79 1.21-3.12 0-.94-.26-1.73-.79-2.36-.53-.64-1.25-1.07-2.17-1.29.68-.21 1.21-.56 1.59-1.04.38-.49.57-1.08.57-1.79 0-1.14-.39-2.04-1.17-2.68C11.96 4.23 10.88 4 9.5 4H6zm2 2h1.5c.54 0 .96.12 1.25.36.3.24.45.57.45 1 0 .43-.15.76-.45 1-.29.24-.71.36-1.25.36H8V6zm0 5h2c.61 0 1.08.14 1.41.43.34.29.51.69.51 1.21 0 .52-.17.92-.51 1.21-.33.29-.8.43-1.41.43H8v-3.28z"/></svg>
                            </button>
                            <button type="button" data-action="italic" class="tiptap-btn" title="Italic (Ctrl+I)">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 4v3h2.21l-3.42 8H6v3h8v-3h-2.21l3.42-8H18V4h-8z"/></svg>
                            </button>
                            <button type="button" data-action="strike" class="tiptap-btn" title="Strikethrough">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M6 9h8v2H6V9zm0-5h8v2H6V4zm0 8h8v2H6v-2z"/></svg>
                            </button>
                            <div class="w-px h-6 bg-gray-300"></div>
                            <button type="button" data-action="heading" data-level="1" class="tiptap-btn" title="Heading 1">H1</button>
                            <button type="button" data-action="heading" data-level="2" class="tiptap-btn" title="Heading 2">H2</button>
                            <button type="button" data-action="heading" data-level="3" class="tiptap-btn" title="Heading 3">H3</button>
                            <div class="w-px h-6 bg-gray-300"></div>
                            <button type="button" data-action="bulletList" class="tiptap-btn" title="Bullet List">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4h2v2H4V4zm0 5h2v2H4V9zm0 5h2v2H4v-2zM8 4h10v2H8V4zm0 5h10v2H8V9zm0 5h10v2H8v-2z"/></svg>
                            </button>
                            <button type="button" data-action="orderedList" class="tiptap-btn" title="Numbered List">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4h1v4H4V4zm1 6H4v1h1v3H4v1h3v-1H6v-3h1V10H5zm3-6h10v2H8V4zm0 5h10v2H8V9zm0 5h10v2H8v-2z"/></svg>
                            </button>
                            <div class="w-px h-6 bg-gray-300"></div>
                            <button type="button" data-action="blockquote" class="tiptap-btn" title="Quote">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M6 10c0-2 1-3.5 3-4.5L8.5 4C5.5 5 4 7.5 4 10.5c0 2.5 2 4.5 4.5 4.5 2.5 0 4.5-2 4.5-4.5S11 6 8.5 6c-.5 0-1 .1-1.5.3.6-1.2 1.5-2 3-2.3zm8 0c0-2 1-3.5 3-4.5L16.5 4c-3 1-4.5 3.5-4.5 6.5 0 2.5 2 4.5 4.5 4.5 2.5 0 4.5-2 4.5-4.5S19 6 16.5 6c-.5 0-1 .1-1.5.3.6-1.2 1.5-2 3-2.3z"/></svg>
                            </button>
                            <button type="button" data-action="horizontalRule" class="tiptap-btn" title="Horizontal Line">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M3 9h14v2H3V9z"/></svg>
                            </button>
                            <div class="w-px h-6 bg-gray-300"></div>
                            <button type="button" data-action="undo" class="tiptap-btn" title="Undo (Ctrl+Z)">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 3L4 9l6 6v-4h8V7h-8V3z"/></svg>
                            </button>
                            <button type="button" data-action="redo" class="tiptap-btn" title="Redo (Ctrl+Y)">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 3l6 6-6 6v-4H2V7h8V3z"/></svg>
                            </button>
                        </div>
                        
                        <!-- Editor Content -->
                        <div id="tiptap-content" class="prose max-w-none p-4 min-h-[200px] focus:outline-none"></div>
                    </div>
                    
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Requirements -->
                <div>
                    <label for="requirements" class="block text-sm font-medium text-gray-700">Requirements (Optional)</label>
                    <textarea name="requirements" id="requirements" rows="4" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('requirements') border-red-300 @enderror">{{ old('requirements') }}</textarea>
                    @error('requirements')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Create Job & Proceed to Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- AI Generator Modal -->
<div id="aiModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">AI Job Description Generator</h3>
                <button type="button" onclick="closeAiModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="mt-4">
                <div id="aiModalContent">
                    <!-- Livewire component akan di-load di sini -->
                    <div class="text-center py-8">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
                        <p class="mt-2 text-gray-600">Loading AI Generator...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tiptap Editor Styles -->
<style>
.tiptap-btn {
    @apply px-2 py-1 text-gray-700 hover:bg-gray-200 rounded transition-colors duration-150 text-sm font-medium;
}

.tiptap-btn.is-active {
    @apply bg-indigo-100 text-indigo-700;
}

/* Tiptap Editor Content Styles */
#tiptap-content {
    outline: none;
}

#tiptap-content h1 {
    @apply text-3xl font-bold mt-6 mb-4;
}

#tiptap-content h2 {
    @apply text-2xl font-bold mt-5 mb-3;
}

#tiptap-content h3 {
    @apply text-xl font-bold mt-4 mb-2;
}

#tiptap-content p {
    @apply mb-3;
}

#tiptap-content ul {
    @apply list-disc pl-6 mb-3;
}

#tiptap-content ol {
    @apply list-decimal pl-6 mb-3;
}

#tiptap-content li {
    @apply mb-1;
}

#tiptap-content blockquote {
    @apply border-l-4 border-gray-300 pl-4 italic my-4;
}

#tiptap-content hr {
    @apply my-4 border-gray-300;
}

#tiptap-content strong {
    @apply font-bold;
}

#tiptap-content em {
    @apply italic;
}

#tiptap-content s {
    @apply line-through;
}

#tiptap-content .is-empty::before {
    content: attr(data-placeholder);
    @apply text-gray-400 float-left h-0 pointer-events-none;
}
</style>

<script>
// Global variables
let isModalOpen = false;

// Declare functions on window object for global access (must be before modal loads)
window.handleUseResponse = function(promptId) {
    console.log('handleUseResponse called with prompt ID:', promptId);
    
    // Fetch AI prompt response dari database
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
            useAiResponse(data.response);
        } else {
            showErrorMessage('Failed to fetch AI response. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error fetching AI response:', error);
        showErrorMessage('Error fetching AI response. Please try again.');
    });
};

// Function to open AI modal
function openAiModal() {
    const modal = document.getElementById('aiModal');
    const modalContent = document.getElementById('aiModalContent');
    
    // Show modal
    modal.classList.remove('hidden');
    isModalOpen = true;
    
    // Disable body scroll
    document.body.style.overflow = 'hidden';
    
    // Load Livewire component
    loadAiComponent();
}

// Function to close AI modal
function closeAiModal() {
    const modal = document.getElementById('aiModal');
    
    // Hide modal
    modal.classList.add('hidden');
    isModalOpen = false;
    
    // Enable body scroll
    document.body.style.overflow = 'auto';
    
    // Clear modal content
    document.getElementById('aiModalContent').innerHTML = `
        <div class="text-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
            <p class="mt-2 text-gray-600">Loading AI Generator...</p>
        </div>
    `;
}

// Function to load AI component
function loadAiComponent() {
    // Get form data untuk context
    const title = document.getElementById('title').value;
    const company = document.getElementById('company').value;
    const location = document.getElementById('location').value;
    const jobType = document.getElementById('job_type').value;
    
    // Create dynamic prompt based on form data
    let contextPrompt = 'Generate a professional job description';
    
    if (title) contextPrompt += ` for ${title} position`;
    if (company) contextPrompt += ` at ${company}`;
    if (location) contextPrompt += ` located in ${location}`;
    if (jobType) contextPrompt += ` as a ${jobType.replace('-', ' ')} role`;
    
    contextPrompt += '. Include key responsibilities, requirements, and benefits.';
    
    // Load Livewire component with context
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
    .then(response => response.text())
    .then(html => {
        document.getElementById('aiModalContent').innerHTML = html;
    })
    .catch(error => {
        console.error('Error loading AI component:', error);
        document.getElementById('aiModalContent').innerHTML = `
            <div class="text-center py-8 text-red-600">
                <p>Error loading AI Generator. Please try again.</p>
                <button onclick="loadAiComponent()" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Retry
                </button>
            </div>
        `;
    });
}

// Function to use AI response (called from Livewire component)
function useAiResponse(response) {
    console.log('useAiResponse called with:', response);
    
    // Wait a bit for Tiptap to initialize if needed
    const insertContent = () => {
        if (window.tiptapEditor) {
            // Convert plain text to HTML format
            const htmlContent = convertPlainTextToHtml(response);
            console.log('HTML content to insert:', htmlContent.substring(0, 200));
            
            // Insert response into Tiptap editor
            window.tiptapEditor.commands.setContent(htmlContent);
            console.log('Response inserted into Tiptap editor successfully');
            
            // Close modal
            closeAiModal();
            
            // Show success message
            showSuccessMessage('AI-generated description has been inserted!');
        } else {
            console.error('Tiptap editor not found, retrying in 500ms...');
            setTimeout(insertContent, 500);
        }
    };
    
    insertContent();
}

// Helper function to convert plain text to HTML
function convertPlainTextToHtml(text) {
    // Split into lines
    let lines = text.split('\n');
    let html = '';
    let inList = false;
    
    lines.forEach((line, index) => {
        line = line.trim();
        
        if (!line) {
            if (inList) {
                html += '</ul>';
                inList = false;
            }
            return;
        }
        
        // Check for headers (lines that are short, capitalized, and followed by content)
        if (line.length < 100 && line === line.toUpperCase() && !line.startsWith('•')) {
            if (inList) {
                html += '</ul>';
                inList = false;
            }
            html += `<h2>${line}</h2>`;
        }
        // Check for headers with title case (Job Description:, Key Responsibilities, etc.)
        else if ((line.endsWith(':') || (line.length < 80 && /^[A-Z][a-zA-Z\s]+$/.test(line))) && !line.startsWith('•')) {
            if (inList) {
                html += '</ul>';
                inList = false;
            }
            // Remove trailing colon if exists
            const headerText = line.endsWith(':') ? line.slice(0, -1) : line;
            html += `<h3>${headerText}</h3>`;
        }
        // Check for bullet points (•)
        else if (line.startsWith('•')) {
            if (!inList) {
                html += '<ul>';
                inList = true;
            }
            // Remove bullet and trim
            const content = line.substring(1).trim();
            html += `<li>${content}</li>`;
        }
        // Regular paragraph
        else {
            if (inList) {
                html += '</ul>';
                inList = false;
            }
            // Preserve bold formatting if using **text**
            let formattedLine = line.replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>');
            html += `<p>${formattedLine}</p>`;
        }
    });
    
    // Close any open list
    if (inList) {
        html += '</ul>';
    }
    
    return html;
}

// Function to import last AI result
function importLastAiResult() {
    // Show loading state on button
    const importBtn = event.target;
    const originalText = importBtn.innerHTML;
    
    importBtn.disabled = true;
    importBtn.innerHTML = `
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Loading...
    `;
    
    // Fetch last AI result for current user
    fetch('/get-last-ai-result', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        // Restore button state
        importBtn.disabled = false;
        importBtn.innerHTML = originalText;
        
        if (data.success && data.response) {
            // Convert plain text to HTML
            const htmlContent = convertPlainTextToHtml(data.response);
            
            // Insert AI result into Tiptap editor
            if (window.tiptapEditor) {
                window.tiptapEditor.commands.setContent(htmlContent);
                showSuccessMessage('Latest AI result has been imported successfully!');
            } else {
                showErrorMessage('Editor not ready. Please try again.');
            }
        } else if (data.message) {
            // Show info message if no results found
            showInfoMessage(data.message);
        } else {
            // Show error message
            showErrorMessage('Failed to import AI result. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error importing AI result:', error);
        
        // Restore button state
        importBtn.disabled = false;
        importBtn.innerHTML = originalText;
        
        // Show error message
        showErrorMessage('Error importing AI result. Please check your connection and try again.');
    });
}

// Function to show success message
function showSuccessMessage(message) {
    // Create temporary success message
    const successDiv = document.createElement('div');
    successDiv.className = 'fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md shadow-lg z-50';
    successDiv.innerHTML = `
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            ${message}
        </div>
    `;
    
    document.body.appendChild(successDiv);
    
    // Remove after 3 seconds
    setTimeout(() => {
        successDiv.remove();
    }, 3000);
}

// Function to show info message
function showInfoMessage(message) {
    const infoDiv = document.createElement('div');
    infoDiv.className = 'fixed top-4 right-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-md shadow-lg z-50';
    infoDiv.innerHTML = `
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            ${message}
        </div>
    `;
    
    document.body.appendChild(infoDiv);
    
    // Remove after 4 seconds
    setTimeout(() => {
        infoDiv.remove();
    }, 4000);
}

// Function to show error message
function showErrorMessage(message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md shadow-lg z-50';
    errorDiv.innerHTML = `
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            ${message}
        </div>
    `;
    
    document.body.appendChild(errorDiv);
    
    // Remove after 5 seconds
    setTimeout(() => {
        errorDiv.remove();
    }, 5000);
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('aiModal');
    if (event.target === modal && isModalOpen) {
        closeAiModal();
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && isModalOpen) {
        closeAiModal();
    }
});
</script>
@endsection