<?php

use App\Http\Controllers\ProdutoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

/*Route::prefix('auth')->group(function(){
    Route::post('/login', LoginController::class, 'login');
    Route::post('/logout', LoginController::class, 'logout');
    Route::post('/Registo', LoginController::class, 'register');
});*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Rotas para a Gestão dos produtos
Route::get('/', [ProdutoController::class, 'index']);
Route::get('/pesquisa/{search}', [ProdutoController::class, 'search']);

//Rotas de acesso dos users
Route::post('/login', [UserController::class, 'login']);
Route::post('/registo', [UserController::class, 'registro']);

Route::group(['middleware' => 'auth:sanctum'], function(){

    //Rotas se Categoria
    Route::get('/categoria', [CategoriaController::class, 'index']);
    Route::post('/categoria/criacao', [CategoriaController::class, 'store']);
    
    //Rotas para a Gestão dos produtos
    Route::post('/produto/criacao', [ProdutoController::class, 'store']);
    Route::get('/produto/{id}', [ProdutoController::class, 'show']);
    Route::delete('/produto/delete/{id}', [ProdutoController::class, 'destroy']);
    Route::put('/produto/editar/{id}', [ProdutoController::class, 'update']);

    //Rotas para pedidos
    Route::get('/pedido', [PedidoController::class, 'index']);
    Route::get('/pedido/{id}', [PedidoController::class, 'show']);
    Route::get('/pesquisa/{search}', [PedidoController::class, 'search']);
    Route::post('/pedido/criacao', [PedidoController::class, 'store']);
    Route::put('/pedido/edita/{id}', [PedidoController::class, 'update']);
    Route::delete('/pedido/deleta/{id}', [PedidoController::class, 'destroy']);

    //Rotas para entregas
    Route::get('/entrega', [PedidoController::class, 'index']);
    Route::get('/entrega/{id}', [PedidoController::class, 'show']);
    Route::get('/entrega/pesquisa/{search}', [PedidoController::class, 'search']);
    Route::post('/entrega/criacao', [PedidoController::class, 'store']);
    Route::put('/entrega/edita/{id}', [PedidoController::class, 'update']);
    Route::delete('/entrega/deleta/{id}', [PedidoController::class, 'destroy']);
 });