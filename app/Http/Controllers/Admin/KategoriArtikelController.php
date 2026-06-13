<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\KategoriArtikel;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriArtikelController extends Controller
{
    public function index()
    {
        $kategoris = KategoriArtikel::withCount('articles')->orderBy('urutan')->orderBy('nama')->get();
        $languages = Language::aktif()->get();
        return view('admin.kategori-artikel.index', compact('kategoris', 'languages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'   => 'required|string|max:100|unique:kategori_artikel,nama',
            'urutan' => 'nullable|integer|min:0',
            'aktif'  => 'nullable|boolean',
        ]);

        $data['slug']         = Str::slug($data['nama']);
        $data['urutan']       = $data['urutan'] ?? (KategoriArtikel::max('urutan') + 1);
        $data['aktif']        = $request->boolean('aktif', true);
        $data['translations'] = $this->extractTranslations($request);

        $kat = KategoriArtikel::create($data);

        return response()->json(['success' => true, 'message' => 'Kategori berhasil ditambahkan.', 'data' => $kat]);
    }

    public function update(Request $request, KategoriArtikel $kategori)
    {
        $data = $request->validate([
            'nama'   => 'required|string|max:100|unique:kategori_artikel,nama,' . $kategori->id,
            'urutan' => 'nullable|integer|min:0',
            'aktif'  => 'nullable|boolean',
        ]);

        $oldNama = $kategori->nama;
        $data['slug']         = Str::slug($data['nama']);
        $data['aktif']        = $request->boolean('aktif', true);
        $data['translations'] = $this->extractTranslations($request);

        $kategori->update($data);

        if ($oldNama !== $data['nama']) {
            Article::where('kategori', $oldNama)->update(['kategori' => $data['nama']]);
        }

        return response()->json(['success' => true, 'message' => 'Kategori berhasil diperbarui.', 'data' => $kategori]);
    }

    public function destroy(KategoriArtikel $kategori)
    {
        $count = Article::where('kategori', $kategori->nama)->count();
        if ($count > 0) {
            return response()->json([
                'success' => false,
                'message' => "Tidak bisa dihapus — ada {$count} artikel di kategori ini.",
            ], 422);
        }

        $kategori->delete();
        return response()->json(['success' => true, 'message' => 'Kategori berhasil dihapus.']);
    }

    public function toggle(KategoriArtikel $kategori)
    {
        $kategori->update(['aktif' => !$kategori->aktif]);
        $label = $kategori->aktif ? 'diaktifkan' : 'dinonaktifkan';
        return response()->json(['success' => true, 'message' => "Kategori berhasil {$label}.", 'aktif' => $kategori->aktif]);
    }

    private function extractTranslations(Request $request): array
    {
        $locales = Language::aktif()->where('code', '!=', 'id')->pluck('code');
        $trans   = [];
        foreach ($locales as $locale) {
            $nama = $request->input("trans.{$locale}.nama", '');
            if ($nama !== '') {
                $trans[$locale]['nama'] = $nama;
            }
        }
        return $trans;
    }
}
