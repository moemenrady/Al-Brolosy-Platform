<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\UserBehavior;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BehaviorTrackingController extends Controller
{
    public function track(Request $request)
    {
        $validated = $request->validate([
            'event_type' => 'required|string|max:100',
            'project_id' => 'nullable|exists:projects,id',
            'page_url' => 'nullable|string|max:500',
            'page_title' => 'nullable|string|max:255',
            'metadata' => 'nullable|array',
            'device' => 'nullable|string|max:50',
        ]);

        $identity = $request->attributes->get('identity');
        $client = null;

        if ($identity) {
            $client = Client::where('identity_id', $identity->id)->first();
        }

        $device = $validated['device'] ?? $this->detectDevice($request->userAgent());

        $behavior = UserBehavior::create([
            'identity_id' => $identity?->id,
            'client_id' => $client?->id,
            'user_id' => Auth::id(),
            'project_id' => $validated['project_id'] ?? null,
            'event_type' => $validated['event_type'],
            'page_url' => $validated['page_url'] ?? $request->header('referer'),
            'page_title' => $validated['page_title'] ?? null,
            'metadata' => $validated['metadata'] ?? null,
            'device' => $device,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'success' => true,
            'id' => $behavior->id,
        ]);
    }

    private function detectDevice(?string $userAgent): string
    {
        if (!$userAgent) {
            return 'desktop';
        }
        $ua = strtolower($userAgent);
        if (str_contains($ua, 'tablet') || str_contains($ua, 'ipad')) {
            return 'tablet';
        }
        if (str_contains($ua, 'mobile') || str_contains($ua, 'android') || str_contains($ua, 'iphone')) {
            return 'mobile';
        }
        return 'desktop';
    }
}
