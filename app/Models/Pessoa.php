<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pessoa extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'telefone',
        'data_nascimento',
        'cpf',
        'user_id'
    ];

    //trazer sempre user nas requisições
    protected $with = ['user'];

    //relacionamento com users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
