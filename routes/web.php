<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\ConsultationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CertificationController;
use App\Http\Controllers\Admin\KategoriArtikelController;
use App\Http\Controllers\Admin\KategoriProdukController;
use Illuminate\Support\Facades\Route;

// ─── HALAMAN PUBLIK ───────────────────────────────────────────────────────────
Route::middleware('uc')->group(function () {
    Route::get('/',         [HomeController::class, 'index'])->name('home');
    Route::get('/tentang',  [HomeController::class, 'tentang'])->name('tentang');

    Route::get('/produk',          [ProductController::class, 'index'])->name('produk.index');
    Route::get('/produk/{slug}',   [ProductController::class, 'show'])->name('produk.show');

    Route::get('/edukasi',         [ArticleController::class, 'index'])->name('edukasi.index');
    Route::get('/edukasi/{slug}',  [ArticleController::class, 'show'])->name('edukasi.show');
});

Route::get('/under-construction', [HomeController::class, 'underConstruction'])->name('under-construction');

// ─── LANGUAGE SWITCH ─────────────────────────────────────────────────────────
Route::get('/lang/{code}', function (string $code) {
    $valid = \App\Models\Language::aktif()->pluck('code')->toArray();
    if (in_array($code, $valid)) {
        session(['locale' => $code]);
    }
    return redirect()->back()->withHeaders([
        'Cache-Control' => 'no-store',
    ]);
})->name('lang.switch');

// ─── ADMIN AUTH ───────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ─── ADMIN PANEL (proteksi middleware) ────────────────────────────────────
    Route::middleware('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Produk
        Route::get('/produk',              [AdminProductController::class, 'index'])->name('produk.index');
        Route::post('/produk',             [AdminProductController::class, 'store'])->name('produk.store');
        Route::put('/produk/{product}',    [AdminProductController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{product}', [AdminProductController::class, 'destroy'])->name('produk.destroy');
        Route::post('/produk/bulk-destroy',[AdminProductController::class, 'bulkDestroy'])->name('produk.bulk-destroy');
        Route::get('/produk/export-csv',   [AdminProductController::class, 'exportCsv'])->name('produk.export-csv');

        // Kategori Produk
        Route::get('/kategori',                    [KategoriProdukController::class, 'index'])->name('kategori.index');
        Route::post('/kategori',                   [KategoriProdukController::class, 'store'])->name('kategori.store');
        Route::put('/kategori/{kategori}',         [KategoriProdukController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{kategori}',      [KategoriProdukController::class, 'destroy'])->name('kategori.destroy');
        Route::patch('/kategori/{kategori}/toggle',[KategoriProdukController::class, 'toggle'])->name('kategori.toggle');

        // Sertifikasi Produk
        Route::get('/sertifikasi',                       [CertificationController::class, 'index'])->name('sertifikasi.index');
        Route::post('/sertifikasi',                      [CertificationController::class, 'store'])->name('sertifikasi.store');
        Route::post('/sertifikasi/{certification}',      [CertificationController::class, 'update'])->name('sertifikasi.update');
        Route::delete('/sertifikasi/{certification}',    [CertificationController::class, 'destroy'])->name('sertifikasi.destroy');
        Route::patch('/sertifikasi/{certification}/toggle',[CertificationController::class, 'toggle'])->name('sertifikasi.toggle');

        // Artikel
        Route::get('/artikel',              [AdminArticleController::class, 'index'])->name('artikel.index');
        Route::post('/artikel',             [AdminArticleController::class, 'store'])->name('artikel.store');
        Route::put('/artikel/{article}',    [AdminArticleController::class, 'update'])->name('artikel.update');
        Route::delete('/artikel/{article}', [AdminArticleController::class, 'destroy'])->name('artikel.destroy');
        Route::post('/artikel/bulk-destroy',[AdminArticleController::class, 'bulkDestroy'])->name('artikel.bulk-destroy');

        // Kategori Artikel
        Route::get('/kategori-artikel',                    [KategoriArtikelController::class, 'index'])->name('kategori-artikel.index');
        Route::post('/kategori-artikel',                   [KategoriArtikelController::class, 'store'])->name('kategori-artikel.store');
        Route::put('/kategori-artikel/{kategori}',         [KategoriArtikelController::class, 'update'])->name('kategori-artikel.update');
        Route::delete('/kategori-artikel/{kategori}',      [KategoriArtikelController::class, 'destroy'])->name('kategori-artikel.destroy');
        Route::patch('/kategori-artikel/{kategori}/toggle',[KategoriArtikelController::class, 'toggle'])->name('kategori-artikel.toggle');

        // Konsultasi
        Route::get('/konsultasi',                   [ConsultationController::class, 'index'])->name('konsultasi.index');
        Route::post('/konsultasi',                  [ConsultationController::class, 'store'])->name('konsultasi.store');
        Route::put('/konsultasi/{consultation}',    [ConsultationController::class, 'update'])->name('konsultasi.update');
        Route::delete('/konsultasi/{consultation}', [ConsultationController::class, 'destroy'])->name('konsultasi.destroy');
        Route::post('/konsultasi/bulk-update',      [ConsultationController::class, 'bulkUpdate'])->name('konsultasi.bulk-update');
        Route::post('/konsultasi/bulk-destroy',     [ConsultationController::class, 'bulkDestroy'])->name('konsultasi.bulk-destroy');

        // Users (hanya administrator)
        Route::middleware('admin:administrator')->group(function () {
            Route::get('/users',            [UserController::class, 'index'])->name('users.index');
            Route::post('/users',           [UserController::class, 'store'])->name('users.store');
            Route::put('/users/{user}',     [UserController::class, 'update'])->name('users.update');
            Route::delete('/users/{user}',  [UserController::class, 'destroy'])->name('users.destroy');
            Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        });

        // Pengaturan (hanya administrator)
        Route::middleware('admin:administrator')->group(function () {
            Route::get('/pengaturan',                    [SettingController::class, 'index'])->name('pengaturan.index');
            Route::post('/pengaturan/site',                  [SettingController::class, 'saveSite'])->name('pengaturan.site');
            Route::get('/pengaturan/site/delete/{field}',    [SettingController::class, 'deleteLogo'])->name('pengaturan.site.delete-logo');
            Route::get('/pengaturan/homepage',           [SettingController::class, 'homepage'])->name('pengaturan.homepage');
            Route::post('/pengaturan/homepage',          [SettingController::class, 'saveHomepage'])->name('pengaturan.homepage.save');
            Route::get('/pengaturan/tentang',            [SettingController::class, 'tentang'])->name('pengaturan.tentang');
            Route::post('/pengaturan/tentang',           [SettingController::class, 'saveTentang'])->name('pengaturan.tentang.save');
            Route::get('/pengaturan/under-construction', [SettingController::class, 'underConstruction'])->name('pengaturan.uc');
            Route::post('/pengaturan/under-construction',[SettingController::class, 'saveUnderConstruction'])->name('pengaturan.uc.save');
            // Bahasa
            Route::get('/bahasa',              [LanguageController::class, 'index'])->name('bahasa.index');
            Route::post('/bahasa',             [LanguageController::class, 'store'])->name('bahasa.store');
            Route::put('/bahasa/{language}',   [LanguageController::class, 'update'])->name('bahasa.update');
            Route::delete('/bahasa/{language}',[LanguageController::class, 'destroy'])->name('bahasa.destroy');
            Route::patch('/bahasa/{language}/toggle', [LanguageController::class, 'toggle'])->name('bahasa.toggle');
            Route::patch('/bahasa/{language}/default', [LanguageController::class, 'setDefault'])->name('bahasa.default');
        });

        // Testimoni
        Route::get('/testimoni',                          [TestimonialController::class, 'index'])->name('testimoni.index');
        Route::post('/testimoni',                         [TestimonialController::class, 'store'])->name('testimoni.store');
        Route::put('/testimoni/{testimonial}',            [TestimonialController::class, 'update'])->name('testimoni.update');
        Route::delete('/testimoni/{testimonial}',         [TestimonialController::class, 'destroy'])->name('testimoni.destroy');
        Route::patch('/testimoni/{testimonial}/toggle',   [TestimonialController::class, 'toggleAktif'])->name('testimoni.toggle');

        // Statistik
        Route::get('/statistik', [SettingController::class, 'statistik'])->name('statistik');
    });
});
