<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matricula extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'cpf',
        'documento_tipo_id',
        'documento_numero',
        'responsavel_nome',
        'responsavel_cpf',
        'responsavel_telefone',
        'responsavel_email'
    ];
}
