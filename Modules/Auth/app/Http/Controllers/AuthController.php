<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = Config::get('services.vimedika.base_url');
    }

    public function index()
    {
        return view('auth::pages.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:1',
            'password' => 'required|string|min:6'
        ]);


        try {
            $response = Http::post($this->baseUrl . '/login', [
                'username' => $request->username,
                'password' => $request->password,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $token = $data['data'] ?? null;

                if ($token) {
                    Session::put('api_token_login', $token);
                    return redirect()->route('auth.select-branch.view');
                } else {
                    return back()->withInput()->withErrors(['api' => 'Login failed: Token not received']);
                }
            } else {
                $errorBody = $response->json();
                return back()->withInput()->withErrors(['api' => $errorBody['message'] ?? 'Login failed. Please check your credentials.']);
            }
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['api' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function showSelectBranchForm()
    {
        if (!Session::has('api_token_login')) {
            return redirect()->route('auth.login.view');
        }

        $branches = [];
        $errorMessage = null;

        try {
            $token = Session::get('api_token_login');
            $response = Http::withToken($token)->get($this->baseUrl . '/list_branches');

            if ($response->successful()) {
                $data = $response->json();
                $branches = $data['data'] ?? [];
            } else {
                $errorBody = $response->json();
                $errorMessage = $errorBody['message'] ?? 'Failed to fetch branches.';
            }
        } catch (\Exception $e) {
            $errorMessage = 'An error occurred: ' . $e->getMessage();
        }

        return view('auth::pages.auth.branch', compact('branches', 'errorMessage'));
    }

    public function selectBranch(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|string',
        ]);

        if (!Session::has('api_token_login')) {
            return redirect()->route('auth.login.view');
        }

        try {
            $token = Session::get('api_token_login');
            $response = Http::withToken($token)->post($this->baseUrl . '/set_branch', [
                'branch_id' => $request->branch_id,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $branchToken = $data['data'] ?? null;

                if ($branchToken) {
                    Session::forget('api_token_login');
                    Session::put('api_token_branch', $branchToken);
                    return redirect()->route('dashboard');
                } else {
                    return back()->withInput()->withErrors(['api' => 'Branch selection failed: Token not received.']);
                }
            } else {
                $errorBody = $response->json();
                return back()->withInput()->withErrors(['api' => $errorBody['message'] ?? 'Branch selection failed.']);
            }
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['api' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function logout()
    {
        Session::forget('api_token_login');
        Session::forget('api_token_branch');
        return redirect()->route('auth.login.view');
    }
}
