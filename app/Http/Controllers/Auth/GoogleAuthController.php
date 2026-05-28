<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    // Redirect ke halaman login Google
    public function redirect()
    {
        $driver = Socialite::driver('google');
        if (app()->environment('local')) {
            $driver->setHttpClient(new \GuzzleHttp\Client(['verify' => false]));
        }
        return $driver->redirect();
    }

    // Callback setelah user login Google
    public function callback()
    {
        try {
            $driver = Socialite::driver('google');
            if (app()->environment('local')) {
                $driver->setHttpClient(new \GuzzleHttp\Client(['verify' => false]));
            }
            $googleUser = $driver->user();
        } catch (\Exception $e) {
            logger()->error('Google OAuth callback failed: ' . $e->getMessage(), ['exception' => $e]);
            return redirect('/login')->withErrors(['google' => 'Login dengan Google gagal: ' . $e->getMessage()]);
        }

        // Cek apakah user sudah pernah login dengan Google
        $user = User::where('google_id', $googleUser->id)->first();

        if (!$user) {
            // Cek apakah email sudah terdaftar (tanpa Google)
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // Update user lama dengan google_id
                $user->update([
                    'google_id' => $googleUser->id,
                    'avatar'    => $googleUser->avatar,
                ]);
            } else {
                // User baru -> arahkan ke halaman pilih role & konfirmasi nama
                session([
                    'google_auth_user' => [
                        'google_id' => $googleUser->id,
                        'email'     => $googleUser->email,
                        'name'      => $googleUser->name,
                        'avatar'    => $googleUser->avatar,
                    ]
                ]);

                return redirect()->route('auth.google.complete');
            }
        }

        Auth::login($user, true); // true = remember me

        return match($user->role) {
            'instructor' => redirect(route('instructor.dashboard')),
            'admin'      => redirect(route('admin.dashboard')),
            default      => redirect(route('student.index')),
        };
    }

    // Menampilkan form lengkapi profil (pilih role & nama)
    public function showCompleteProfile()
    {
        if (!session()->has('google_auth_user')) {
            return redirect('/login')->withErrors(['google' => 'Sesi Google Auth habis atau tidak valid. Silakan coba lagi.']);
        }

        $googleUser = session('google_auth_user');

        return view('auth.google-complete-profile', compact('googleUser'));
    }

    // Memproses form lengkapi profil
    public function completeProfile(\Illuminate\Http\Request $request)
    {
        if (!session()->has('google_auth_user')) {
            return redirect('/login')->withErrors(['google' => 'Sesi Google Auth habis atau tidak valid. Silakan coba lagi.']);
        }

        $googleUser = session('google_auth_user');

        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:student,instructor',
        ]);

        // Buat user baru di database
        $user = User::create([
            'name'      => $request->name,
            'email'     => $googleUser['email'],
            'google_id' => $googleUser['google_id'],
            'avatar'    => $googleUser['avatar'],
            'password'  => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(24)),
            'role'      => $request->role,
        ]);

        // Hapus sesi sementara
        session()->forget('google_auth_user');

        // Login user
        Auth::login($user, true);

        // Kirim email selamat datang
        try {
            Mail::to($user->email)->send(new WelcomeMail($user));
        } catch (\Exception $e) {
            logger()->warning('Google registration welcome email failed: ' . $e->getMessage());
        }

        return match($user->role) {
            'instructor' => redirect(route('instructor.dashboard')),
            'admin'      => redirect(route('admin.dashboard')),
            default      => redirect(route('student.index')),
        };
    }
}
