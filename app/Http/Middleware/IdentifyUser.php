<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use App\Models\Identity;
use App\Models\UserSetting;
use App\Models\UserBehavior;
use App\Models\Client;

class IdentifyUser
{
    public function handle(Request $request, Closure $next)
    {
        $guestId = $request->cookie('guest_id');

        if (!$guestId) {
            $guestId = (string) Str::uuid();
        }

        if (Auth::check()) {
            $userId = Auth::id();
            $userIdentity = Identity::where('user_id', $userId)->first();
            $guestIdentity = Identity::where('guest_id', $guestId)->first();

            if ($userIdentity) {
                // If there is an existing guest identity from this session, merge any data into userIdentity
                if ($guestIdentity && $guestIdentity->id !== $userIdentity->id) {
                    UserBehavior::where('identity_id', $guestIdentity->id)
                        ->update(['identity_id' => $userIdentity->id]);

                    if (!$userIdentity->client && $guestIdentity->client) {
                        $guestIdentity->client->update(['identity_id' => $userIdentity->id]);
                    }

                    $guestIdentity->delete();
                }

                $userIdentity->guest_id = $guestId;
                $userIdentity->ip = $request->ip();
                $userIdentity->user_agent = $request->userAgent();
                $userIdentity->save();

                $identity = $userIdentity;
            } else {
                if ($guestIdentity) {
                    $guestIdentity->user_id = $userId;
                    $guestIdentity->ip = $request->ip();
                    $guestIdentity->user_agent = $request->userAgent();
                    $guestIdentity->save();
                    $identity = $guestIdentity;
                } else {
                    $identity = Identity::create([
                        'user_id'    => $userId,
                        'guest_id'   => $guestId,
                        'ip'         => $request->ip(),
                        'user_agent' => $request->userAgent(),
                    ]);
                }
            }
        } else {
            $identity = Identity::firstOrCreate(
                ['guest_id' => $guestId],
                [
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]
            );

            $identity->update([
                'ip'         => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

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
            if (method_exists($response, 'cookie')) {
                $response->cookie(
                    'guest_id',
                    $guestId,
                    60 * 24 * 365 * 5
                );
            } else {
                $response->headers->setCookie(cookie(
                    'guest_id',
                    $guestId,
                    60 * 24 * 365 * 5
                ));
            }
        }

        return $response;
    }
}
