<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Consultation;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'konsultasi_baru'   => Consultation::where('status', 'baru')->count(),
            'konsultasi_total'  => Consultation::count(),
            'produk_aktif'      => Product::where('status', 'tersedia')->count(),
            'produk_total'      => Product::count(),
            'artikel_terbit'    => Article::where('status', 'terbit')->count(),
            'artikel_total'     => Article::count(),
            'users_total'       => User::where('status', 'aktif')->count(),
            'stok_menipis'      => Product::where('status', 'hampir-habis')->count(),
        ];

        $recentConsultations = Consultation::latest()->take(5)->get();
        $recentArticles      = Article::latest()->take(5)->get();
        $lowStockProducts    = Product::whereIn('status', ['hampir-habis', 'habis'])->get();

        return view('admin.dashboard', compact('stats', 'recentConsultations', 'recentArticles', 'lowStockProducts'));
    }
}
