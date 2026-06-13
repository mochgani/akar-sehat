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

/* Editor WYSIWYG */
.rich-wrap { border:1px solid var(--cms); border-radius:var(--r1); overflow:hidden; background:var(--cw); }
.rich-tb { display:flex; gap:2px; flex-wrap:wrap; padding:6px; background:var(--cbg); border-bottom:1px solid var(--cms); }
.rich-tb button { height:26px; min-width:26px; padding:0 7px; border:1px solid var(--cms); background:var(--cw); border-radius:4px; cursor:pointer; font-size:12px; color:var(--ctm); display:inline-flex; align-items:center; justify-content:center; }
.rich-tb button:hover { background:var(--cpl); border-color:var(--cp); color:var(--cp); }
.rich-tb .sep { width:1px; background:var(--cms); margin:2px 3px; }
.rich-area { padding:10px 12px; min-height:70px; font-size:13.5px; line-height:1.7; outline:none; color:var(--ctm); }
.rich-area[dir="rtl"] { text-align:right; }
.rich-area:empty:before { content:attr(data-ph); color:var(--cmt); }
.rich-area p { margin:0 0 8px; }
.rich-area ul, .rich-area ol { margin:0 0 8px; padding-inline-start:24px; }
.rich-area ul { list-style:disc; } .rich-area ol { list-style:decimal; }
.rich-area li { margin-bottom:3px; display:list-item; }
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
            <textarea name="footer_desc[{{ $loc }}]" class="js-rich" data-min="70" dir="{{ $lang->dir ?? 'ltr' }}">{{ $d['footer_desc'] ?? ($dId['footer_desc'] ?? '') }}</textarea>
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
function richAlign(dir) {
  if (!activeRich) return;
  richRestoreRange();
  document.execCommand('styleWithCSS', false, true);
  document.execCommand('justify' + dir, false, null);
  document.execCommand('styleWithCSS', false, false);
  activeRich.dispatchEvent(new Event('input')); richSaveRange();
}
function buildRichToolbar() {
  const b = (l, t, fn) => `<button type="button" title="${t}" onmousedown="event.preventDefault()" onclick="${fn}">${l}</button>`;
  return '<div class="rich-tb">'
    + b('<b>B</b>', 'Tebal', "richExec('bold')")
    + b('<i>I</i>', 'Miring', "richExec('italic')")
    + b('<u>U</u>', 'Garis bawah', "richExec('underline')")
    + '<span class="sep"></span>'
    + b('•', 'Daftar', "richExec('insertUnorderedList')")
    + b('1.', 'Daftar nomor', "richExec('insertOrderedList')")
    + '<span class="sep"></span>'
    + b('<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="13" y2="12"/><line x1="3" y1="18" x2="17" y2="18"/></svg>', 'Rata kiri', "richAlign('Left')")
    + b('<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="6" y1="12" x2="18" y2="12"/><line x1="5" y1="18" x2="19" y2="18"/></svg>', 'Rata tengah', "richAlign('Center')")
    + b('<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="9" y1="12" x2="21" y2="12"/><line x1="7" y1="18" x2="21" y2="18"/></svg>', 'Rata kanan', "richAlign('Right')")
    + b('<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>', 'Rata kiri-kanan (justify)', "richAlign('Full')")
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
  area.style.minHeight = (ta.dataset.min || 70) + 'px';
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
  document.querySelectorAll('form[action*="pengaturan/site"]').forEach(f => f.addEventListener('submit', syncAllRich));
});
</script>
@endpush
@endsection
