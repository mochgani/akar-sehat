<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        if ($kategori = $request->input('kategori')) {
            $query->where('kategori', $kategori);
        }

        $products  = $query->orderBy('urutan')->paginate(15)->withQueryString();
        $kategoris = Product::distinct()->pluck('kategori');
        $languages = Language::aktif()->get();

        return view('admin.produk.index', compact('products', 'kategoris', 'languages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'        => 'required|string|max:255',
            'sku'         => 'required|string|max:50|unique:products',
            'kategori'    => 'required|string|max:100',
            'harga'       => 'required|integer|min:0',
            'stok'        => 'required|integer|min:0',
            'kandungan'   => 'nullable|array',
            'deskripsi'   => 'nullable|string',
            'cara_pakai'  => 'nullable|string',
            'is_featured' => 'boolean',
            'foto'        => 'nullable|image|max:2048',
        ]);

        $data['slug']         = Str::slug($data['nama']);
        $data['is_featured']  = $request->boolean('is_featured');
        $data['translations'] = $this->extractTranslations($request, ['nama', 'deskripsi', 'cara_pakai']);

        if ($request->hasFile('foto')) {
            $ext          = $request->file('foto')->getClientOriginalExtension();
            $filename     = Str::slug($data['nama']) . '-' . uniqid() . '.' . $ext;
            $request->file('foto')->move(public_path('asset/produk'), $filename);
            $data['foto'] = $filename;
        }

        Product::create($data);
        return response()->json(['success' => true, 'message' => 'Produk berhasil ditambahkan.']);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'nama'        => 'required|string|max:255',
            'sku'         => "required|string|max:50|unique:products,sku,{$product->id}",
            'kategori'    => 'required|string|max:100',
            'harga'       => 'required|integer|min:0',
            'stok'        => 'required|integer|min:0',
            'kandungan'   => 'nullable|array',
            'deskripsi'   => 'nullable|string',
            'cara_pakai'  => 'nullable|string',
            'is_featured' => 'boolean',
            'foto'        => 'nullable|image|max:2048',
        ]);

        $data['is_featured']  = $request->boolean('is_featured');
        $data['translations'] = $this->extractTranslations($request, ['nama', 'deskripsi', 'cara_pakai']);

        if ($request->hasFile('foto')) {
            if ($product->foto && file_exists(public_path('asset/produk/' . $product->foto))) {
                @unlink(public_path('asset/produk/' . $product->foto));
            }
            $ext          = $request->file('foto')->getClientOriginalExtension();
            $filename     = Str::slug($data['nama']) . '-' . uniqid() . '.' . $ext;
            $request->file('foto')->move(public_path('asset/produk'), $filename);
            $data['foto'] = $filename;
        }

        $product->update($data);
        return response()->json(['success' => true, 'message' => 'Produk berhasil diperbarui.']);
    }

    /** Extract translations[locale][field] from request, skip 'id' locale */
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

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['success' => true, 'message' => 'Produk berhasil dihapus.']);
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->validate(['ids' => 'required|array', 'ids.*' => 'integer'])['ids'];
        Product::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => count($ids) . ' produk berhasil dihapus.']);
    }

    public function exportCsv()
    {
        $products = Product::orderBy('urutan')->get();
        $headers  = ['ID', 'SKU', 'Nama', 'Kategori', 'Harga', 'Stok', 'Status', 'Featured'];
        $rows     = $products->map(fn($p) => [$p->id, $p->sku, $p->nama, $p->kategori, $p->harga, $p->stok, $p->status, $p->is_featured ? 'Ya' : 'Tidak']);

        $csv = collect([$headers])->merge($rows)
            ->map(fn($row) => implode(',', array_map(fn($v) => '"' . str_replace('"', '""', $v) . '"', $row)))
            ->implode("\n");

        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="produk_' . date('Y-m-d') . '.csv"',
        ]);
    }
}
