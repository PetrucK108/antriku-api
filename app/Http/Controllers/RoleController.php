<?php

namespace App\Http\Controllers;

use App\Models\MsRole;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function getAllRole(Request $request)
    {
        try {
            $roles = MsRole::with('user', 'permissions')->get();

            return response()->json([
                'data' => $roles,
                'message' => 'Roles fetched successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching roles.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
