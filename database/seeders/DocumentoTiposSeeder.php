<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentoTiposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $documentos = [
                ['id' => 1, 'nome' => 'Certidão de Nascimento'],
                ['id' => 2, 'nome' => 'RG'],
                ['id' => 3, 'nome' => 'Cadastro do Cidadão']
            ];

            foreach ($documentos as $doc) {
                // Verifica se o documento já existe antes de inserir
                $existente = DB::table('documento_tipos')->where('id', $doc['id'])->first();
                if (!$existente) {
                    DB::table('documento_tipos')->insert($doc);
                }
            }
        }
    }
}
