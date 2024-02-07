<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PessoaController extends Controller
{
    //

    public function index()
    {
        $pessoa = Pessoa::all();
        return response()->json(['data' => $pessoa]);
    }

    public function store(Request $request)
    {
        //verifica se tem permissão
        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('diretor')) {
            return response(['message' => 'Você não tem permissão para criar pessoas'], 401);
        }

        $request->merge(['user_id' => Auth::user()->id]);

        $validatedData = $request->validate([
            'nome' => 'required|max:255',
            'telefone' => 'required',
            'data_nascimento' => 'required|date',
            'cpf' => 'required|unique:pessoas',
            'user_id' => 'required|exists:users,id|unique:pessoas,user_id'
        ]);

        try {
            DB::beginTransaction();

            $pessoa = Pessoa::create($validatedData);

            DB::commit();
            return response()->json(['data' => $pessoa, 'message' => 'Pessoa criada']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response(['message' => 'Erro ao criar pessoa', 'error' => $e->getMessage()], 500);
        }


    }

    public function show($id)
    {
        $pessoa = Pessoa::find($id);
        if (!$pessoa) {
            return response()->json(['message' => 'Pessoa não encontrada'], 404);
        }

        return response()->json(['data' => $pessoa]);
    }

    public function update(Request $request, $id)
    {
        //verifica se tem permissão
        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('diretor')) {
            return response(['message' => 'Você não tem permissão para editar pessoas']);
        }

        $pessoa = Pessoa::find($id);
        if (!$pessoa) {
            return response()->json(['message' => 'Pessoa não encontrada'], 404);
        }

        //verifica se existe cpf no payload
        if ($request->cpf) {
            //verifica se o cpf é igual ao cpf do usuário
            if ($pessoa->cpf == $request->cpf) {
                unset($request['cpf']);
            }
        }

        $validatedData = $request->validate([
            'nome' => 'max:255',
            'data_nascimento' => 'date',
            'cpf' => 'unique:pessoas'
        ]);

        try {
            DB::beginTransaction();

            //remover user_id
            unset($validatedData['user_id']);

            $pessoa->update($validatedData);

            DB::commit();
            return response()->json(['data' => $pessoa, 'message' => 'Pessoa atualizada']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response(['message' => 'Erro ao criar pessoa', 'error' => $e->getMessage()], 500);
        }

    }

    public function destroy($id)
    {
        return response()->json(['message' => 'Método não implementado']);
    }
}
