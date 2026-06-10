<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_featured', true)
            ->where('status', '!=', 'habis')
            ->orderBy('urutan')
            ->take(6)
            ->get();

        $latestArticles = Article::published()->take(3)->get();

        $testimonials = Testimonial::aktif()->get();

        $settings = Setting::getGroup('homepage');
        $siteSettings = Setting::getGroup('site');

        return view('public.home', compact('featuredProducts', 'latestArticles', 'testimonials', 'settings', 'siteSettings'));
    }

    public function tentang()
    {
        $settings = Setting::getGroup('tentang');
        $siteSettings = Setting::getGroup('site');
        return view('public.tentang', compact('settings', 'siteSettings'));
    }

    public function underConstruction()
    {
        $settings = Setting::getGroup('uc');
        $siteSettings = Setting::getGroup('site');
        return view('public.under-construction', compact('settings', 'siteSettings'));
    }
}
