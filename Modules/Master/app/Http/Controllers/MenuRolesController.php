<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class MenuRolesController extends Controller
{
    private const ROLE_PERMISSIONS = [
        'superadmin' => ['dashboard', 'master', 'transaksi', 'audit-finance', 'laporan', 'membership', 'user-manage'],
        'operator' => ['dashboard', 'master', 'transaksi'],
        'finance' => ['dashboard', 'transaksi'],
        'guest' => ['dashboard']
    ];

    public function findAllMenus(Request $request)
    {
        try {
            $userRole = $this->getUserRoleFromToken();
            $allMenus = $this->getAllMenusStructure();
            $filteredMenus = $this->filterMenusByRole($allMenus, $userRole);

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
    
    private function getUserRoleFromToken(): string
    {
        if (!Session::has('api_token_branch')) {
            return 'guest';
        }

        try {
            $tokenBranch = Session::get('api_token_branch');
            $tokenParts = explode('.', $tokenBranch);
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

    private function getAllMenusStructure(): array
    {
        return [
            [
                "name" => "dashboard",
                "label" => "Dashboard",
                "icon" => "fa-solid fa-desktop",
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
                        "label" => "Konversi Satuan",
                        "path" => "/master/kon_satuan",
                    ],
                    [
                        "label" => "Kategori Supplier",
                        "path" => "/master/kat_supplier",
                    ],
                    [
                        "label" => "Supplier",
                        "path" => "/master/supplier",
                    ],
                    [
                        "label" => "Produk Supplier",
                        "path" => "/master/prod_supplier",
                    ]
                ]
            ],
            [
                "name" => "transaksi",
                "label" => "Transaksi",
                "icon" => "fa-solid fa-file-invoice-dollar",
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
                        "label" => "Copy Resep",
                        "path" => "/transaksi/cop_resep",
                    ],
                    [
                        "label" => "Pengeluaran",
                        "path" => "/transaksi/pengeluaran",
                    ],
                    [
                        "label" => "Pemasukan Lain",
                        "path" => "/transaksi/pem_lain",
                    ]
                ]
            ],
            [
                "name" => "audit-finance",
                "label" => "Audit & Finance",
                "icon" => "fa-solid fa-chart-line",
                "path" => "/audit-finance",
                "submenu" => [
                    [
                        "label" => "Stok Awal",
                        "path" => "/audit-finance/stok_awal",
                    ],
                    [
                        "label" => "Stok Opname",
                        "path" => "/audit-finance/stok_opname",
                    ]
                ]
            ],
            [
                "name" => "laporan",
                "label" => "Laporan",
                "icon" => "fa-solid fa-layer-group",
                "path" => "/laporan",
                "submenu" => [
                    [
                        "label" => "Penjualan Bulanan",
                        "path" => "/laporan/pen_bulanan",
                    ],
                    [
                        "label" => "Near ED",
                        "path" => "/laporan/near_ed",
                    ],
                    [
                        "label" => "Neraca Saldo",
                        "path" => "/laporan/ner_saldo",
                    ]
                ]
            ],
            [
                "name" => "membership",
                "label" => "Membership",
                "icon" => "fa-solid fa-user",
                "path" => "/membership",
                "submenu" => [
                    [
                        "label" => "Kategori Member",
                        "path" => "/membership/kat_member",
                    ],
                    [
                        "label" => "Member",
                        "path" => "/membership/member",
                    ],
                    [
                        "label" => "Koin",
                        "path" => "/membership/koin",
                    ]
                ]
            ],
            [
                "name" => "user-manage",
                "label" => "User Manage",
                "icon" => "fa-solid fa-users-gear",
                "path" => "/user-manage",
                "submenu" => [
                    [
                        "label" => "User",
                        "path" => "/user-manage/user",
                    ],
                    [
                        "label" => "Cabang",
                        "path" => "/user-manage/cabang",
                    ],
                    [
                        "label" => "Otoritas",
                        "path" => "/user-manage/otoritas",
                    ]
                ]
            ]
        ];
    }
    
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

    private function searchMenus(array $menus, string $search): array
    {
        $search = strtolower(trim($search));

        return array_filter($menus, function ($menu) use ($search) {
            if (
                str_contains(strtolower($menu['name']), $search) ||
                str_contains(strtolower($menu['label']), $search)
            ) {
                return true;
            }
            
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