<?php

namespace App\Http\Controllers;

use App\Mail\UserCreated;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    private $user;

    public function driverRedirect($driver): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        return Socialite::driver($driver)->redirect();
    }

    public function driverCallback($driver)
    {
        try {
            $user_auth = Socialite::driver($driver)->user();
        } catch (\Exception $e) {
            $user_auth = null;
        }

        if (!$user_auth) return $this->authFailed();

        $this->user = User::where($driver . '_id', $user_auth->getId())->first();

        if (!$this->user) {
            $this->user = new User();
            $this->user[$driver . '_id'] = $user_auth->getId();

            $password = $this->setPassword();
            $this->sendPassword($user_auth->getEmail(), $password);

            $this->fillUser($user_auth);
        }

        return $this->authUser();
    }

    private function authUser()
    {
        Auth::login($this->user);
        $accessToken = $this->user->createToken('authToken')->accessToken;
        $query = http_build_query([
            'auth-token' => $accessToken,
        ]);

        return redirect(config('app.land_url') . '?' . $query);
    }

    private function authFailed()
    {
        return redirect(config('app.land_url'));
    }

    private function sendPassword($email, $password)
    {
        Mail::to($email)->queue(new UserCreated($password));
    }

    private function fillUser(\Laravel\Socialite\Contracts\User $auth_user)
    {
        $this->user->name = $auth_user->getName();
        $this->user->email = $auth_user->getEmail();
        $this->user->data_user_agreement = true;

        if ($this->user->isDirty()) {
            $this->user->save();
        }
    }

    private function setPassword(): string
    {
        $password = strtolower(Str::random(8));
        $this->user->password = \Hash::make($password);

        return $password;
    }
}
