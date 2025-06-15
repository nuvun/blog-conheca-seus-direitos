<?php

namespace App\Livewire\Chat;

use Illuminate\View\View;
use Livewire\Component;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;
use Prism\Prism\ValueObjects\Messages\AssistantMessage;
use Prism\Prism\ValueObjects\Messages\UserMessage;

class Messages extends Component
{

    public array $messages = [];
    public string $message = '';

    public function mount(): void
    {
        $this->messages = session()->get('chat_messages', []);
    }

    public function sendMessage(): void
    {
        $userMessage = trim($this->message);

        if (empty($userMessage)) {
            return;
        }

        $this->messages[] = ['from' => 'user', 'content' => $userMessage];
        $this->message = '';

        $conversation = [];
        foreach ($this->messages as $message) {
            if ($message['from'] === 'user') {
                $conversation[] = new UserMessage($message['content']);
            } else {
                $conversation[] = new AssistantMessage($message['content']);
            }
        }

        $response = Prism::text()
            ->using(Provider::OpenAI, 'o4-mini')
            ->withSystemPrompt(view('chat.prompts.lawyer-assistant'))
            ->withMessages($conversation)
            ->asText();

        $this->messages[] = ['from' => 'lawyer', 'content' => $response->text];

        session()->put('chat_messages', $this->messages);

        $this->dispatch('newMessage', ['message' => $response->text]);
    }

    public function resetChat(): void
    {
        $this->messages = [];
        session()->forget('chat_messages');
    }

    public function render(): View
    {
        return view('livewire.chat.messages');
    }
}
