<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class MenuRolesController extends Controller
{
    /**
     * Role-based menu access configuration
     * Define which roles can access which menus
     */
    private const ROLE_PERMISSIONS = [
        'superadmin' => ['dashboard', 'master', 'transaksi'], // Full access
        'operator' => ['dashboard', 'master', 'transaksi'],   // Full access
        'finance' => ['dashboard', 'transaksi'],              // Limited access
        'guest' => ['dashboard']                              // Minimal access
    ];

    public function findAllMenus(Request $request)
    {
        try {
            $userRole = $this->getUserRoleFromToken();
            $allMenus = $this->getAllMenusStructure();
            $filteredMenus = $this->filterMenusByRole($allMenus, $userRole);

            // Apply search filter if provided
            $search = $request->input('search');
            if ($search) {
                $filteredMenus = $this->searchMenus($filteredMenus, $search);
            }

            return response()->json([
                'success' => true,
                'data' => array_values($filteredMenus),
                'user_role' => $userRole
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load menus: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    /**
     * Extract and decode user role from JWT token
     */
    private function getUserRoleFromToken(): string
    {
        if (!Session::has('api_token_branch')) {
            return 'guest';
        }

        try {
            $jwt = Session::get('api_token_branch');

            // For production, use proper JWT verification:
            // $decoded = JWT::decode($jwt, new Key(config('jwt.secret'), 'HS256'));
            // $decodedTokenPayload = (array) $decoded;

            // Current implementation (less secure - consider upgrading)
            $tokenParts = explode('.', $jwt);
            if (count($tokenParts) !== 3) {
                throw new \InvalidArgumentException('Invalid JWT token format');
            }

            $payload = base64_decode($tokenParts[1]);
            $decodedTokenPayload = json_decode($payload, true);

            if ($decodedTokenPayload === null) {
                throw new \RuntimeException('Failed to decode JWT payload: ' . json_last_error_msg());
            }

            return $decodedTokenPayload['user_role'] ?? 'guest';
        } catch (\Exception $e) {
            Log::warning('JWT token decode failed: ' . $e->getMessage());
            return 'guest';
        }
    }

    /**
     * Get all available menus structure
     */
    private function getAllMenusStructure(): array
    {
        return [
            [
                "name" => "dashboard",
                "label" => "Dashboard",
                "icon" => "fa-solid fa-house",
                "path" => "/",
                "submenu" => [],
            ],
            [
                "name" => "master",
                "label" => "Master",
                "icon" => "fa-solid fa-database",
                "path" => "/master",
                "submenu" => [
                    [
                        "label" => "Satuan",
                        "path" => "/master/satuan",
                    ],
                    [
                        "label" => "Kategori Produk",
                        "path" => "/master/kat_produk",
                    ],
                    [
                        "label" => "Produk",
                        "path" => "/master/produk",
                    ],
                    [
                        "label" => "Supplier",
                        "path" => "/master/supplier",
                    ]
                ]
            ],
            [
                "name" => "transaksi",
                "label" => "Transaksi",
                "icon" => "fa-solid fa-chart-line",
                "path" => "/transaksi",
                "submenu" => [
                    [
                        "label" => "Penjualan",
                        "path" => "/transaksi/penjualan",
                    ],
                    [
                        "label" => "Pembelian",
                        "path" => "/transaksi/pembelian",
                    ],
                    [
                        "label" => "Retur Penjualan",
                        "path" => "/transaksi/retur-penjualan",
                    ],
                    [
                        "label" => "Retur Pembelian",
                        "path" => "/transaksi/retur-pembelian",
                    ]
                ]
            ],
            [
                "name" => "laporan",
                "label" => "Laporan",
                "icon" => "fa-solid fa-file-alt",
                "path" => "/laporan",
                "submenu" => [
                    [
                        "label" => "Laporan Penjualan",
                        "path" => "/laporan/penjualan",
                    ],
                    [
                        "label" => "Laporan Pembelian",
                        "path" => "/laporan/pembelian",
                    ],
                    [
                        "label" => "Laporan Stok",
                        "path" => "/laporan/stok",
                    ]
                ]
            ]
        ];
    }

    /**
     * Filter menus based on user role permissions
     */
    private function filterMenusByRole(array $allMenus, string $userRole): array
    {
        $allowedMenus = self::ROLE_PERMISSIONS[$userRole] ?? [];

        if (empty($allowedMenus)) {
            return [];
        }

        return array_filter($allMenus, function ($menu) use ($allowedMenus) {
            return in_array($menu['name'], $allowedMenus, true);
        });
    }

    /**
     * Search menus by keyword
     */
    private function searchMenus(array $menus, string $search): array
    {
        $search = strtolower(trim($search));

        return array_filter($menus, function ($menu) use ($search) {
            // Search in main menu name and label
            if (
                str_contains(strtolower($menu['name']), $search) ||
                str_contains(strtolower($menu['label']), $search)
            ) {
                return true;
            }

            // Search in submenu labels
            if (!empty($menu['submenu'])) {
                foreach ($menu['submenu'] as $submenu) {
                    if (str_contains(strtolower($submenu['label']), $search)) {
                        return true;
                    }
                }
            }

            return false;
        });
    }

    /**
     * Get user permissions for debugging/frontend use
     */
    public function getUserPermissions(Request $request)
    {
        try {
            $userRole = $this->getUserRoleFromToken();
            $permissions = self::ROLE_PERMISSIONS[$userRole] ?? [];

            return response()->json([
                'success' => true,
                'user_role' => $userRole,
                'permissions' => $permissions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}