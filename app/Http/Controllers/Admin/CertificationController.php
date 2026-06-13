<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificationController extends Controller
{
    public function index()
    {
        $certifications = Certification::orderBy('urutan')->orderBy('id')->get();
        $languages = Language::aktif()->get();
        return view('admin.sertifikasi.index', compact('certifications', 'languages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'  => 'required|string|max:150',
            'urutan' => 'nullable|integer|min:0',
            'aktif'  => 'nullable|boolean',
            'gambar' => 'required|image|max:2048',
        ]);

        $data['urutan']       = $data['urutan'] ?? (Certification::max('urutan') + 1);
        $data['aktif']        = $request->boolean('aktif', true);
        $data['translations'] = $this->extractTranslations($request);
        $data['gambar']       = $request->file('gambar')->store('sertifikasi', 'public');

        $cert = Certification::create($data);

        return response()->json(['success' => true, 'message' => 'Sertifikasi berhasil ditambahkan.', 'data' => $cert]);
    }

    public function update(Request $request, Certification $certification)
    {
        $data = $request->validate([
            'judul'  => 'required|string|max:150',
            'urutan' => 'nullable|integer|min:0',
            'aktif'  => 'nullable|boolean',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $data['aktif']        = $request->boolean('aktif', true);
        $data['translations'] = $this->extractTranslations($request);

        if ($request->hasFile('gambar')) {
            if ($certification->gambar && !str_starts_with($certification->gambar, 'asset/')) {
                Storage::disk('public')->delete($certification->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('sertifikasi', 'public');
        } else {
            unset($data['gambar']);
        }

        $certification->update($data);

        return response()->json(['success' => true, 'message' => 'Sertifikasi berhasil diperbarui.', 'data' => $certification]);
    }

    public function destroy(Certification $certification)
    {
        if ($certification->gambar && !str_starts_with($certification->gambar, 'asset/')) {
            Storage::disk('public')->delete($certification->gambar);
        }
        $certification->delete();
        return response()->json(['success' => true, 'message' => 'Sertifikasi berhasil dihapus.']);
    }

    public function toggle(Certification $certification)
    {
        $certification->update(['aktif' => !$certification->aktif]);
        $label = $certification->aktif ? 'diaktifkan' : 'dinonaktifkan';
        return response()->json(['success' => true, 'message' => "Sertifikasi berhasil {$label}.", 'aktif' => $certification->aktif]);
    }

    private function extractTranslations(Request $request): array
    {
        $locales = Language::aktif()->where('code', '!=', 'id')->pluck('code');
        $trans   = [];
        foreach ($locales as $locale) {
            $judul = $request->input("trans.{$locale}.judul", '');
            if ($judul !== '') {
                $trans[$locale]['judul'] = $judul;
            }
        }
        return $trans;
    }
}
