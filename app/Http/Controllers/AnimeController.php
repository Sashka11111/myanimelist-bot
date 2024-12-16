<?php
namespace App\Http\Controllers;

use App\Services\TelegramService;
use App\Services\AnimeService;
use Illuminate\Http\Request;
use Telegram\Bot\Actions;
use Telegram\Bot\Laravel\Facades\Telegram;

class AnimeController extends Controller
{
    protected $telegramService;
    protected $animeService;

    public function __construct(TelegramService $telegramService, AnimeService $animeService)
    {
        $this->telegramService = $telegramService;
        $this->animeService = $animeService;
    }

    // Основний метод для отримання оновлень
    public function webhook(Request $request)
    {
        $update = Telegram::getWebhookUpdate();
        $chatId = $update->getMessage()->getChat()->getId();
        $text = $update->getMessage()->getText();

        // Відповідь на команду /start
        if ($text === '/start') {
            $this->telegramService->sendMessage($chatId, "Привіт! Я твій аніме бот.");
        }

        // Перегляд списку аніме
        elseif (str_contains($text, '/anime')) {
            $animeList = $this->animeService->getAnimeList();
            $this->telegramService->sendAnimeList($chatId, $animeList['data']);
        }

        // Пошук аніме за назвою
        elseif (str_contains($text, '/search')) {
            $title = str_replace('/search ', '', $text);
            $animeList = $this->animeService->searchAnimeByTitle($title);
            $this->telegramService->sendAnimeList($chatId, $animeList['data']);
        }

        // Деталі аніме
        elseif (str_contains($text, '/details')) {
            $animeId = str_replace('/details ', '', $text);
            $animeDetails = $this->animeService->getAnimeDetails($animeId);
            $this->telegramService->sendAnimeDetails($chatId, $animeDetails);
        }

        // Якщо команда не знайдена
        else {
            $this->telegramService->sendMessage($chatId, "Я не розумію цю команду.");
        }
    }
}
