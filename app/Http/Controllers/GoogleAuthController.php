<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Find user by google_id or email
            $user = User::where('google_id', $googleUser->getId())
                        ->orWhere('email', $googleUser->getEmail())
                        ->first();

            if (!$user) {
                // If the user does not exist, create a new user account
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'username' => strtolower(str_replace(' ', '', $googleUser->getName())) . rand(10, 99), // Generate a default username
                    'password' => null, // Password can be null since they log in via Google
                    'role' => 'staff', // Default role for new signups
                ]);
            } else {
                // If user exists but google_id is not set, update google_id (bind accounts)
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                    ]);
                }
            }

            // Log in the user
            Auth::login($user);

            return redirect()->to('/')->with('success', 'Berhasil masuk menggunakan akun Google!');
        } catch (Exception $e) {
            return redirect()->route('login')->withErrors(['login' => 'Gagal masuk menggunakan Google. Silakan coba lagi. Error: ' . $e->getMessage()]);
        }
    }
}
