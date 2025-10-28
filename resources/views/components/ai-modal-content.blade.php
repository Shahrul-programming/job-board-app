<div class="ai-modal-component">
    <livewire:ai-text-generate-component-modal :initial-prompt="$context" />
</div>

<script>
// Backup event listener for Livewire events
window.addEventListener('ai-response-ready', (event) => {
    console.log('Window received AI response event:', event.detail);
    if (event.detail && event.detail.response && window.useAiResponse) {
        window.useAiResponse(event.detail.response);
    }
});
</script>