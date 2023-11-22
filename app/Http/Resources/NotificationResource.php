<?php

namespace App\Http\Resources;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'is_read' => $this->resource->is_read,
            'target_type' => $this->resource->target_type,
            'content' => $this->resource->content,
            'default_content' => $this->getContentMessage($this->resource->target_type),
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
        // return parent::toArray($request);
    }

    /**
     * Get the content message based on the target type.
     *
     * @return string
     */
    private function getContentMessage($targetType)
    {
        return Notification::NOTIFICATION_MESSAGE[$targetType] ?? 'Unknown notification';
    }
}
