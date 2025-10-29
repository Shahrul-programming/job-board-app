<div class="w-full">
    <div class="mb-4">
        <label for="modal-prompt" class="block text-sm font-medium text-gray-700 mb-2">
            AI Prompt
        </label>
        <textarea
            wire:model="prompt"
            id="modal-prompt"
            rows="3"
            class="w-full border border-gray-300 rounded-md px-3 py-2 bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            placeholder="Enter your prompt here..."
        ></textarea>
        <p class="mt-1 text-xs text-gray-500">
            Tip: Be specific about the job role, company, and requirements for better results.
        </p>
    </div>

    <div class="flex items-center space-x-3 mb-4">
        <button
            wire:click="generatePrompt"
            wire:loading.attr="disabled"
            @if($currentPrompt && $currentPrompt->status === 'Pending') disabled @endif
            class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white px-6 py-2 rounded-md disabled:opacity-50 transition-all duration-200 flex items-center"
        >
            <svg wire:loading wire:target="generatePrompt" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            @if($currentPrompt && $currentPrompt->status === 'Pending')
                <span>Generating...</span>
            @else
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                <span>Generate with AI</span>
            @endif
        </button>

        @if($currentPrompt)
            <div class="flex items-center">
                <span class="text-sm font-medium text-gray-600">Status:</span>
                <span class="ml-2 px-2 py-1 text-xs rounded-full
                    @if($currentPrompt->status === 'Pending') bg-yellow-100 text-yellow-800
                    @elseif($currentPrompt->status === 'Completed') bg-green-100 text-green-800
                    @else bg-red-100 text-red-800 @endif">
                    {{ ucfirst($currentPrompt->status) }}
                </span>
            </div>
        @endif
    </div>

    @if($currentPrompt)
        <div class="border border-gray-200 rounded-lg bg-gray-50" wire:poll.1s="checkStatus">
            @if($currentPrompt->status === 'Pending')
                <div class="p-6 text-center">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
                    <p class="mt-2 text-gray-600">AI is generating your job description...</p>
                    <p class="text-sm text-gray-500">This usually takes 30-60 seconds</p>
                </div>
            @elseif($currentPrompt->status === 'Completed')
                <div class="p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="font-medium text-gray-900">Generated Job Description:</h4>
                        <button
                            wire:click="useResponse"
                            onclick="handleAiUseResponse({{ $currentPrompt->id }})"
                            data-prompt-id="{{ $currentPrompt->id }}"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center"
                        >
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Use This Description
                        </button>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-md p-4 max-h-96 overflow-y-auto">
                        <div class="prose prose-sm max-w-none text-gray-900 
                                    prose-headings:text-gray-900 prose-headings:font-semibold
                                    prose-h1:text-lg prose-h1:mb-3 prose-h1:mt-4
                                    prose-h2:text-base prose-h2:mb-2 prose-h2:mt-3
                                    prose-h3:text-sm prose-h3:mb-2 prose-h3:mt-2
                                    prose-p:mb-3 prose-p:leading-relaxed
                                    prose-ul:mb-3 prose-ol:mb-3
                                    prose-li:mb-1 prose-li:leading-relaxed
                                    prose-strong:font-semibold prose-strong:text-gray-800
                                    prose-em:italic prose-em:text-gray-700
                                    prose-code:bg-gray-100 prose-code:px-1 prose-code:py-0.5 prose-code:rounded
                                    prose-blockquote:border-l-4 prose-blockquote:border-blue-200 prose-blockquote:pl-4 prose-blockquote:italic">
                            {!! $currentPrompt->getFormattedResponse() !!}
                        </div>
                    </div>
                </div>
            @elseif($currentPrompt->status === 'Failed')
                <div class="p-4 text-center">
                    <div class="text-red-600">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        <strong>Generation Failed</strong>
                        <p class="text-sm mt-1">{{ $currentPrompt->error_message }}</p>
                        <button 
                            wire:click="generatePrompt"
                            class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                            Try Again
                        </button>
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>
