<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $this->call(RolesSeeder::class);

         \App\Models\User::factory()->create([
             'name' => 'Pedro Lima',
             'email' => 'pruan@gmail.com',
             'password' => bcrypt('123456'),
            'user_type' => 1
         ]);

        $this->call(DocumentoTiposSeeder::class);
    }
}
