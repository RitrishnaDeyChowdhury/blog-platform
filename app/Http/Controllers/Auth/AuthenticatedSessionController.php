<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        //return redirect()->intended(route('dashboard', absolute: false));

        return redirect()->route('dashboard');

        // // 3. Get logged-in user
        // $user = Auth::user();

        // // 4. Redirect based on role
        // if ($user->role === 'admin') {
        //     return redirect()->route('admin.dashboard');
        // }

        // if ($user->role === 'author') {
        //     return redirect()->route('author.dashboard');
        // }

        // // Default: viewer
        // return redirect()->route('viewer.dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
