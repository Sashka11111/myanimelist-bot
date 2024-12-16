<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class AnimeService
{
    private string $baseUrl = 'https://kitsu.io/api/edge/';

    public function getAnimeList($page = 1)
    {
        $response = Http::get($this->baseUrl . 'anime', [
            'page[limit]' => 10,
            'page[offset]' => ($page - 1) * 10,
        ]);
        return $response->json();
    }

    public function searchAnimeByTitle($title)
    {
        $response = Http::get($this->baseUrl . 'anime', [
            'filter[text]' => $title,
        ]);
        return $response->json();
    }

    public function getAnimeDetails($animeId)
    {
        $response = Http::get($this->baseUrl . 'anime/' . $animeId);
        return $response->json();
    }
}
