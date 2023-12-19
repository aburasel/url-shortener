<?php

use App\Http\Controllers\Api\V2\UrlShorteningController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::POST('/url/shortening', [UrlShorteningController::class, 'shortenUrl'])->name('url.shorten');
    Route::GET('/urls', [UrlShorteningController::class, 'index'])->name('urls');

});
