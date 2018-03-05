<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    public function MaterialTransaction()
    {
        return $this->hasMany('App\MaterialTransaction', 'seller_id');
    }
}
