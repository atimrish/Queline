<?php

namespace App\Http\Resources\Video;

use App\Http\Resources\Category\DefaultCategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DefaultVideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'hash_id' => $this->hash_id,
            'title' => $this->title,
            'nickname' => $this->user->nickname,
            'description' => $this->description,
            'preview' => $this->preview,
            'category' => new DefaultCategoryResource($this->category),
            'path' => $this->path,
            'is_moderated' => $this->is_moderated,
            'created_at' => $this->created_at,
            'grades' => [],
            'tags' => []
        ];
    }
}