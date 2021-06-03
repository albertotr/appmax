<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * teste basico se a o get para o / é valido
     *
     * @return void
     */
    public function test_existe_url()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * teste se passando uma senha errada, o sistema retorno a mensagem correta e tipo
     */
    public function test_pass_invalido()
    {
        $response = $this->postJson('/auth', ['email' => 'devault@test.com', 'password' => 'pasword']);

        $response
            ->assertStatus(401)
            ->assertJson(['success' => false, 'error' => "Credenciais incorretas."]);
    }

    /**
     * verifica se o sistem autentica o usuario se passado o email e senha corretos
     */
    public function test_correct_user()
    {
        $response = $this->postJson('/auth', ['email' => 'default@test.com', 'password' => 'password']);

        $response->assertStatus(200);
    }
}
