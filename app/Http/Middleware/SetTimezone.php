<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetTimezone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ضبط التوقيت على مكة المكرمة
        date_default_timezone_set('Asia/Riyadh');
        
        // ضبط Carbon على توقيت مكة
        \Carbon\Carbon::setLocale('ar');
        \Carbon\Carbon::setTimezone('Asia/Riyadh');
        
        return $next($request);
    }
}
