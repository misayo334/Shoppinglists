@extends('layouts.app')

@section('content')
    <div>
        <h2>Edit Shopping List</h2>
        
        {!! Form::model($shoplist, ['route' => ['shoplists.update', $shoplist->id], 'method' => 'put']) !!}
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
                    @foreach ($shoplist_items as $shoplist_item)
                    <tr>
                        <td scope="row">{!! Form::label('shoplist_item_id' . $shoplist_item->shoplist_item_id, e($shoplist_item->shoplist_item_id), ['class' => 'form-control']) !!}</td>
                        <td scope="row">{!! Form::text('item_name' . $shoplist_item->shoplist_item_id, e($shoplist_item->item_name), ['class' => 'form-control']) !!}</td> 
                        <td scope="row">{!! Form::text('qty' . $shoplist_item->shoplist_item_id, e($shoplist_item->qty), ['class' => 'form-control']) !!}</td> 
                    </tr>
                    @endforeach
            
                </tbody>
            </table>
            
            
    
            <br>
            {!! Form::submit('OK', ['class' => 'btn-outline-success btn-sm']) !!}
        {!! Form::close() !!}
            
            
    </div>

@endsection