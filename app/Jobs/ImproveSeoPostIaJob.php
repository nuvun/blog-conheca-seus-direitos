<?php

namespace App\Jobs;

use App\Enums\StatusEnum;
use App\Models\ContentTag;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use OpenAI\Laravel\Facades\OpenAI;

class ImproveSeoPostIaJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Post $post
    ) { }

    public function handle(): void
    {
        $prompt =
            "Otimização de SEO para o post: {$this->post->title}\n\n" .
            "Título: {$this->post->title}\n" .
            "Subtítulo: {$this->post->subtitle}\n" .
            "Conteúdo: {$this->post->content}\n" .
            "---\n" .
            "**Instruções Adicionais ou Detalhes Específicos:**\n" .
            "Atue como um experiente profissional de SEO para um portal de notícias e otimize o conteúdo do post para melhorar o ranqueamento nos motores de busca.\n" .
            "Remova do conteúdo os links do site concursosnews.com, mantendo a palavra que estava com o link.\n" .
            "O retorno deve ser o resultado otimizado no formato **JSON puro**, contendo os campos 'title', 'subtitle', 'content' e 'tags'.\n" .
            "O valor do campo conteúdo deve sempre deve ser formatado em HTML.\n" .
            "O conteúdo otimizado deve ser focado em SEO, mantendo o sentido original do texto.\n" .
            "Não inclua nenhum texto adicional, comentários ou marcação, apenas o JSON puro.";

        $chat = OpenAI::chat()->create([
            'model' => 'gpt-4o',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "Você é um especialista em SEO para portais de notícias. Sua tarefa é otimizar o conteúdo fornecido para ranqueamento nos motores de busca, removendo links do site concursosnews.com e mantendo o texto original. O retorno deve ser em JSON contendo os campos 'title', 'subtitle', 'content' e 'tags'."
                ],
                [
                    'role' => 'user',
                    'content' => $prompt,
                ],
            ],
        ]);

        $response = $chat->choices[0]->message->content;
        $response = str_replace(["```json", "```"], "", $response);

        if (json_validate($response)) {
            $responseArray = json_decode($response, true);

            $tags = $responseArray['tags'] ?? null;
            $tagsPost = [];

            foreach ($tags as $tag) {
                $tag = trim($tag);

                $tag = ContentTag::firstOrCreate(['name' => $tag]);

                $tagsPost[] = $tag->id;
            }

            $this->post->title    = $responseArray['title'];
            $this->post->subtitle = $responseArray['subtitle'];
            $this->post->content  = $responseArray['content'];
            $this->post->status   = StatusEnum::ACTIVE->value;
            $this->post->save();

            $this->post->tags()->sync($tagsPost);
        }
    }

    public function uniqueId(): string
    {
        return $this->post->id;
    }

}
