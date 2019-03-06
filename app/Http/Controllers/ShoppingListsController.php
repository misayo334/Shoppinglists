<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;                       // 追加
use App\Shoplist;                   // 追加
use App\Shoplist_item;              // 追加

class ShoppingListsController extends Controller
{
    public function index()
    {
        
        $data = [];
        if (\Auth::check()) {
            
            $user = \Auth::user();
            $shoplists = $user->shoplists()->orderBy('id', 'desc')->paginate(10);
            
            $data = [
                'user' => $user,
                'shoplists' => $shoplists,
            ];
        }
        
        return view('shoppinglist.index', $data);
    }
    
    public function show($id)
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $shoplist = $user->shoplists()->find($id);
            $assigned_to = User::find($shoplist->assigned_to);
            $shoplist_items = $shoplist->shoplist_items()->get();
            
            $data = [
                'user' => $user,
                'shoplist' => $shoplist,
                'assigned_to' => $assigned_to,
                'shoplist_items' => $shoplist_items
            ];
            
            return view('shoppinglist.show', $data);
        }
    }
    
    public function create()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $shoplist = new Shoplist;
            $shoplist_item = new Shoplist_item;
    
            return view('shoppinglist.create', [
                'shoplist' => $shoplist,
                'shoplist_item' => $shoplist_item,
            ]);
        
        }
    }
    
    public function store(Request $request)
    {
        if (\Auth::check()) {
            
            $user = \Auth::user();
            
            $this->validate($request, [
            'shoplist_name' => 'required|max:191',   
            'assigned_to' => 'required',  
            ]);
            
            $request->user()->shoplists()->create([
                'shoplist_name' => $request->shoplist_name,
                'status' => 'open',
                'assigned_to' => $request->assigned_to,
            ]);

        return redirect('/');
            
            
            
        
        }
    }
}
