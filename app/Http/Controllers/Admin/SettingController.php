<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $site = Setting::getGroup('site');
        return view('admin.pengaturan.index', compact('site'));
    }

    public function saveSite(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'tagline'     => 'nullable|string|max:200',
            'wa_number'   => 'nullable|string|max:20',
            'email'       => 'nullable|email',
            'instagram'   => 'nullable|string|max:100',
            'logo'        => 'nullable|image|max:512',
            'favicon'     => 'nullable|image|max:128',
            'address'     => 'nullable|string|max:200',
            'footer_desc' => 'nullable|string|max:300',
            'copyright'   => 'nullable|string|max:200',
            'fb_url'      => 'nullable|url|max:255',
            'ig_url'      => 'nullable|url|max:255',
            'yt_url'      => 'nullable|url|max:255',
        ]);

        foreach (['name','tagline','wa_number','email','instagram','address','footer_desc','copyright','fb_url','ig_url','yt_url'] as $key) {
            Setting::set("site.{$key}", $request->input($key, ''));
        }

        foreach (['logo','favicon'] as $field) {
            if ($request->hasFile($field)) {
                $old = Setting::get("site.{$field}");
                if ($old) Storage::disk('public')->delete($old);
                $path = $request->file($field)->store("site", 'public');
                Setting::set("site.{$field}", $path);
            }
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }

    public function deleteLogo(string $field)
    {
        if (!in_array($field, ['logo','favicon'])) abort(404);
        $path = Setting::get("site.{$field}");
        if ($path) Storage::disk('public')->delete($path);
        Setting::set("site.{$field}", '');
        return back()->with('success', ucfirst($field).' berhasil dihapus.');
    }

    public function homepage()
    {
        $all = Setting::getGroupAllLocales('homepage');
        // Decode JSON arrays for id locale
        foreach (['stats', 'mentor_stats'] as $k) {
            foreach (array_keys($all) as $loc) {
                if (!empty($all[$loc][$k]) && is_string($all[$loc][$k])) {
                    $all[$loc][$k] = json_decode($all[$loc][$k], true) ?? [];
                }
            }
        }
        $settings = $all['id'] ?? [];
        $languages = \App\Models\Language::aktif()->get();
        return view('admin.pengaturan.homepage', compact('settings', 'all', 'languages'));
    }

    public function saveHomepage(Request $request)
    {
        $locales   = \App\Models\Language::aktif()->pluck('code')->toArray();
        $textKeys  = [
            'hero_badge','hero_title1','hero_title2','hero_desc','hero_btn_text',
            'mentor_tag','mentor_nama','mentor_bio','mentor_btn',
            'cta_title','cta_desc','cta_btn',
            'konsul_title','konsul_desc','konsul_btn',
        ];

        // Save text per locale
        foreach ($locales as $locale) {
            foreach ($textKeys as $key) {
                $val = $request->input("{$key}.{$locale}", '');
                // Only save non-id locales if they have content OR always save 'id'
                if ($locale === 'id' || $val !== '') {
                    Setting::set("homepage.{$key}", $val, $locale);
                }
            }

            // Stats array per locale
            if ($request->has("stats.{$locale}")) {
                $stats = array_values(array_filter($request->input("stats.{$locale}"), fn($s) => !empty($s['nilai'])));
                Setting::set('homepage.stats', json_encode($stats, JSON_UNESCAPED_UNICODE), $locale);
            } elseif ($locale === 'id' && $request->has('stats')) {
                // backward compat
                $stats = array_values(array_filter($request->input('stats'), fn($s) => !empty($s['nilai'])));
                Setting::set('homepage.stats', json_encode($stats, JSON_UNESCAPED_UNICODE), 'id');
            }

            // Mentor stats per locale
            if ($request->has("mentor_stats.{$locale}")) {
                $ms = array_values(array_filter($request->input("mentor_stats.{$locale}"), fn($s) => !empty($s['nilai'])));
                Setting::set('homepage.mentor_stats', json_encode($ms, JSON_UNESCAPED_UNICODE), $locale);
            }
        }

        // Images are locale-independent (always save as 'id')
        foreach (['hero_image', 'mentor_image'] as $field) {
            if ($request->hasFile($field)) {
                $request->validate([$field => 'image|max:2048']);
                $old = Setting::get("homepage.{$field}", null, 'id');
                if ($old) Storage::disk('public')->delete($old);
                $path = $request->file($field)->store('homepage', 'public');
                Setting::set("homepage.{$field}", $path, 'id');
            }
        }

        return back()->with('success', 'Pengaturan homepage berhasil disimpan.');
    }

    public function tentang()
    {
        $all = Setting::getGroupAllLocales('tentang');
        $settings = $all['id'] ?? [];
        $languages = \App\Models\Language::aktif()->get();
        return view('admin.pengaturan.tentang', compact('settings', 'all', 'languages'));
    }

    public function saveTentang(Request $request)
    {
        $request->validate([
            'profil_foto' => 'nullable|image|max:2048',
        ]);

        $locales  = \App\Models\Language::aktif()->pluck('code')->toArray();
        $textKeys = ['hero_badge', 'hero_title', 'hero_desc', 'profil_nama', 'profil_gelar', 'profil_bio', 'visi', 'misi'];

        foreach ($locales as $locale) {
            foreach ($textKeys as $key) {
                // Check if input is array (multi-locale) or scalar (old format)
                $val = is_array($request->input($key))
                    ? $request->input("{$key}.{$locale}", '')
                    : ($locale === 'id' ? $request->input($key, '') : '');
                if ($locale === 'id' || $val !== '') {
                    Setting::set("tentang.{$key}", $val, $locale);
                }
            }
        }

        // Profil foto is locale-independent
        if ($request->hasFile('profil_foto')) {
            $old = Setting::get('tentang.profil_foto', null, 'id');
            if ($old) Storage::disk('public')->delete($old);
            $path = $request->file('profil_foto')->store('tentang', 'public');
            Setting::set('tentang.profil_foto', $path, 'id');
        }

        return back()->with('success', 'Pengaturan halaman tentang berhasil disimpan.');
    }

    public function underConstruction()
    {
        $settings = Setting::getGroup('uc');
        return view('admin.pengaturan.underconstruction', compact('settings'));
    }

    public function saveUnderConstruction(Request $request)
    {
        $keys = ['mode', 'launch_date', 'progress', 'title_line1', 'title_line2',
                 'description', 'show_countdown', 'show_progress', 'show_subscribe'];

        foreach ($keys as $key) {
            Setting::set("uc.{$key}", $request->input($key, '0'));
        }

        return back()->with('success', 'Pengaturan under construction berhasil disimpan.');
    }

    public function statistik()
    {
        $stats = [
            'konsultasi_per_status' => \App\Models\Consultation::selectRaw('status, count(*) as total')
                ->groupBy('status')->pluck('total', 'status'),
            'produk_per_kategori'   => \App\Models\Product::selectRaw('kategori, count(*) as total')
                ->groupBy('kategori')->pluck('total', 'kategori'),
            'artikel_per_status'    => \App\Models\Article::selectRaw('status, count(*) as total')
                ->groupBy('status')->pluck('total', 'status'),
            'top_articles'          => \App\Models\Article::orderByDesc('views')->take(5)->get(),
        ];

        return view('admin.statistik', compact('stats'));
    }
}
