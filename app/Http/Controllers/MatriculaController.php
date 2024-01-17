<?php

namespace App\Http\Controllers;

use App\Services\MatriculaServices;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{

    private $matriculaServices;

    public function __construct(MatriculaServices $matriculaServices)
    {
        $this->matriculaServices = $matriculaServices;
    }

    public function create()
    {
        $documentoTipos = \App\Models\DocumentoTipo::all();
        $unidades = \App\Models\Unidade::all();

        return view('matricula.create', compact('documentoTipos', 'unidades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email',
            'telefone' => 'required',
            'cpf' => 'string',
            'documento_tipo_id' => 'number',
            'documento_numero' => 'string',
            'responsavel_nome' => 'required|string',
            'responsavel_cpf' => 'required|string',
            'responsavel_telefone' => 'required|string',
            'responsavel_email' => 'required|string|email'
        ]);

        $params = $request->all();

        $matricula = $this->matriculaServices->create($params);

        return response()->json($matricula, 201);
    }
}
