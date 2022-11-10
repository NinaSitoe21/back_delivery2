<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use  App\Models\User;

class UserController extends Controller
{
    /*function login(Request $request)
    {
        $user= User::where('email', $request->email)->first();
        //print_r($user);
        if (!$user && !Hash::check($request->password, $user->password)) {
            return response([
                'mensagem' => ['E-mail ou Password inválidos!']
            ], 401);
            //print_r('ACesso negado');
        }
        //print_r(Hash::check($request->password, $user->password));
        $token = $user->createToken('my-app-token')->plainTextToken;
    
        $response = [
            'user' => $user,
            'token' => $token
        ];
    
        return response($response, 201);
    }*/

    function login(Request $request)
    {
        //$user = new User;
        $credentials= $request->only('email', 'password');
        //$user->password = Hash::check($user->password, $request->password);
        // print_r($data);
        if (!auth()->attempt($credentials)){
            return response([
                'mensagem' => ['E-mail ou Password inválidos!']
            ], 401);
        }
    
        $token = auth()->user()->createToken('auth_user_token');
    
        $response = [
            'token' => $token->plainTextToken
        ];
    
        return response($response, 201);
    }

    public function registro(Request $request){

        /*$user= new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->acesso = $request->acesso;
        $user->password = Hash::make($request->pass);

        //$request->only('name', 'email','acesso', 'password');

        if(!$user->save()){
            return response([
                'message' => ['Ocorreu um erro ao criar o utilizador!']
            ], 500);
        }

        $token = $user->createToken('auth_user_token')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];

        $acesso = $request->acesso;
        $user_id = DB::table('users')->max('id');
        if($acesso == 'funcionario'){
            DB::insert('insert into funcionarios(user_id, cargo) values(?, ?)', [$user_id, 'admin']);
        }

        return response($response, 201);*/
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'acesso' => $request->acesso,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_user_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'message' => 'User created successfully',
            'authorization' => [
                'token' => $token,
                'type' => 'bearer'
            ]
        ]);
    }
}