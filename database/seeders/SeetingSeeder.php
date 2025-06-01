<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeetingSeeder extends Seeder
{

    use WithoutModelEvents;

    public function run(): void
    {
        $rows = [
            [
                'name' => 'Link Facebook',
                'key' => 'site.link_facebook',
                'value' => 'https://www.facebook.com',
            ],
            [
                'name' => 'Link Instagram',
                'key' => 'site.link_instagram',
                'value' => 'https://www.instagram.com/',
            ],
            [
                'name' => 'Link YouTube',
                'key' => 'site.link_youtube',
                'value' => 'https://linktr.ee',
            ],
            [
                'name' => 'Link WhatsApp',
                'key' => 'site.link_whatsapp',
                'value' => 'https://wa.me/5586999999999',
            ],
            [
                'name' => 'Link Twitter',
                'key' => 'site.link_twitter',
                'value' => 'https://twitter.com',
            ],
            [
                'name' => 'Link grupo WhatsApp',
                'key' => 'site.grupo_whatsapp',
                'value' => 'https://chat.whatsapp.com/KAUZT9ucQPvEnhuXIh7YVo',
            ],
            [
                'name' => 'Link Telegram',
                'key' => 'site.link_telegram',
                'value' => 'https://t.me/+L5CcwOtONpkzZDdh',
            ],
            [
                'name' => 'Link TikTok',
                'key' => 'site.link_tiktok',
                'value' => 'https://www.tiktok.com/',
            ],
            [
                'name' => 'Telefone',
                'key' => 'site.phone_number',
                'value' => '(86) 99123-4567',
            ],
        ];

        Setting::query()
            ->upsert($rows, ['key'], ['name', 'value']);
    }
}
