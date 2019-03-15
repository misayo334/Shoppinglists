<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function shoplists()
    {
        return $this->hasMany(Shoplist::class);
    }
    
    public function family_inviting()
    {
        return $this->belongsToMany(User::class, 'family', 'inviting_user_id', 'invited_user_id')
            ->withTimestamps()
            ->withPivot(['invitation_status']);
    }

    public function family_invited()
    {
        return $this->belongsToMany(User::class, 'family', 'invited_user_id', 'inviting_user_id')
            ->withTimestamps()
            ->withPivot(['invitation_status']);
    }
    
    public function is_family($userId)
    {
        $invitation_sent = $this->family_inviting()->where('invited_user_id', $userId)->exists();
        $invitation_received = $this->family_invited()->where('inviting_user_id', $userId)->exists();
        
        if($invitation_sent || $invitation_received) {
            return true;
        }
        else {
            return false;
        }
    }
    
    public function invite_family($userId)
    {
        // 既にfamilyになっているかの確認
        $exist = $this->is_family($userId);
        // 相手が自分自身ではないかの確認
        $its_me = $this->id == $userId;
    
        if ($exist || $its_me) {
            // 既にfamilyなら何もしない
            return false;
        } else {
            // まだfamilyでなければinviteする
            $this->family_inviting()->attach($userId, ['invitation_status' => 'invited']);
            return true;
        }
    }
    
    public function accept_family_invite($userId)
    {
        // 既にfamilyになっているかの確認
        $exist = $this->is_family($userId);
        // 相手が自分自身ではないかの確認
        $its_me = $this->id == $userId;
        
        if ($its_me) {
            // 自分だった場合は何もしない
                return false;
        } else {
            if ($exist) {
                // 自分がinviteされているかを確認
                $invited_status = $this->family_invited()->where('inviting_user_id', $userId)->where('invitation_status', 'invited')->exists();
                
                if($invited_status) {
                    // inviteされていたら、statusをacceptに変更する
                    $this->family_invited()->where('inviting_user_id', $userId)->updateExistingPivot($userId, ['invitation_status' => 'accepted']);
                } else {
                    // inviteされていない（自分がinviteした側だった）、あるいは、すでにacceptされていた場合は何もしない
                    return false;
                }
            } else {
                // まだinviteされてなければ何もしない
                return false;
            }
        }
        
    }
    
    public function remove_family($userId)
    {
        // 既にfamilyになっているかの確認
        $exist = $this->is_family($userId);
        // 相手が自分自身ではないかの確認
        $its_me = $this->id == $userId;
    
        if ($exist) {
            if($its_me) {
                // 自分だった場合は何もしない
                return false;
            } else {
                // 既にfamilyかつ自分でないならdetachする(inviting & invited両方)
                $this->family_inviting()->detach($userId);
                $this->family_invited()->detach($userId);
                return true;
            }
        } else {
            // まだfamilyでなければ何もしない
            return false;
        }
    }
    
    
}
