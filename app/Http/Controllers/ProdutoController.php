<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Produto;
use Exception;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produto = DB::table('produtos')
            ->join('categorias', 'categorias.id', '=', 'produtos.codigo_categoria')
            ->select('produtos.id', 'categorias.categoria','produtos.descricao', 'produtos.preco')
            ->where('estado', 0)
            ->orderBy('categorias.categoria')
            ->get();
        if(count($produto) == 0){
            return response([
                'mensagem' => ['Não há produtos disponíveis, actualmente!']
            ], 404);
        }
        return response($produto, 200);//Produto::all()->where('estado', 0);
    }

    public function search()
    {
        $search = request('search');

        if($search){
            return Produto::where([
                ['estado', 'like', '%'.$search.'%']
            ])->get();
        }else{
            response(['mensagem',['Não foi encontrada nenhuma correspondência para '.$search]], 400);
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

        $produto = new Produto;
        
        /*$request = ([
            'codigo_categoria' => 'required',
            'descricao' => 'required',
            'preco' => 'required',
            'imagem' => 'required|image',
        ]);*/
        $produto->descricao = $request->descricao;
        $produto->codigo_categoria = $request->codigo_categoria;
        //$categoria = DB::table('categorias')->where('categorias.id', '=', $produto->codigo_categoria);
        $produto->preco = $request->preco;

        if($request->hasFile('imagem') && $request->file('imagem')->isValid()){
            $requestImage = $request->imagem;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage
            ->getClientOriginalName().strtotime('now')).".".$extension;

            $request->imagem->move(public_path('imgs/products'), $imageName);
            $produto->imagem = $imageName;
        }
        
        return $produto->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Produto::findOrFail($id)){

            $produto = DB::table('Produtos')
            ->join('categorias', 'produtos.codigo_categoria', '=', 'categorias.id')
            ->select('produtos.id', 'produtos.descricao', 'categorias.categoria', 'produtos.preco', 'produtos.imagem')
            ->where('produtos.id', '=', $id)
            ->where('estado', 0)
            ->get();

            return $produto;
        }else{
            throw new Exception(404, 'Produto não encontrado!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produto = Produto::findOrFail($id)->first()->toArray();
        return $produto;
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
        Produto::findOrFail($request->$id)->update($request->all());
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       //$produto = DB::table('produtos')->where('id', '=', $id)->update(['estado' => 1]);
       $produto = Produto::findOrFail($id)->update(['estado' => 1]);
       return $produto;
    }
}
