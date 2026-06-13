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
            'wa_number_2' => 'nullable|string|max:20',
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
            'tiktok_url'  => 'nullable|url|max:255',
        ]);

        foreach (['name','tagline','wa_number','wa_number_2','email','instagram','address','footer_desc','copyright','fb_url','ig_url','yt_url','tiktok_url'] as $key) {
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
        $textKeys = [
            // Hero
            'hero_badge', 'hero_title', 'hero_desc',
            'hero_stat1_val', 'hero_stat1_label', 'hero_stat2_val', 'hero_stat2_label',
            'hero_stat3_val', 'hero_stat3_label', 'hero_stat4_val', 'hero_stat4_label',
            // Siapa Kami
            'intro_label', 'intro_title', 'intro_p1', 'intro_p2', 'intro_p3',
            'value1_title', 'value1_desc', 'value2_title', 'value2_desc',
            'value3_title', 'value3_desc', 'value4_title', 'value4_desc',
            // Visi & Misi
            'vm_title', 'vm_desc', 'visi_label', 'visi', 'misi_label', 'misi_heading', 'misi',
            // Profil
            'profil_section_label', 'profil_section_title', 'profil_inner_label',
            'profil_nama', 'profil_gelar', 'profil_bio',
            'cert1', 'cert2', 'cert3',
            'profil_stat1_val', 'profil_stat1_label', 'profil_stat2_val', 'profil_stat2_label',
            'profil_stat3_val', 'profil_stat3_label', 'keahlian_title', 'keahlian_tags',
            // Perjalanan
            'journey_title', 'journey_desc',
            'tl1_year', 'tl1_title', 'tl1_desc', 'tl2_year', 'tl2_title', 'tl2_desc',
            'tl3_year', 'tl3_title', 'tl3_desc', 'tl4_year', 'tl4_title', 'tl4_desc',
            'tl5_year', 'tl5_title', 'tl5_desc', 'tl6_year', 'tl6_title', 'tl6_desc',
            'tl7_year', 'tl7_title', 'tl7_desc',
            // Proses Pendampingan
            'ck_label', 'ck_title', 'ck_desc',
            'step1_title', 'step1_desc', 'step2_title', 'step2_desc', 'step3_title', 'step3_desc',
            'step4_title', 'step4_desc', 'step5_title', 'step5_desc',
            'ckd1_title', 'ckd1_intro', 'ckd1_list', 'ckd2_title', 'ckd2_intro', 'ckd2_list',
            'ckd3_title', 'ckd3_intro', 'ckd3_list',
            // CTA & Banner
            'cta_label', 'cta_title', 'cta_desc', 'cta_btn', 'cta_note',
            'banner_title', 'banner_desc', 'banner_btn',
        ];

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
