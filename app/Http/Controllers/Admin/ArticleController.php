<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $articles  = $query->latest()->paginate(15)->withQueryString();
        // Daftar kategori untuk dropdown — utamakan dari master kategori artikel
        try {
            $kategoris = \App\Models\KategoriArtikel::aktif()->orderBy('urutan')->orderBy('nama')->pluck('nama');
        } catch (\Exception $e) {
            $kategoris = Article::distinct()->pluck('kategori')->filter();
        }
        $languages = Language::aktif()->get();

        return view('admin.artikel.index', compact('articles', 'kategoris', 'languages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'      => 'required|string|max:255',
            'status'     => 'required|in:terbit,draft,review,arsip',
            'kategori'   => 'nullable|string|max:100',
            'penulis'    => 'nullable|string|max:100',
            'konten'     => 'nullable|string',
            'keywords'   => 'nullable|array',
            'meta_title' => 'nullable|string|max:70',
            'meta_desc'  => 'nullable|string|max:160',
            'thumbnail'  => 'nullable|image|max:2048',
        ]);

        $data['slug']         = Str::slug($data['judul']);
        $data['translations'] = $this->extractTranslations($request, ['judul', 'konten', 'meta_title', 'meta_desc']);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('artikel', 'public');
        }

        Article::create($data);
        return response()->json(['success' => true, 'message' => 'Artikel berhasil disimpan.']);
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->validate([
            'judul'      => 'required|string|max:255',
            'status'     => 'required|in:terbit,draft,review,arsip',
            'kategori'   => 'nullable|string|max:100',
            'penulis'    => 'nullable|string|max:100',
            'konten'     => 'nullable|string',
            'keywords'   => 'nullable|array',
            'meta_title' => 'nullable|string|max:70',
            'meta_desc'  => 'nullable|string|max:160',
            'thumbnail'  => 'nullable|image|max:2048',
        ]);

        $data['translations'] = $this->extractTranslations($request, ['judul', 'konten', 'meta_title', 'meta_desc']);

        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail) Storage::disk('public')->delete($article->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('artikel', 'public');
        }

        $article->update($data);
        return response()->json(['success' => true, 'message' => 'Artikel berhasil diperbarui.']);
    }

    private function extractTranslations(Request $request, array $fields): array
    {
        $translations = [];
        $trans        = $request->input('trans', []);
        foreach ($trans as $locale => $localeData) {
            if ($locale === 'id' || !is_array($localeData)) continue;
            $clean = [];
            foreach ($fields as $f) {
                $v = $localeData[$f] ?? '';
                if ($v !== '') $clean[$f] = $v;
            }
            if (!empty($clean)) $translations[$locale] = $clean;
        }
        return $translations;
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json(['success' => true, 'message' => 'Artikel berhasil dihapus.']);
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->validate(['ids' => 'required|array', 'ids.*' => 'integer'])['ids'];
        Article::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => count($ids) . ' artikel berhasil dihapus.']);
    }
}
