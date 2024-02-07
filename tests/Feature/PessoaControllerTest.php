<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PessoaControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_pode_criar_pessoa_admin(): void
    {

        $response = $this->criar_pessoa(1);
        $response->assertStatus(200);
    }

    public function test_pode_criar_pessoa_diretor(): void
    {

        $response = $this->criar_pessoa(2);
        $response->assertStatus(200);
    }

    public function test_nao_pode_criar_pessoa_professor(): void
    {

        $response = $this->criar_pessoa(3);
        $response->assertStatus(401);
    }

    public function test_nao_pode_criar_pessoa_aluno(): void
    {

        $response = $this->criar_pessoa(4);
        $response->assertStatus(401);
    }

    public function test_pode_criar_pessoa_erro_falta_cpf(): void
    {
        $array = [
            'nome' => 'Teste',
            'telefone' => '123456789',
            'data_nascimento' => '2021-10-10'
        ];

        $message = [
            'cpf' => [
                'The cpf field is required.'
            ]
        ];

        $this->criar_pessoas_faltam_dados($array,$message);
    }

    public function test_pode_criar_pessoa_erro_falta_telefone(): void
    {
        $array = [
            'nome' => 'Teste',
            'data_nascimento' => '2021-10-10',
            'cpf' => '01369262310'
        ];

        $message = [
            'telefone' => [
                'The telefone field is required.'
            ]
        ];

        $this->criar_pessoas_faltam_dados($array,$message);
    }

    public function test_pode_criar_pessoa_erro_falta_nome(): void
    {
        $array = [
            'data_nascimento' => '2021-10-10',
            'cpf' => '01369262310'
        ];

        $message = [
            'nome' => [
                'The nome field is required.'
            ]
        ];

        $this->criar_pessoas_faltam_dados($array,$message);
    }

    public function test_pode_criar_pessoa_erro_falta_data_nascimento(): void
    {
        $array = [
            'cpf' => '01369262310'
        ];

        $message = [
            'data_nascimento' => [
                'The data nascimento field is required.'
            ]
        ];

        $this->criar_pessoas_faltam_dados($array,$message);
    }

    protected function criar_pessoas_faltam_dados($array,$message){
        $user = $this->createUser(1);

        $response = $this->actingAs($user)->postJson('api/pessoas', $array);

        $response->assertStatus(422)->assertJson([
            'errors' => $message
        ]);
    }

    protected function criar_pessoa($role)
    {
        $user = $this->createUser($role);

        return $this->actingAs($user)->postJson('api/pessoas', [
            'nome' => 'Teste',
            'telefone' => '123456789',
            'data_nascimento' => '2021-10-10',
            'cpf' => '01369262310',
            'user_id' => $user->id
        ]);

    }

    private function createUser($role): User
    {
        return User::factory()->create([
            'user_type' => $role
        ]);
    }
}
