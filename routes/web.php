<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\UserCommentController;
use App\Http\Controllers\UserController;
use App\Mail\CommentedPostMarkdown;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('mailable', function(){

    $comment = Comment::find(1);

    return new CommentedPostMarkdown($comment);
    
});

Route::view('/','welcome');

Route::get('secret', [HomeController::class, 'secret'])->middleware('can:secret.page');

Route::get('posts/archive', [PostController::class, 'archive'])->name('archive');
Route::get('posts/all', [PostController::class, 'all'])->name('all');
Route::patch('posts/{id}/restore', [PostController::class, 'restore']);
Route::delete('posts/{id}/forceDelete', [PostController::class, 'forceDelete']);

Route::get('posts/tag/{id}',[PostTagController::class,'index'])->name('posts.tag.index');

Route::resource('posts', PostController::class);
Route::resource('posts.comments', PostCommentController::class)->only(['store', 'show']);
Route::resource('users.comments', UserCommentController::class)->only(['store']);
Route::resource('users', UserController::class)->only(['show', 'edit', 'update']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

