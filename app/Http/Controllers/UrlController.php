<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UrlController extends Controller
{
    public function openUrl(Request $request) //
    {

        $shortUrl = $request->route('short_url');

        $request->merge(['short_url' => $shortUrl]);

        try {
            $validated = $request->validate(['short_url' => ['required', 'min:8', 'max:8']]);
        } catch (ValidationException $e) {
            abort(404);
        }

        $url = Url::where('short_url', $validated['short_url'])->first();

        if ($url == null) {
            abort(404);
        } else {
            $url->increment('visit_count');
            return redirect($url->long_url);
        }

    }
}
