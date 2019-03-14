@extends('layouts.app')

@section('content')

    <div>
        <h2>Choose a list</h2>
    </div>
    <ul>
        @if ($shoplists->count()>0)
            @foreach ($shoplists as $shoplist)
                    <li>
                        {!! nl2br(e($shoplist->id)) !!} :
                        {!! link_to_route('shoplists.show', nl2br(e($shoplist->shoplist_name)), ['id' => $shoplist->id], ['class' => 'btn-link']) !!}
                        (last updated at: {!! nl2br(e($shoplist->updated_at)) !!} 
                        , status: {!! nl2br(e($shoplist->status)) !!} 
                        , created by: {!! nl2br(e($shoplist->user_id)) !!} 
                        , assigned to: {!! nl2br(e($shoplist->assigned_to)) !!} )
                    </li>
            @endforeach
        @else
            <p>You do not have pending shoplists</p>
        @endif
    </ul>
    
{{--   {{ $shoplists->render('pagination::bootstrap-4') }}
--}}


@endsection