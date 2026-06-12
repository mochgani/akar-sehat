@extends('layouts.admin')

@section('title', 'Pengaturan Halaman Tentang')
@section('breadcrumb')
  <a href="{{ route('admin.pengaturan.index') }}">Pengaturan</a>
  <span class="sep">/</span><span class="cur">Tentang</span>
@endsection

@push('styles')
<style>
.lang-tabs { display:flex; gap:4px; border-bottom:2px solid var(--cms); margin-bottom:16px; }
.lang-tab { padding:7px 16px; font-size:13px; font-weight:600; cursor:pointer; border:none; background:none; color:var(--cmt); border-bottom:2px solid transparent; margin-bottom:-2px; border-radius:4px 4px 0 0; transition:all .15s; }
.lang-tab:hover { color:var(--ctm); background:var(--cbg); }
.lang-tab.active { color:var(--cp); border-bottom-color:var(--cp); background:var(--cpl); }
.lang-pane { display:none; }
.lang-pane.active { display:block; }
</style>
@endpush

@section('content')
<div class="pg-hd">
  <div><h1>Pengaturan Halaman Tentang</h1><p>Edit konten hero, profil pendiri, visi misi dan foto. Gunakan tab bahasa untuk terjemahan.</p></div>
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

<form method="POST" action="{{ route('admin.pengaturan.tentang.save') }}" enctype="multipart/form-data">
  @csrf

  {{-- ============ HERO SECTION ============ --}}
  <div class="card" style="margin-bottom:16px">
    <div class="card-hd"><h3>🌿 Hero / Banner Halaman Tentang</h3></div>
    <div class="card-body">
      <div class="lang-tabs" id="hero-tabs">
        @foreach($languages as $lang)
        <button type="button" class="lang-tab {{ $loop->first ? 'active' : '' }}" onclick="switchTab('hero',this,'{{ $lang->code }}')">
          {{ $lang->flag }} {{ $lang->native_name }}
        </button>
        @endforeach
      </div>
      @foreach($languages as $lang)
      @php $loc = $lang->code; $d = $all[$loc] ?? []; $dId = $all['id'] ?? []; @endphp
      <div class="lang-pane {{ $loop->first ? 'active' : '' }}" id="hero-pane-{{ $loc }}" dir="{{ $lang->dir }}">
        <div class="fg"><label class="fl">Badge / Label Hero</label>
          <input type="text" name="hero_badge[{{ $loc }}]" class="fc" value="{{ $d['hero_badge'] ?? ($dId['hero_badge'] ?? '') }}" placeholder="{{ $dId['hero_badge'] ?? '' }}">
        </div>
        <div class="fg"><label class="fl">Judul Hero (H1)</label>
          <input type="text" name="hero_title[{{ $loc }}]" class="fc" value="{{ $d['hero_title'] ?? ($dId['hero_title'] ?? '') }}" placeholder="{{ $dId['hero_title'] ?? '' }}">
        </div>
        <div class="fg"><label class="fl">Deskripsi Hero</label>
          <textarea name="hero_desc[{{ $loc }}]" class="fc" rows="3">{{ $d['hero_desc'] ?? ($dId['hero_desc'] ?? '') }}</textarea>
        </div>
      </div>
      @endforeach
    </div>
  </div>

  {{-- ============ PROFIL PENDIRI ============ --}}
  <div class="card" style="margin-bottom:16px">
    <div class="card-hd"><h3>👤 Profil Pendiri (Kang Bahri)</h3></div>
    <div class="card-body">

      {{-- Foto Upload (locale-independent) --}}
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

      {{-- Translatable text --}}
      <div class="lang-tabs" id="profil-tabs" style="margin-top:16px">
        @foreach($languages as $lang)
        <button type="button" class="lang-tab {{ $loop->first ? 'active' : '' }}" onclick="switchTab('profil',this,'{{ $lang->code }}')">
          {{ $lang->flag }} {{ $lang->native_name }}
        </button>
        @endforeach
      </div>
      @foreach($languages as $lang)
      @php $loc = $lang->code; $d = $all[$loc] ?? []; $dId = $all['id'] ?? []; @endphp
      <div class="lang-pane {{ $loop->first ? 'active' : '' }}" id="profil-pane-{{ $loc }}" dir="{{ $lang->dir }}">
        <div class="frow frow-2">
          <div class="fg"><label class="fl">Nama Lengkap</label>
            <input type="text" name="profil_nama[{{ $loc }}]" class="fc" value="{{ $d['profil_nama'] ?? ($dId['profil_nama'] ?? '') }}" placeholder="{{ $dId['profil_nama'] ?? '' }}">
          </div>
          <div class="fg"><label class="fl">Gelar / Jabatan</label>
            <input type="text" name="profil_gelar[{{ $loc }}]" class="fc" value="{{ $d['profil_gelar'] ?? ($dId['profil_gelar'] ?? '') }}" placeholder="{{ $dId['profil_gelar'] ?? '' }}">
          </div>
        </div>
        <div class="fg">
          <label class="fl">Bio / Deskripsi <span style="color:var(--cmt);font-weight:400">(pisahkan paragraf dengan baris kosong)</span></label>
          <textarea name="profil_bio[{{ $loc }}]" class="fc" rows="8">{{ $d['profil_bio'] ?? ($dId['profil_bio'] ?? '') }}</textarea>
        </div>
      </div>
      @endforeach
    </div>
  </div>

  {{-- ============ VISI & MISI ============ --}}
  <div class="card" style="margin-bottom:16px">
    <div class="card-hd"><h3>🎯 Visi & Misi</h3></div>
    <div class="card-body">
      <div class="lang-tabs" id="vm-tabs">
        @foreach($languages as $lang)
        <button type="button" class="lang-tab {{ $loop->first ? 'active' : '' }}" onclick="switchTab('vm',this,'{{ $lang->code }}')">
          {{ $lang->flag }} {{ $lang->native_name }}
        </button>
        @endforeach
      </div>
      @foreach($languages as $lang)
      @php $loc = $lang->code; $d = $all[$loc] ?? []; $dId = $all['id'] ?? []; @endphp
      <div class="lang-pane {{ $loop->first ? 'active' : '' }}" id="vm-pane-{{ $loc }}" dir="{{ $lang->dir }}">
        <div class="fg">
          <label class="fl">Visi</label>
          <textarea name="visi[{{ $loc }}]" class="fc" rows="3">{{ $d['visi'] ?? ($dId['visi'] ?? '') }}</textarea>
        </div>
        <div class="fg">
          <label class="fl">Misi <span style="color:var(--cmt);font-weight:400">(satu poin per baris)</span></label>
          <textarea name="misi[{{ $loc }}]" class="fc" rows="6" placeholder="Misi 1&#10;Misi 2&#10;Misi 3">{{ $d['misi'] ?? ($dId['misi'] ?? '') }}</textarea>
          <p style="font-size:11px;color:var(--cmt);margin-top:4px">Setiap baris baru akan menjadi satu poin misi di halaman tentang.</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>

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
