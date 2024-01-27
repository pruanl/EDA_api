<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // criando permissão de administrador, diretor, professor e aluno

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'diretor']);
        Role::create(['name' => 'professor']);
        Role::create(['name' => 'aluno']);

        // criando permissão de administrador, diretor, professor e aluno
    }
}
