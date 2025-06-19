<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class ShareBranchInfo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('branch_info_token')) {
            try {
                $encryptedBranchData = Session::get('branch_info_token');
                $branchInfo = Crypt::decrypt($encryptedBranchData);

                // Bagikan ke semua views
                View::share('branchInfo', $branchInfo);

                // Atau Anda bisa menyimpannya di request untuk diakses di controller
                // $request->attributes->add(['branchInfo' => $branchInfo]);

            } catch (\Exception $e) {
                // Log error jika dekripsi gagal
                Log::error('Failed to decrypt branch_info_token: ' . $e->getMessage());
                // Opsional: hapus session token yang corrupt jika perlu
                Session::forget('branch_info_token');
            }
        }

        return $next($request);
    }
}