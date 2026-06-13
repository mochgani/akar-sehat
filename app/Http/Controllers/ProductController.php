<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->q . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->q . '%');
            });
        }

        match ($request->sort) {
            'harga-asc'  => $query->orderBy('harga', 'asc'),
            'harga-desc' => $query->orderBy('harga', 'desc'),
            'nama-az'    => $query->orderBy('nama', 'asc'),
            default      => $query->orderBy('urutan'),
        };

        $produk    = $query->paginate(12)->withQueryString();
        $siteSettings = Setting::getGroup('site');

        try {
            $kategoris = KategoriProduk::aktif()->orderBy('urutan')->orderBy('nama')->get();
        } catch (\Exception $e) {
            $kategoris = collect();
        }

        return view('public.produk.index', compact('produk', 'kategoris', 'siteSettings'));
    }

    public function show(string $slug)
    {
        $produk  = Product::where('slug', $slug)->firstOrFail();
        $related = Product::where('kategori', $produk->kategori)
            ->where('id', '!=', $produk->id)
            ->take(4)->get();
        $siteSettings = Setting::getGroup('site');

        try {
            $kategoriObj = KategoriProduk::where('nama', $produk->kategori)->first();
        } catch (\Exception $e) {
            $kategoriObj = null;
        }

        return view('public.produk.show', compact('produk', 'related', 'siteSettings', 'kategoriObj'));
    }
}
