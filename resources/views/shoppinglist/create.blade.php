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
                        <td scope="row">number</td>
                        <td scope="row">blank</td> 
                        <td scope="row">blank</td> 
                    </tr>
            
                </tbody>
            </table>
    
            <br>
            
            {!! Form::submit('Save', ['class' => 'btn-outline-success btn-block']) !!}
            
        {!! Form::close() !!}
    </div>

@endsection