<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialTransaction extends Model
{
    public function material()
    {
        return $this->hasMany('App\Material', 'transaction_id');
    }

    public function seller()
    {
        return $this->belongsTo('App\Seller');
    }
}
