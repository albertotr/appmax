<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Laravel\Sanctum\Sanctum;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_baixar_produtos()
    {

        /**
         * tentativa de consumo da api se autenticação
         */
        $response = $this->postJson('/api/baixar-produtos', ['sku' => null, 'qtd' => 1]);
        $response->assertStatus(403);

        /**
         * autenticação fake no sistema
         */
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        /**
         * busca o primeiro produto na tabela
         */
        $product = Product::first();
        $id = $product->id;
        $sku = $product->sku;
        $qtd = $product->quantity;

        /**
         * executa a api retirando um item do estoque e verifica se foi bem sucedida
         */
        $subQtd = 1;
        $response = $this->postJson('/api/baixar-produtos', ['sku' => $sku, 'qtd' => $subQtd]);
        $response->assertStatus(200);

        /**
         * busca o mesmo produto em estoque para comparação
         */
        $nextProduct = Product::find($id);

        /**
         * verifica se foi mesmo retirado um item do estoque
         */
        $this->assertEquals($qtd - $subQtd, $nextProduct->quantity);

        /**
         * verifica se o estoque esta menor que no inicio dos testes
         */
        $this->assertLessThan($qtd, $nextProduct->quantity);


        /**
         * tenta baixar do estoque uma quantidade maior que existe no mesmo
         */
        $product = Product::find($id);
        $response = $this->postJson('/api/baixar-produtos', ['sku' => $product->sku, 'qtd' => $product->quantity + 10]);
        $response->assertStatus(406);
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_adicionar_produtos()
    {

        /**
         * tentativa de consumo da api se autenticação
         */
        $response = $this->postJson('/api/adicionar-produtos', ['sku' => null, 'qtd' => 1]);
        $response->assertStatus(403);

        /**
         * autenticação fake no sistema
         */
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        /**
         * busca o primeiro produto na tabela
         */
        $product = Product::first();
        $id = $product->id;
        $sku = $product->sku;
        $qtd = $product->quantity;

        /**
         * executa a api retirando um item do estoque e verifica se foi bem sucedida
         */
        $addQtd = 1;
        $response = $this->postJson('/api/adicionar-produtos', ['sku' => $sku, 'qtd' => $addQtd]);
        $response->assertStatus(200);

        /**
         * verifica se foi mesmo adicionado um item do estoque
         */
        $nextProduct = Product::find($id);
        $this->assertEquals($qtd + $addQtd, $nextProduct->quantity);

        /**
         * verifica se o estoque esta maior que no inicio dos testes
         */
        $this->assertGreaterThan($qtd, $nextProduct->quantity);
    }
}
