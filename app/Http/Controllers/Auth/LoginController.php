<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $user = User::where('email', mb_strtolower($request->email))
            ->orWhere('name', mb_strtolower($request->name))
            ->first();

        if (is_null($user)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Такого пользователя не существует.'
            ], 422);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                    'status' => 'error',
                    'message' => 'Неверный пароль. Проверьте точность ввода.'
                ]
            , 422);
        }

        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json([
            'token' => $accessToken,
            'user_id' => $user->id,
        ]);
    }

    public function logout()
    {
        $user = Auth::user()->token();
        $user->revoke();

        return response()->json(['status' => 200]);
    }
}
