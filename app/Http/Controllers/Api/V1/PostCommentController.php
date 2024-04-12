<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\CommentPosted;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComment;
use App\Http\Resources\CommentResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post, Request $request)
    {
        $perPage = $request->input('per_page') ?? null;

        return CommentResource::collection($post->comments()->with('user')->paginate($perPage)->appends([
            "per_page" => $perPage,
        ]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( Post $post, StoreComment $request)
    {
        $comment = $post->comments()->create([
            'content' => $request->content,
            'user_id' => $request->user()->id
        ]);     

        event(new CommentPosted($comment));

        return new CommentResource($comment);
    } 

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
