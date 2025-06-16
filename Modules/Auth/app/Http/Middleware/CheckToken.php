<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $loginToken = Session::get('api_token_login');
        $branchToken = Session::get('api_token_branch');

        // Jika dua-duanya tidak ada → redirect ke login
        if (!$loginToken && !$branchToken) {
            return redirect('auth/login');
        }

        // Cek token login jika tersedia
        if ($loginToken && $this->isTokenExpired($loginToken)) {
            Session::forget('api_token_login');
            Session::forget('api_token_branch');
            return redirect('auth/login');
        }

        // Harus punya token cabang
        if (!$branchToken) {
            return redirect('auth/branch');
        }

        // Jika branchToken expired → redirect ke select branch
        if ($this->isTokenExpired($branchToken)) {
            Session::forget('api_token_branch');
            return redirect('auth/branch');
        }

        return $next($request);
    }

    private function isTokenExpired(string $jwt): bool
    {
        try {
            $payload = $this->decodeJwtPayload($jwt);
            return isset($payload['exp']) && time() >= $payload['exp'];
        } catch (\Throwable $e) {
            // Jika decoding gagal, anggap token tidak valid
            return true;
        }
    }

    private function decodeJwtPayload(string $jwt): array
    {
        $parts = explode('.', $jwt);
        if (count($parts) !== 3) {
            throw new \InvalidArgumentException('Invalid JWT structure');
        }

        $payload = $parts[1];
        $decoded = json_decode(base64_decode(strtr($payload, '-_', '+/')), true);

        if (!is_array($decoded)) {
            throw new \RuntimeException('Invalid JWT payload');
        }

        return $decoded;
    }
}
