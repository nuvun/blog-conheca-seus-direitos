<?php

namespace App\Jobs;

use App\Models\ChatUserData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendCaseToNuvunJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public ChatUserData $chatUserData
    ) {}

    public function handle(): void
    {
        $response = Http::baseUrl(config('services.nuvun.base_url'))
            ->withHeaders([
                'x-api-key' => config('services.nuvun.api_key'),
            ])
            ->asJson()
            ->post('/api/v1/data/cases', $this->chatUserData)
            ->throw();

        if ($response->successful()) {
            $this->chatUserData->update(['sent_to_nuvun' => true]);
        }
    }

    public function failed(\Throwable $exception): void
    {
        \Log::error('Failed to send case to Nuvun', [
            'data'  => $this->chatUserData->toArray(),
            'error' => $exception->getMessage(),
        ]);
    }

    public function uniqueId(): string
    {
        return $this->chatUserData->session_id;
    }
}
