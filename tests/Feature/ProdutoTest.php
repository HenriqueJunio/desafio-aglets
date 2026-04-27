<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Produto;

class ProdutoTest extends TestCase
{
    use RefreshDatabase;

    public function test_criar_produto() {
        $response = $this->postJson('/api/produtos', [
            'nome' => 'Mouse Gamer',
            'descricao' => 'RGB',
            'preco' => 150.00,
            'quantidade' => 10,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('Produto', [
            'nome' => 'Mouse Gamer'
        ]);
    }

    public function test_listar_produtos() {
        Produto::factory()->count(3)->create();

        $response = $this->getJson('/api/produtos');

        $response->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
    }

    public function test_listar_produto_especifico() {
        $produto = Produto::factory()->create();

        $response = $this->getJson("/api/produtos/{$produto->id}");

        $response->assertStatus(200)->assertJsonFragment([
            'id' => $produto->id
        ]);
    }
}