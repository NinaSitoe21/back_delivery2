<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Entrega;


class EntregaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entrega = new Entrega;

        $entrega = Entrega::all()->where('estado', 'not like', 'cancelada');
        return $entrega;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $entrega = new Entrega;

        $pedido = DB::table('pedidos')
            ->max('id');
        $entregador = DB::table('funcionarios')
            ->select('id')
            ->where(
                ['acesso', 'like', 'entregador'],
                ['estado', 'like', 'disponivel']
            )
            ->first();
        $entrega->endereco = $request->endereco;
        $entrega->data_entega = $request->data_entrega;
        $entrega->pedido_id = $pedido;
        $entrega->funcionario_id = $entregador;

        $entrega->save();
        return $entrega;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entrega = Entrega::findOrFail($id);
        return $entrega;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entrega = Entrega::findOrFail($id)->update(['estado' => 'cancelada']);
        return $entrega;
    }
}
