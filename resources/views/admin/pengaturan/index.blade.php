@extends('layouts.admin')

@section('title', 'Pengaturan')
@section('breadcrumb')
  <span class="cur">Pengaturan</span>
@endsection

@push('styles')
<style>
.lang-tabs { display:flex; gap:4px; border-bottom:2px solid var(--cms); margin-bottom:14px; flex-wrap:wrap; }
.lang-tab { padding:7px 16px; font-size:13px; font-weight:600; cursor:pointer; border:none; background:none; color:var(--cmt); border-bottom:2px solid transparent; margin-bottom:-2px; border-radius:4px 4px 0 0; transition:all .15s; }
.lang-tab:hover { color:var(--ctm); background:var(--cbg); }
.lang-tab.active { color:var(--cp); border-bottom-color:var(--cp); background:var(--cpl); }
.lang-pane { display:none; }
.lang-pane.active { display:block; }
</style>
@endpush

@section('content')
<div class="pg-hd">
  <div><h1>Pengaturan Sistem</h1><p>Kelola identitas website dan konfigurasi halaman</p></div>
</div>

<!-- HUB MENU CARDS -->
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px;margin-bottom:28px">
  @php
    $menus = [
      ['route' => 'admin.pengaturan.homepage', 'icon' => '🏠', 'title' => 'Pengaturan Homepage', 'desc' => 'Edit hero, statistik, produk pilihan, testimoni & CTA', 'color' => '#C86A44'],
      ['route' => 'admin.pengaturan.tentang',  'icon' => '👤', 'title' => 'Pengaturan Tentang',  'desc' => 'Edit profil, visi misi, timeline & cara kerja', 'color' => '#3b82f6'],
      ['route' => 'admin.users.index',         'icon' => '👥', 'title' => 'Manajemen Pengguna',  'desc' => 'Kelola akun admin, role & hak akses', 'color' => '#8b5cf6'],
      ['route' => 'admin.pengaturan.uc',       'icon' => '🚧', 'title' => 'Under Construction',  'desc' => 'Toggle mode UC, redirect, konten & tampilan', 'color' => '#f59e0b'],
      ['route' => 'admin.bahasa.index',        'icon' => '🌐', 'title' => 'Manajemen Bahasa',    'desc' => 'Kelola bahasa aktif (ID / EN / AR) dan tambah bahasa baru', 'color' => '#10b981'],
    ];
  @endphp
  @foreach($menus as $m)
  <a href="{{ route($m['route']) }}" style="text-decoration:none;background:var(--cw);border:1px solid var(--cms);border-radius:var(--r3);padding:20px;display:flex;align-items:flex-start;gap:14px;box-shadow:var(--s1);transition:all var(--tr)" onmouseover="this.style.borderColor='{{ $m['color'] }}'" onmouseout="this.style.borderColor='var(--cms)'">
    <div style="width:46px;height:46px;border-radius:var(--r2);display:grid;place-items:center;font-size:22px;flex-shrink:0;background:rgba(0,0,0,.04)">{{ $m['icon'] }}</div>
    <div>
      <div style="font-weight:600;font-size:14px;color:var(--ctm);margin-bottom:4px">{{ $m['title'] }}</div>
      <div style="font-size:12.5px;color:var(--cmt)">{{ $m['desc'] }}</div>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--cms)" stroke-width="2" style="margin-left:auto;flex-shrink:0;margin-top:2px"><polyline points="9 18 15 12 9 6"/></svg>
  </a>
  @endforeach
</div>

<!-- IDENTITAS WEBSITE -->
<div class="card">
  <div class="card-hd"><h3>Identitas Website</h3></div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.pengaturan.site') }}" enctype="multipart/form-data">
      @csrf
      {{-- Nama Website, Tagline, Deskripsi Footer, Alamat & Copyright (multi-bahasa) --}}
      <div style="border:1px solid var(--cms);border-radius:var(--r2);padding:14px;margin:0 0 16px;background:var(--csi)">
        <div class="lang-tabs" id="site-tabs">
          @foreach($languages as $lang)
          <button type="button" class="lang-tab {{ $loop->first ? 'active' : '' }}" onclick="switchTab('site',this,'{{ $lang->code }}')">
            {{ $lang->flag }} {{ $lang->native_name }}
          </button>
          @endforeach
        </div>
        @foreach($languages as $lang)
        @php $loc = $lang->code; $d = $siteAll[$loc] ?? []; $dId = $siteAll['id'] ?? []; @endphp
        <div class="lang-pane {{ $loop->first ? 'active' : '' }}" id="site-pane-{{ $loc }}" dir="{{ $lang->dir }}">
          <div class="fg"><label class="fl">Nama Website @if($loc==='id')<span style="color:#ef4444">*</span>@endif</label>
            <input type="text" name="name[{{ $loc }}]" class="fc" value="{{ $d['name'] ?? ($dId['name'] ?? '') }}" {{ $loc==='id' ? 'required' : '' }}>
          </div>
          <div class="fg"><label class="fl">Tagline</label>
            <input type="text" name="tagline[{{ $loc }}]" class="fc" value="{{ $d['tagline'] ?? ($dId['tagline'] ?? '') }}">
          </div>
          <div class="fg"><label class="fl">Deskripsi Footer</label>
            <textarea name="footer_desc[{{ $loc }}]" class="fc" rows="2" placeholder="Deskripsi singkat di footer website...">{{ $d['footer_desc'] ?? ($dId['footer_desc'] ?? '') }}</textarea>
          </div>
          <div class="frow frow-2">
            <div class="fg"><label class="fl">Alamat</label>
              <input type="text" name="address[{{ $loc }}]" class="fc" value="{{ $d['address'] ?? ($dId['address'] ?? '') }}" placeholder="Bandung, Jawa Barat">
            </div>
            <div class="fg"><label class="fl">Teks Copyright</label>
              <input type="text" name="copyright[{{ $loc }}]" class="fc" value="{{ $d['copyright'] ?? ($dId['copyright'] ?? '') }}" placeholder="© 2026 Akar Sehat. All rights reserved.">
            </div>
          </div>
        </div>
        @endforeach
      </div>

      <div class="frow frow-3">
        <div class="fg"><label class="fl">Nomor WhatsApp 1</label><input type="text" name="wa_number" class="fc" value="{{ $site['wa_number'] ?? '' }}" placeholder="6281234567890"></div>
        <div class="fg"><label class="fl">Nomor WhatsApp 2 (Arab)</label><input type="text" name="wa_number_2" class="fc" value="{{ $site['wa_number_2'] ?? '' }}" placeholder="966XXXXXXXXX"></div>
        <div class="fg"><label class="fl">Email</label><input type="email" name="email" class="fc" value="{{ $site['email'] ?? '' }}"></div>
      </div>

      <div class="frow frow-2">
        <div class="fg"><label class="fl">URL Facebook</label><input type="url" name="fb_url" class="fc" value="{{ $site['fb_url'] ?? '' }}" placeholder="https://facebook.com/..."></div>
        <div class="fg"><label class="fl">URL Instagram</label><input type="url" name="ig_url" class="fc" value="{{ $site['ig_url'] ?? '' }}" placeholder="https://instagram.com/..."></div>
      </div>
      <div class="frow frow-2">
        <div class="fg"><label class="fl">URL YouTube</label><input type="url" name="yt_url" class="fc" value="{{ $site['yt_url'] ?? '' }}" placeholder="https://youtube.com/..."></div>
        <div class="fg"><label class="fl">URL TikTok</label><input type="url" name="tiktok_url" class="fc" value="{{ $site['tiktok_url'] ?? '' }}" placeholder="https://tiktok.com/@..."></div>
      </div>

      {{-- LOGO & FAVICON --}}
      <div class="frow frow-2" style="margin-top:8px">
        <div class="fg">
          <label class="fl">Logo Website</label>
          <div style="display:flex;align-items:center;gap:14px;margin-bottom:8px">
            <div style="width:60px;height:60px;background:var(--cbg);border:1px solid var(--cms);border-radius:var(--r2);display:grid;place-items:center;overflow:hidden" id="logo-preview">
              @if(!empty($site['logo']))
                <img src="{{ asset('storage/'.$site['logo']) }}" style="width:100%;height:100%;object-fit:contain">
              @else
                @include('partials.logo', ['logoSvgStyle'=>'width:36px;height:36px;color:var(--cp)'])
              @endif
            </div>
            <div>
              <input type="file" name="logo" id="logo-file" accept="image/*" style="display:none" data-preview="logo-preview" onchange="previewImg(this,'logo-preview')">
              <button type="button" class="btn btn-outline btn-sm" onclick="document.getElementById('logo-file').click()">Upload Logo</button>
              @if(!empty($site['logo']))
              <a href="{{ route('admin.pengaturan.site.delete-logo', 'logo') }}" class="btn btn-sm" style="color:#ef4444;border-color:#ef4444;background:none;margin-left:6px" onclick="return confirm('Hapus logo?')">Hapus</a>
              @endif
              <p style="font-size:11.5px;color:var(--cmt);margin-top:6px">PNG/SVG, maks 512KB. Kosongkan untuk pakai logo default.</p>
            </div>
          </div>
        </div>
        <div class="fg">
          <label class="fl">Favicon</label>
          <div style="display:flex;align-items:center;gap:14px;margin-bottom:8px">
            <div style="width:60px;height:60px;background:var(--cbg);border:1px solid var(--cms);border-radius:var(--r2);display:grid;place-items:center;overflow:hidden" id="favicon-preview">
              @if(!empty($site['favicon']))
                <img src="{{ asset('storage/'.$site['favicon']) }}" style="width:32px;height:32px;object-fit:contain">
              @else
                @include('partials.logo', ['logoSvgStyle'=>'width:28px;height:28px;color:var(--cp)'])
              @endif
            </div>
            <div>
              <input type="file" name="favicon" id="favicon-file" accept="image/*" style="display:none" data-preview="favicon-preview" onchange="previewImg(this,'favicon-preview')">
              <button type="button" class="btn btn-outline btn-sm" onclick="document.getElementById('favicon-file').click()">Upload Favicon</button>
              @if(!empty($site['favicon']))
              <a href="{{ route('admin.pengaturan.site.delete-logo', 'favicon') }}" class="btn btn-sm" style="color:#ef4444;border-color:#ef4444;background:none;margin-left:6px" onclick="return confirm('Hapus favicon?')">Hapus</a>
              @endif
              <p style="font-size:11.5px;color:var(--cmt);margin-top:6px">PNG/ICO 32×32, maks 128KB. Kosongkan untuk pakai logo sebagai favicon.</p>
            </div>
          </div>
        </div>
      </div>

      <div style="display:flex;justify-content:flex-end">
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

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
  const reader = new FileReader();
  reader.onload = e => {
    const box = document.getElementById(previewId);
    box.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:contain">`;
  };
  reader.readAsDataURL(input.files[0]);
}
</script>
@endpush
@endsection
