<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'material_type', 'length', 'price',
    ];

    public function materialTransaction()
    {
        return $this->belongsTo('App\materialTransaction', 'transaction_id');
    }
}
