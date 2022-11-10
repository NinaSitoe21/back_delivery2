<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    public function funcionarios(){
        return $this->belongsTo('App\Models\User');
    }

    public function pedidos(){
        return $this->hasMany('App\Models\Pedido');
    }
}
