<?php

namespace App\Services;

use App\Models\Url;
use App\Models\User;
use Illuminate\Support\Str;

class UrlService
{
    public function getUrl(array $data): User
    {
        return Url::where($data)->first();
    }

    public function createShortUrl(array $data): Url
    {
        $shortUrlHash = Str::random(8);
        $anUrl = [
            'long_url' => $data['url'],
            'short_url' => $shortUrlHash,
            'user_id' => $data['user_id'],
        ];

        return Url::create($anUrl);
    }
}
