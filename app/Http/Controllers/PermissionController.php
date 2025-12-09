<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TrPermission;

class PermissionController extends Controller
{
    public function getAllPermissions()
    {
        $permissions = DB::table('trPermission')
            ->select('id', 'name', 'slug')
            ->get();

        return response()->json([
            'message' => 'Berhasil mengambil semua permission',
            'data' => $permissions
        ], 200);
    }

    public function getPermissionById($id)
    {
        $permission = DB::table('trPermission')
            ->select('id', 'name', 'slug')
            ->where('id', $id)
            ->first();

        if (!$permission) {
            return response()->json([
                'message' => 'Permission tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'data' => $permission,
            'message' => 'Permission fetched successfully',
        ], 200);
    }

    public function getRolesByPermission($id)
    {
        // Ambil role ids untuk permission ini
        $roles = DB::table('msrole')
            ->join('trRolePermission', 'msrole.id', '=', 'trRolePermission.role_id')
            ->where('trRolePermission.permission_id', $id)
            ->select('msrole.id', 'msrole.name') // selalu prefix tabel
            ->get();

        return response()->json($roles, 200);
    }

    public function updateRoles(Request $request, $id)
    {
        $roles = $request->input('roles', []); // array of role ids

        // Hapus dulu semua role lama untuk permission ini
        DB::table('trRolePermission')
            ->where('permission_id', $id)
            ->delete();

        // Insert yang baru
        $insertData = array_map(fn($roleId) => [
            'role_id' => $roleId,
            'permission_id' => $id,
            'created_at' => now(),
            'updated_at' => now(),
        ], $roles);

        if (!empty($insertData)) {
            DB::table('trRolePermission')->insert($insertData);
        }

        return response()->json([
            'message' => 'Roles for permission updated successfully.'
        ], 200);
    }
}
