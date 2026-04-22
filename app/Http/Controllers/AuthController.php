<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use App\Notifications\SendOtpResetPassword;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validasi format input dasar
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string|min:6',
        ], [
            'login.required' => 'Username atau Email wajib diisi',
            'password.required' => 'Password belom di isi',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        // 2. Proteksi Brute Force (Max 5x coba dalam 1 menit)
        $throttleKey = 'login:' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors(['login' => "Terlalu banyak percobaan. Coba lagi dalam $seconds detik."]);
        }

        // 3. Tentukan field (Email atau Username)
        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // 4. Cari User di Database untuk validasi spesifik
        $user = User::where($fieldType, $request->login)->first();

        // 5. Cek apakah User ditemukan?
        if (!$user) {
            RateLimiter::hit($throttleKey);
            return back()->withErrors([
                'login' => 'Username atau Email ini tidak terdaftar di sistem kami.'
            ])->withInput($request->only('login'));
        }

        // 6. Cek apakah Password cocok?
        if (!Hash::check($request->password, $user->password)) {
            RateLimiter::hit($throttleKey);
            return back()->withErrors([
                'password' => 'Password salah, cek lagi ya.'
            ])->withInput($request->only('login'));
        }

        // 7. Jika lolos semua, lakukan Login resmi
        if (Auth::loginUsingId($user->id, $request->filled('remember'))) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();
            
            return $this->redirectByRole(Auth::user()->role);
        }

        return back()->withErrors(['login' => 'Gagal login, terjadi gangguan sistem.'])->withInput($request->only('login'));
    }

    protected function redirectByRole($role)
    {
        return match($role) {
            'admin' => redirect()->intended('/admin/dashboard'),
            'guru' => redirect()->intended('/guru/dashboard'),
            'orangtua' => redirect()->intended('/orangtua/dashboard'),
            default => redirect('/login'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('status', 'Berhasil logout. Sampai jumpa lagi!');
    }

    // --- FORGOT PASSWORD LOGIC ---

    public function showForgot() {
        return view('auth.forgot-password');
    }

    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Masukkan email buat kirim kodenya.',
            'email.exists' => 'Email ini tidak terdaftar disistem kami',
        ]);

        $otpKey = 'otp:' . $request->email;
        if (RateLimiter::tooManyAttempts($otpKey, 1)) {
            $seconds = RateLimiter::availableIn($otpKey);
            return back()->withErrors(['email' => "mohon, tunggu $seconds detik sebelum minta kode lagi."]);
        }

        $otp = rand(100000, 999999);
        $email = $request->email;

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => Hash::make($otp),
                'created_at' => now()
            ]
        );

        $user = User::where('email', $email)->first();
        
        try {
            $user->notify(new SendOtpResetPassword($otp));
            RateLimiter::hit($otpKey, 120); // Lock 2 menit

            return redirect()->route('password.reset.form', ['email' => $email])
                             ->with('status', 'Kode OTP sudah dikirim ke Gmail kamu!');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal kirim email. Cek koneksi internet.']);
        }
    }

    public function showResetForm(Request $request) {
        if (!$request->has('email')) return redirect('/forgot-password');
        return view('auth.reset-password', ['email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|numeric|digits:6',
            'password' => 'required|min:8|confirmed',
        ], [
            'otp.digits' => 'Kode OTP itu 6 digit bg.',
            'password.confirmed' => 'Konfirmasi password-nya tidak sama',
            'password.min' => 'Password baru minimal 8 karakter',
        ]);

        $resetData = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$resetData || now()->diffInMinutes($resetData->created_at) > 30) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa. Silahkan minta lagi.']);
        }

        if (!Hash::check($request->otp, $resetData->token)) {
            return back()->withErrors(['otp' => 'Kodenya salah, cek lagi Gmail-nya.']);
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect('/login')->with('status', 'Password berhasil diupdate! Silahkan login dan pakai password baru.');
    }
}