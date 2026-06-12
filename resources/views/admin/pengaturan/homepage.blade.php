@extends('layouts.admin')

@section('title', 'Pengaturan Homepage')
@section('breadcrumb')
  <a href="{{ route('admin.pengaturan.index') }}">Pengaturan</a>
  <span class="sep">/</span><span class="cur">Homepage</span>
@endsection

@push('styles')
<style>
/* Language tab styles */
.lang-tabs { display:flex; gap:4px; border-bottom:2px solid var(--cms); margin-bottom:16px; }
.lang-tab {
  padding:7px 16px; font-size:13px; font-weight:600; cursor:pointer;
  border:none; background:none; color:var(--cmt); border-bottom:2px solid transparent;
  margin-bottom:-2px; border-radius:4px 4px 0 0; transition:all .15s;
}
.lang-tab:hover { color:var(--ctm); background:var(--cbg); }
.lang-tab.active { color:var(--cp); border-bottom-color:var(--cp); background:var(--cpl); }
.lang-pane { display:none; }
.lang-pane.active { display:block; }
</style>
@endpush

@section('content')
<div class="pg-hd">
  <div><h1>Pengaturan Homepage</h1><p>Edit semua konten yang tampil di halaman utama. Gunakan tab bahasa untuk mengisi terjemahan.</p></div>
  <div style="display:flex;gap:8px">
    <a href="{{ route('home') }}" target="_blank" class="btn btn-outline">
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

<form method="POST" action="{{ route('admin.pengaturan.homepage.save') }}" enctype="multipart/form-data">
  @csrf

  {{-- ============ HERO SECTION ============ --}}
  <div class="card" style="margin-bottom:16px">
    <div class="card-hd"><h3>🏠 Hero / Banner Utama</h3></div>
    <div class="card-body">

      {{-- Language tabs for text --}}
      <div class="lang-tabs" id="hero-tabs">
        @foreach($languages as $lang)
        <button type="button" class="lang-tab {{ $loop->first ? 'active' : '' }}" onclick="switchTab('hero',this,'{{ $lang->code }}')">
          {{ $lang->flag }} {{ $lang->native_name }}
        </button>
        @endforeach
      </div>

      @foreach($languages as $lang)
      @php $loc = $lang->code; $d = $all[$loc] ?? []; @endphp
      <div class="lang-pane {{ $loop->first ? 'active' : '' }}" id="hero-pane-{{ $loc }}" dir="{{ $lang->dir }}">
        <div class="frow frow-2">
          <div class="fg"><label class="fl">Badge Text</label>
            <input type="text" name="hero_badge[{{ $loc }}]" class="fc" value="{{ $d['hero_badge'] ?? ($all['id']['hero_badge'] ?? '') }}" placeholder="{{ $all['id']['hero_badge'] ?? '' }}">
          </div>
          <div class="fg"><label class="fl">Teks Tombol</label>
            <input type="text" name="hero_btn_text[{{ $loc }}]" class="fc" value="{{ $d['hero_btn_text'] ?? ($all['id']['hero_btn_text'] ?? '') }}" placeholder="{{ $all['id']['hero_btn_text'] ?? '' }}">
          </div>
        </div>
        <div class="frow frow-2">
          <div class="fg"><label class="fl">Judul Baris 1</label>
            <input type="text" name="hero_title1[{{ $loc }}]" class="fc" value="{{ $d['hero_title1'] ?? ($all['id']['hero_title1'] ?? '') }}" placeholder="{{ $all['id']['hero_title1'] ?? '' }}">
          </div>
          <div class="fg"><label class="fl">Judul Baris 2 (warna primary)</label>
            <input type="text" name="hero_title2[{{ $loc }}]" class="fc" value="{{ $d['hero_title2'] ?? ($all['id']['hero_title2'] ?? '') }}" placeholder="{{ $all['id']['hero_title2'] ?? '' }}">
          </div>
        </div>
        <div class="fg"><label class="fl">Deskripsi</label>
          <textarea name="hero_desc[{{ $loc }}]" class="fc" rows="3">{{ $d['hero_desc'] ?? ($all['id']['hero_desc'] ?? '') }}</textarea>
        </div>
      </div>
      @endforeach

      {{-- Hero Image (locale-independent) --}}
      <div style="border-top:1px solid var(--cms);margin-top:16px;padding-top:16px">
        <div class="fg">
          <label class="fl">Gambar Hero <span style="color:var(--cmt);font-size:11px;font-weight:400">(sama untuk semua bahasa)</span></label>
          <div style="display:flex;gap:16px;align-items:flex-start;flex-wrap:wrap">
            <div id="hero-img-preview" style="width:160px;height:120px;border:2px dashed var(--cms);border-radius:8px;display:flex;align-items:center;justify-content:center;overflow:hidden;background:var(--cbg);flex-shrink:0">
              @if(!empty($settings['hero_image']))
                <img src="{{ asset('storage/'.$settings['hero_image']) }}" style="width:100%;height:100%;object-fit:cover">
              @else
                <span style="font-size:32px;color:var(--cmt)">🖼️</span>
              @endif
            </div>
            <div style="flex:1;min-width:200px">
              <input type="file" name="hero_image" accept="image/*" class="fc" onchange="previewImg(this,'hero-img-preview')" style="padding:8px">
              <p style="font-size:11px;color:var(--cmt);margin-top:4px">Format: JPG/PNG/WEBP. Maks 2MB. Jika kosong, menggunakan gambar default.</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  {{-- ============ STATISTIK STRIP ============ --}}
  <div class="card" style="margin-bottom:16px">
    <div class="card-hd">
      <h3>📊 Statistik Strip</h3>
      <button type="button" class="btn btn-outline btn-sm" onclick="addStat(activeStatLocale())">+ Tambah</button>
    </div>
    <div class="card-body">
      <div class="lang-tabs" id="stat-tabs">
        @foreach($languages as $lang)
        <button type="button" class="lang-tab {{ $loop->first ? 'active' : '' }}" onclick="switchTab('stat',this,'{{ $lang->code }}')">
          {{ $lang->flag }} {{ $lang->native_name }}
        </button>
        @endforeach
      </div>

      @foreach($languages as $lang)
      @php $loc = $lang->code; $statData = $all[$loc]['stats'] ?? ($all['id']['stats'] ?? []); @endphp
      <div class="lang-pane {{ $loop->first ? 'active' : '' }}" id="stat-pane-{{ $loc }}" dir="{{ $lang->dir }}">
        <div id="stat-list-{{ $loc }}">
          @foreach((array)$statData as $i => $stat)
          <div class="stat-item-row" style="display:grid;grid-template-columns:70px 1fr 1fr auto;gap:10px;align-items:end;margin-bottom:10px">
            <div class="fg" style="margin:0"><label class="fl">Ikon</label><input type="text" name="stats[{{ $loc }}][{{ $i }}][icon]" class="fc" value="{{ $stat['icon'] ?? '' }}" style="text-align:center;font-size:18px" placeholder="👥"></div>
            <div class="fg" style="margin:0"><label class="fl">Nilai</label><input type="text" name="stats[{{ $loc }}][{{ $i }}][nilai]" class="fc" value="{{ $stat['nilai'] ?? '' }}" placeholder="2.500+"></div>
            <div class="fg" style="margin:0"><label class="fl">Label</label><input type="text" name="stats[{{ $loc }}][{{ $i }}][label]" class="fc" value="{{ $stat['label'] ?? '' }}" placeholder="Pengguna Puas"></div>
            <button type="button" onclick="this.closest('.stat-item-row').remove()" style="height:36px;width:36px;border:1px solid #ef4444;background:none;border-radius:6px;cursor:pointer;color:#ef4444;font-size:18px">&times;</button>
          </div>
          @endforeach
        </div>
      </div>
      @endforeach
    </div>
  </div>

  {{-- ============ MENTOR SECTION ============ --}}
  <div class="card" style="margin-bottom:16px">
    <div class="card-hd"><h3>👤 Seksi Mentor</h3></div>
    <div class="card-body">

      <div class="lang-tabs" id="mentor-tabs">
        @foreach($languages as $lang)
        <button type="button" class="lang-tab {{ $loop->first ? 'active' : '' }}" onclick="switchTab('mentor',this,'{{ $lang->code }}')">
          {{ $lang->flag }} {{ $lang->native_name }}
        </button>
        @endforeach
      </div>

      @foreach($languages as $lang)
      @php $loc = $lang->code; $d = $all[$loc] ?? []; $dId = $all['id'] ?? []; @endphp
      <div class="lang-pane {{ $loop->first ? 'active' : '' }}" id="mentor-pane-{{ $loc }}" dir="{{ $lang->dir }}">
        <div class="frow frow-2">
          <div class="fg"><label class="fl">Tag / Label</label>
            <input type="text" name="mentor_tag[{{ $loc }}]" class="fc" value="{{ $d['mentor_tag'] ?? ($dId['mentor_tag'] ?? '') }}" placeholder="{{ $dId['mentor_tag'] ?? '' }}">
          </div>
          <div class="fg"><label class="fl">Nama Mentor</label>
            <input type="text" name="mentor_nama[{{ $loc }}]" class="fc" value="{{ $d['mentor_nama'] ?? ($dId['mentor_nama'] ?? '') }}" placeholder="{{ $dId['mentor_nama'] ?? '' }}">
          </div>
        </div>
        <div class="fg"><label class="fl">Bio Mentor</label>
          <textarea name="mentor_bio[{{ $loc }}]" class="fc" rows="3">{{ $d['mentor_bio'] ?? ($dId['mentor_bio'] ?? '') }}</textarea>
        </div>
        <div class="fg"><label class="fl">Teks Tombol</label>
          <input type="text" name="mentor_btn[{{ $loc }}]" class="fc" value="{{ $d['mentor_btn'] ?? ($dId['mentor_btn'] ?? '') }}" placeholder="{{ $dId['mentor_btn'] ?? '' }}">
        </div>
        {{-- Mentor Stats --}}
        <div style="margin-top:8px">
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
            <label class="fl" style="margin:0">Statistik Mentor</label>
            <button type="button" class="btn btn-outline btn-sm" onclick="addMentorStat('{{ $loc }}')">+ Tambah</button>
          </div>
          <div id="mentor-stat-list-{{ $loc }}">
            @php $ms = $all[$loc]['mentor_stats'] ?? ($dId['mentor_stats'] ?? []); @endphp
            @foreach((array)$ms as $i => $m)
            <div class="mentor-stat-row" style="display:grid;grid-template-columns:1fr 1fr auto;gap:10px;align-items:end;margin-bottom:10px">
              <div class="fg" style="margin:0"><label class="fl">Nilai</label><input type="text" name="mentor_stats[{{ $loc }}][{{ $i }}][nilai]" class="fc" value="{{ $m['nilai'] ?? '' }}" placeholder="20+"></div>
              <div class="fg" style="margin:0"><label class="fl">Label</label><input type="text" name="mentor_stats[{{ $loc }}][{{ $i }}][label]" class="fc" value="{{ $m['label'] ?? '' }}" placeholder="Tahun Pengalaman"></div>
              <button type="button" onclick="this.closest('.mentor-stat-row').remove()" style="height:36px;width:36px;border:1px solid #ef4444;background:none;border-radius:6px;cursor:pointer;color:#ef4444;font-size:18px">&times;</button>
            </div>
            @endforeach
          </div>
        </div>
      </div>
      @endforeach

      {{-- Mentor Image (locale-independent) --}}
      <div style="border-top:1px solid var(--cms);margin-top:16px;padding-top:16px">
        <div class="fg">
          <label class="fl">Foto Mentor <span style="color:var(--cmt);font-size:11px;font-weight:400">(sama untuk semua bahasa)</span></label>
          <div style="display:flex;gap:16px;align-items:flex-start;flex-wrap:wrap">
            <div id="mentor-img-preview" style="width:120px;height:150px;border:2px dashed var(--cms);border-radius:8px;display:flex;align-items:center;justify-content:center;overflow:hidden;background:var(--cbg);flex-shrink:0">
              @if(!empty($settings['mentor_image']))
                <img src="{{ asset('storage/'.$settings['mentor_image']) }}" style="width:100%;height:100%;object-fit:cover">
              @else
                <span style="font-size:32px;color:var(--cmt)">👤</span>
              @endif
            </div>
            <div style="flex:1;min-width:200px">
              <input type="file" name="mentor_image" accept="image/*" class="fc" onchange="previewImg(this,'mentor-img-preview')" style="padding:8px">
              <p style="font-size:11px;color:var(--cmt);margin-top:4px">Format: JPG/PNG/WEBP. Maks 2MB.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ============ MID CTA ============ --}}
  <div class="card" style="margin-bottom:16px">
    <div class="card-hd"><h3>📣 Banner CTA Tengah</h3></div>
    <div class="card-body">
      <div class="lang-tabs" id="cta-tabs">
        @foreach($languages as $lang)
        <button type="button" class="lang-tab {{ $loop->first ? 'active' : '' }}" onclick="switchTab('cta',this,'{{ $lang->code }}')">
          {{ $lang->flag }} {{ $lang->native_name }}
        </button>
        @endforeach
      </div>
      @foreach($languages as $lang)
      @php $loc = $lang->code; $d = $all[$loc] ?? []; $dId = $all['id'] ?? []; @endphp
      <div class="lang-pane {{ $loop->first ? 'active' : '' }}" id="cta-pane-{{ $loc }}" dir="{{ $lang->dir }}">
        <div class="fg"><label class="fl">Judul CTA</label>
          <input type="text" name="cta_title[{{ $loc }}]" class="fc" value="{{ $d['cta_title'] ?? ($dId['cta_title'] ?? '') }}">
        </div>
        <div class="fg"><label class="fl">Deskripsi CTA</label>
          <input type="text" name="cta_desc[{{ $loc }}]" class="fc" value="{{ $d['cta_desc'] ?? ($dId['cta_desc'] ?? '') }}">
        </div>
        <div class="fg"><label class="fl">Teks Tombol</label>
          <input type="text" name="cta_btn[{{ $loc }}]" class="fc" value="{{ $d['cta_btn'] ?? ($dId['cta_btn'] ?? '') }}">
        </div>
      </div>
      @endforeach
    </div>
  </div>

  {{-- ============ KONSULTASI CTA ============ --}}
  <div class="card" style="margin-bottom:16px">
    <div class="card-hd"><h3>💬 Seksi Konsultasi (CTA Bawah)</h3></div>
    <div class="card-body">
      <div class="lang-tabs" id="konsul-tabs">
        @foreach($languages as $lang)
        <button type="button" class="lang-tab {{ $loop->first ? 'active' : '' }}" onclick="switchTab('konsul',this,'{{ $lang->code }}')">
          {{ $lang->flag }} {{ $lang->native_name }}
        </button>
        @endforeach
      </div>
      @foreach($languages as $lang)
      @php $loc = $lang->code; $d = $all[$loc] ?? []; $dId = $all['id'] ?? []; @endphp
      <div class="lang-pane {{ $loop->first ? 'active' : '' }}" id="konsul-pane-{{ $loc }}" dir="{{ $lang->dir }}">
        <div class="fg"><label class="fl">Judul</label>
          <input type="text" name="konsul_title[{{ $loc }}]" class="fc" value="{{ $d['konsul_title'] ?? ($dId['konsul_title'] ?? '') }}">
        </div>
        <div class="fg"><label class="fl">Deskripsi</label>
          <textarea name="konsul_desc[{{ $loc }}]" class="fc" rows="3">{{ $d['konsul_desc'] ?? ($dId['konsul_desc'] ?? '') }}</textarea>
        </div>
        <div class="fg"><label class="fl">Teks Tombol</label>
          <input type="text" name="konsul_btn[{{ $loc }}]" class="fc" value="{{ $d['konsul_btn'] ?? ($dId['konsul_btn'] ?? '') }}">
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
// Current active locale per section (for dynamic add row)
const activeLoc = {};

function switchTab(section, btn, locale) {
  // Switch buttons
  document.querySelectorAll(`#${section}-tabs .lang-tab`).forEach(t => t.classList.remove('active'));
  btn.classList.add('active');
  // Switch panes
  document.querySelectorAll(`[id^="${section}-pane-"]`).forEach(p => p.classList.remove('active'));
  const pane = document.getElementById(`${section}-pane-${locale}`);
  if (pane) pane.classList.add('active');
  activeLoc[section] = locale;
}

function activeStatLocale() { return activeLoc['stat'] || '{{ $languages->first()->code ?? 'id' }}'; }

// Stats
const statCounters = {};
@foreach($languages as $lang)
statCounters['{{ $lang->code }}'] = {{ count($all[$lang->code]['stats'] ?? $all['id']['stats'] ?? []) }};
@endforeach

function addStat(loc) {
  if (!statCounters[loc]) statCounters[loc] = 0;
  const i   = statCounters[loc]++;
  const row = document.createElement('div');
  row.className = 'stat-item-row';
  row.style.cssText = 'display:grid;grid-template-columns:70px 1fr 1fr auto;gap:10px;align-items:end;margin-bottom:10px';
  row.innerHTML = `
    <div class="fg" style="margin:0"><label class="fl">Ikon</label><input type="text" name="stats[${loc}][${i}][icon]" class="fc" style="text-align:center;font-size:18px" placeholder="👥"></div>
    <div class="fg" style="margin:0"><label class="fl">Nilai</label><input type="text" name="stats[${loc}][${i}][nilai]" class="fc" placeholder="2.500+"></div>
    <div class="fg" style="margin:0"><label class="fl">Label</label><input type="text" name="stats[${loc}][${i}][label]" class="fc" placeholder="Pengguna Puas"></div>
    <button type="button" onclick="this.closest('.stat-item-row').remove()" style="height:36px;width:36px;border:1px solid #ef4444;background:none;border-radius:6px;cursor:pointer;color:#ef4444;font-size:18px">&times;</button>
  `;
  document.getElementById(`stat-list-${loc}`).appendChild(row);
}

// Mentor stats
const msCounters = {};
@foreach($languages as $lang)
msCounters['{{ $lang->code }}'] = {{ count($all[$lang->code]['mentor_stats'] ?? $all['id']['mentor_stats'] ?? []) }};
@endforeach

function addMentorStat(loc) {
  if (!msCounters[loc]) msCounters[loc] = 0;
  const i   = msCounters[loc]++;
  const row = document.createElement('div');
  row.className = 'mentor-stat-row';
  row.style.cssText = 'display:grid;grid-template-columns:1fr 1fr auto;gap:10px;align-items:end;margin-bottom:10px';
  row.innerHTML = `
    <div class="fg" style="margin:0"><label class="fl">Nilai</label><input type="text" name="mentor_stats[${loc}][${i}][nilai]" class="fc" placeholder="20+"></div>
    <div class="fg" style="margin:0"><label class="fl">Label</label><input type="text" name="mentor_stats[${loc}][${i}][label]" class="fc" placeholder="Tahun Pengalaman"></div>
    <button type="button" onclick="this.closest('.mentor-stat-row').remove()" style="height:36px;width:36px;border:1px solid #ef4444;background:none;border-radius:6px;cursor:pointer;color:#ef4444;font-size:18px">&times;</button>
  `;
  document.getElementById(`mentor-stat-list-${loc}`).appendChild(row);
}

async function previewImg(input, previewId) {
  if (!input.files || !input.files[0]) return;
  setLoading('Mengompresi gambar...');
  await compressInputFile(input);
  clearLoading();
  const preview = document.getElementById(previewId);
  const reader = new FileReader();
  reader.onload = e => {
    preview.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover">`;
  };
  reader.readAsDataURL(input.files[0]);
}
</script>
@endpush
