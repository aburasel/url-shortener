<?php

namespace App\Http\Resources;

use App\MyApp;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UrlResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
        return [
            'id' => $this->id,
            'short_url' => MyApp::BASE_URL . $this->short_url,
            'long_url' => $this->long_url,
            'visit_count' => $this->visit_count,
        ];
    }
}
