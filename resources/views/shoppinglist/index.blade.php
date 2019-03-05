@extends('layouts.app')

@section('content')

    <div>
        <h2>Choose a list</h2>
    </div>
    <ul>
        @if ($shoplists->count()>0)
            @foreach ($shoplists as $shoplist)
                <li>{!! nl2br(e($shoplist->shoplist_name)) !!}</li>
            @endforeach
        @else
            <p>You do not have pending shoplists</p>
        @endif
    </ul>

@endsection