<?php
// app/Http/Controllers/Auth/GoogleController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // بنشوف لو اليوزر موجود قبل كدة بالإيميل أو بالجوجل آي دي
            $user = User::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            if ($user) {
                // لو موجود بنحدث بياناته ونعمل دخول
                $user->update(['google_id' => $googleUser->id]);
                Auth::login($user);
            } else {
                // لو جديد بنكريت أكونت
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'role' => 'user', // عميل تلقائياً
                    'password' => null // ملوش باسورد محلي
                ]);
                Auth::login($newUser);
            }

            return redirect()->intended('/dashboard');
        } catch (Exception $e) {
            return redirect('/login')->with('error', 'حدث خطأ أثناء تسجيل الدخول بجوجل');
        }
    }
}
