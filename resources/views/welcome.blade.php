@extends('layouts.app')

@section('content')

    <div class="jumbotron jumbotron-fluid">
        <div class="text-center">
            <h1>Welcome!</h1>
            <br>
            <hr class="my-4">  <!--区切り線を入れる-->
            @if (Auth::check())
                <div>
                {!! link_to_route('shoplists.get', 'Display my shoplists', [], ['class' => 'btn btn-outline-success btn-lg']) !!}
                </div>
            @else
                <div>
                    {!! link_to_route('login', 'Login', [], ['class' => 'btn btn-outline-success btn-lg']) !!}
                    {!! link_to_route('signup.get', 'Register now!', [], ['class' => 'btn btn-outline-success btn-lg']) !!}
                </div>
            @endif
        </div>
    </div>

@endsection