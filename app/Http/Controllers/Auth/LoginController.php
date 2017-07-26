<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\Services\SocialAccountService;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider($socialProvider)
    {
        return Socialite::driver($socialProvider)->redirect();
    }

    public function handleProviderCallback(SocialAccountService $service, $socialProvider)
    {
        $user = $service->createOrGetUser(Socialite::driver($socialProvider)->user(), $socialProvider);
        auth()->login($user);
        return redirect()->to('/');
    }
}
