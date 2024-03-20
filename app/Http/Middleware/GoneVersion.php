<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GoneVersion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(): Response
    {
        return response()->json([
            'error' => [
                'message' => 'Bu API versiyonu artık desteklenmiyor. Lütfen güncel versiyona geçin.'
            ]
        ], 410);
    }
}
