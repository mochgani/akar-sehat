<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::orderBy('urutan')->get();
        return view('admin.bahasa.index', compact('languages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'        => 'required|string|max:10|unique:languages,code',
            'name'        => 'required|string|max:100',
            'native_name' => 'required|string|max:100',
            'dir'         => 'required|in:ltr,rtl',
            'flag'        => 'nullable|string|max:10',
            'urutan'      => 'nullable|integer|min:0',
        ]);

        $data['aktif']      = true;
        $data['is_default'] = false;
        $data['urutan']     = $data['urutan'] ?? (Language::max('urutan') + 1);

        Language::create($data);
        return response()->json(['success' => true, 'message' => 'Bahasa berhasil ditambahkan.']);
    }

    public function update(Request $request, Language $language)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'native_name' => 'required|string|max:100',
            'dir'         => 'required|in:ltr,rtl',
            'flag'        => 'nullable|string|max:10',
            'urutan'      => 'nullable|integer|min:0',
        ]);

        $language->update($data);
        return response()->json(['success' => true, 'message' => 'Bahasa berhasil diperbarui.']);
    }

    public function destroy(Language $language)
    {
        if ($language->is_default) {
            return response()->json(['success' => false, 'message' => 'Bahasa default tidak dapat dihapus. Pilih bahasa default lain terlebih dahulu.'], 422);
        }
        if ($language->code === 'id') {
            return response()->json(['success' => false, 'message' => 'Bahasa Indonesia adalah fallback dan tidak dapat dihapus.'], 422);
        }
        $language->delete();
        return response()->json(['success' => true, 'message' => 'Bahasa berhasil dihapus.']);
    }

    public function toggle(Language $language)
    {
        if ($language->is_default) {
            return response()->json(['success' => false, 'message' => 'Bahasa default tidak dapat dinonaktifkan. Pilih bahasa default lain terlebih dahulu.'], 422);
        }
        if ($language->code === 'id' && $language->aktif) {
            return response()->json(['success' => false, 'message' => 'Bahasa Indonesia adalah fallback dan harus tetap aktif.'], 422);
        }
        $language->update(['aktif' => !$language->aktif]);
        $status = $language->fresh()->aktif ? 'diaktifkan' : 'dinonaktifkan';
        return response()->json(['success' => true, 'message' => "Bahasa berhasil {$status}."]);
    }

    public function setDefault(Language $language)
    {
        if (!$language->aktif) {
            return response()->json(['success' => false, 'message' => 'Bahasa harus aktif terlebih dahulu sebelum dijadikan default.'], 422);
        }

        Language::where('is_default', true)->update(['is_default' => false]);
        $language->update(['is_default' => true]);

        return response()->json(['success' => true, 'message' => "{$language->native_name} dijadikan bahasa default frontend."]);
    }
}
