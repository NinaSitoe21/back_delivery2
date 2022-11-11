<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_categoria',
        'descricao',
        'preco',
        'imagem',
        'estado',
    ];

    public function Categoria(){
        return $this->belongsTo('App\Models\Categoria');
    }

    public function Produtos(){
        return $this->belongsTo('App\Models\Pedido');
    }
}