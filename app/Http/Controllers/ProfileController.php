<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * ==========================================================
     * Form Profil
     * ==========================================================
     */
    public function edit()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->load('driver');

        return view('profile.edit', compact('user'));
    }

    /**
     * ==========================================================
     * Update Profil
     * ==========================================================
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([

            'name' => [
                'required',
                'string',
                'max:100'
            ],

            'email' => [
                'required',
                'email',
                Rule::unique('users')
                    ->ignore($user->id)
            ],

        ]);

        $user->update([

            'name'  => $request->name,

            'email' => $request->email,

        ]);

        return back()->with(
            'success',
            'Profil berhasil diperbarui.'
        );
    }

    /**
     * ==========================================================
     * Ubah Password
     * ==========================================================
     */
    public function password(Request $request)
    {
        $request->validate([

            'current_password' => [
                'required'
            ],

            'password' => [
                'required',
                'confirmed',
                'min:8'
            ],

        ]);

        $user = Auth::user();

        if (!Hash::check(
            $request->current_password,
            $user->password
        )) {

            return back()->withErrors([

                'current_password' =>
                'Password lama tidak sesuai.'

            ]);

        }

        $user->update([

            'password' => Hash::make(
                $request->password
            ),

        ]);

        return back()->with(
            'success',
            'Password berhasil diperbarui.'
        );
    }
}