@extends('layouts.app')

@section('content')
    <div>
        <h2>Create Shopping List</h2>
        
        {!! Form::open(['route' => 'shoplists.post']) !!}
            <div class="form-group">
                {!! Form::label('shoplist_name', 'List name') !!}
                {!! Form::text('shoplist_name', $today, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('assigned_to', 'Assigned to') !!}
                {!! Form::select('assigned_to', $users, $user->id, ['class' => 'form-control', 'id' => 'id']) !!}
            </div>
        
            <h6>Items to buy: </h6>
            
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th scope="col">Item</th>
                        <th scope="col">Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i <= 10; $i++)
                    <tr>
                        <td scope="row">{!! $i !!}
                                        {!! Form::hidden("items[$i][shoplist_item_id]", $i) !!}</td>
                        <td scope="row">{!! Form::text("items[$i][item_name]", old("items[$i][item_name]"), ['class' => 'form-control']) !!}</td> 
                        <td scope="row">{!! Form::text("items[$i][qty]". $i, old("items[$i][qty]"), ['class' => 'form-control']) !!}</td> 
                    </tr>
                    @endfor
            
                </tbody>
            </table>
            {!! Form::submit('OK', ['class' => 'btn-success btn-block']) !!}
        {!! Form::close() !!}
            
            
    </div>

@endsection