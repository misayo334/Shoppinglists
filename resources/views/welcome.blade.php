@extends('layouts.app')

@section('content')
    <div class="jumbotron jumbotron-fluid">
        <div class="text-center">
            <h1>Welcome!</h1>
            <br>
            <hr class="my-4">
            
            <div>
                <p class="btn btn-outline-success btn-sm">Login button here</p>
                
                
                {!! link_to_route('signup.get', 'Register now!', [], ['class' => 'btn btn-outline-success btn-lg']) !!}
            </div>
        </div>
    </div>

@endsection