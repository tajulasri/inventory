<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use App\Entity\Item;

class Purchase extends Model
{
    protected $table = 'purchases';
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $guard = [];

    const PENDING_PURCHASE = 0;
    const APPROVE_PURCHASE = 1;
    const CANCEL_PURCHASE = 2;

    
    public function item()
    {
    	return $this->belongsTo(Item::class,'item_id','id');
    }

    public static function getPurchaseStatus(Purchase $item)
    {
        switch($item->status) {
            case self::PENDING_PURCHASE:
                return 'Pending';
                break;
            case self::APPROVE_PURCHASE:
                return 'Approve';
                break;
            default:
                return 'Cancelled';
                break;
        }
    }
}
