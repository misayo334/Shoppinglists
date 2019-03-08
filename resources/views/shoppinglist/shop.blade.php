@extends('layouts.app')

@section('content')
    <div>
        <h2>Shop with List (ID: {!! nl2br(e($shoplist->id)) !!} )</h2>
        <h6>List name: {!! nl2br(e($shoplist->shoplist_name)) !!}</h6>
        <h6>Created by: {!! nl2br(e($user->name)) !!}</h6>
        <h6>Assigned to: {!! nl2br(e($assigned_to->name)) !!}</h6>
        <h6>Items to buy: </h6>
    </div>
    
    @if ($shoplist_items->count()>0)
    {!! Form::model($shoplist, ['route' => ['shoplists.status_change', $shoplist->id], 'method' => 'put']) !!}
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th scope="col">Item</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Done</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shoplist_items as $shoplist_item)
                <tr>
                    <td scope="row">{!! nl2br(e($shoplist_item->shoplist_item_id)) !!}</td>
                    <td scope="row">{!! nl2br(e($shoplist_item->item_name)) !!}</td> 
                    <td scope="row">{!! nl2br(e($shoplist_item->qty)) !!}</td> 
                    <td scope="row">{{Form::checkbox('status' . $shoplist_item->shoplist_item_id, 1, false)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    
        {!! Form::submit('Checkout', ['class' => 'btn-outline-success btn-sm']) !!}
    {!! Form::close() !!}
    
    @else
        <p>No item in this list!</p>
    @endif
    
    

@endsection