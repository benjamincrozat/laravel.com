<?php

namespace App\Livewire;

use App\Documentation;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Validation\ValidationException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class Conversation extends Component
{
    use WithRateLimiting;

    #[Locked]
    public string $content;

    #[Locked]
    public string $currentVersion;

    protected Documentation $docs;

    #[Validate('required|string|max:256')]
    public string $message = '';

    public bool $replying = false;

    #[Locked]
    public string $reply = '';

    #[Locked]
    public array $messages = [];

    public function boot(Documentation $docs) : void
    {
        $this->docs = $docs;
    }

    public function mount() : void
    {
        $this->messages[] = [
            'role' => 'system',
            'content' => $this->removeUnnecessaryCharacters("You are an AI assistant living in Laravel's documentation and helping developers by answering their questions about the current page and Laravel in general.

            Your answers should be concise and using simple vocabulary with a conversational tone. Focus on providing clear and direct answers to the questions, but only when it's somewhat related to the current page. You must always provide links whenever necessary.

            Avoid unnecessary details or jargon. Your goal is to make the information easy to understand and immediately useful.

            To avoid hallucinations, make sure to use the provided information first.

            What to do if you need to answer a question that's not related to the current page:
            - Tell the user to go to the relevant page of the documentation and provide them with a link to do so.
            - Tell them that after they visit the page, they can start a new conversation with you.
            - If they insist, try to answer anyway. But don't hallucinate. Use your knowledge of Laravel to answer the question.

            Example on how to tell the user about it if they ask 'How do I dispatch a job?':

            'To make sure I can answer your question in the best possible way, go on the [Job Dispatching](/docs/11.x/lifecycle#dispatching-jobs) page and ask me again. Or do you want me to try anyway?'

            Example on how not to do it (you will notice the missing link) if they ask 'How do I dispatch a job?':

            'To make sure I can answer your question in the best possible way, go on the Job Dispatching page and ask me again. Or do you want me to try anyway?'

            How to format generate and format links:
            - Don't use laravel.com
            - Instead, use a relative link like /docs/11.x/lifecycle#dispatching-jobs instead of https://laravel.com/docs/11.x/lifecycle#dispatching-jobs
            - For anchors, use what you can find in the provided information

            If the user asks about cats or anything in the same vein, tell them they're off topic."),
        ];

        $this->messages[] = [
            'role' => 'user',
            'content' => "Index: " . $this->docsIndex() . "

            Current page's content: " . $this->removeUnnecessaryCharacters($this->content),
        ];
    }

    public function submitMessage() : void
    {
        if ($this->replying) {
            return;
        }

        $this->validate();

        try {
            // Limit to 30 requests per hour.
            $this->rateLimit(30, 3600);
        } catch (TooManyRequestsException $e) {
            throw ValidationException::withMessages(['message' => 'Only 30 requests per hour are allowed, sorry!']);

            return;
        }

        $this->messages[] = [
            'role' => 'user',
            'content' => $this->message,
        ];

        $this->message = '';

        $this->replying = true;

        $this->dispatch('new-message')->self();
    }

    #[On('new-message')]
    public function reply() : void
    {
        $stream = OpenAI::chat()->createStreamed([
            'model' => 'gpt-4o-mini',
            'messages' => $this->messages,
            'max_tokens' => 1024,
            'temperature' => 0.5,
        ]);

        foreach ($stream as $response) {
            $this->reply .= $response->choices[0]->delta->content;

            $domain = str_replace('https://', '', config('app.url'));
            $this->reply = str_replace('https://laravel.com/docs', "https://$domain/docs", $this->reply);

            $this->stream(
                'reply-' . $this->getId(),
                $response->choices[0]->delta->content,
            );
        }

        $this->messages[] = [
            'role' => 'assistant',
            'content' => $this->reply,
        ];

        $this->reply = '';

        $this->replying = false;
    }

    protected function docsIndex() : string
    {
        return $this->removeUnnecessaryCharacters($this->docs->getIndex($this->currentVersion));
    }

    protected function removeUnnecessaryCharacters(string $content) : string
    {
        return trim(preg_replace(['/\n+/', '/ +/'], ["\n", ' '], strip_tags($content, ['a', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'])));
    }
}
