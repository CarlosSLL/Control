<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    public function redirect(Request $request): RedirectResponse
    {
        abort_unless($this->configured(), 404);

        $state = Str::random(64);
        $verifier = Str::random(64);
        $request->session()->put('google_oauth', [
            'state' => $state,
            'verifier' => $verifier,
            'expires_at' => now()->addMinutes(10)->timestamp,
        ]);

        return redirect()->away('https://accounts.google.com/o/oauth2/v2/auth?'.http_build_query([
            'client_id' => config('services.google.client_id'),
            'redirect_uri' => config('services.google.redirect'),
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => $state,
            'code_challenge' => rtrim(strtr(base64_encode(hash('sha256', $verifier, true)), '+/', '-_'), '='),
            'code_challenge_method' => 'S256',
        ], '', '&', PHP_QUERY_RFC3986));
    }

    public function callback(Request $request): RedirectResponse
    {
        abort_unless($this->configured(), 404);

        $flow = $request->session()->pull('google_oauth');
        $state = $request->query('state');
        $code = $request->query('code');
        if (! $flow || ! is_string($state) || ! hash_equals($flow['state'], $state)
            || $flow['expires_at'] <= now()->timestamp || ! is_string($code) || $code === ''
            || $request->has('error')) {
            return $this->failed('No se pudo completar el acceso con Google. Inténtalo de nuevo.');
        }

        try {
            $token = Http::asForm()->timeout(10)->withoutRedirecting()
                ->post('https://oauth2.googleapis.com/token', [
                    'code' => $code,
                    'client_id' => config('services.google.client_id'),
                    'client_secret' => config('services.google.client_secret'),
                    'redirect_uri' => config('services.google.redirect'),
                    'grant_type' => 'authorization_code',
                    'code_verifier' => $flow['verifier'],
                ])->throw()->json('access_token');

            if (! is_string($token) || $token === '') {
                return $this->failed('No se pudo completar el acceso con Google. Inténtalo de nuevo.');
            }

            $profile = Http::withToken($token)->acceptJson()->timeout(10)->withoutRedirecting()
                ->get('https://openidconnect.googleapis.com/v1/userinfo')->throw()->json();
        } catch (HttpClientException) {
            return $this->failed('No se pudo completar el acceso con Google. Inténtalo de nuevo.');
        }

        $googleId = $profile['sub'] ?? null;
        if (! is_string($googleId) || $googleId === '' || strlen($googleId) > 255) {
            return $this->failed('Google no devolvió una identidad válida.');
        }

        $user = User::where('google_id', $googleId)->first();
        if ($user) {
            if (! $user->estado) {
                return $this->failed('Tu cuenta está pendiente de activación por un administrador.');
            }

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard', absolute: false));
        }

        $email = $profile['email'] ?? null;
        if (($profile['email_verified'] ?? null) !== true || ! is_string($email)
            || strlen($email) > 255 || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->failed('Google no devolvió un correo verificado.');
        }

        $email = Str::lower($email);
        if (User::whereRaw('LOWER(email) = ?', [$email])->exists()) {
            return $this->failed('Ese correo ya está registrado. Inicia sesión con tu método habitual.');
        }

        $role = Rol::where('tipo_rol', 'Trabajador')->first();
        if (! $role) {
            return $this->failed('El registro con Google no está disponible en este momento.');
        }

        $user = new User([
            'nombres' => Str::substr(trim($profile['given_name'] ?? '') ?: 'Usuario', 0, 255),
            'apellidos' => Str::substr(trim($profile['family_name'] ?? '') ?: 'Google', 0, 255),
            'email' => $email,
            'password' => Str::random(64),
            'estado' => false,
        ]);
        $user->google_id = $googleId;
        $user->rol()->associate($role);

        try {
            $user->save();
        } catch (UniqueConstraintViolationException) {
            return $this->failed('No se pudo completar el registro con Google. Inténtalo de nuevo.');
        }

        return redirect()->route('login')->with('status', 'Registro recibido. Un administrador debe activar tu cuenta.');
    }

    private function configured(): bool
    {
        return filled(config('services.google.client_id'))
            && filled(config('services.google.client_secret'))
            && filled(config('services.google.redirect'));
    }

    private function failed(string $message): RedirectResponse
    {
        return redirect()->route('login')->withErrors(['google' => $message]);
    }
}
