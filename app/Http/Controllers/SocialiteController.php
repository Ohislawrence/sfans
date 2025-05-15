<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class SocialiteController extends Controller
{
    public function redirect(string $provider)
    {
        $this->validateProvider($provider);
 
        return Socialite::driver($provider)->redirect();
    }
 
    public function callback(string $provider)
    {
        $this->validateProvider($provider);
 
        try {
            $response = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['oauth' => 'Authentication failed.']);
        }
 
        $user = User::firstWhere(['email' => $response->getEmail()]);
 
        if ($user) {
            $user->update([$provider . '_id' => $response->getId()]);
        } else {
            $user = User::create([
                $provider . '_id' => $response->getId(),
                'name'            => $response->getName(),
                'email'           => $response->getEmail(),
                'username'         => $this->generateUniqueUsername($response->getName()),
                'password'        => Str::random(32),
            ]);

            $role = Role::where('name', 'fan')->first();
            $user->assignRole($role);
        }
 
        auth()->login($user);
 
        return redirect()->intended(route('profile'));
    }
 
    protected function validateProvider(string $provider): void
    {
        Validator::make(
            ['provider' => $provider],
            ['provider' => 'in:google']
        )->validate();
    }


    function generateUniqueUsername($fullName)
    {
        // 1. Remove spaces and lowercase the name
        $baseUsername = strtolower(str_replace(' ', '', $fullName));
        
        // 2. Remove any non-alphanumeric characters (optional, cleaner usernames)
        $baseUsername = preg_replace('/[^a-z0-9]/', '', $baseUsername);

        $username = $baseUsername;
        $counter = 1;

        // 3. Check if username exists
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }
}
