<?php

namespace App\Livewire\Chat;

use App\Jobs\ExtractUserDataFromMessagesJob;
use App\Models\ChatMessage;
use App\Models\ChatUserData;
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

        $sessionId = session()->getId();

        $this->messages[] = ['from' => 'user', 'content' => $userMessage];

        ChatMessage::create(['session_id' => $sessionId, 'from' => 'user', 'content' => $userMessage]);

        $this->checkAndExtractUserData();

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

        ChatMessage::create(['session_id' => $sessionId, 'from' => 'lawyer', 'content' => $response->text]);

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

    protected function checkAndExtractUserData(): void
    {
        $sessionId = session()->getId();

        $userDataAlreadyFilled = ChatUserData::where('session_id', $sessionId)
            ->whereNotNull(['name', 'email', 'phone_number', 'city', 'area_of_law'])
            ->exists();

        if ($userDataAlreadyFilled) {
            return;
        }

        $userMessagesCount = array_sum(array_map(
            fn($msg) => $msg['from'] === 'user' ? 1 : 0,
            $this->messages
        ));

        if ($userMessagesCount >= 5) {
            $allUserMessages = array_filter(
                $this->messages,
                fn($msg) => $msg['from'] === 'user'
            );

            $userMessageContents = array_map(
                fn($msg) => $msg['content'],
                $allUserMessages
            );

            ExtractUserDataFromMessagesJob::dispatch($userMessageContents, $sessionId);
        }
    }
}
