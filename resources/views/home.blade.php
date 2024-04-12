@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">    

                 <h1> {{ __('Welcome') }} </h1>
                 {{-- <p>{{ __('example_with_value', ['name' => 'Mohammed']) }} </p> --}}
                 <p> {{ trans_choice('plural', 0) }} </p>
                 <p> {{ trans_choice('plural', 1) }} </p>
                 <p> {{ trans_choice('plural', 29) }} </p>                  


                @can('secret.page')
                  <p><a href="secret">administration</a></p>
                @endcan  
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
