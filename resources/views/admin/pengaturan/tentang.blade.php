@extends('layouts.admin')

@section('title', 'Pengaturan Halaman Tentang')
@section('breadcrumb')
  <a href="{{ route('admin.pengaturan.index') }}">Pengaturan</a>
  <span class="sep">/</span><span class="cur">Tentang</span>
@endsection

@push('styles')
<style>
.lang-tabs { display:flex; gap:4px; border-bottom:2px solid var(--cms); margin-bottom:16px; flex-wrap:wrap; }
.lang-tab { padding:7px 16px; font-size:13px; font-weight:600; cursor:pointer; border:none; background:none; color:var(--cmt); border-bottom:2px solid transparent; margin-bottom:-2px; border-radius:4px 4px 0 0; transition:all .15s; }
.lang-tab:hover { color:var(--ctm); background:var(--cbg); }
.lang-tab.active { color:var(--cp); border-bottom-color:var(--cp); background:var(--cpl); }
.lang-pane { display:none; }
.lang-pane.active { display:block; }
.sub-head { font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:var(--cp); margin:18px 0 10px; padding-top:14px; border-top:1px dashed var(--cms); }
.sub-head:first-child { margin-top:0; padding-top:0; border-top:none; }

/* Tab antar-section */
.sec-tabs { display:flex; gap:6px; flex-wrap:wrap; margin-bottom:18px; }
.sec-tab { padding:9px 15px; font-size:13px; font-weight:600; cursor:pointer; border:1px solid var(--cms); background:var(--cw); color:var(--cmt); border-radius:var(--rr); transition:all .15s; }
.sec-tab:hover { color:var(--ctm); border-color:var(--cp); }
.sec-tab.active { background:var(--cp); color:#fff; border-color:var(--cp); }
.sec-card { display:none; }
.sec-card.active { display:block; }

/* Editor WYSIWYG */
.rich-wrap { border:1px solid var(--cms); border-radius:var(--r1); overflow:hidden; background:var(--cw); }
.rich-tb { display:flex; gap:2px; flex-wrap:wrap; padding:6px; background:var(--cbg); border-bottom:1px solid var(--cms); }
.rich-tb button { height:26px; min-width:26px; padding:0 7px; border:1px solid var(--cms); background:var(--cw); border-radius:4px; cursor:pointer; font-size:12px; color:var(--ctm); display:inline-flex; align-items:center; justify-content:center; }
.rich-tb button:hover { background:var(--cpl); border-color:var(--cp); color:var(--cp); }
.rich-tb .sep { width:1px; background:var(--cms); margin:2px 3px; }
.rich-area { padding:10px 12px; min-height:80px; font-size:13.5px; line-height:1.7; outline:none; color:var(--ctm); }
.rich-area[dir="rtl"] { text-align:right; }
.rich-area:empty:before { content:attr(data-ph); color:var(--cmt); }
.rich-area p { margin:0 0 8px; }
.rich-area h3 { font-size:15px; font-weight:600; margin:10px 0 6px; }
.rich-area ul, .rich-area ol { margin:0 0 8px; padding-inline-start:24px; }
.rich-area ul { list-style:disc; } .rich-area ol { list-style:decimal; }
.rich-area li { margin-bottom:3px; display:list-item; }
</style>
@endpush

@section('content')
<div class="pg-hd">
  <div><h1>Pengaturan Halaman Tentang</h1><p>Semua teks di halaman Tentang dapat diedit & diterjemahkan ke 3 bahasa. Gunakan tab bahasa di setiap kartu.</p></div>
  <div style="display:flex;gap:8px">
    <a href="{{ route('tentang') }}" target="_blank" class="btn btn-outline">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
      Lihat Halaman
    </a>
    <a href="{{ route('admin.pengaturan.index') }}" class="btn btn-outline">Kembali</a>
  </div>
</div>

@if(session('success'))
<div style="background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#16a34a;padding:12px 16px;border-radius:8px;margin-bottom:16px">
  ✓ {{ session('success') }}
</div>
@endif

@php
  // ── Konfigurasi seluruh field per kartu ──
  // type: text | area | list  (list = textarea satu poin per baris)
  // head: judul sub-bagian
  $sections = [
    'hero' => ['icon' => '🌿', 'title' => 'Hero / Banner', 'fields' => [
      ['head' => 'Teks Utama'],
      ['key' => 'hero_badge', 'label' => 'Badge / Label Hero', 'type' => 'text'],
      ['key' => 'hero_title', 'label' => 'Judul Hero (H1)', 'type' => 'text'],
      ['key' => 'hero_desc',  'label' => 'Deskripsi Hero', 'type' => 'area'],
      ['head' => 'Statistik (4 angka)'],
      ['key' => 'hero_stat1_val', 'label' => 'Statistik 1 — Angka', 'type' => 'text'],
      ['key' => 'hero_stat1_label', 'label' => 'Statistik 1 — Label', 'type' => 'text'],
      ['key' => 'hero_stat2_val', 'label' => 'Statistik 2 — Angka', 'type' => 'text'],
      ['key' => 'hero_stat2_label', 'label' => 'Statistik 2 — Label', 'type' => 'text'],
      ['key' => 'hero_stat3_val', 'label' => 'Statistik 3 — Angka', 'type' => 'text'],
      ['key' => 'hero_stat3_label', 'label' => 'Statistik 3 — Label', 'type' => 'text'],
      ['key' => 'hero_stat4_val', 'label' => 'Statistik 4 — Angka', 'type' => 'text'],
      ['key' => 'hero_stat4_label', 'label' => 'Statistik 4 — Label', 'type' => 'text'],
    ]],
    'intro' => ['icon' => '🧭', 'title' => 'Siapa Kami', 'fields' => [
      ['head' => 'Teks Pengantar'],
      ['key' => 'intro_label', 'label' => 'Label Kecil', 'type' => 'text'],
      ['key' => 'intro_title', 'label' => 'Judul (H2)', 'type' => 'text'],
      ['key' => 'intro_p1', 'label' => 'Paragraf 1', 'type' => 'area'],
      ['key' => 'intro_p2', 'label' => 'Paragraf 2', 'type' => 'area'],
      ['key' => 'intro_p3', 'label' => 'Paragraf 3', 'type' => 'area'],
      ['head' => 'Kartu Nilai (4)'],
      ['key' => 'value1_title', 'label' => 'Nilai 1 — Judul', 'type' => 'text'],
      ['key' => 'value1_desc', 'label' => 'Nilai 1 — Deskripsi', 'type' => 'area'],
      ['key' => 'value2_title', 'label' => 'Nilai 2 — Judul', 'type' => 'text'],
      ['key' => 'value2_desc', 'label' => 'Nilai 2 — Deskripsi', 'type' => 'area'],
      ['key' => 'value3_title', 'label' => 'Nilai 3 — Judul', 'type' => 'text'],
      ['key' => 'value3_desc', 'label' => 'Nilai 3 — Deskripsi', 'type' => 'area'],
      ['key' => 'value4_title', 'label' => 'Nilai 4 — Judul', 'type' => 'text'],
      ['key' => 'value4_desc', 'label' => 'Nilai 4 — Deskripsi', 'type' => 'area'],
    ]],
    'vm' => ['icon' => '🎯', 'title' => 'Visi & Misi', 'fields' => [
      ['key' => 'vm_title', 'label' => 'Judul Bagian', 'type' => 'text'],
      ['key' => 'vm_desc', 'label' => 'Deskripsi Bagian', 'type' => 'area'],
      ['key' => 'visi_label', 'label' => 'Label Badge Visi', 'type' => 'text'],
      ['key' => 'visi', 'label' => 'Isi Visi', 'type' => 'area'],
      ['key' => 'misi_label', 'label' => 'Label Badge Misi', 'type' => 'text'],
      ['key' => 'misi_heading', 'label' => 'Judul di atas daftar Misi', 'type' => 'text'],
      ['key' => 'misi', 'label' => 'Daftar Misi', 'type' => 'list', 'hint' => 'Satu poin misi per baris.'],
    ]],
    'profil' => ['icon' => '👤', 'title' => 'Profil Pendiri', 'fields' => [
      ['head' => 'Judul Bagian'],
      ['key' => 'profil_section_label', 'label' => 'Label Atas (mis. Tentang Pendiri)', 'type' => 'text'],
      ['key' => 'profil_section_title', 'label' => 'Judul Bagian (mis. Mengenal Kang Bahri)', 'type' => 'text'],
      ['head' => 'Identitas'],
      ['key' => 'profil_inner_label', 'label' => 'Label "Profil Lengkap"', 'type' => 'text'],
      ['key' => 'profil_nama', 'label' => 'Nama Lengkap', 'type' => 'text'],
      ['key' => 'profil_gelar', 'label' => 'Gelar / Jabatan', 'type' => 'text'],
      ['key' => 'profil_bio', 'label' => 'Bio / Deskripsi', 'type' => 'area', 'rows' => 8, 'hint' => 'Pisahkan paragraf dengan baris kosong.'],
      ['head' => 'Sertifikat / Badge'],
      ['key' => 'cert1', 'label' => 'Sertifikat 1', 'type' => 'text'],
      ['key' => 'cert2', 'label' => 'Sertifikat 2', 'type' => 'text'],
      ['key' => 'cert3', 'label' => 'Sertifikat 3', 'type' => 'text'],
      ['head' => 'Statistik Profil (3)'],
      ['key' => 'profil_stat1_val', 'label' => 'Statistik 1 — Angka', 'type' => 'text'],
      ['key' => 'profil_stat1_label', 'label' => 'Statistik 1 — Label', 'type' => 'text'],
      ['key' => 'profil_stat2_val', 'label' => 'Statistik 2 — Angka', 'type' => 'text'],
      ['key' => 'profil_stat2_label', 'label' => 'Statistik 2 — Label', 'type' => 'text'],
      ['key' => 'profil_stat3_val', 'label' => 'Statistik 3 — Angka', 'type' => 'text'],
      ['key' => 'profil_stat3_label', 'label' => 'Statistik 3 — Label', 'type' => 'text'],
      ['head' => 'Area Keahlian'],
      ['key' => 'keahlian_title', 'label' => 'Judul "Area Keahlian"', 'type' => 'text'],
      ['key' => 'keahlian_tags', 'label' => 'Tag Keahlian', 'type' => 'list', 'hint' => 'Satu tag per baris.'],
    ]],
    'journey' => ['icon' => '🛤️', 'title' => 'Perjalanan Kang Bahri', 'fields' => [
      ['head' => 'Judul Bagian'],
      ['key' => 'journey_title', 'label' => 'Judul', 'type' => 'text'],
      ['key' => 'journey_desc', 'label' => 'Deskripsi', 'type' => 'area'],
      ['head' => 'Timeline 1'],
      ['key' => 'tl1_year', 'label' => 'Tahun / Tahap', 'type' => 'text'],
      ['key' => 'tl1_title', 'label' => 'Judul', 'type' => 'text'],
      ['key' => 'tl1_desc', 'label' => 'Deskripsi', 'type' => 'area'],
      ['head' => 'Timeline 2'],
      ['key' => 'tl2_year', 'label' => 'Tahun / Tahap', 'type' => 'text'],
      ['key' => 'tl2_title', 'label' => 'Judul', 'type' => 'text'],
      ['key' => 'tl2_desc', 'label' => 'Deskripsi', 'type' => 'area'],
      ['head' => 'Timeline 3'],
      ['key' => 'tl3_year', 'label' => 'Tahun / Tahap', 'type' => 'text'],
      ['key' => 'tl3_title', 'label' => 'Judul', 'type' => 'text'],
      ['key' => 'tl3_desc', 'label' => 'Deskripsi', 'type' => 'area'],
      ['head' => 'Timeline 4'],
      ['key' => 'tl4_year', 'label' => 'Tahun / Tahap', 'type' => 'text'],
      ['key' => 'tl4_title', 'label' => 'Judul', 'type' => 'text'],
      ['key' => 'tl4_desc', 'label' => 'Deskripsi', 'type' => 'area'],
      ['head' => 'Timeline 5'],
      ['key' => 'tl5_year', 'label' => 'Tahun / Tahap', 'type' => 'text'],
      ['key' => 'tl5_title', 'label' => 'Judul', 'type' => 'text'],
      ['key' => 'tl5_desc', 'label' => 'Deskripsi', 'type' => 'area'],
      ['head' => 'Timeline 6'],
      ['key' => 'tl6_year', 'label' => 'Tahun / Tahap', 'type' => 'text'],
      ['key' => 'tl6_title', 'label' => 'Judul', 'type' => 'text'],
      ['key' => 'tl6_desc', 'label' => 'Deskripsi', 'type' => 'area'],
      ['head' => 'Timeline 7'],
      ['key' => 'tl7_year', 'label' => 'Tahun / Tahap', 'type' => 'text'],
      ['key' => 'tl7_title', 'label' => 'Judul', 'type' => 'text'],
      ['key' => 'tl7_desc', 'label' => 'Deskripsi', 'type' => 'area'],
    ]],
    'ck' => ['icon' => '🔄', 'title' => 'Proses Pendampingan', 'fields' => [
      ['head' => 'Judul Bagian'],
      ['key' => 'ck_label', 'label' => 'Label Kecil', 'type' => 'text'],
      ['key' => 'ck_title', 'label' => 'Judul (H2)', 'type' => 'text'],
      ['key' => 'ck_desc', 'label' => 'Deskripsi', 'type' => 'area'],
      ['head' => 'Langkah (5)'],
      ['key' => 'step1_title', 'label' => 'Langkah 1 — Judul', 'type' => 'text'],
      ['key' => 'step1_desc', 'label' => 'Langkah 1 — Deskripsi', 'type' => 'area'],
      ['key' => 'step2_title', 'label' => 'Langkah 2 — Judul', 'type' => 'text'],
      ['key' => 'step2_desc', 'label' => 'Langkah 2 — Deskripsi', 'type' => 'area'],
      ['key' => 'step3_title', 'label' => 'Langkah 3 — Judul', 'type' => 'text'],
      ['key' => 'step3_desc', 'label' => 'Langkah 3 — Deskripsi', 'type' => 'area'],
      ['key' => 'step4_title', 'label' => 'Langkah 4 — Judul', 'type' => 'text'],
      ['key' => 'step4_desc', 'label' => 'Langkah 4 — Deskripsi', 'type' => 'area'],
      ['key' => 'step5_title', 'label' => 'Langkah 5 — Judul', 'type' => 'text'],
      ['key' => 'step5_desc', 'label' => 'Langkah 5 — Deskripsi', 'type' => 'area'],
      ['head' => 'Kartu Detail 1'],
      ['key' => 'ckd1_title', 'label' => 'Judul', 'type' => 'text'],
      ['key' => 'ckd1_intro', 'label' => 'Pengantar', 'type' => 'area'],
      ['key' => 'ckd1_list', 'label' => 'Daftar Poin', 'type' => 'list', 'hint' => 'Satu poin per baris.'],
      ['head' => 'Kartu Detail 2'],
      ['key' => 'ckd2_title', 'label' => 'Judul', 'type' => 'text'],
      ['key' => 'ckd2_intro', 'label' => 'Pengantar', 'type' => 'area'],
      ['key' => 'ckd2_list', 'label' => 'Daftar Poin', 'type' => 'list', 'hint' => 'Satu poin per baris.'],
      ['head' => 'Kartu Detail 3'],
      ['key' => 'ckd3_title', 'label' => 'Judul', 'type' => 'text'],
      ['key' => 'ckd3_intro', 'label' => 'Pengantar', 'type' => 'area'],
      ['key' => 'ckd3_list', 'label' => 'Daftar Poin', 'type' => 'list', 'hint' => 'Satu poin per baris.'],
    ]],
    'cta' => ['icon' => '📣', 'title' => 'CTA & Banner Produk', 'fields' => [
      ['head' => 'CTA Konsultasi'],
      ['key' => 'cta_label', 'label' => 'Label Kecil', 'type' => 'text'],
      ['key' => 'cta_title', 'label' => 'Judul (H2)', 'type' => 'text'],
      ['key' => 'cta_desc', 'label' => 'Deskripsi', 'type' => 'area'],
      ['key' => 'cta_btn', 'label' => 'Teks Tombol WhatsApp', 'type' => 'text'],
      ['key' => 'cta_note', 'label' => 'Catatan Kecil di bawah tombol', 'type' => 'text'],
      ['head' => 'Banner Produk'],
      ['key' => 'banner_title', 'label' => 'Judul Banner', 'type' => 'text'],
      ['key' => 'banner_desc', 'label' => 'Deskripsi Banner', 'type' => 'area'],
      ['key' => 'banner_btn', 'label' => 'Teks Tombol', 'type' => 'text'],
    ]],
  ];
@endphp

<form method="POST" action="{{ route('admin.pengaturan.tentang.save') }}" enctype="multipart/form-data">
  @csrf

  {{-- Tab antar-section --}}
  <div class="sec-tabs">
    @foreach($sections as $sid => $sec)
    <button type="button" class="sec-tab {{ $loop->first ? 'active' : '' }}" onclick="switchSection('{{ $sid }}', this)">{{ $sec['icon'] }} {{ $sec['title'] }}</button>
    @endforeach
  </div>

  {{-- Foto Profil (locale-independent) — bagian dari section "profil" --}}
  <div class="card sec-card" data-sec="profil" style="margin-bottom:16px">
    <div class="card-hd"><h3>🖼️ Foto Profil Pendiri</h3></div>
    <div class="card-body">
      <div class="fg">
        <label class="fl">Foto Profil <span style="color:var(--cmt);font-size:11px;font-weight:400">(sama untuk semua bahasa)</span></label>
        <div style="display:flex;gap:16px;align-items:flex-start;flex-wrap:wrap">
          <div id="profil-foto-preview" style="width:130px;height:160px;border:2px dashed var(--cms);border-radius:8px;display:flex;align-items:center;justify-content:center;overflow:hidden;background:var(--cbg);flex-shrink:0">
            @if(!empty($settings['profil_foto']))
              <img src="{{ asset('storage/'.$settings['profil_foto']) }}" style="width:100%;height:100%;object-fit:cover;object-position:top">
            @else
              <img src="{{ asset('asset/profile/foto-kang-bahri-removebg-preview.png') }}" style="width:100%;height:100%;object-fit:cover;object-position:top" onerror="this.parentElement.innerHTML='<span style=\'font-size:32px;color:var(--cmt)\'>👤</span>'">
            @endif
          </div>
          <div style="flex:1;min-width:200px">
            <input type="file" name="profil_foto" accept="image/*" class="fc" onchange="previewImg(this,'profil-foto-preview')" style="padding:8px">
            <p style="font-size:11px;color:var(--cmt);margin-top:4px">Format: JPG/PNG/WEBP. Maks 2MB. Jika kosong, menggunakan foto default.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Semua kartu teks dirender dari konfigurasi $sections --}}
  @foreach($sections as $sid => $sec)
  <div class="card sec-card {{ $loop->first ? 'active' : '' }}" data-sec="{{ $sid }}" style="margin-bottom:16px">
    <div class="card-hd"><h3>{{ $sec['icon'] }} {{ $sec['title'] }}</h3></div>
    <div class="card-body">
      <div class="lang-tabs" id="{{ $sid }}-tabs">
        @foreach($languages as $lang)
        <button type="button" class="lang-tab {{ $loop->first ? 'active' : '' }}" onclick="switchTab('{{ $sid }}',this,'{{ $lang->code }}')">
          {{ $lang->flag }} {{ $lang->native_name }}
        </button>
        @endforeach
      </div>
      @foreach($languages as $lang)
      @php $loc = $lang->code; $d = $all[$loc] ?? []; $dId = $all['id'] ?? []; @endphp
      <div class="lang-pane {{ $loop->first ? 'active' : '' }}" id="{{ $sid }}-pane-{{ $loc }}" dir="{{ $lang->dir }}">
        @foreach($sec['fields'] as $f)
          @if(isset($f['head']))
            <div class="sub-head">{{ $f['head'] }}</div>
          @else
            @php $val = $d[$f['key']] ?? ($dId[$f['key']] ?? ''); @endphp
            <div class="fg">
              <label class="fl">{{ $f['label'] }}</label>
              @if($f['type'] === 'text')
                <input type="text" name="{{ $f['key'] }}[{{ $loc }}]" class="fc" value="{{ $val }}">
              @else
                <textarea name="{{ $f['key'] }}[{{ $loc }}]" class="js-rich" data-min="{{ $f['type'] === 'list' ? 110 : 80 }}" dir="{{ $lang->dir ?? 'ltr' }}">{{ $val }}</textarea>
              @endif
              @if(!empty($f['hint']))
                <p style="font-size:11px;color:var(--cmt);margin-top:4px">{{ $f['hint'] }}</p>
              @endif
            </div>
          @endif
        @endforeach
      </div>
      @endforeach
    </div>
  </div>
  @endforeach

  <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:8px;margin-bottom:24px">
    <a href="{{ route('admin.pengaturan.index') }}" class="btn btn-outline">Batal</a>
    <button type="submit" class="btn btn-primary">Simpan Semua Perubahan</button>
  </div>

</form>
@endsection

@push('scripts')
<script>
function switchTab(section, btn, locale) {
  document.querySelectorAll(`#${section}-tabs .lang-tab`).forEach(t => t.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll(`[id^="${section}-pane-"]`).forEach(p => p.classList.remove('active'));
  const pane = document.getElementById(`${section}-pane-${locale}`);
  if (pane) pane.classList.add('active');
}

function switchSection(sid, btn) {
  document.querySelectorAll('.sec-tab').forEach(t => t.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('.sec-card').forEach(c => c.classList.toggle('active', c.dataset.sec === sid));
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

/* ── Editor WYSIWYG ── */
let activeRich = null;
function richSaveRange() {
  const sel = window.getSelection();
  if (activeRich && sel.rangeCount && activeRich.contains(sel.anchorNode)) activeRich._range = sel.getRangeAt(0).cloneRange();
}
function richRestoreRange() {
  if (!activeRich) return null;
  activeRich.focus();
  const sel = window.getSelection();
  let range = activeRich._range;
  if (!range || !activeRich.contains(range.commonAncestorContainer)) {
    range = document.createRange(); range.selectNodeContents(activeRich); range.collapse(false);
  }
  sel.removeAllRanges(); sel.addRange(range); return range;
}
function richExec(cmd, val) {
  if (!activeRich) return;
  richRestoreRange();
  document.execCommand(cmd, false, val || null);
  activeRich.dispatchEvent(new Event('input')); richSaveRange();
}
function buildRichToolbar() {
  const b = (l, t, fn) => `<button type="button" title="${t}" onmousedown="event.preventDefault()" onclick="${fn}">${l}</button>`;
  return '<div class="rich-tb">'
    + b('<b>B</b>', 'Tebal', "richExec('bold')")
    + b('<i>I</i>', 'Miring', "richExec('italic')")
    + b('<u>U</u>', 'Garis bawah', "richExec('underline')")
    + '<span class="sep"></span>'
    + b('H', 'Sub-judul', "richExec('formatBlock','<h3>')")
    + b('¶', 'Paragraf', "richExec('formatBlock','<p>')")
    + b('•', 'Daftar', "richExec('insertUnorderedList')")
    + b('1.', 'Daftar nomor', "richExec('insertOrderedList')")
    + '</div>';
}
function mountRichEditor(ta) {
  if (ta.dataset.richMounted) return;
  ta.dataset.richMounted = '1';
  ta.style.display = 'none';
  const wrap = document.createElement('div');
  wrap.className = 'rich-wrap';
  wrap.innerHTML = buildRichToolbar();
  const area = document.createElement('div');
  area.className = 'rich-area';
  area.contentEditable = 'true';
  area.style.minHeight = (ta.dataset.min || 80) + 'px';
  if (ta.getAttribute('dir')) area.setAttribute('dir', ta.getAttribute('dir'));
  area.dataset.ph = 'Tulis di sini…';
  area.innerHTML = ta.value || '';
  wrap.appendChild(area);
  ta.parentNode.insertBefore(wrap, ta.nextSibling);
  ta._richArea = area;
  const sync = () => { ta.value = area.innerHTML; };
  area.addEventListener('input', () => { sync(); richSaveRange(); });
  area.addEventListener('focus', () => { activeRich = area; richSaveRange(); });
  area.addEventListener('keyup', richSaveRange);
  area.addEventListener('mouseup', richSaveRange);
}
function syncAllRich() {
  document.querySelectorAll('textarea.js-rich').forEach(ta => { if (ta._richArea) ta.value = ta._richArea.innerHTML; });
}
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('textarea.js-rich').forEach(mountRichEditor);
  const form = document.querySelector('form[action*="tentang"]');
  if (form) form.addEventListener('submit', syncAllRich);
});

async function previewImg(input, previewId) {
  if (!input.files || !input.files[0]) return;
  setLoading('Mengompresi gambar...');
  await compressInputFile(input);
  clearLoading();
  const preview = document.getElementById(previewId);
  const reader = new FileReader();
  reader.onload = e => {
    preview.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;object-position:top">`;
  };
  reader.readAsDataURL(input.files[0]);
}
</script>
@endpush
