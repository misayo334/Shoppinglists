@extends('layouts.app')

@section('content')
    <div>
        <h2>Create Shopping List</h2>
        
        {!! Form::open(['route' => 'shoplists.post']) !!}
            <div class="form-group">
                {!! Form::label('shoplist_name', 'List name') !!}
                {!! Form::text('shoplist_name', old('shoplist_name'), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('assigned_to', 'Assigned to') !!}
                {!! Form::text('assigned_to', old('assigned_to'), ['class' => 'form-control']) !!}
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
                    <tr>
                        <td scope="row">1</td>
                        <td scope="row">{!! Form::text('item_name1', old('item_name1'), ['class' => 'form-control']) !!}</td> 
                        <td scope="row">{!! Form::text('qty1', old('qty1'), ['class' => 'form-control']) !!}</td> 
                    </tr>
                    
                    <tr>
                        <td scope="row">2</td>
                        <td scope="row">{!! Form::text('item_name2', old('item_name2'), ['class' => 'form-control']) !!}</td> 
                        <td scope="row">{!! Form::text('qty2', old('qty2'), ['class' => 'form-control']) !!}</td>
                    </tr>
                    
                    <tr>
                        <td scope="row">3</td>
                        <td scope="row">{!! Form::text('item_name3', old('item_name3'), ['class' => 'form-control']) !!}</td> 
                        <td scope="row">{!! Form::text('qty3', old('qty3'), ['class' => 'form-control']) !!}</td>
                    </tr>
                    
                    <tr>
                        <td scope="row">4</td>
                        <td scope="row">{!! Form::text('item_name4', old('item_name4'), ['class' => 'form-control']) !!}</td> 
                        <td scope="row">{!! Form::text('qty4', old('qty4'), ['class' => 'form-control']) !!}</td>
                    </tr>
                    
                    <tr>
                        <td scope="row">5</td>
                        <td scope="row">{!! Form::text('item_name5', old('item_name5'), ['class' => 'form-control']) !!}</td> 
                        <td scope="row">{!! Form::text('qty5', old('qty5'), ['class' => 'form-control']) !!}</td>
                    </tr>
            
                </tbody>
            </table>
    
            <br>
            {!! Form::submit('OK', ['class' => 'btn-outline-success btn-sm']) !!}
        {!! Form::close() !!}
            
            
    </div>

@endsection