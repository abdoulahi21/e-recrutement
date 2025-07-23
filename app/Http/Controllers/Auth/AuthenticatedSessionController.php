<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
class AuthenticatedSessionController extends Controller
{



    protected function redirectTo()
    {
        $user = auth()->user();

        switch ($user->role) {
            case 'admin':
                return route('admin.dashboard');
            case 'recruiter':
                return route('rh.dashboard');
            case 'user':
                return route('candidat.dashboard');
            default:
                return route('/');
        }
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

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

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
