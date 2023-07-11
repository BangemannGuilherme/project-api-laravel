<?php

namespace Tests\Feature;

use App\Models\Eventos;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class EventoTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function testEventosIndex()
    {
        // Crie um usuário de exemplo
        $user = User::factory()->create();

        // Autentique o usuário
        $this->actingAs($user);

        $response = $this->get('/eventos');

        $response->assertStatus(200);
    }

    public function testEventosCreate()
    {
        $response = $this->get('/eventos/create');

        $response->assertStatus(200);
    }

    public function testEventCreation()
    {
        $event = Eventos::factory()->create([
            'nome' => 'Evento de Teste',
            'descricao' => 'Descrição do evento de teste',
            'data_inicial' => '2023-07-01',
            'data_final' => '2023-07-05',
        ]);

        $this->assertInstanceOf(Eventos::class, $event);
        $this->assertEquals('Evento de Teste', $event->nome);
        $this->assertEquals('Descrição do evento de teste', $event->descricao);
    }

    public function testEditEvento()
    {
        $evento = $this->createEvento();
        $evento->nome = 'New test name';
        $evento->save();

        $this->assertDatabaseHas('eventos', [
            'nome' => 'New test name',
        ]);
    }

    public function testGetEvento()
    {
        $evento = $this->createEvento();

        $eventoRepository = new Eventos();
        $eventoRepository->find($evento->id);

        $this->assertEquals(3, $evento->id);
    }

    public function testDeleteEvento()
    {
        $evento = $this->createEvento();
        $evento->delete();

        $this->assertDatabaseMissing('eventos', [
            'nome' => 'Test name',
        ]);
    }

    private function createEvento(): Eventos
    {
        $event = Eventos::factory()->create([
            'nome' => 'Evento de Teste',
            'descricao' => 'Descrição do evento de teste',
            'data_inicial' => '2023-07-01',
            'data_final' => '2023-07-05',
        ]);

        return $event;
    }
}
