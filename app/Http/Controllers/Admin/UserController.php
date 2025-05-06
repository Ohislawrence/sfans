<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = DB::table('roles')->get();
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|max:255',
            'username' => '',
            'role' => 'required', 
            'gender'  => 'nullable|string',
            'sexual_orientation'  => 'nullable|string',
            'bio' => 'nullable|string',
            'instagram'  => 'nullable|string',
            'tictok'  => 'nullable|string',
            'x'  => 'nullable|string',
            'website'  => 'nullable|string',
            'display_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Hash the password
        $validated['password'] = bcrypt($validated['password']);
        
        $validated['username'] = $this->generateUniqueUsername($validated['name']);

        // Handle display photo
        if ($request->hasFile('display_photo')) {
            $validated['display_photo'] = $request->file('display_photo')->store('users/display_photos', 'public');
        }

        // Handle cover photo
        if ($request->hasFile('cover_photo')) {
            $validated['cover_photo'] = $request->file('cover_photo')->store('users/cover_photos', 'public');
        }

        $user = User::create($validated);

        $role = Role::where('name', $validated['role'])->first();
        $user->assignRole($role);

        return back()->with('success', 'User Created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|max:255',
            'username' => '',
            'role' => 'required', 
            'gender'  => 'nullable|string',
            'sexual_orientation'  => 'nullable|string',
            'bio' => 'nullable|string',
            'instagram'  => 'nullable|string',
            'tictok'  => 'nullable|string',
            'x'  => 'nullable|string',
            'website'  => 'nullable|string',
            'display_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Hash the password
        $validated['password'] = bcrypt($validated['password']);
        
        $validated['username'] = $this->generateUniqueUsername($validated['name']);

        // Handle display photo
        if ($request->hasFile('display_photo')) {
            $validated['display_photo'] = $request->file('display_photo')->store('users/display_photos', 'public');
        }

        // Handle cover photo
        if ($request->hasFile('cover_photo')) {
            $validated['cover_photo'] = $request->file('cover_photo')->store('users/cover_photos', 'public');
        }

        $user->update($validated);

        // Handle role
        if ($request->hasFile('role')) {
            $role = Role::where('name', $validated['role'])->first();
            $user->assignRole($role);
        }

        return back()->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'User deleted successfully.');
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
