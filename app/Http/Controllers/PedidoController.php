<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Pedido;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$pedido = Pedido::all();
        
        //Fazer validacoe dos produtos que sao reqisitados nos pedidos.

        $pedido = DB::table('pedidos')
            ->join('produtos', 'produtos.id', '=', 'pedidos.produto_id')
            ->join('clientes', 'clientes.id', '=', 'pedidos.cliente_id')
            ->join('users', 'users.id', '=', 'clientes.user_id')
            //->select('pedidos.id', 'produtos.descricao', 'pedidos.quantidade')
            ->select('pedidos.id', 'produtos.descricao', 'pedidos.quantidade', 'pedidos.preferencias', 'users.name', 'pedidos.created_at')
            ->where('pedidos.estado', 'not like', 'cancelado')
            ->orderBy('pedidos.created_at', 'desc')
            ->get();
        return $pedido;
    }

    /**f
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $search = request('search');

        if($search){
            return Pedido::where([
                ['estado', 'like', '%'.$search.'%']
            ])->get();
        }else{
            throw new exception('Não foi encontrada nenhuma correspondência para '.$search);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pedido = new Pedido;
        //$cliente = new Cliente;
        $pedido->cliente_id = $request->cliente_id;
        $pedido->produto_id = $request->produto_id;
        $pedido->quantidade = $request->quantidade;
        $pedido->preferencias = $request->preferencias;
        
        return $pedido->save();
        /*
        'cliente_id',
        'produto_id',
        'quantidade',
        'preferencias',
        */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pedido = Pedido::findOrFail($id);
        /*$pedido = DB::table('pedidos')
            ->join('produtos', 'produtos.id', '=', 'produtos.id')
            ->where('pedidos.id','=', $id)
            ->get();*/
        return $pedido;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pedido = Pedido::findOrFail($id)->first()->toArray();
        return $pedido;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Pedido::findOrFail($request->$id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pedido = DB::table('pedidos')
            ->where('pedidos.id', '=', $id)
            ->update(['estado' => 'cancelado']);
        return $pedido;
    }
}
