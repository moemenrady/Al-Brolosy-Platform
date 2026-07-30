<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use App\Models\Identity;
use App\Models\UserSetting;

class IdentifyUser
{
    public function handle(Request $request, Closure $next)
    {
        $guestId = $request->cookie('guest_id');

        /*
        |--------------------------------------------------------------------------
        | Guest لأول مرة
        |--------------------------------------------------------------------------
        */

        if (!$guestId) {
            $guestId = (string) Str::uuid();
        }

        /*
        |--------------------------------------------------------------------------
        | تحديد الـ Identity
        |--------------------------------------------------------------------------
        */

        if (Auth::check()) {

            // هل يوجد Guest حالياً؟
            $identity = Identity::where('guest_id', $guestId)->first();

            if ($identity) {

                // اربطه بالمستخدم
                if (!$identity->user_id) {
                    $identity->user_id = Auth::id();
                }
            } else {

                // هل للمستخدم Identity قديمة؟
                $identity = Identity::where('user_id', Auth::id())->first();

                if (!$identity) {

                    $identity = Identity::create([
                        'user_id'    => Auth::id(),
                        'guest_id'   => $guestId,
                        'ip'         => $request->ip(),
                        'user_agent' => $request->userAgent(),
                    ]);
                }
            }
        } else {

            $identity = Identity::firstOrCreate(
                [
                    'guest_id' => $guestId,
                ],
                [
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | تحديث البيانات
        |--------------------------------------------------------------------------
        */

        $identity->update([
            'user_id'    => Auth::check() ? Auth::id() : $identity->user_id,
            'ip'         => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | إنشاء Settings افتراضية
        |--------------------------------------------------------------------------
        */

        $setting = UserSetting::firstOrCreate(
            [
                'identity_id' => $identity->id
            ],
            [
                'lang' => 'ar',
                'theme' => 'dark'
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | مشاركة الإعدادات
        |--------------------------------------------------------------------------
        */



        $request->attributes->set('identity', $identity);
        $request->attributes->set('userSetting', $setting);

        /*
        |--------------------------------------------------------------------------
        | مشاركة البيانات مع الـ Views
        |--------------------------------------------------------------------------
        */

        app()->setLocale($setting->lang);

        View::share([
            'currentLang'  => $setting->lang,
            'currentTheme' => $setting->theme,
            'identity'     => $identity,
            'userSetting'  => $setting,
        ]);

        $response = $next($request);

        if (!$request->hasCookie('guest_id')) {
            $response->cookie(
                'guest_id',
                $guestId,
                60 * 24 * 365 * 5
            );
        }

        return $response;
    }
}
