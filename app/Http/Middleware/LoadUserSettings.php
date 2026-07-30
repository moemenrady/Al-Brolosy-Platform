<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use App\Models\Identity;

class IdentifyUser
{
    public function handle($request, Closure $next)
    {
        $lang = 'ar';
        $theme = 'dark';

        $identity = Identity::current();

        if ($identity && $identity->setting) {

            $lang = $identity->setting->lang;

            $theme = $identity->setting->theme;
        }

        app()->setLocale($lang);

        View::share([
            'currentLang' => $lang,
            'currentTheme' => $theme
        ]);

        return $next($request);
    }
}
