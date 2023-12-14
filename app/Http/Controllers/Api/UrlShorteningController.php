<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShortenUrlRequest;
use App\Http\Traits\ResponseAPI;
use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class UrlShorteningController extends Controller
{
    use ResponseAPI;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function shortenUrl(ShortenUrlRequest $request)
    {
        $validated = $request->validated();

        $existingShortenedUrl = Url::where([
            'long_url' => $validated['url'],
            'user_id' => $request->user()->id,
        ])->first();

        if (!$existingShortenedUrl) {
            $shortUrlHash = Str::random(8);

            $anUrl = [
                'long_url' => $validated['url'],
                'short_url' => $shortUrlHash,
                'user_id' => $request->user()->id,
            ];

            Url::create($anUrl);
            //Url::create($anUrl)->toRawSql();
//dd(Url::create($anUrl)->toRawSql());
            $this->success('Shortened successfully', [
                'long_url' => $validated['url'],
                'short_url' => 'http://127.0.0.1:8000/' . $shortUrlHash,
            ], Response::HTTP_OK);
        } else {
            $this->success('Shortened successfully', [
                'long_url' => $validated['url'],
                'short_url' => 'http://127.0.0.1:8000/' . $existingShortenedUrl['short_url'],
            ], Response::HTTP_OK);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Url $url)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Url $url)
    {
        //
    }
}
