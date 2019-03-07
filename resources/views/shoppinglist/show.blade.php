@extends('layouts.app')

@section('content')
    <div>
        <h2>Display Shopping List</h2>
        <h6>List name: {!! nl2br(e($shoplist->shoplist_name)) !!}</h6>
        <h6>Created by: {!! nl2br(e($user->name)) !!}</h6>
        <h6>Assigned to: {!! nl2br(e($assigned_to->name)) !!}</h6>
        <h6>Items to buy: </h6>
    </div>
    
    @if ($shoplist_items->count()>0)
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
                <td scope="row">{!! nl2br(e($shoplist_item->shoplist_item_id)) !!}</td>
                <td scope="row">{!! nl2br(e($shoplist_item->item_name)) !!}</td> 
                <td scope="row">{!! nl2br(e($shoplist_item->qty)) !!}</td> 
            </tr>
            @endforeach
        </tbody>
    </table>
        
    @else
        <p>No item in this list!</p>
    @endif
    
     
    {!! link_to_route('shoplists.get', 'Back to My Shoplists', [], ['class' => 'btn btn-outline-success btn-sm']) !!}
    

@endsection