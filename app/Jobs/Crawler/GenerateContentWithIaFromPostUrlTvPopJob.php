<?php

namespace App\Jobs\Crawler;

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

class GenerateContentWithIaFromPostUrlTvPopJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Post $post,
        public string $title,
        public string $externalUrl,
    ) { }

    public function handle(): void
    {
        $prompt =
            "O título atual da notícia é: {$this->title}\n\n" .
            "Acesse a URL: {$this->externalUrl}\n\n" .
            "Gere um conteúdo otimizado para SEO com base no texto da notícia que normalmente fica na div com class elementor-widget-container.\n\n" .
            "---\n" .
            "**Instruções Adicionais ou Detalhes Específicos:**\n" .
            "Atue como um experiente profissional de SEO para um portal de notícias e otimize o conteúdo do post para melhorar o ranqueamento nos motores de busca.\n" .
            "Foque nas palavras-chave: [inserir palavras-chave primárias] e [inserir palavras-chave secundárias], distribuindo-as naturalmente ao longo do texto.\n" .
            "Garanta que as palavras-chave apareçam nos primeiros 100 caracteres do conteúdo.\n" .
            "Utilize subtítulos (<h2>, <h3>) para estruturar o conteúdo e mantenha parágrafos curtos\n" .
            "Adicione listas numeradas ou com marcadores quando for apropriado.\n" .
            "Remova do conteúdo os links do site https://www.tvpop.com.br/, mantendo a palavra que estava com o link.\n" .
            "O retorno deve ser o resultado otimizado no formato **JSON puro**, contendo os seguintes campos:\n" .
            "- 'title': Um título otimizado para SEO com até 60 caracteres.\n" .
            "- 'subtitle': Um resumo envolvente com até 150 caracteres.\n" .
            "- 'content': O conteúdo otimizado e formatado em HTML, com pelo menos [número de palavras desejado].\n" .
            "- 'tags': Até 10 palavras-chave relacionadas ao tema.\n" .
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
//            $this->post->status   = StatusEnum::ACTIVE->value;
            $this->post->save();

            $this->post->tags()->sync($tagsPost);
        }
    }

    public function uniqueId(): string
    {
        return $this->externalUrl;
    }

}
