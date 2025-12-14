<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Guest;

class TrackGuest
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()) {
            return $next($request);
        }

        $guestId = $request->header('X-Guest-ID');

        // لو مفيش أو مش موجود في DB
        if (!$guestId || !Guest::where('guest_id', $guestId)->exists()) {
            $guestId = (string) Str::uuid();

            Guest::create([
                'guest_id' => $guestId,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        // حط الـ guest_id داخل الـ request نفسه
        $request->attributes->set('guest_id', $guestId);

        $response = $next($request);

        // رجّع الهيدر للـ frontend
        $response->headers->set('X-Guest-ID', $guestId);

        return $response;
    }
}
