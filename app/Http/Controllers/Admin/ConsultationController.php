<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        $query = Consultation::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('kontak', 'like', "%{$search}%")
                  ->orWhere('keluhan', 'like', "%{$search}%");
            });
        }
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        if ($sumber = $request->input('sumber')) {
            $query->where('sumber', $sumber);
        }
        if ($from = $request->input('dari')) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to = $request->input('sampai')) {
            $query->whereDate('created_at', '<=', $to);
        }

        $consultations = $query->latest()->paginate(10)->withQueryString();
        return view('admin.konsultasi.index', compact('consultations'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'      => 'required|string|max:100',
            'kontak'    => 'required|string|max:20',
            'keluhan'   => 'required|string',
            'sumber'    => 'required|in:whatsapp,website,referral,langsung',
            'prioritas' => 'required|in:normal,tinggi,urgent',
            'catatan'   => 'nullable|string',
        ]);

        $data['status']  = 'baru';
        $data['history'] = [['status' => 'baru', 'catatan' => 'Konsultasi masuk', 'waktu' => now()->format('Y-m-d H:i')]];

        Consultation::create($data);
        return response()->json(['success' => true, 'message' => 'Konsultasi berhasil ditambahkan.']);
    }

    public function update(Request $request, Consultation $consultation)
    {
        $data = $request->validate([
            'nama'      => 'required|string|max:100',
            'kontak'    => 'required|string|max:20',
            'keluhan'   => 'required|string',
            'status'    => 'required|in:baru,diproses,selesai,dibatalkan',
            'sumber'    => 'required|in:whatsapp,website,referral,langsung',
            'prioritas' => 'required|in:normal,tinggi,urgent',
            'catatan'   => 'nullable|string',
        ]);

        if ($data['status'] !== $consultation->status) {
            $consultation->addHistory($data['status'], $data['catatan'] ?? '');
            $data['history'] = $consultation->history;
        }

        $consultation->update($data);
        return response()->json(['success' => true, 'message' => 'Konsultasi berhasil diperbarui.']);
    }

    public function destroy(Consultation $consultation)
    {
        $consultation->delete();
        return response()->json(['success' => true, 'message' => 'Konsultasi berhasil dihapus.']);
    }

    public function bulkUpdate(Request $request)
    {
        $data = $request->validate([
            'ids'    => 'required|array',
            'ids.*'  => 'integer',
            'status' => 'required|in:baru,diproses,selesai,dibatalkan',
        ]);

        Consultation::whereIn('id', $data['ids'])->each(function ($c) use ($data) {
            $c->addHistory($data['status'], 'Diubah massal');
            $c->status = $data['status'];
            $c->save();
        });

        return response()->json(['success' => true, 'message' => count($data['ids']) . ' konsultasi diperbarui.']);
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->validate(['ids' => 'required|array', 'ids.*' => 'integer'])['ids'];
        Consultation::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => count($ids) . ' konsultasi dihapus.']);
    }
}
