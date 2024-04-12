@extends('layouts.app')

@section('content')
  <h1>{{__('Create!')}}</h1>
    <form action="{{route('posts.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        
        @include('posts.form')
    <div class="d-grid gap-2">   
        <button class="btn btn-primary" type="submit">{{__('Create!')}}</button>
    </div>
        
    </form>
@endsection

