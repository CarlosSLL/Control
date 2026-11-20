<?php

namespace Tests\Feature\Auth;

use App\Livewire\Usuarios\Usuarios;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Testing\TestResponse;
use Livewire\Livewire;
use Tests\TestCase;

class GoogleAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['services.google' => [
            'client_id' => 'test-client',
            'client_secret' => 'test-secret',
            'redirect' => route('google.callback'),
        ]]);
        Http::preventStrayRequests();
    }

    public function test_google_registration_requires_activation_in_usuarios_before_login(): void
    {
        $worker = Rol::create(['tipo_rol' => 'Trabajador']);
        $admin = User::create([
            'nombres' => 'Ana',
            'apellidos' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'example-password',
            'rol_id' => Rol::create(['tipo_rol' => 'Administrador'])->id,
        ]);

        $this->fakeGoogle();
        $this->googleCallback()->assertRedirect(route('login'))->assertSessionHas('status');
        $this->assertGuest();
        $user = User::where('email', 'trabajador@example.com')->sole();
        $this->assertSame('123456789', $user->google_id);
        $this->assertEquals($worker->id, $user->rol_id);
        $this->assertFalse((bool) $user->estado);

        $this->googleCallback()->assertRedirect(route('login'))->assertSessionHasErrors('google');
        $this->assertGuest();
        $this->assertDatabaseCount('users', 2);

        $this->actingAs($admin)->get(route('usuarios.index'))->assertOk();
        Livewire::test(Usuarios::class)
            ->call('editar', $user->id)
            ->set('estado', true)
            ->call('guardar')
            ->assertHasNoErrors();
        $this->post(route('logout'))->assertRedirect('/');

        $user->update(['email' => 'otro@example.com']);
        $this->googleCallback()->assertRedirect(route('dashboard', absolute: false));
        $this->assertAuthenticatedAs($user);
        $this->assertDatabaseCount('users', 2);
    }

    public function test_matching_email_preserves_password_access_without_linking_google(): void
    {
        $user = User::create([
            'nombres' => 'Ana',
            'apellidos' => 'Prueba',
            'email' => 'Trabajador@example.com',
            'password' => 'example-password',
            'estado' => true,
            'rol_id' => Rol::create(['tipo_rol' => 'Trabajador'])->id,
        ]);
        $password = $user->password;

        $this->fakeGoogle();
        $this->googleCallback()->assertRedirect(route('login'))->assertSessionHasErrors('google');
        $this->assertGuest();
        $this->assertDatabaseCount('users', 1);
        $this->assertNull($user->fresh()->google_id);
        $this->assertSame($password, $user->fresh()->password);

        $this->post(route('login'), ['email' => $user->email, 'password' => 'example-password'])
            ->assertRedirect(route('dashboard', absolute: false));
        $this->assertAuthenticatedAs($user);
    }

    public function test_unverified_google_email_cannot_register(): void
    {
        Rol::create(['tipo_rol' => 'Trabajador']);
        $this->fakeGoogle(['email_verified' => false]);

        $this->googleCallback()->assertRedirect(route('login'))->assertSessionHasErrors('google');
        $this->assertGuest();
        $this->assertDatabaseCount('users', 0);
    }

    public function test_invalid_state_is_rejected_before_contacting_google(): void
    {
        Http::fake();
        $this->get(route('google.redirect'))->assertRedirect();
        $this->get(route('google.callback', ['state' => 'invalid', 'code' => 'code']))
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('google');

        Http::assertNothingSent();
        $this->assertGuest();
    }

    public function test_google_token_failure_returns_an_error_without_creating_an_account(): void
    {
        Http::fake(['https://oauth2.googleapis.com/token' => Http::response(['error' => 'invalid_grant'], 400)]);

        $this->googleCallback()->assertRedirect(route('login'))->assertSessionHasErrors('google');
        $this->assertGuest();
        $this->assertDatabaseCount('users', 0);
    }

    private function fakeGoogle(array $profile = []): void
    {
        Http::fake([
            'https://oauth2.googleapis.com/token' => Http::response(['access_token' => 'test-token']),
            'https://openidconnect.googleapis.com/v1/userinfo' => Http::response(array_replace([
                'sub' => '123456789',
                'email' => 'trabajador@example.com',
                'email_verified' => true,
                'given_name' => 'Ana',
                'family_name' => 'Prueba',
            ], $profile)),
        ]);
    }

    private function googleCallback(): TestResponse
    {
        $response = $this->get(route('google.redirect'))->assertRedirect();
        $url = $response->headers->get('Location');
        $this->assertStringStartsWith('https://accounts.google.com/o/oauth2/v2/auth?', $url);
        parse_str(parse_url($url, PHP_URL_QUERY), $query);
        $this->assertSame('S256', $query['code_challenge_method']);

        $callback = $this->get(route('google.callback', ['state' => $query['state'], 'code' => 'test-code']));
        Http::assertSent(function (Request $request) use ($query) {
            if ($request->url() !== 'https://oauth2.googleapis.com/token') {
                return false;
            }

            $verifier = $request['code_verifier'];
            $challenge = rtrim(strtr(base64_encode(hash('sha256', $verifier, true)), '+/', '-_'), '=');

            return $request['code'] === 'test-code' && $challenge === $query['code_challenge'];
        });

        return $callback;
    }
}
