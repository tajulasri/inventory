<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use App\Entity\Category;
use App\Entity\Stock;

class Item extends Model
{
	protected $primaryKey = 'id';
    protected $table = 'items';
    protected $fillable = ['brand','model','identifier','attributes','image','buy','sell'];
    protected $guard = [];

    const PENDING_POST = 0;
    const APPROVE_POST = 1;

    public function category()
    {
    	return $this->belongsTo(Category::class,'id','category_id');
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class,'id','item_id');
    }
    
    public static function getItemStatus(Item $item)
    {
        switch($item->status) {
            case self::APPROVE_POST:
                return 'On selling';
                break;
            default:
                return 'Pending';
                break;
        }
    }

    public static function generateIdentifier(Item $item)
    {
        $model = explode(" ",$item->model);
        $string = $item->brand." ".$model[0];
        $exp = explode(" ",$string);
        $identifier = implode('_',$exp);

        return $identifier;
    }

}
