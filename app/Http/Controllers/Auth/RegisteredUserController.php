<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Mail\UserCreated;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     * @param UserStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $role = Role::select('id')->where('name', 'customer')->first();
        $user = new User();
        $password = strtolower(Str::random(8));
        $user->email = $request->email;
        $user->password = Hash::make($password);
        $user->data_user_agreement = $request->data_user_agreement ?? false;
        if ($role) {
            $user->role_id = $role->id;
        }
        $user->save();

        event(new Registered($user));
        Auth::login($user);
        Mail::to($user->email)->queue(new UserCreated($password));

        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json([
            'status' => 'Success',
            'token' => $accessToken
        ]);
    }

    public function resendPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if(!$user) {
            return response()->json([
                'message' => 'Пользователя с таким имейлом не существует.'
            ], 422);
        }

        $password = strtolower(Str::random(8));
        $user->password = Hash::make($password);
        $user->save();

        event(new Registered($user));
        Auth::login($user);
        Mail::to($user->email)->queue(new UserCreated($password));

        return response()->json([
            'message' => 'Письмо успешно выслано на Ваш Email.'
        ]);
    }
}
