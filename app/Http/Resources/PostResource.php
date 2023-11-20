<?php

namespace App\Http\Resources;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $request->user();

        return [
            'id' => $this->resource->id,
            'title' => $this->title,
            'content' => $this->content,
            'total_count' => $this->likes->count(),
            'like_count' => $this->likes->where('emoji_type', Like::LIKE_EMOTION)->count(),
            'love_count' => $this->likes->where('emoji_type', Like::LOVE_EMOTION)->count(),
            'haha_count' => $this->likes->where('emoji_type', Like::HAHA_EMOTION)->count(),
            'user' => new UserResource($this->whenLoaded('user')),
            'likes' => LikeResource::collection($this->whenLoaded('likes')),
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'is_liked_by_user' => $user ? $this->likes->where('user_id', $user->id)->isNotEmpty() : false,
        ];
    }
}
