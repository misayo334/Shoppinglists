@extends('layouts.app')

@section('content')
    <div class="jumbotron jumbotron-fluid">
        <div class="text-center">
            <h1>Welcome!</h1>
            <br>
            <hr class="my-4">  <!--区切り線を入れる-->
            
            <div>
                @if (Auth::check())
                    {{ Auth::user()->name }}
                @else
                {!! link_to_route('login', 'Login', [], ['class' => 'btn btn-outline-success btn-lg']) !!}
                {!! link_to_route('signup.get', 'Register now!', [], ['class' => 'btn btn-outline-success btn-lg']) !!}
                @endif
            </div>
        </div>
    </div>

@endsection