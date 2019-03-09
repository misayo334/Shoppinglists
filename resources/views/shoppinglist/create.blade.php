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
                    @for ($i = 1; $i < 6; $i++)
                    <tr>
                        <td scope="row">{!! Form::label('shoplist_item_id'. $i, $i, ['class' => 'form-control', 'readonly' => 'true']) !!}</td>
                        <td scope="row">{!! Form::text('item_name'. $i, old('item_name'. $i), ['class' => 'form-control']) !!}</td> 
                        <td scope="row">{!! Form::text('qty'. $i, old('qty'. $i), ['class' => 'form-control']) !!}</td> 
                    </tr>
                    @endfor
            
                </tbody>
            </table>
    
            {!! Form::submit('OK', ['class' => 'btn-success btn-block']) !!}
        {!! Form::close() !!}
            
            
    </div>

@endsection