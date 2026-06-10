@extends('layouts.admin')

@section('title', 'Statistik')
@section('breadcrumb')
  <span class="cur">Statistik</span>
@endsection

@section('content')
<div class="pg-hd">
  <div><h1>Laporan & Statistik</h1><p>Ringkasan performa website dan operasional</p></div>
</div>

<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:24px">
  <!-- KONSULTASI PER STATUS -->
  <div class="card">
    <div class="card-hd"><h3>Status Konsultasi</h3></div>
    <div class="card-body">
      @php
        $total = $stats['konsultasi_per_status']->sum();
        $statusLabels = ['baru' => ['Baru','#3b82f6'], 'diproses' => ['Diproses','#f59e0b'], 'selesai' => ['Selesai','#22c55e'], 'dibatalkan' => ['Dibatalkan','#ef4444']];
      @endphp
      @foreach($statusLabels as $key => [$label, $color])
      @php $val = $stats['konsultasi_per_status'][$key] ?? 0; $pct = $total > 0 ? round($val/$total*100) : 0; @endphp
      <div style="margin-bottom:12px">
        <div style="display:flex;justify-content:space-between;font-size:12.5px;margin-bottom:4px">
          <span style="color:var(--ctm)">{{ $label }}</span>
          <span style="font-weight:600">{{ $val }} <span style="color:var(--cmt);font-weight:400">({{ $pct }}%)</span></span>
        </div>
        <div style="height:6px;background:var(--cbg);border-radius:99px">
          <div style="height:100%;background:{{ $color }};border-radius:99px;width:{{ $pct }}%;transition:.5s ease"></div>
        </div>
      </div>
      @endforeach
      <div style="font-size:12px;color:var(--cmt);margin-top:14px;text-align:right">Total: <strong>{{ $total }}</strong></div>
    </div>
  </div>

  <!-- PRODUK PER KATEGORI -->
  <div class="card">
    <div class="card-hd"><h3>Produk per Kategori</h3></div>
    <div class="card-body">
      @php $maxProd = $stats['produk_per_kategori']->max() ?: 1; @endphp
      @foreach($stats['produk_per_kategori'] as $kat => $jml)
      <div style="margin-bottom:10px">
        <div style="display:flex;justify-content:space-between;font-size:12.5px;margin-bottom:4px">
          <span>{{ $kat }}</span>
          <span style="font-weight:600">{{ $jml }}</span>
        </div>
        <div style="height:5px;background:var(--cbg);border-radius:99px">
          <div style="height:100%;background:var(--cp);border-radius:99px;width:{{ round($jml/$maxProd*100) }}%"></div>
        </div>
      </div>
      @endforeach
    </div>
  </div>

  <!-- ARTIKEL PER STATUS -->
  <div class="card">
    <div class="card-hd"><h3>Status Artikel</h3></div>
    <div class="card-body">
      @php $artLabels = ['terbit' => ['Terbit','#22c55e'], 'draft' => ['Draft','#6b7280'], 'review' => ['Review','#f59e0b'], 'arsip' => ['Arsip','#9ca3af']]; @endphp
      @foreach($artLabels as $key => [$label, $color])
      @php $val = $stats['artikel_per_status'][$key] ?? 0; @endphp
      <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--cbg)">
        <div style="display:flex;align-items:center;gap:8px">
          <div style="width:10px;height:10px;border-radius:50%;background:{{ $color }}"></div>
          <span style="font-size:13px">{{ $label }}</span>
        </div>
        <span style="font-weight:700;font-size:15px">{{ $val }}</span>
      </div>
      @endforeach
    </div>
  </div>
</div>

<!-- ARTIKEL TERPOPULER -->
<div class="card">
  <div class="card-hd"><h3>Artikel Terpopuler</h3></div>
  <div class="tbl-wrap">
    <table>
      <thead><tr><th>#</th><th>Judul</th><th>Kategori</th><th>Penulis</th><th>Views</th><th>Waktu Baca</th></tr></thead>
      <tbody>
        @forelse($stats['top_articles'] as $i => $a)
        <tr>
          <td style="font-size:14px;font-weight:700;color:{{ $i===0?'#f59e0b':($i===1?'#9ca3af':($i===2?'#cd7c2e':'var(--cmt)')) }}">{{ $i+1 }}</td>
          <td style="font-weight:600;font-size:13px">{{ Str::limit($a->judul, 70) }}</td>
          <td style="font-size:12.5px;color:var(--cmt)">{{ $a->kategori ?? '—' }}</td>
          <td style="font-size:12.5px">{{ $a->penulis ?? '—' }}</td>
          <td>
            <div style="display:flex;align-items:center;gap:8px">
              <div style="width:80px;height:5px;background:var(--cbg);border-radius:99px">
                @php $maxV = $stats['top_articles']->max('views') ?: 1; @endphp
                <div style="height:100%;background:var(--cp);border-radius:99px;width:{{ round($a->views/$maxV*100) }}%"></div>
              </div>
              <span style="font-weight:700">{{ number_format($a->views) }}</span>
            </div>
          </td>
          <td style="font-size:12.5px;color:var(--cmt)">{{ $a->read_time }} mnt</td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;padding:32px;color:var(--cmt)">Belum ada data artikel</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
