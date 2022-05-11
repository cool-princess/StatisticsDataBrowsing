<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\IpUtils;

final class CheckIPAddress
{
    private const ALLOWED_IPS = [
        '218.216.182.193', // ジブリ1
        '113.34.25.98', // ジブリ2
        '122.217.248.98', // ジブリ3
        '61.8.81.92', // Dalafarm1
        '61.8.81.93', // Dalafarm2
        '127.0.0.1', // My Local
    ];

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws AuthorizationException
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->isAllowedIp($request->ip())) {
            return $next($request);
        }

        throw new AuthorizationException(sprintf('Access denied from %s', $request->ip()));
    }

    /**
     * @param string $ip
     * @return bool
     */
    private function isAllowedIp(string $ip): bool
    {
        return IpUtils::checkIp($ip, self::ALLOWED_IPS);
    }
}