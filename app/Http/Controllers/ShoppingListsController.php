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
            $users = User::pluck('name', 'id');
            $today = date("Ymd");
    
            return view('shoppinglist.create', [
                'user' => $user,
                'shoplist' => $shoplist,
                'shoplist_item' => $shoplist_item,
                'users' => $users,
                'today' => $today
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
            'items.1.item_name' => 'required',
            'items.1.qty' => 'required'
            ]);
            
            $assigned_to = User::find($request->assigned_to);
            
            $request->user()->shoplists()->create([
                'shoplist_name' => $request->shoplist_name,
                'status' => 'open',
                'assigned_to' => $assigned_to->id,
            ]);
            
            $id = \DB::getPdo()->lastInsertId();        //作成したshoplistのidを取得する。
            $shoplist = Shoplist::find($id);
            
            $items = $request->items;
            
            // dd($items);                                 //Debug挿入
            
            foreach($items as $item){
                // dd($item["item_name"]);                 //Debug挿入
                if ($item["item_name"]) {
                    $shoplist->shoplist_items()->create([
                        'shoplist_item_id' => $item["shoplist_item_id"],
                        'item_name' => $item["item_name"],
                        'qty' => $item["qty"],
                        'item_status' => 'open'
                    ]);
                } 
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
    
    public function edit($id)       
    {
            
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $shoplist = $user->shoplists()->find($id);
            $assigned_to = User::find($shoplist->assigned_to);
            $shoplist_items = $shoplist->shoplist_items()->get();
            $users = User::pluck('name', 'id');
            
            $data = [
                'user' => $user,
                'shoplist' => $shoplist,
                'assigned_to' => $assigned_to,
                'shoplist_items' => $shoplist_items,
                'users' => $users
            ];
            
            return view('shoppinglist.edit', $data);
        }
    }
    
    public function update(Request $request, $id)
    {
        if (\Auth::check()) {
            
            $user = \Auth::user();
            
            $this->validate($request, [
                'shoplist_name' => 'required|max:191',   
                'assigned_to' => 'required', 
                'item_name1' => 'required|max:191',
                'qty1' => 'required'
                ]);
    
            $shoplist = $user->shoplists()->find($id);
            
            $shoplist->update([
                'shoplist_name' => $request->shoplist_name,
                'status' => 'open',
                'assigned_to' => $request->assigned_to,
            ]);
            
            if ($request->item_name1) {
                $shoplist_item = $shoplist->shoplist_items()->where('shoplist_item_id', 1)->first();
                $shoplist_item->update([
                    'shoplist_item_id' => '1',
                    'item_name' => $request->item_name1,
                    'qty' => $request->qty1,
                    'item_status' => 'open'
                    ]);
            }
            
            if ($request->item_name2) {
                $shoplist_item = $shoplist->shoplist_items()->where('shoplist_item_id', 2)->first();
                $shoplist_item->update([
                    'shoplist_item_id' => '2',
                    'item_name' => $request->item_name2,
                    'qty' => $request->qty2,
                    'item_status' => 'open'
                    ]);
            }
            
            if ($request->item_name3) {
                $shoplist_item = $shoplist->shoplist_items()->where('shoplist_item_id', 3)->first();
                $shoplist_item->update([
                    'shoplist_item_id' => '3',
                    'item_name' => $request->item_name3,
                    'qty' => $request->qty3,
                    'item_status' => 'open'
                    ]);
            }
            
            if ($request->item_name4) {
                $shoplist_item = $shoplist->shoplist_items()->where('shoplist_item_id', 4)->first();
                $shoplist_item->update([
                    'shoplist_item_id' => '4',
                    'item_name' => $request->item_name4,
                    'qty' => $request->qty4,
                    'item_status' => 'open'
                    ]);
            }
            
            if ($request->item_name5) {
                $shoplist_item = $shoplist->shoplist_items()->where('shoplist_item_id', 5)->first();
                $shoplist_item->update([
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
    
    public function destroy($id)
    {
        
        if (\Auth::check()) {
            
            $user = \Auth::user();
            $shoplist = $user->shoplists()->find($id);
            
            if (\Auth::id() === $shoplist->user_id) {
                
                $shoplist->shoplist_items()->delete();
                $shoplist->delete();
            } 
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
    
    public function edit_shop($id)       
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
            
            return view('shoppinglist.shop', $data);
        }
    }
    
    public function status_change(Request $request, $id)
    {
        if (\Auth::check()) {
            
            $user = \Auth::user();
    
            $shoplist = $user->shoplists()->find($id);
            
            $shoplist->update([
                'status' => 'closed',
            ]);
            
            if ($request->status1) {
                $shoplist_item = $shoplist->shoplist_items()->where('shoplist_item_id', 1)->first();
                $shoplist_item->update([
                    'item_status' => 'closed'
                    ]);
            }
            
            if ($request->status2) {
                $shoplist_item = $shoplist->shoplist_items()->where('shoplist_item_id', 2)->first();
                $shoplist_item->update([
                    'item_status' => 'closed'
                    ]);
            }
            
            if ($request->status3) {
                $shoplist_item = $shoplist->shoplist_items()->where('shoplist_item_id', 3)->first();
                $shoplist_item->update([
                    'item_status' => 'closed'
                    ]);
            }
            
            if ($request->status4) {
                $shoplist_item = $shoplist->shoplist_items()->where('shoplist_item_id', 4)->first();
                $shoplist_item->update([
                    'item_status' => 'closed'
                    ]);
            }
            
            if ($request->status5) {
                $shoplist_item = $shoplist->shoplist_items()->where('shoplist_item_id', 5)->first();
                $shoplist_item->update([
                    'item_status' => 'closed'
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
