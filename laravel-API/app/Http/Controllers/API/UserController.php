<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    return response()->json($user, 201);
}

    public function show(User $user)
    {
        return $user;
    }

    public function update(Request $request, User $user)
    {
        // Validate and update user
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }

  public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    if (!Auth::attempt($credentials)) {
        return response()->json(['message' => 'Invalid email or password'], 401);
    }

    $user = Auth::user();
    $token = $user->createToken('API Token')->plainTextToken;

    return response()->json(['user' => $user, 'token' => $token]);
}

    public function register(Request $request)
    {
        // Handle registration
    }
}
