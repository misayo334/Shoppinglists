<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Shoplist;           //追加

class Shoplist_item extends Model
{
    protected $fillable = ['shoplist_item_id', 'shoplist_id', 'item_name', 'qty', 'item_status'];
    
    public function shoplist()
    {
        return $this->belongsTo(Shoplist::class);
    }
}
