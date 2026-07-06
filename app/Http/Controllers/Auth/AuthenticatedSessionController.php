<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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

    $user = Auth::user();

    /*
    |--------------------------------------------------------------------------
    | Cek Status Driver
    |--------------------------------------------------------------------------
    */

    if ($user->hasRole('driver')) {

        if (!$user->driver) {

            Auth::logout();

            return back()->withErrors([
                'email' => 'Akun driver belum terhubung dengan data driver.',
            ]);

        }

        if ($user->driver->status == 'Tidak Aktif') {

            Auth::logout();

            return back()->withErrors([
                'email' => 'Driver telah dinonaktifkan.',
            ]);

        }

    }

    /*
    |--------------------------------------------------------------------------
    | Redirect Role
    |--------------------------------------------------------------------------
    */

    if ($user->hasRole('admin')) {

        return redirect()->route('admin.dashboard');

    }

    if ($user->hasRole('driver')) {

        return redirect()->route('driver.dashboard');

    }

    if ($user->hasRole('kepala')) {

        return redirect()->route('kepala.dashboard');

    }

    return redirect('/');
}


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
