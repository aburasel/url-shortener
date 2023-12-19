<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShortenUrlRequest;
use App\Http\Resources\UrlResource;
use App\Http\Traits\ResponseAPI;
use App\Models\Url;
use App\MyApp;
use App\Services\UrlService;
use Illuminate\Http\Request;
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

        return $this->success('All urls loaded successfully', UrlResource::collection($urls), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function shortenUrl(ShortenUrlRequest $request, UrlService $urlService)
    {
        $validated = $request->validated();

        $existingShortenedUrl = $urlService->getUrl([
            'long_url' => $validated['url'],
        ]);

        if (! $existingShortenedUrl) {
            $data = array_merge(['user_id' => $request->user()->id], $validated);
            $shortenedUrl = $urlService->createShortUrl($data);

            return $this->success('Shortened successfully', [
                'long_url' => $shortenedUrl['long_url'],
                'short_url' => MyApp::BASE_URL.$shortenedUrl['short_url'],
            ], Response::HTTP_OK);
        } else {
            return $this->success('Shortened successfully', [
                'long_url' => $validated['url'],
                'short_url' => MyApp::BASE_URL.$existingShortenedUrl['short_url'],
            ], Response::HTTP_OK);
        }
    }
}
