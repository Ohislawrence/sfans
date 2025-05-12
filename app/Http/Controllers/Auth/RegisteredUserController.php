<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $this->generateUniqueUsername($request->name),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $role = Role::where('name', 'fan')->first();
        $user->assignRole($role);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('profile',['username' => Auth::user()->username], absolute: false));
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
