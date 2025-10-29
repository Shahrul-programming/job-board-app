<div class="ai-modal-component">
    <livewire:ai-text-generate-component-modal :initial-prompt="$context" />
</div>

<script>
// Smart handler that detects which modal is open and routes accordingly
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

// Backup event listener for Livewire events
window.addEventListener('ai-response-ready', (event) => {
    console.log('Window received AI response event:', event.detail);
    if (event.detail && event.detail.response) {
        const coverLetterModal = document.getElementById('coverLetterAiModal');
        const isCoverLetterModalOpen = coverLetterModal && window.getComputedStyle(coverLetterModal).display !== 'none';
        
        // Try to detect which handler to use
        if (typeof window.useCoverLetterAiResponse === 'function' && isCoverLetterModalOpen) {
            window.useCoverLetterAiResponse(event.detail.response);
        } else if (typeof window.useAiResponse === 'function') {
            window.useAiResponse(event.detail.response);
        }
    }
});
</script>