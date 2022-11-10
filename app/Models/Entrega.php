<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_id',
        'funcionario_id',
        'endereco',
        'data_entrega'
    ];
    public function entregador(){
        return $this->belongsTo('App\MOdels\Funcionario');
    }

    public function entregas(){
        return $this->belongsTo('App\Models\Pedido');
    }
}
