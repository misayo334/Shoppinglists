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
                {!! Form::select('assigned_to', $users, old('assigned_to'), ['class' => 'form-control', 'id' => 'id']) !!}
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
                        <td scope="row">{!! $shoplist_item->shoplist_item_id !!}
                                        {!! Form::hidden("items[$shoplist_item->shoplist_item_id][shoplist_item_id]", e($shoplist_item->shoplist_item_id), ['class' => 'form-control']) !!}</td>
                        <td scope="row">{!! Form::text("items[$shoplist_item->shoplist_item_id][item_name]", e($shoplist_item->item_name), ['class' => 'form-control']) !!}</td> 
                        <td scope="row">{!! Form::text("items[$shoplist_item->shoplist_item_id][qty]", e($shoplist_item->qty), ['class' => 'form-control']) !!}</td> 
                    </tr>
                    @endforeach
            
                </tbody>
            </table>

            {!! Form::submit('OK', ['class' => 'btn-success btn-block']) !!}
        {!! Form::close() !!}
            
            
    </div>

@endsection