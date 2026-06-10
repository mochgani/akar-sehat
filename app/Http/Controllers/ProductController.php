<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter pencarian
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->q . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->q . '%');
            });
        }

        // Sorting
        match ($request->sort) {
            'harga-asc'  => $query->orderBy('harga', 'asc'),
            'harga-desc' => $query->orderBy('harga', 'desc'),
            'nama-az'    => $query->orderBy('nama', 'asc'),
            default      => $query->orderBy('urutan'),
        };

        $produk    = $query->paginate(12)->withQueryString();
        $kategoris = Product::distinct()->pluck('kategori')->filter()->sort()->values();
        $siteSettings = Setting::getGroup('site');

        return view('public.produk.index', compact('produk', 'kategoris', 'siteSettings'));
    }

    public function show(string $slug)
    {
        $produk = Product::where('slug', $slug)->firstOrFail();
        $related = Product::where('kategori', $produk->kategori)
            ->where('id', '!=', $produk->id)
            ->take(4)
            ->get();
        $siteSettings = Setting::getGroup('site');
        return view('public.produk.show', compact('produk', 'related', 'siteSettings'));
    }
}
