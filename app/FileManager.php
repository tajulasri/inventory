<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileManager extends Model
{

    public function getPathAttribute($value)
    {
        return route('image.stream',['x' => base64_encode($value)]);
    }
}
