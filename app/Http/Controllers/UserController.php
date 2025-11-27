<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MsUser;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    public function login(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required', 'string', 'min:6'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        }

        // Cek kredensial
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Email atau Password Anda salah',
            ], 401);
        }

        // Ambil user
        $user = MsUser::where('email', $request->email)->first();

        // Generate token Sanctum
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function register(Request $request)
    {
        try {
            // Validasi
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:msuser,email'],
                'password' => ['required', 'string', 'min:6'],
                'roleId' => ['required', 'integer'],
            ]);

            // Insert user
            $user = MsUser::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'roleId' => $request->roleId,
            ]);

            // Token Sanctum
            $token = $user->createToken("api-token")->plainTextToken;

            return response()->json([
                'message'   => 'Registrasi berhasil',
                'user'      => $user,
                'token'     => $token
            ], 201);

        } catch (ValidationException $e) {

            return response()->json([
                'message' => 'Validasi gagal',
                'errors'  => $e->errors(),
            ], 422);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Terjadi kesalahan server',
                'error'   => $e->getMessage(),  // REAL ERROR
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        // Ambil user yang sedang login
        $user = $request->user();

        if ($user) {
            // Hapus token yang sedang dipakai
            $user->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Logout berhasil'
            ], 200);
        }

        return response()->json([
            'message' => 'User tidak ditemukan'
        ], 404);
    }





}
