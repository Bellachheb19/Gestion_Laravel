<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->intended('/admin/dashboard');
            }
            return redirect()->intended('/student/profile');
        }

        return back()->withErrors([
            'email' => 'Les identifiants ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    public function showSignup()
    {
        return view('auth.signup');
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'apogee' => 'nullable|string',
            'phone' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'google_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('profile_photos', 'public');
        }

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
            'apogee' => $request->apogee,
            'phone' => $request->phone,
            'photo' => $photoPath,
            'google_id' => $request->google_id,
        ]);

        Auth::login($user);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'redirect' => '/student/profile'
            ]);
        }

        return redirect('/student/profile');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function googleLogin(Request $request)
    {
        // This will be called by frontend after Firebase login
        $idToken = $request->idToken;
        $userData = $request->userData; // nom, prenom, email, google_id, photo

        $user = User::where('email', $userData['email'])->first();

        if ($user) {
            $user->update([
                'google_id' => $userData['google_id'],
                // update photo if needed
            ]);
        } else {
            $user = User::create([
                'nom' => $userData['nom'] ?? $userData['name'],
                'prenom' => $userData['prenom'] ?? '',
                'email' => $userData['email'],
                'google_id' => $userData['google_id'],
                'photo' => $userData['photo'] ?? null,
                'role' => 'student',
                'password' => null,
            ]);
        }

        Auth::login($user);

        return response()->json([
            'success' => true,
            'redirect' => $user->isAdmin() ? '/admin/dashboard' : '/student/profile'
        ]);
    }
}
