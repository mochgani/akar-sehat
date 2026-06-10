<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Setting;

class ArticleController extends Controller
{
    public function index()
    {
        $artikel = Article::published()->paginate(9);
        $kategoris = Article::where('status', 'terbit')->distinct()->pluck('kategori')->filter();
        $siteSettings = Setting::getGroup('site');
        return view('public.edukasi.index', compact('artikel', 'kategoris', 'siteSettings'));
    }

    public function show(string $slug)
    {
        $artikel = Article::where('slug', $slug)->where('status', 'terbit')->firstOrFail();
        $artikel->increment('views');

        $related = Article::published()
            ->where('kategori', $artikel->kategori)
            ->where('id', '!=', $artikel->id)
            ->take(3)
            ->get();

        $produkTerkait = \App\Models\Product::where('kategori', $artikel->kategori)
            ->take(3)->get();

        $siteSettings = Setting::getGroup('site');
        return view('public.edukasi.show', compact('artikel', 'related', 'produkTerkait', 'siteSettings'));
    }
}
