@extends('layouts.admin')

@section('title', 'Dashboard')
@section('breadcrumb')<span class="cur">Dashboard</span>@endsection

@section('content')
<div class="pg-hd">
  <div>
    <h1>Dashboard</h1>
    <p>Selamat datang, {{ auth()->user()->name }}. Berikut ringkasan hari ini.</p>
  </div>
  <div class="pg-hd-acts">
    <a href="{{ route('admin.konsultasi.index') }}" class="btn btn-primary">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
      Lihat Konsultasi
    </a>
  </div>
</div>

<!-- KPI CARDS -->
<div class="kpi-grid">
  <div class="kpi">
    <div class="kpi-icon" style="background:rgba(59,130,246,.12)">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
    </div>
    <div>
      <div class="kpi-val">{{ $stats['konsultasi_baru'] }}</div>
      <div class="kpi-label">Konsultasi Baru</div>
      <div class="kpi-trend" style="color:#3b82f6">Total: {{ $stats['konsultasi_total'] }}</div>
    </div>
  </div>
  <div class="kpi">
    <div class="kpi-icon" style="background:rgba(200,106,68,.12)">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C86A44" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>
    </div>
    <div>
      <div class="kpi-val">{{ $stats['produk_aktif'] }}</div>
      <div class="kpi-label">Produk Tersedia</div>
      <div class="kpi-trend" style="color:{{ $stats['stok_menipis'] > 0 ? '#f59e0b' : '#22c55e' }}">
        {{ $stats['stok_menipis'] > 0 ? $stats['stok_menipis'] . ' stok menipis' : 'Stok aman' }}
      </div>
    </div>
  </div>
  <div class="kpi">
    <div class="kpi-icon" style="background:rgba(34,197,94,.12)">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
    </div>
    <div>
      <div class="kpi-val">{{ $stats['artikel_terbit'] }}</div>
      <div class="kpi-label">Artikel Terbit</div>
      <div class="kpi-trend" style="color:#22c55e">Total: {{ $stats['artikel_total'] }}</div>
    </div>
  </div>
  <div class="kpi">
    <div class="kpi-icon" style="background:rgba(139,92,246,.12)">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
    </div>
    <div>
      <div class="kpi-val">{{ $stats['users_total'] }}</div>
      <div class="kpi-label">Pengguna Aktif</div>
      <div class="kpi-trend" style="color:#8b5cf6">Admin Panel</div>
    </div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px">
  <!-- KONSULTASI TERBARU -->
  <div class="card">
    <div class="card-hd">
      <h3>Konsultasi Terbaru</h3>
      <a href="{{ route('admin.konsultasi.index') }}" class="btn btn-outline btn-sm">Lihat Semua</a>
    </div>
    <div class="tbl-wrap">
      <table>
        <thead><tr><th>Nama</th><th>Keluhan</th><th>Status</th><th>Tanggal</th></tr></thead>
        <tbody>
          @forelse($recentConsultations as $c)
          <tr>
            <td>
              <div style="font-weight:600;font-size:13px">{{ $c->nama }}</div>
              <div style="color:var(--cmt);font-size:11.5px">{{ $c->kontak }}</div>
            </td>
            <td style="max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-size:12.5px;color:var(--cmt)">{{ Str::limit($c->keluhan, 50) }}</td>
            <td><span class="badge s-{{ $c->status }}">{{ ucfirst($c->status) }}</span></td>
            <td style="font-size:12px;color:var(--cmt);white-space:nowrap">{{ $c->created_at->format('d M Y') }}</td>
          </tr>
          @empty
          <tr><td colspan="4" style="text-align:center;color:var(--cmt);padding:24px">Belum ada konsultasi</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- PRODUK STOK MENIPIS -->
  <div class="card">
    <div class="card-hd">
      <h3>Perhatian Stok</h3>
      <a href="{{ route('admin.produk.index') }}" class="btn btn-outline btn-sm">Kelola Produk</a>
    </div>
    <div class="card-body">
      @forelse($lowStockProducts as $p)
      <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--cbg)">
        <div>
          <div style="font-weight:600;font-size:13px">{{ $p->nama }}</div>
          <div style="font-size:12px;color:var(--cmt)">{{ $p->sku }}</div>
        </div>
        <div style="text-align:right">
          <div style="font-weight:700;font-size:15px;color:{{ $p->stok === 0 ? '#ef4444' : '#f59e0b' }}">{{ $p->stok }}</div>
          <span class="badge {{ $p->status === 'habis' ? 's-habis' : 's-hampir' }}" style="font-size:10.5px">{{ ucfirst($p->status) }}</span>
        </div>
      </div>
      @empty
      <div style="text-align:center;padding:32px 0;color:var(--cmt)">
        <div style="font-size:32px;margin-bottom:8px">✅</div>
        <div style="font-size:13px">Semua stok produk aman</div>
      </div>
      @endforelse
    </div>
  </div>
</div>

<!-- ARTIKEL TERBARU -->
<div class="card">
  <div class="card-hd">
    <h3>Artikel Terbaru</h3>
    <a href="{{ route('admin.artikel.index') }}" class="btn btn-outline btn-sm">Kelola Artikel</a>
  </div>
  <div class="tbl-wrap">
    <table>
      <thead><tr><th>Judul</th><th>Kategori</th><th>Penulis</th><th>Status</th><th>Tanggal</th><th>Views</th></tr></thead>
      <tbody>
        @forelse($recentArticles as $a)
        <tr>
          <td style="font-weight:600;font-size:13px;max-width:260px">{{ Str::limit($a->judul, 60) }}</td>
          <td style="font-size:12.5px;color:var(--cmt)">{{ $a->kategori ?? '—' }}</td>
          <td style="font-size:12.5px">{{ $a->penulis ?? '—' }}</td>
          <td><span class="badge s-{{ $a->status }}">{{ ucfirst($a->status) }}</span></td>
          <td style="font-size:12px;color:var(--cmt);white-space:nowrap">{{ $a->created_at->format('d M Y') }}</td>
          <td style="font-size:13px;font-weight:600">{{ number_format($a->views) }}</td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;color:var(--cmt);padding:24px">Belum ada artikel</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
