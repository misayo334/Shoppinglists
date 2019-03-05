@extends('layouts.app')

@section('content')
    <div class="row">
        <aside class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $user->name }}</h3>
                </div>
                <div class="card-body">
                    <img class="rounded img-fluid" src="{{ Gravatar::src($user->email, 500) }}" alt="">
                </div>
            </div>
        </aside>
        <div class="col-sm-8">
            <p>Nickname :  {{ $user->name }}</p>
            <p>Email :  {{ $user->email }}</p>
            <p>Registered at :  {{ $user->created_at }}</p>
            <br>
            <br>
            {!! link_to_route('users.index', 'Back to Manage Family', [], ['class' => 'btn btn-outline-success']) !!}
        </div>
    </div>
    </div>
@endsection
