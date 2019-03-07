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
            'item_name1' => 'required|max:191',
            'qty1' => 'required'
            ]);
            
            $request->user()->shoplists()->create([
                'shoplist_name' => $request->shoplist_name,
                'status' => 'open',
                'assigned_to' => $request->assigned_to,
            ]);
            
            $id = \DB::getPdo()->lastInsertId();        //作成したshoplistのidを取得する。
            $shoplist = Shoplist::find($id);
            
            if ($request->item_name1) {
                $shoplist->shoplist_items()->create([
                    'shoplist_item_id' => '1',
                    'item_name' => $request->item_name1,
                    'qty' => $request->qty1,
                    'item_status' => 'open'
                    ]);
            }
            
            if ($request->item_name2) {
                $shoplist->shoplist_items()->create([
                    'shoplist_item_id' => '2',
                    'item_name' => $request->item_name2,
                    'qty' => $request->qty2,
                    'item_status' => 'open'
                    ]);
            }
            
            if ($request->item_name3) {
                $shoplist->shoplist_items()->create([
                    'shoplist_item_id' => '3',
                    'item_name' => $request->item_name3,
                    'qty' => $request->qty3,
                    'item_status' => 'open'
                    ]);
            }
            
            if ($request->item_name4) {
                $shoplist->shoplist_items()->create([
                    'shoplist_item_id' => '4',
                    'item_name' => $request->item_name4,
                    'qty' => $request->qty4,
                    'item_status' => 'open'
                    ]);
            }
            
            if ($request->item_name5) {
                $shoplist->shoplist_items()->create([
                    'shoplist_item_id' => '5',
                    'item_name' => $request->item_name5,
                    'qty' => $request->qty5,
                    'item_status' => 'open'
                    ]);
            }

            $data = [];
        
            $user = \Auth::user();
            $shoplists = $user->shoplists()->orderBy('id', 'desc')->paginate(10);
            
            $data = [
                'user' => $user,
                'shoplists' => $shoplists,
            ];
        
            return view('shoppinglist.index', $data);           
            
        }
    }
}
