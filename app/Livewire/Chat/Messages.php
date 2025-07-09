<?php

namespace App\Livewire\Chat;

use App\Models\ChatMessage;
use App\Models\ChatUserData;
use Illuminate\View\View;
use Livewire\Component;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;
use Prism\Prism\Schema\ObjectSchema;
use Prism\Prism\Schema\StringSchema;
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

    protected function checkAndExtractUserData(): void
    {
        $sessionId = session()->getId();

        $userDataAlreadyFilled = ChatUserData::where('session_id', $sessionId)
            ->whereNotNull(['name', 'email', 'phone_number', 'city', 'area_of_law'])
            ->exists();

        if ($userDataAlreadyFilled)
            return;

        $userMessagesCount = array_sum(array_map(
            fn($msg) => $msg['from'] === 'user' ? 1 : 0,
            $this->messages
        ));

        if ($userMessagesCount >= 5) {
            $allUserMessages = array_filter(
                $this->messages,
                fn($msg) => $msg['from'] === 'user'
            );

            $combinedMessages = implode("\n---\n", array_map(
                fn($msg) => $msg['content'],
                $allUserMessages
            ));

            $this->extractUserDataFromMessage($combinedMessages);
        }
    }

    protected function extractUserDataFromMessage(string $message): void
    {
        try {
            $messageArray = explode("\n---\n", $message);

            $userMessages = [];
            foreach ($messageArray as $msg) {
                $userMessages[] = new UserMessage($msg);
            }

            $schema = new ObjectSchema(
                name: 'data_extraction_schema',
                description: 'Schema for extracting user data from chat messages',
                properties: [
                    new StringSchema('name', 'Nome completo do usuário'),
                    new StringSchema('email', 'Email do usuário'),
                    new StringSchema('phone_number', 'Número de telefone/celular do usuário'),
                    new StringSchema('city', 'Cidade do usuário'),
                    new StringSchema('area_of_law', 'Área do direito relacionada ao caso do usuário'),
                ],
                requiredFields: ['name', 'email', 'phone_number', 'city', 'area_of_law']
            );

            $response = Prism::structured()
                ->using(Provider::OpenAI, 'o4-mini')
                ->withSchema($schema)
                ->withSystemPrompt(view('chat.prompts.extract-user-data'))
                ->withMessages($userMessages)
                ->asStructured();

            $dataToUpdate = [];

            if (!empty($response->structured['name'])) {
                $dataToUpdate['name'] = $response->structured['name'];
            }

            if (!empty($response->structured['email']) && filter_var($response->structured['email'], FILTER_VALIDATE_EMAIL)) {
                $dataToUpdate['email'] = $response->structured['email'];
            }

            if (!empty($response->structured['phone_number'])) {
                $dataToUpdate['phone_number'] = $response->structured['phone_number'];
            }

            if (!empty($response->structured['city'])) {
                $dataToUpdate['city'] = $response->structured['city'];
            }

            if (!empty($response->structured['area_of_law'])) {
                $dataToUpdate['area_of_law'] = $response->structured['area_of_law'];
            }

            if (!empty($dataToUpdate)) {
                $this->saveUserData($dataToUpdate);
            }
        } catch (\Exception $e) {
            \Log::error('Erro ao extrair dados do usuário: ' . $e->getMessage());
        }
    }

    public function resetChat(): void
    {
        $this->messages = [];
        session()->forget('chat_messages');
    }

    public function saveUserData(array $data): void
    {
        $sessionId = session()->getId();

        ChatUserData::updateOrCreate(
            ['session_id' => $sessionId],
            [
                'name'         => $data['name'] ?? null,
                'email'        => $data['email'] ?? null,
                'phone_number' => $data['phone_number'] ?? null,
                'city'         => $data['city'] ?? null,
                'area_of_law'  => $data['area_of_law'] ?? null,
            ]
        );
    }

    public function render(): View
    {
        return view('livewire.chat.messages');
    }
}
