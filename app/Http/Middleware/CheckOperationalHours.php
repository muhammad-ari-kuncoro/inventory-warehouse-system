<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ConsumableIssuanceController;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckOperationalHours
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{
    $currentHour = Carbon::now('Asia/Jakarta')->hour;

    if ($currentHour >= 17 || $currentHour < 8) {

        app(ConsumableIssuanceController::class)->autoSubmit();

        return redirect()->route('consumable-issuance.index')
            ->with('forbidden', 'Akses ditutup! Input data hanya bisa dilakukan jam 08:00 s/d 17:00 WIB.');
    }

    return $next($request);
}
}
