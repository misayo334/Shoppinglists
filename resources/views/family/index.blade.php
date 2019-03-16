@extends('layouts.app')

@section('content')
    
    <h2>My family members</h2>
    @if (count($inviting_users) + count($invited_users) > 0)
    <ul class="list-unstyled">
        @foreach ($inviting_users as $inviting_user)
            <li class="media">
                <img class="mr-2 rounded" src="{{ Gravatar::src($inviting_user->email, 50) }}" alt="">
                <div class="media-body">
                    <div>
                        {{ $inviting_user->name }}
                    </div>
                    <div>
                        <p> {!! link_to_route('users.show', 'View profile', ['id' => $inviting_user->id]) !!}</p>
                        <p>
                            @if (Auth::user()->is_family($inviting_user->id))
                                {!! Form::open(['route' => ['family.remove', $inviting_user->id], 'method' => 'delete']) !!}
                                    {!! Form::submit('Remove', ['class' => "btn btn-danger btn-sm"]) !!}
                                {!! Form::close() !!}
                            @endif
                        </p>
                    </div>
                </div>
            </li>
        @endforeach
        @foreach ($invited_users as $invited_user)
            <li class="media">
                <img class="mr-2 rounded" src="{{ Gravatar::src($invited_user->email, 50) }}" alt="">
                <div class="media-body">
                    <div>
                        {{ $invited_user->name }}
                    </div>
                    <div>
                        <p> {!! link_to_route('users.show', 'View profile', ['id' => $invited_user->id]) !!}</p>
                        <p>
                            @if (Auth::user()->is_family($invited_user->id))
                                {!! Form::open(['route' => ['family.remove', $invited_user->id], 'method' => 'delete']) !!}
                                    {!! Form::submit('Remove', ['class' => "btn btn-danger btn-sm"]) !!}
                                {!! Form::close() !!}
                            @endif
                        </p>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    @else
    <p>No family members</p>
    @endif
    
    <h2>Pending invitations</h2>
    @if (count($inviting_users_pending) + count($invited_users_pending) > 0)
    <ul class="list-unstyled">
        @foreach ($inviting_users_pending as $inviting_user_pending)
            <li class="media">
                <img class="mr-2 rounded" src="{{ Gravatar::src($inviting_user_pending->email, 50) }}" alt="">
                <div class="media-body">
                    <div>
                        {{ $inviting_user_pending->name }}
                    </div>
                    <div>
                        <p> {!! link_to_route('users.show', 'View profile', ['id' => $inviting_user_pending->id]) !!}
                         - Pending acceptance</p>
                        <p>
                            @if (Auth::user()->is_family($inviting_user_pending->id))
                                {!! Form::open(['route' => ['family.remove', $inviting_user_pending->id], 'method' => 'delete']) !!}
                                    {!! Form::submit('Remove', ['class' => "btn btn-danger btn-sm"]) !!}
                                {!! Form::close() !!}
                            @endif
                        </p>
                    </div>
                </div>
            </li>
        @endforeach
        @foreach ($invited_users_pending as $invited_user_pending)
            <li class="media">
                <img class="mr-2 rounded" src="{{ Gravatar::src($invited_user_pending->email, 50) }}" alt="">
                <div class="media-body">
                    <div>
                        {{ $invited_user_pending->name }}
                    </div>
                    <div>
                        <p> {!! link_to_route('users.show', 'View profile', ['id' => $invited_user_pending->id]) !!}</p>
                        <p>
                            @if (Auth::user()->is_family($invited_user_pending->id))
                                {!! Form::open(['route' => ['family.accept', $invited_user_pending->id], 'method' => 'put']) !!}
                                    {!! Form::submit('Accept', ['class' => "btn btn-info btn-sm"]) !!}
                                {!! Form::close() !!}
                            @endif
                        </p>
                        <p>
                            @if (Auth::user()->is_family($invited_user_pending->id))
                                {!! Form::open(['route' => ['family.remove', $invited_user_pending->id], 'method' => 'delete']) !!}
                                    {!! Form::submit('Remove', ['class' => "btn btn-danger btn-sm"]) !!}
                                {!! Form::close() !!}
                            @endif
                        </p>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    @else
    <p>No pending members</p>
    @endif
    
    <h2>Non-family members</h2>
    
    @if (count($other_users) > 0)
    <ul class="list-unstyled">
        @foreach ($other_users as $other_user)
            <li class="media">
                <img class="mr-2 rounded" src="{{ Gravatar::src($other_user->email, 50) }}" alt="">
                <div class="media-body">
                    <div>
                        {{ $other_user->name }}
                    </div>
                    <div>
                        <p> {!! link_to_route('users.show', 'View profile', ['id' => $other_user->id]) !!}</p>
                        <p> {!! Form::open(['route' => ['family.invite', $other_user->id]]) !!}
                                {!! Form::submit('Invite', ['class' => "btn btn-success btn-sm"]) !!}
                            {!! Form::close() !!}
                        </p>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    @else
    <p>No non-family users</p>
    @endif
    
@endsection