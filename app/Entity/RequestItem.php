<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class RequestItem extends Model
{
    protected $table = 'request_items';
    protected $fillable = [];
    protected $guard = [];

    const REQUEST_STATUS_PENDING = 1;

    
}
