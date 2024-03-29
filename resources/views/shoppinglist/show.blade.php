@extends('layouts.app')

@section('content')
    <div>
        <h2>Display Shopping List (ID: {!! nl2br(e($shoplist->id)) !!} )</h2>
        <h6>List name: {!! nl2br(e($shoplist->shoplist_name)) !!}</h6>
        <h6>Created by: {!! nl2br(e($created_by->name)) !!}</h6>
        <h6>Assigned to: {!! nl2br(e($assigned_to->name)) !!}</h6>
        <h6>Status: {!! nl2br(e($shoplist->status)) !!}</h6>
        <h6>Items to buy: </h6>
    </div>
    
    @if ($shoplist_items->count()>0)
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th scope="col">Item</th>
                <th scope="col">Qty</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($shoplist_items as $shoplist_item)
            <tr>
                <td scope="row">{!! nl2br(e($shoplist_item->shoplist_item_id)) !!}</td>
                <td scope="row">{!! nl2br(e($shoplist_item->item_name)) !!}</td> 
                <td scope="row">{!! nl2br(e($shoplist_item->qty)) !!}</td>
                <td scope="row">{!! nl2br(e($shoplist_item->item_status)) !!}</td> 
            </tr>
            @endforeach
        </tbody>
    </table>
        
    @else
        <p>No item in this list!</p>
    @endif
    
    
    <div>
        <!--ボタン：一覧に戻る -->
        {!! link_to_route('shoplists.get', 'Back to My Shoplists', [], ['class' => 'btn btn-success']) !!}
        
        <!--ボタン：編集 & 削除-->
        @if($shoplist->status == "open") 
            {!! link_to_route('shoplists.edit', 'Edit list', ['id' => $shoplist->id], ['class' => 'btn btn-success']) !!}
           
            <!--削除はFormで。。削除は作成者のみOKとする-->
            @if(Auth::user()->id == $created_by->id)
                <div>
                    {!! Form::open(['route' => ['shoplists.delete', $shoplist->id], 'method' => 'delete']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-success']) !!}
                    {!! Form::close() !!}
                </div>
            @endif
        @endif
        
        <!--ボタン：買物 -->
        @if($shoplist_items_count != $shoplist_items_closed_count) 
            {!! link_to_route('shoplists.shop', 'Shop with list', ['id' => $shoplist->id], ['class' => 'btn btn-success']) !!}
        @endif

    </div>

@endsection