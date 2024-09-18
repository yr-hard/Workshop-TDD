<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TweetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            'content' => $this->content,
            'created_at' => $this->created_at->diffForHumans(),
            'user' => $this->whenLoaded('user'),
            'photo' => $this->getPhoto(),
        ];
    }
}
