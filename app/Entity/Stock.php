<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use App\Entity\Item;

class Stock extends Model
{
	protected $table = 'stocks';
	protected $fillable = ['item_id','balance'];
	protected $guard = ['created_at','updated_at'];

	const TRESHOLD_LIMIT = 1;

    public function item()
    {
    	return $this->belongsTo(Item::class,'id');
    }
}
