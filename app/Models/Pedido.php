<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'produto_id',
        'quantidade',
        'preferencias',
    ];

    public function pedidos(){
        return $this->hasMany('App\Models\Produto');
    }
    
    public function clientes(){
        return $this->belongsTo('App\Models\Cliente');
    }

    public function entregas(){
        return $this->hasOne('App\Models\Entrega');
    }
}