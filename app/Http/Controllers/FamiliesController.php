<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;                       // 追加
use App\Shoplist;                   // 追加
use App\Shoplist_item;              // 追加

class FamiliesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $inviting_users = $user->family_inviting()->orderBy('id', 'asc')->get();
            $invited_users = $user->family_invited()->orderBy('id', 'asc')->get();
            $inviting_users_id = $inviting_users->pluck('id');
            $invited_users_id = $invited_users->pluck('id');
            $other_users = User::whereNotIn('id', $inviting_users_id)->whereNotIn('id', $invited_users_id)->where('id', '!=' , $user->id)->orderBy('id', 'asc')->get();
            
            
            $data = [
                'user' => $user,
                'inviting_users' => $inviting_users,
                'invited_users' => $invited_users,
                'other_users' => $other_users
            ];
            
            return view('family.index', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //使わない
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        if (\Auth::check()) {
            \Auth::user()->invite_family($id);
            return back();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //使わない
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //使わない
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (\Auth::check()) {
            \Auth::user()->remove_family($id);
            return back();
        }
    }
}
