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
            $shoplists = $user->shoplists()->whereNotIn('status',['closed'])->orderBy('id', 'desc')->get();
            $shoplists_assigned = Shoplist::where('assigned_to', $user->id)->whereNotIn('status',['closed'])->orderBy('id', 'desc')->get();
            
            $shoplists = $shoplists->merge($shoplists_assigned);
            $shoplists = $shoplists->sortByDesc('id');
            
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
            
            if(is_null($shoplist)){
                $shoplist = Shoplist::find($id);
                if($shoplist){
                    if($shoplist->assigned_to != $user->id){
                        return view('welcome');
                    }
                }
                else {
                    return view('welcome');
                }
            }
            
            $created_by = User::find($shoplist->user_id);
            $assigned_to = User::find($shoplist->assigned_to);
            $shoplist_items = $shoplist->shoplist_items()->orderBy('id', 'asc')->get();
            $shoplist_items_count = $shoplist_items->count();
            $shoplist_items_closed_count = $shoplist_items->where('item_status', 'closed')->count();
            
            $data = [
                'user' => $user,
                'shoplist' => $shoplist,
                'created_by' => $created_by,
                'assigned_to' => $assigned_to,
                'shoplist_items' => $shoplist_items,
                'shoplist_items_count' => $shoplist_items_count,
                'shoplist_items_closed_count' => $shoplist_items_closed_count
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
            
            $family_members_inviting = $user->family_inviting()->where('invitation_status', 'accepted')->get();
            $family_members_invited = $user->family_invited()->where('invitation_status', 'accepted')->get();
            $users = $family_members_inviting->merge($family_members_invited);
            $users = $users->push($user)->sortBy('id');             //自分自身を追加
            $users = $users->pluck('name', 'id');                   //名前とuser_idのみ取り出す
            
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
                'items.1.item_name' => 'required|max:191',
                'items.1.qty' => 'integer|required',
                'items.*.item_name' => 'nullable|max:191',
                'items.*.qty' => 'integer|nullable'
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
            $shoplists = $user->shoplists()->whereNotIn('status',['closed'])->orderBy('id', 'desc')->get();
            
            $shoplists_assigned = Shoplist::where('assigned_to', $user->id)->whereNotIn('status',['closed'])->orderBy('id', 'desc')->get();
            $shoplists = $shoplists->merge($shoplists_assigned);
            $shoplists = $shoplists->sortByDesc('id');
            
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
            
            if(is_null($shoplist)){
                $shoplist = Shoplist::find($id);
                if($shoplist){
                    if($shoplist->assigned_to != $user->id){
                        return view('welcome');
                    }
                }
                else {
                    return view('welcome');
                }
            }
            
            $created_by = User::find($shoplist->user_id);
            $assigned_to = User::find($shoplist->assigned_to);
            $shoplist_items = $shoplist->shoplist_items()->orderBy('id', 'asc')->get();
            $last_item_id = $shoplist->shoplist_items()->orderBy('id', 'desc')->first()->shoplist_item_id;
            
            $family_members_inviting = $user->family_inviting()->where('invitation_status', 'accepted')->get();
            $family_members_invited = $user->family_invited()->where('invitation_status', 'accepted')->get();
            $users = $family_members_inviting->merge($family_members_invited);
            $users = $users->push($user)->sortBy('id');             //自分自身を追加
            $users = $users->pluck('name', 'id');                   //名前とuser_idのみ取り出す
            
            $data = [
                'user' => $user,
                'shoplist' => $shoplist,
                'created_by' => $created_by,
                'assigned_to' => $assigned_to,
                'shoplist_items' => $shoplist_items,
                'users' => $users,
                'last_item_id' => $last_item_id
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
                'items.1.item_name' => 'required|max:191',
                'items.1.qty' => 'integer|required',
                'items.*.item_name' => 'nullable|max:191',
                'items.*.qty' => 'integer|nullable'
            ]);
    
            $shoplist = Shoplist::find($id);
            
            $items = $request->items;
            
            $shoplist->update([
                'shoplist_name' => $request->shoplist_name,
                'status' => 'open',
                'assigned_to' => $request->assigned_to,
            ]);
            
            foreach($items as $item) {
                if ($item["item_name"]) {
                    $shoplist_item = $shoplist->shoplist_items()->where('shoplist_item_id', $item["shoplist_item_id"])->first();
                    if($shoplist_item) {
                        $shoplist_item->update([
                            'shoplist_item_id' => $item["shoplist_item_id"],
                            'item_name' => $item["item_name"],
                            'qty' => $item["qty"],
                            'item_status' => 'open'
                        ]);
                    }
                    else {
                        $shoplist->shoplist_items()->create([
                        'shoplist_item_id' => $item["shoplist_item_id"],
                        'item_name' => $item["item_name"],
                        'qty' => $item["qty"],
                        'item_status' => 'open'
                    ]);
                    }
                } 
            }
    
            $data = [];
            
            $user = \Auth::user();
            $shoplists = $user->shoplists()->whereNotIn('status',['closed'])->orderBy('id', 'desc')->get();
            
            $shoplists_assigned = Shoplist::where('assigned_to', $user->id)->whereNotIn('status',['closed'])->orderBy('id', 'desc')->get();
            $shoplists = $shoplists->merge($shoplists_assigned);
            $shoplists = $shoplists->sortByDesc('id');
            
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
        
            $data = [];
            
            $user = \Auth::user();
            $shoplists = $user->shoplists()->whereNotIn('status',['closed'])->orderBy('id', 'desc')->get();
            
            $shoplists_assigned = Shoplist::where('assigned_to', $user->id)->whereNotIn('status',['closed'])->orderBy('id', 'desc')->get();
            $shoplists = $shoplists->merge($shoplists_assigned);
            $shoplists = $shoplists->sortByDesc('id');
            
            $data = [
                'user' => $user,
                'shoplists' => $shoplists,
            ];
        
            return view('shoppinglist.index', $data); 
        }
        
    }
    
    public function edit_shop($id)       
    {
            
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $shoplist = $user->shoplists()->find($id);
            
            if(is_null($shoplist)){
                $shoplist = Shoplist::find($id);
                if($shoplist){
                    if($shoplist->assigned_to != $user->id){
                        return view('welcome');
                    }
                }
                else {
                    return view('welcome');
                }
            }
            
            $created_by = User::find($shoplist->user_id);
            $assigned_to = User::find($shoplist->assigned_to);
            $shoplist_items = $shoplist->shoplist_items()->get();
            
            $data = [
                'user' => $user,
                'shoplist' => $shoplist,
                'created_by' => $created_by,
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
            $shoplist = Shoplist::find($id);
           
            $shoplist->update([
                'status' => 'shopping',
            ]);
            
            $items = $request->items;
            
            foreach($items as $item) {
                if ($item["item_status"] == "closed") {
                    $shoplist_item = $shoplist->shoplist_items()->where('shoplist_item_id', $item["shoplist_item_id"])->first();
                    $shoplist_item->update([
                        'item_status' => 'closed'
                    ]);
                } 
            }
            
            $shoplist_items = $shoplist->shoplist_items()->get();
            $shoplist_items_count = $shoplist_items->count();
            $shoplist_items_closed_count = $shoplist_items->where('item_status', 'closed')->count();
            if ($shoplist_items_closed_count == 0) {
                $shoplist->update([
                'status' => 'open',
                ]); 
            }
            elseif ($shoplist_items_count == $shoplist_items_closed_count) {
               $shoplist->update([
                'status' => 'closed',
                ]); 
            }
            
    
            $data = [];
            
            $user = \Auth::user();
            $shoplists = $user->shoplists()->whereNotIn('status',['closed'])->orderBy('id', 'desc')->get();
            
            $shoplists_assigned = Shoplist::where('assigned_to', $user->id)->whereNotIn('status',['closed'])->orderBy('id', 'desc')->get();
            $shoplists = $shoplists->merge($shoplists_assigned);
            $shoplists = $shoplists->sortByDesc('id');
            
            $data = [
                'user' => $user,
                'shoplists' => $shoplists,
            ];
        
            return view('shoppinglist.index', $data); 
        }
    }
    
}
