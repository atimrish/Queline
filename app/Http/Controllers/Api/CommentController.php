<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentStoreRequest;
use App\Http\Requests\Comment\CommentUpdateRequest;
use App\Http\Resources\Comment\DefaultCommentResource;
use App\Models\Comment;
use App\Models\Video;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class CommentController extends Controller
{
    public function allFromVideo($hash_id) {
        $video = Video::where('hash_id', $hash_id)->where('is_deleted', 0);

        if (empty($video->count())) {
            return response()->json([
                'error' => 'Ничего не найдено'
            ], 404);
        }

        $video = $video->first();
        $comments = Comment::where('video_id', $video->id)->where('re_id', null)->get();

        return DefaultCommentResource::collection($comments);
    }

    public function store($hash_id, CommentStoreRequest $request)
    {
        $video = Video::where('hash_id', $hash_id)->where('is_deleted', 0);

        if (empty($video->count())) {
            return response()->json([
                'error' => 'Ничего не найдено'
            ], 404);
        }

        $user_id = PersonalAccessToken::findToken($request->bearerToken())->tokenable_id;
        $video = $video->first();

        Comment::create([
           'text' => $request->input('text'),
           're_id' => $request->input('re_id') ?? null,
           'video_id' => $video->id,
            'user_id' => $user_id
        ]);
        return response()->json([
            'message' => 'Комментарий добавлен'
        ]);
    }

    public function update($id, CommentUpdateRequest $request)
    {
        $comment = Comment::findOrFail($id);
        $comment->update([
            'text' => $request->input('text')
        ]);
        return response()->json([
            'message' => 'Комментарий изменен'
        ], 200, [
            'Content-type' => 'application/json'
        ]);
    }

    public function delete($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update([
            'is_deleted' => true
        ]);
        return response(null, 204);
    }

}
