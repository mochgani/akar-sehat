<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonis = Testimonial::orderBy('urutan')->get();
        $languages  = Language::aktif()->get();
        return view('admin.testimoni.index', compact('testimonis', 'languages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'    => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'rating'  => 'required|numeric|min:1|max:5',
            'isi'     => 'required|string',
            'inisial' => 'nullable|string|max:4',
            'warna'   => 'nullable|string|max:20',
            'aktif'   => 'nullable|boolean',
            'urutan'  => 'nullable|integer',
            'foto'    => 'nullable|image|max:2048',
        ]);

        $data['aktif']        = $request->boolean('aktif', true);
        $data['urutan']       = $request->input('urutan', Testimonial::max('urutan') + 1);
        $data['translations'] = $this->extractTranslations($request, ['nama', 'jabatan', 'isi']);

        if (empty($data['inisial'])) {
            $words = explode(' ', trim($data['nama']));
            $data['inisial'] = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
        }

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('testimoni', 'public');
        }

        Testimonial::create($data);
        return back()->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate([
            'nama'    => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'rating'  => 'required|numeric|min:1|max:5',
            'isi'     => 'required|string',
            'inisial' => 'nullable|string|max:4',
            'warna'   => 'nullable|string|max:20',
            'aktif'   => 'nullable|boolean',
            'urutan'  => 'nullable|integer',
            'foto'    => 'nullable|image|max:2048',
        ]);

        $data['aktif']        = $request->boolean('aktif', true);
        $data['translations'] = $this->extractTranslations($request, ['nama', 'jabatan', 'isi']);

        if (empty($data['inisial'])) {
            $words = explode(' ', trim($data['nama']));
            $data['inisial'] = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
        }

        if ($request->hasFile('foto')) {
            if ($testimonial->foto) Storage::disk('public')->delete($testimonial->foto);
            $data['foto'] = $request->file('foto')->store('testimoni', 'public');
        }

        $testimonial->update($data);
        return back()->with('success', 'Testimoni berhasil diperbarui.');
    }

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

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->foto) Storage::disk('public')->delete($testimonial->foto);
        $testimonial->delete();
        return back()->with('success', 'Testimoni berhasil dihapus.');
    }

    public function toggleAktif(Testimonial $testimonial)
    {
        $testimonial->update(['aktif' => !$testimonial->aktif]);
        return back()->with('success', 'Status testimoni diperbarui.');
    }
}
