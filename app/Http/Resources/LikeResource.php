<?php

namespace App\Http\Resources;

use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
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
            'emoji_type' => $this->emoji_type,
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }

    /**
     * Load user info for each like
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
