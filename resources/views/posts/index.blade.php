@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-8">
          {{-- <nav class="nav nav-tabs flex-row my-5">
            <a class="nav-link @if($tab == 'list') active @endif" href="{{ route('posts.index') }}" aria-current="page">List</a>
            <a class="nav-link @if($tab == 'archive') active @endif" href="{{ route('archive') }}" aria-current="page">Archive</a>
            <a class="nav-link @if($tab == 'all') active @endif" href="{{ route('all') }}" aria-current="page">All</a>  
          </nav> --}}
      
          <div class="my-3">
            <h4> {{ $posts->count() }} Post(s) </h4>
          </div>
      
          <ul class="list-group">
            @forelse ($posts as $post)
            <li class="list-group-item">

              @if($post->created_at->diffInHours() < 1)
                 <x-badge type="success">{{__('New')}}</x-badge>
              @else
                 <x-badge type="dark">{{__('Old')}}</x-badge>
              @endif

      
              @if($post->image)
               <img src="{{ $post->image->url() }}" alt="Post Image" class="img-fluid mt-3 rounded">
              @endif

          {{-- <img src="http://127.0.0.1:8000/storage/{{$post->image->path ?? null}}" class="img-fluid mt-3 rounded" alt=""> --}}


                <h2>
                  <a href="{{route('posts.show', ['post' => $post->id])}}">
                      @if($post->trashed())
                        <del>
                          {{ $post->title }}
                        </del>    
                      @else
                          {{ $post->title }}
                      @endif
                  </a>
                </h2>

                <x-tag :tags="$post->tags"></x-tag>

                <p>{{ $post->content }}</p>
                <em>{{ $post->created_at }}</em>
      
                @if($post->comments_count)
                  <div>
                    <span class="badge bg-primary"> {{ $post->comments_count }} {{__('Comments')}} </span>
                  </div>          
                @else
                  <div>
                    <span class="badge bg-dark"> {{__('No comments yet!')}} </span>
                  </div>  
                @endif
      
                <x-updated :date="$post->created_at" :name="$post->user->name" :userId="$post->user->id">{{__('Added')}}</x-updated>
                <x-updated :date="$post->updated_at">{{__('Updated')}}</x-updated>

          @auth
                @can('update', $post)
                  <a class="btn btn-warning" href="{{route('posts.edit', ['post' => $post->id])}}">{{__('Edit')}}</a>
                @endcan
      
                @cannot('delete', $post)
                     <x-badge type="danger">{{__('You can\'t delete')}}</x-badge>
                @endcannot
      
                @if(!$post->deleted_at)
      
                    @can('delete', $post)
                        <form class="form-inline" method="POST" action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                          @csrf
                          @method('DELETE')           
                          <button class="btn btn-danger" type="submit">{{__('Delete')}}</button>
                        </form>
                    @endcan
      
                @else
      
                    @can('restore', $post)
                      <form class="form-inline" method="POST" action="{{ url('posts/'.$post->id.'/restore') }}">
                        @csrf
                        @method('PATCH')           
                        <button class="btn btn-success" type="submit">Restore</button>
                      </form>
                    @endcan
      
                    @can('forceDelete', $post)
                      <form class="form-inline" method="POST" action="{{ url('posts/'.$post->id.'/forceDelete') }}">
                        @csrf
                        @method('DELETE')           
                        <button class="btn btn-danger" type="submit">Force delete</button>
                      </form>
                    @endcan
                    @endif
          @endauth
      
              </li>
              @empty
              <x-badge type="danger">No post yet.</x-badge>
                @endforelse
          </ul>
        </div>
      <div class="col-4">

          @include('posts.sidebar')

      </div>
    </div>

   
@endsection