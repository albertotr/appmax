<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Session::has('user_attempt')) {
            if (Session::get('user_attempt') > 5) {
                $lifetime = env('SESSION_LIFETIME') / 60;
                return response(['success' => false, 'error' => "Houve muitas tentativas erradas, feche seu aplicativo e tente novamente em {$lifetime} minutos"], 401);
            }
            Session::put(['user_attempt' => Session::get('user_attempt') + 1]);
        } else {
            Session::put(['user_attempt' => 1]);
        }

        $user = User::where('email', $credentials['email'])->first();

        if (is_null($user)) return response(['success' => false, 'error' => "Credenciais incorretas."], 401);

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response(['success' => false, 'error' => "Credenciais incorretas."], 401);
        }

        /**
         * exclui todos os tokens antigos do usuário
         */
        $user->tokens()->delete();

        $token = $user->createToken(App::environment('APP_KEY'))->plainTextToken;

        return response(['success' => true, 'data' => ['token' => $token, 'user' => $user->makeHidden(['investor_id', 'partner_id', 'created_at', 'updated_at', 'deleted_at'])]]);
    }
}
