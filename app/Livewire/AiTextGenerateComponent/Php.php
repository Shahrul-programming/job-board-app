<?php

namespace App\Livewire;

use App\Models\AiPrompt;
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

    }

    public function render()
    {
        return view('livewire.ai-text-generate-component');
    }
}
