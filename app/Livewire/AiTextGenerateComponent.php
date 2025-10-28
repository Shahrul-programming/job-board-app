<?php

namespace App\Livewire;

use App\Jobs\SendAiPrompt;
use App\Models\AiPrompt;
use App\Services\DeepseekService;
use Illuminate\Support\Str;
use Livewire\Component;

class AiTextGenerateComponent extends Component
{
    public string $prompt = 'Generate job description for Laravel Developer in Malaysia.';
    public ?AiPrompt $currentPrompt = null;
    public string $requestId = '';

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
            // Logic untuk guna response - contoh: copy ke clipboard atau redirect ke form lain
            session()->flash('message', 'Response has been used successfully!');
            
            // Reset untuk generate yang baru
            $this->currentPrompt = null;
            $this->prompt = '';
        }
    }

    public function render()
    {
        return view('livewire.ai-text-generate-component');
    }
}
