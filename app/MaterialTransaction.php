<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialTransaction extends Model
{
    public function Material()
    {
        return $this->hasMany('App\Material', 'transaction_id');
    }
}
