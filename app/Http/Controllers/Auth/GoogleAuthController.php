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
    /**
     * Redirect ke Google — dari halaman LOGIN.
     */
    public function redirectLogin()
    {
        session(['google_auth_intent' => 'login']);
        return $this->redirectToGoogle();
    }

    /**
     * Redirect ke Google — dari halaman REGISTER.
     */
    public function redirectRegister()
    {
        session(['google_auth_intent' => 'register']);
        return $this->redirectToGoogle();
    }

    /**
     * Shared: redirect ke Google OAuth consent screen.
     */
    private function redirectToGoogle()
    {
        $driver = Socialite::driver('google');
        if (app()->environment('local')) {
            $driver->setHttpClient(new \GuzzleHttp\Client(['verify' => false]));
        }

        // Force Google to show the account selector so users can choose the correct email.
        return $driver->with(['prompt' => 'select_account'])->redirect();
    }

    /**
     * Callback setelah user login/register Google.
     * Alur berbeda tergantung intent (login vs register).
     */
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

        $intent = session()->pull('google_auth_intent', 'login');

        // Cek apakah user sudah pernah login dengan Google
        $user = User::where('google_id', $googleUser->id)->first();

        if (!$user) {
            // Cek apakah email sudah terdaftar (tanpa Google)
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // Email sudah terdaftar — hubungkan dengan Google ID
                $user->update([
                    'google_id' => $googleUser->id,
                    'avatar'    => $googleUser->avatar,
                ]);
            }
        }

        // ─── INTENT: LOGIN ───────────────────────────────────────
        if ($intent === 'login') {
            if (!$user) {
                // User belum terdaftar, TOLAK login
                return redirect('/login')->withErrors([
                    'google' => 'Akun dengan email ' . $googleUser->email . ' belum terdaftar. Silakan daftar terlebih dahulu melalui halaman Register.'
                ]);
            }

            // User sudah ada, langsung login
            Auth::login($user, true);

            return match($user->role) {
                'instructor' => redirect(route('instructor.dashboard')),
                'admin'      => redirect(route('admin.dashboard')),
                default      => redirect(route('student.index')),
            };
        }

        // ─── INTENT: REGISTER ────────────────────────────────────
        if ($user) {
            // User sudah terdaftar, arahkan ke login
            return redirect('/login')->with('status', 'Akun dengan email ' . $googleUser->email . ' sudah terdaftar. Silakan login.');
        }

        // User baru -> arahkan ke halaman pilih role & konfirmasi nama
        $googleAuthData = [
            'google_id' => $googleUser->id,
            'email'     => $googleUser->email,
            'name'      => $googleUser->name,
            'avatar'    => $googleUser->avatar,
        ];
        
        session()->put('google_auth_user', $googleAuthData);
        session()->save();

        \Illuminate\Support\Facades\Log::info('Google OAuth Callback - session saved', [
            'session_id' => session()->getId(),
            'has_google_auth_user' => session()->has('google_auth_user'),
            'google_auth_user' => session('google_auth_user')
        ]);

        return redirect()->route('auth.google.complete');
    }

    // Menampilkan form lengkapi profil (pilih role & nama)
    public function showCompleteProfile()
    {
        \Illuminate\Support\Facades\Log::info('Google OAuth showCompleteProfile', [
            'session_id' => session()->getId(),
            'has_google_auth_user' => session()->has('google_auth_user'),
            'all_session_data' => session()->all()
        ]);

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
