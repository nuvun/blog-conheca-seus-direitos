<?php

namespace App\Jobs;

use App\Models\ChatUserData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;
use Prism\Prism\Schema\ObjectSchema;
use Prism\Prism\Schema\StringSchema;
use Prism\Prism\ValueObjects\Messages\UserMessage;

class ExtractUserDataFromMessagesJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected  array $userMessages,
        protected  string $sessionId
    ) {}

    public function handle(): void
    {
        try {
            $userMessageObjects = [];
            foreach ($this->userMessages as $msg) {
                $userMessageObjects[] = new UserMessage($msg);
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
                ->using(Provider::OpenAI, 'gpt-5-mini-2025-08-07')
                ->withSchema($schema)
                ->withSystemPrompt(view('chat.prompts.extract-user-data'))
                ->withMessages($userMessageObjects)
                ->asStructured();

            $dataToUpdate = [];

           $dataToUpdate = array_filter([
                'name'         => $response->structured['name'] ?? null,
                'email'        => filter_var($response->structured['email'] ?? null, FILTER_VALIDATE_EMAIL) ? $response->structured['email'] : null,
                'phone_number' => $response->structured['phone_number'] ?? null,
                'city'         => $response->structured['city'] ?? null,
                'area_of_law'  => $response->structured['area_of_law'] ?? null,
            ]);

            if (!empty($dataToUpdate)) {
                $this->saveUserData($dataToUpdate);
            }
        } catch (\Exception $e) {
            \Log::error('Erro ao extrair dados do usuário no job: ' . $e->getMessage());
        }
    }

    protected function saveUserData(array $data): void
    {
        ChatUserData::updateOrCreate(
            ['session_id' => $this->sessionId],
            [
                'name'         => $data['name'] ?? null,
                'email'        => $data['email'] ?? null,
                'phone_number' => $data['phone_number'] ?? null,
                'city'         => $data['city'] ?? null,
                'area_of_law'  => $data['area_of_law'] ?? null,
            ]
        );
    }

    public function uniqueId(): string
    {
        return $this->sessionId;
    }
}
