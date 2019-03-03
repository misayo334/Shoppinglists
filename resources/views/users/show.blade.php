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
            ここにuser詳細を表示？
            <br>
            <br>
            {!! link_to_route('users.index', 'Back to Manage Family', [], ['class' => 'nav-link']) !!}
        </div>
    </div>
    </div>
@endsection
