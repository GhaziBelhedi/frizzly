<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'prenom'    => 'required|string|max:255',
            'nom'       => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:users,email',
            'cycle'     => 'required|in:Cycle 1,Cycle 2,Cycle 3',
            'password'  => 'required|string|min:8|confirmed',
            'terms'     => 'accepted',
        ]);

        $user = User::create([
            'name'     => trim($validated['prenom'] . ' ' . $validated['nom']),
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'enseignant',
            'status'   => 'active',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('enseignant.dashboard');
    }

    /**
     * Handle the login form submission.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Redirect based on role
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if ($user->role === 'enseignant') {
                return redirect()->route('enseignant.dashboard');
            }

            return redirect()->route('home');
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Ces identifiants ne correspondent à aucun compte.',
            ]);
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
