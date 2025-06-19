<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = Config::get('services.vimedika.base_url');
    }

    /**
     * Get user profile data from external API
     */
    public function getProfile(Request $request)
    {
        try {
            // Check if user has valid session token
            if (!Session::has('api_token_branch')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication required',
                    'data' => null
                ], 401);
            }

            $token = Session::get('api_token_branch');
            $profileData = $this->fetchProfileFromExternalAPI($token);
            $userRole = $this->getUserRoleFromToken($token);
            $profile = array_merge($profileData, [
                'user_role' => $userRole,
                'role_display' => $this->getRoleDisplayName($userRole)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Profile loaded successfully',
                'data' => $profile
            ]);
        } catch (\Exception $e) {
            Log::error('Profile fetch error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to load profile data',
                'data' => null
            ], 500);
        }
    }

    private function fetchProfileFromExternalAPI(string $token): array
    {
        try {
            $response = Http::withToken($token)
                ->timeout(10)
                ->get($this->baseUrl . '/profile');

            if (!$response->successful()) {
                throw new \RuntimeException(
                    'External API error: ' . $response->status() . ' - ' . $response->body()
                );
            }

            $data = $response->json();
            $profileData = $data['data'] ?? [];

            // Ensure we have required fields with defaults
            return [
                'user_id' => $profileData['user_id'] ?? null,
                'profile_name' => $profileData['profile_name'] ?? 'Unknown User',
                'email' => $profileData['email'] ?? 'no-email@example.com',
                'phone' => $profileData['phone'] ?? null,
            ];
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to fetch profile from external API: ' . $e->getMessage());
        }
    }

    /**
     * Extract user role from JWT token
     */
    private function getUserRoleFromToken(string $jwt): string
    {
        try {
            $tokenParts = explode('.', $jwt);
            if (count($tokenParts) !== 3) {
                return 'guest';
            }

            $payload = base64_decode($tokenParts[1]);
            $decodedTokenPayload = json_decode($payload, true);

            return $decodedTokenPayload['user_role'] ?? 'guest';
        } catch (\Exception $e) {
            Log::warning('JWT role extraction failed: ' . $e->getMessage());
            return 'guest';
        }
    }

    /**
     * Get human-readable role display name
     */
    private function getRoleDisplayName(string $role): string
    {
        $roleNames = [
            'superadmin' => 'Super Administrator',
            'operator' => 'Operator',
            'finance' => 'Finance',
            'guest' => 'Guest'
        ];

        return $roleNames[$role] ?? ucfirst($role);
    }

    /**
     * Update profile data (if needed)
     */
    public function updateProfile(Request $request)
    {
        try {
            if (!Session::has('api_token_branch')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication required'
                ], 401);
            }

            $token = Session::get('api_token_branch');

            // Validate request data
            $validatedData = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|max:255',
                'phone' => 'sometimes|nullable|string|max:20',
            ]);

            // Send update to external API
            $response = Http::withToken($token)
                ->timeout(10)
                ->put($this->baseUrl . '/profile', $validatedData);

            if (!$response->successful()) {
                throw new \RuntimeException('Failed to update profile');
            }

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => $response->json()['data'] ?? null
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Profile update error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile'
            ], 500);
        }
    }

    /**
     * Legacy method for backward compatibility
     * @deprecated Use getProfile() instead
     */
    public function findAllDataProfile()
    {
        $response = $this->getProfile(request());
        $data = $response->getData(true);

        if ($data['success']) {
            return $data['data'];
        }

        return [];
    }
}