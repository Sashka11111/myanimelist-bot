<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;

Route::get('/set-webhook', [AnimeController::class, 'setWebhook']);
