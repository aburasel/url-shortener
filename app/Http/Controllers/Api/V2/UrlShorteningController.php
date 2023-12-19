<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShortenUrlRequest;
use App\Http\Resources\UrlV2Resource;
use App\Http\Traits\ResponseAPI;
use App\Models\Url;
use App\MyApp;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class UrlShorteningController extends Controller
{
    use ResponseAPI;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Url::class);
        $urls = Url::where(['user_id' => $request->user()->id])->get();

        return $this->success('All urls loaded successfully', UrlV2Resource::collection($urls), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function shortenUrl(ShortenUrlRequest $request)
    {
        $validated = $request->validated();

        $existingShortenedUrl = Url::where([
            'long_url' => $validated['url'],
            //'user_id' => $request->user()->id,
        ])->first();

        if (! $existingShortenedUrl) {
            $shortUrlHash = Str::random(8);

            $anUrl = [
                'long_url' => $validated['url'],
                'short_url' => $shortUrlHash,
                'user_id' => $request->user()->id,
            ];

            Url::create($anUrl);

            return $this->success('Shortened successfully', [
                'long_url' => $validated['url'],
                'short_url' => MyApp::BASE_URL.$shortUrlHash,
            ], Response::HTTP_OK);
        } else {
            return $this->success('Shortened successfully', [
                'long_url' => $validated['url'],
                'short_url' => MyApp::BASE_URL.$existingShortenedUrl['short_url'],
            ], Response::HTTP_OK);
        }
    }
}
