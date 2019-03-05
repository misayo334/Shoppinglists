<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    
    public function show()
    {
        
        return view('shoppinglist.show', $data);
    }
}
