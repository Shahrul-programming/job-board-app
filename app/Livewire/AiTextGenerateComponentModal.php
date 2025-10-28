<?php

namespace App\Livewire;

use App\Jobs\SendAiPrompt;
use App\Models\AiPrompt;
use Illuminate\Support\Str;
use Livewire\Component;

class AiTextGenerateComponentModal extends Component
{
    public string $prompt = '';
    public ?AiPrompt $currentPrompt = null;
    public string $requestId = '';
    public string $initialPrompt = '';

    public function mount($initialPrompt = 'Generate job description for Laravel Developer in Malaysia.')
    {
        $this->initialPrompt = $initialPrompt;
        $this->prompt = $initialPrompt;
    }

    public function generatePrompt(): void
    {
        $this->requestId = Str::uuid();

        $this->currentPrompt = AiPrompt::create([
            'user_id' => auth()->id(),
            'request_id' => $this->requestId,
            'prompt' => $this->prompt,
            'status' => 'Pending',
        ]);

        // Communicate dengan deepseek.
        SendAiPrompt::dispatch(
            $this->requestId,
            $this->prompt,
            auth()->id()
        );
    }

    public function checkStatus(): void
    {
        if ($this->currentPrompt) {
            $this->currentPrompt->refresh();
        }
    }

    public function useResponse(): void
    {
        if ($this->currentPrompt && $this->currentPrompt->status === 'Completed') {
            // Send plain text response untuk textarea
            $this->dispatch('ai-response-ready', response: $this->currentPrompt->getPlainResponse());
        }
    }

    public function render()
    {
        return view('livewire.ai-text-generate-component-modal');
    }
}
