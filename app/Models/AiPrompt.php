<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;

class AiPrompt extends Model
{
    protected $fillable = [
        'user_id',
        'request_id',
        'prompt',
        'response',
        'status',
        'error_message',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'string',
            'prompt' => 'string',
            'response' => 'string',
            'error_message' => 'string',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedResponse(): string
    {
        if (empty($this->response)) {
            return '';
        }

        // Configure CommonMark environment with GitHub Flavored Markdown
        $environment = new Environment;
        $environment->addExtension(new CommonMarkCoreExtension);
        $environment->addExtension(new GithubFlavoredMarkdownExtension);

        // Create converter
        $converter = new CommonMarkConverter([], $environment);

        // Convert Markdown to HTML
        $html = $converter->convert($this->response)->getContent();

        return $html;
    }

    public function getPlainResponse(): string
    {
        if (empty($this->response)) {
            return '';
        }

        $text = $this->response;

        // Convert markdown to readable plain text
        // Remove markdown headers (### Header -> Header)
        $text = preg_replace('/^#{1,6}\s+(.+)$/m', '$1', $text);

        // Remove bold (**text** or __text__ -> text)
        $text = preg_replace('/(\*\*|__)(.*?)\1/', '$2', $text);

        // Remove italic (*text* or _text_ -> text)
        $text = preg_replace('/(\*|_)(.*?)\1/', '$2', $text);

        // Convert bullet lists (- item or * item -> • item)
        $text = preg_replace('/^[\*\-]\s+/m', '• ', $text);

        // Convert numbered lists (1. item -> 1. item - keep as is)

        // Remove horizontal rules (--- or ***)
        $text = preg_replace('/^[\*\-_]{3,}$/m', '', $text);

        // Remove extra blank lines (more than 2 consecutive newlines)
        $text = preg_replace('/\n{3,}/', "\n\n", $text);

        // Trim whitespace
        $text = trim($text);

        return $text;
    }
}
