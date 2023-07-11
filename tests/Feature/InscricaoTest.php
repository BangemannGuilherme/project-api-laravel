<?php

namespace Tests\Feature;

use App\Models\Eventos;
use App\Models\Inscricoes;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class InscricaoTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function testInscricoesIndex()
    {
        // Crie um usuário de exemplo
        $user = User::factory()->create();

        // Autentique o usuário
        $this->actingAs($user);

        $response = $this->get('/inscricao');

        $response->assertStatus(200);
    }

    public function testInscricoesCreate()
    {
        $response = $this->get('/inscricao/create');

        $response->assertStatus(200);
    }

    public function testInscricaoCreation()
    {
        $evento = Eventos::factory()->create();
        $user = User::factory()->create();

        $inscricao = Inscricoes::factory()->create([
            'users_id' => $user->id,
            'eventos_id' => $evento->id,
            'checkin' => true,
        ]);

        $this->assertInstanceOf(Inscricoes::class, $inscricao);
        $this->assertEquals($user->id, $inscricao->users_id);
        $this->assertEquals($evento->id, $inscricao->eventos_id);
        $this->assertTrue($inscricao->checkin);
    }

    public function testEditInscricao()
    {
        $inscricao = $this->createInscricao();
        $inscricao->checkin = false;
        $inscricao->save();

        $this->assertDatabaseHas('inscricoes', [
            'checkin' => false,
        ]);
    }

    public function testGetInscricao()
    {
        $inscricao = $this->createInscricao();

        $inscricaoRepository = new Inscricoes();
        $inscricaoRepository->find($inscricao->id);

        $this->assertEquals($inscricao->id, $inscricao->id);
    }

    public function testDeleteInscricao()
    {
        $inscricao = $this->createInscricao();
        $inscricao->delete();

        $this->assertDatabaseMissing('inscricoes', [
            'id' => $inscricao->id,
        ]);
    }

    private function createInscricao(): Inscricoes
    {
        $evento = Eventos::factory()->create();
        $user = User::factory()->create();

        $inscricao = Inscricoes::factory()->create([
            'users_id' => $user->id,
            'eventos_id' => $evento->id,
            'checkin' => true,
        ]);

        return $inscricao;
    }
}
