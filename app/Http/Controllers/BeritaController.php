<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function getAllBerita()
    {
        try {
            $berita = Berita::orderBy('published_at', 'desc')->get();

            return response()->json([
                'data' => $berita,
                'message' => 'Berita fetched successfully',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data berita',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeBerita(Request $request)
    {
        try {
            $request->validate([
                'judul' => 'required|string|max:255',
                'deskripsi' => 'required|string|max:255',
                'foto' => 'nullable|string',
                'published_at' => 'nullable|date',
            ]);

            $berita = new Berita();
            $berita->judul = $request->judul;
            $berita->deskripsi = $request->deskripsi;
            $berita->foto = $request->foto;
            $berita->published_at = $request->published_at;

            $berita->save();

            return response()->json([
                'message' => 'Berita berhasil disimpan',
                'data' => $berita,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan berita',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateBerita(Request $request, $id)
    {
        try {
            $request->validate([
                'judul' => 'required|string|max:255',
                'deskripsi' => 'required|string|max:255',
                'foto' => 'nullable|string',
                'published_at' => 'nullable|date',
            ]);

            $berita = Berita::findOrFail($id);

            $berita->judul = $request->judul;
            $berita->deskripsi = $request->deskripsi;
            $berita->foto = $request->foto;
            $berita->published_at = $request->published_at;

            $berita->save();

            return response()->json([
                'message' => 'Berita berhasil diperbarui',
                'data' => $berita,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui berita',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteBerita($id)
    {
        try {
            $berita = Berita::findOrFail($id);
            $berita->delete();

            return response()->json([
                'message' => 'Berita berhasil dihapus',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus berita',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
