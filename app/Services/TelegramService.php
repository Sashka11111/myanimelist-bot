<?php
namespace App\Services;

use Telegram\Bot\Api;

class TelegramService
{
    protected $telegram;

    public function __construct()
    {
        $this->telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
    }

    // Відправити повідомлення користувачу
    public function sendMessage($chatId, $message)
    {
        $this->telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => $message,
        ]);
    }

    // Відправити список аніме
    public function sendAnimeList($chatId, $animeList)
    {
        $message = "Ось список аніме:\n";
        foreach ($animeList as $anime) {
            $message .= "- " . $anime['attributes']['canonicalTitle'] . "\n";
        }

        $this->sendMessage($chatId, $message);
    }

    // Відправити деталі аніме
    public function sendAnimeDetails($chatId, $animeDetails)
    {
        $message = "Деталі аніме:\n";
        $message .= "Назва: " . $animeDetails['data']['attributes']['canonicalTitle'] . "\n";
        $message .= "Синопсис: " . $animeDetails['data']['attributes']['synopsis'] . "\n";
        $this->sendMessage($chatId, $message);
    }
}
