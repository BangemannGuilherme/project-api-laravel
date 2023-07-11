<?php

namespace Tests\Feature;

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testRegistroPage()
    {
        $response = $this->get('/registro');

        $response->assertStatus(200);
    }

    public function testUserCanViewARegistrationForm()
    {
        $response = $this->get('/registro');

        $response->assertSuccessful();
        $response->assertViewIs('registro');
    }

    public function testUserCanRegister()
    {
        Event::fake();

        $response = $this->post('/registro', [
            'name' => 'John',
            'username' => 'johndoe',
            'password' => 'i-love-laravel',
            'password_confirmation' => 'i-love-laravel',
        ]);

        $response->assertRedirect('/'); // Redirecionar para a página inicial após o registro
        $this->assertCount(1, $users = User::all());
        $this->assertAuthenticatedAs($user = $users->first());
        $this->assertEquals('John', $user->name);
        $this->assertEquals('johndoe', $user->username);
        $this->assertTrue(Hash::check('i-love-laravel', Hash::make($user->password)));
    }

    public function testUserCannotRegisterWithoutName()
    {
        $response = $this->from('/registro')->post('/registro', [
            'name' => '',
            'username' => 'johndoe',
            'password' => 'i-love-laravel',
            'password_confirmation' => 'i-love-laravel',
        ]);

        $users = User::all();

        $this->assertCount(0, $users);
        $response->assertRedirect('/registro');
        $response->assertSessionHasErrors('name');
        $this->assertTrue(session()->hasOldInput('username'));
        $this->assertGuest();
    }

    public function testUserCannotRegisterWithoutUsername()
    {
        $response = $this->from('/registro')->post('/registro', [
            'name' => 'John',
            'username' => '',
            'password' => 'i-love-laravel',
            'password_confirmation' => 'i-love-laravel',
        ]);

        $users = User::all();

        $this->assertCount(0, $users);
        $response->assertRedirect('/registro');
        $response->assertSessionHasErrors('username');
        $this->assertTrue(session()->hasOldInput('name'));
        $this->assertGuest();
    }

    public function testUserCannotRegisterWithoutPassword()
    {
        $response = $this->from('/registro')->post('/registro', [
            'name' => 'John',
            'username' => 'johndoe',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $users = User::all();

        $this->assertCount(0, $users);
        $response->assertRedirect('/registro');
        $response->assertSessionHasErrors('password');
        $this->assertTrue(session()->hasOldInput('name'));
        $this->assertTrue(session()->hasOldInput('username'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    public function testUserCannotRegisterWithPasswordsNotMatching()
    {
        $response = $this->from('/registro')->post('/registro', [
            'name' => 'John',
            'username' => 'johndoe',
            'password' => 'i-love-laravel',
            'password_confirmation' => 'i-love-symfony',
        ]);

        $users = User::all();

        $this->assertCount(0, $users);
        $response->assertRedirect('/registro');
        $response->assertSessionHasErrors('password');
        $this->assertTrue(session()->hasOldInput('name'));
        $this->assertTrue(session()->hasOldInput('username'));
        $this->assertTrue(session()->hasOldInput('password'));
        $this->assertGuest();
    }
}
