<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\CommentGrade\DefaultCommentGradeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DefaultCommentResource extends JsonResource
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
            'nickname' => $this->user->nickname,
            'text' => $this->text,
            'photo' => $this->user->photo,
            'is_deleted' => $this->is_deleted,
            'created_at' => $this->created_at,
            're' => DefaultCommentResource::collection($this->re),
            'grades' => [
                'likes' => DefaultCommentGradeResource::collection($this->likes),
                'dislikes' => DefaultCommentGradeResource::collection($this->dislikes)
            ]
        ];
    }
}
