@extends('layouts.app')

@section('content')

   <div class="row">
      <div class="col-8">
          <h1>{{ $post->title }}</h1>

          @if($post->image)
            <img src="{{ $post->image->url() }}" alt="Post Image" class="img-fluid mt-3 rounded">
          @endif

          {{-- <img src="http://127.0.0.1:8000/storage/{{$post->image->path ?? null}}" class="img-fluid mt-3 rounded" alt=""> --}}

          <p>{{ $post->content }}</p>
          <em>{{ $post->created_at->diffForHumans() }}</em>
          <p>Status : 
            @if ($post->active)
              Enabled
            @else
              Disabled
            @endif
          </p>
          <x-tag :tags="$post->tags"></x-tag>

          <x-comment-form :action="route('posts.comments.store', ['post' => $post->id])"></x-comment-form>

          <h5>{{__('Comments')}}</h5>
          <x-comment-list :comments="$post->comments"></x-comment-list>
  
      </div>
    <div class="col-4">
        @include('posts.sidebar')
    </div>
   </div>    
  
@endsection