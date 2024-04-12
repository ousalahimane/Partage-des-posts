@extends('layouts.app')

@section('content')
  <h1>{{__('Edit')}}</h1>
    <form method="POST" action="{{ route('posts.update', ['post' => $post->id]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
  
        @include('posts.form')
        
      <div class="d-grid gap-2">
          <button class="btn btn-warning" type="submit">{{__('Update!')}}</button>
      </div>
    </form>
@endsection

