<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shoplist extends Model
{
    protected $fillable = ['shoplist_name', 'user_id', 'status', 'assigned_to'];
    
    public function created_by()
    {
        return $this->belongsTo(User::class);
    }
    
    public function assigned_to()
    {
        return $this->belongsTo(User::class);
    }
    
    public function shoplist_items()
    {
        return $this->hasMany(Shoplist_item::class);
    }
}
