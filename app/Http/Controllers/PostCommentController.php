<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Jobs\NotifyUsersPostWasCommented;
use App\Mail\CommentedPostMarkdown;
use App\Models\Post;
use Illuminate\Support\Facades\Mail;
use App\Events\CommentPosted as MyCommentPosted;
use App\Http\Resources\CommentResource;

class PostCommentController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['store']);
    }

    public function show(Post $post){
        return CommentResource::collection($post->comments()->with('user')->get());
    }
    public function store(StoreComment $request, Post $post){
       
        $comment = $post->comments()->create([
            'content' => $request->content,
            'user_id' => $request->user()->id
        ]);     

       
        event(new MyCommentPosted($comment));


        // Mail::to($post->user->email)->send(new CommentedPostMarkdown($comment));
        // $delay = now()->addMinutes(1);
        // Mail::to($post->user->email)->later($delay ,new CommentedPostMarkdown($comment));
        
        return redirect()->back();
    }
}
