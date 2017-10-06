<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialIn extends Model
{
	protected $table = 'convection_material_in';

	protected $fillable = [
        'material_type',
        'color',
        'length',
    ];
}
