<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;


class GoogleController extends Controller
{
    const GOOGLE_TYPE = 'google';

    public function handleGoogleRedirect()
    {
        return Socialite::driver(static::GOOGLE_TYPE)->redirect();
    }

    public function handleGoogleCallback(Request $req)
    {

        $user = Socialite::driver(static::GOOGLE_TYPE)->stateless()->user();
        $userExisted = User::where('oauth_id', $user->id)->first();

        if($userExisted)
        {
            Auth::login($userExisted);
            $req->session()->put('id', $user->id);
            $req->session()->put('email', $user->email);
            return redirect('admin');
        }
        else
        {
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'oauth_id' => $user->id,
                'oauth_type' => static::GOOGLE_TYPE,
                'password' => Hash::make($user->id)
            ]);

            $req->session()->put('id', $user->id);
            $req->session()->put('email', $user->email);
            Auth::login($newUser);
            return redirect('admin');
        }
    }

    public function LogOut(Request $req)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://localhost:8000/");
        $data = curl_exec($curl);
        $req->session()->flush();
    }
}
