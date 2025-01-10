<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Services\ApiResponse;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ApiResponse::success(Cliente::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         //validação  
         $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:clientes',
            'telefone' => 'required'
        ]);

        //add um novo cliente
        $cliente = Cliente::create($request->all());

        return ApiResponse::success($cliente);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cliente = Cliente::find($id);

         //retorna a resposta
         if($cliente){
             return ApiResponse::success($cliente);
         } else {
             return ApiResponse::error('Cliente não encontrado!');
         }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //validação  
        $request->validate([
            'nome' => 'sometimes|required',
            'email' => 'sometimes|required|email|unique:clientes,email,' . $id,
            'telefone' => 'sometimes|required'
        ]);
    
        // Alterando os dados
        $cliente = Cliente::find($id);
        if ($cliente) {
            $cliente->update($request->only(['nome', 'email', 'telefone'])); // Atualiza apenas os campos fornecidos
            return ApiResponse::success($cliente);
        } else {
            return ApiResponse::error('Cliente não encontrado!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       //deletando cliente
       $cliente = Cliente::find($id);
       if($cliente){
           $cliente->delete();
           return ApiResponse::success('Cliente deletado com sucesso');
       } else {
           return ApiResponse::error('Cliente não encontrado');
       }
   }
    
}
