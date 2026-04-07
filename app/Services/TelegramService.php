<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    public static function send($message)
    {
        $response = Http::post(
            "https://api.telegram.org/bot" . config('services.telegram.bot_token') . "/sendMessage",
            [
                'chat_id'    => config('services.telegram.chat_id'),
                'text'       => $message,
                'parse_mode' => 'HTML',
            ]
        );

        if ($response->failed()) {
            Log::error('Telegram send failed', ['response' => $response->body()]);
        }
    }
}
