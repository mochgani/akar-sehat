@extends('layouts.admin')

@section('title', 'Testimoni')
@section('breadcrumb')<span class="cur">Testimoni</span>@endsection

@push('styles')
<style>
.testi-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 16px; }
.testi-card { background: var(--cw); border: 1px solid var(--cms); border-radius: var(--r3); padding: 20px; display: flex; flex-direction: column; gap: 14px; box-shadow: var(--s1); transition: all var(--tr); position: relative; }
.testi-card.inactive { opacity: .55; }
.testi-card:hover { box-shadow: var(--s2); }
.testi-top { display: flex; align-items: center; gap: 14px; }
.testi-av { width: 52px; height: 52px; border-radius: 50%; display: grid; place-items: center; font-size: 16px; font-weight: 700; color: #fff; flex-shrink: 0; overflow: hidden; }
.testi-av img { width: 100%; height: 100%; object-fit: cover; }
.testi-info { flex: 1; min-width: 0; }
.testi-info h4 { font-size: 14px; font-weight: 600; color: var(--ctm); margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.testi-info p { font-size: 12px; color: var(--cmt); }
.testi-rating { font-size: 13px; font-weight: 600; color: #f59e0b; white-space: nowrap; }
.testi-isi { font-size: 13px; color: var(--cmt); line-height: 1.6; font-style: italic; flex: 1; }
.testi-isi::before { content: '"'; }
.testi-isi::after { content: '"'; }
.testi-foot { display: flex; align-items: center; justify-content: space-between; padding-top: 12px; border-top: 1px solid var(--cbg); }
.urutan-badge { font-size: 11px; color: var(--cmt); background: var(--cbg); border-radius: var(--rr); padding: 2px 10px; }
.testi-actions { display: flex; gap: 6px; }
.status-badge { font-size: 11px; font-weight: 600; padding: 2px 10px; border-radius: var(--rr); }
.status-aktif { background: rgba(34,197,94,.1); color: #16a34a; }
.status-nonaktif { background: rgba(107,114,128,.1); color: #6b7280; }
/* empty state */
.empty-state { text-align: center; padding: 60px 20px; color: var(--cmt); }
.empty-state svg { margin: 0 auto 16px; display: block; opacity: .35; }
</style>
@endpush

@section('content')
<div class="pg-hd">
  <div>
    <h1>Manajemen Testimoni</h1>
    <p>Kelola testimoni pelanggan yang tampil di halaman utama</p>
  </div>
  <button class="btn btn-primary" onclick="openModal('m-add')">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Tambah Testimoni
  </button>
</div>

@if(session('success'))
<div class="toast toast-success" id="auto-toast">{{ session('success') }}</div>
@endif

{{-- GRID TESTIMONI --}}
@if($testimonis->isEmpty())
<div class="card">
  <div class="empty-state">
    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
    <p style="font-size:15px;font-weight:600;color:var(--ctm);margin-bottom:6px">Belum ada testimoni</p>
    <p style="font-size:13px">Klik "Tambah Testimoni" untuk menambahkan yang pertama.</p>
  </div>
</div>
@else
<div class="testi-grid">
  @foreach($testimonis as $t)
  <div class="testi-card {{ $t->aktif ? '' : 'inactive' }}">
    {{-- TOP --}}
    <div class="testi-top">
      <div class="testi-av" style="background:{{ $t->warna }}">
        @if($t->foto)
          <img src="{{ asset('storage/'.$t->foto) }}" alt="{{ $t->nama }}">
        @else
          {{ $t->inisial }}
        @endif
      </div>
      <div class="testi-info">
        <h4>{{ $t->nama }}</h4>
        <p>{{ $t->jabatan }}</p>
      </div>
      <div class="testi-rating">★ {{ number_format($t->rating, 1) }}</div>
    </div>

    {{-- ISI --}}
    <p class="testi-isi">{{ $t->isi }}</p>

    {{-- FOOTER --}}
    <div class="testi-foot">
      <div style="display:flex;align-items:center;gap:8px">
        <span class="urutan-badge">#{{ $t->urutan }}</span>
        <span class="status-badge {{ $t->aktif ? 'status-aktif' : 'status-nonaktif' }}">
          {{ $t->aktif ? 'Aktif' : 'Non-aktif' }}
        </span>
      </div>
      <div class="testi-actions">
        {{-- Toggle aktif --}}
        <form method="POST" action="{{ route('admin.testimoni.toggle', $t) }}" style="display:inline">
          @csrf @method('PATCH')
          <button type="submit" class="act-btn" title="{{ $t->aktif ? 'Non-aktifkan' : 'Aktifkan' }}" style="color:{{ $t->aktif ? '#22c55e' : 'var(--cmt)' }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              @if($t->aktif)
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
              @else
                <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>
              @endif
            </svg>
          </button>
        </form>
        {{-- Edit --}}
        <button class="act-btn" title="Edit" onclick="openEdit({{ $t->id }}, {{ json_encode($t) }})">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        </button>
        {{-- Hapus --}}
        <form method="POST" action="{{ route('admin.testimoni.destroy', $t) }}" style="display:inline"
              onsubmit="return confirm('Hapus testimoni {{ addslashes($t->nama) }}?')">
          @csrf @method('DELETE')
          <button type="submit" class="act-btn" title="Hapus" style="color:#ef4444;border-color:#fecaca">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
          </button>
        </form>
      </div>
    </div>
  </div>
  @endforeach
</div>
@endif

{{-- MODAL TAMBAH --}}
<div class="modal-overlay" id="m-add" onclick="handleOC(event,'m-add')">
  <div class="modal">
    <div class="modal-hd">
      <div style="width:36px;height:36px;border-radius:var(--r2);background:var(--cpl);display:grid;place-items:center;color:var(--cp)">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
      </div>
      <div><p class="modal-title">Tambah Testimoni</p><p class="modal-sub">Isi data testimoni pelanggan baru</p></div>
      <button class="modal-close" onclick="closeModal('m-add')">✕</button>
    </div>
    <form method="POST" action="{{ route('admin.testimoni.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="modal-body">
        {{-- Translatable: nama, jabatan, isi --}}
        <div class="lang-section">
          <div style="font-size:12px;color:var(--cmt);margin-bottom:10px;font-weight:600">🌐 Konten per Bahasa</div>
          <div class="lang-tabs" id="add-testi-tabs">
            @foreach($languages as $lang)
            <button type="button" class="lang-tab {{ $loop->first ? 'active' : '' }}"
              onclick="switchLangTab('add-testi', this, '{{ $lang->code }}')">
              {{ $lang->flag }} {{ $lang->native_name }}
            </button>
            @endforeach
          </div>
          @foreach($languages as $lang)
          @php $isId = $lang->code === 'id'; $loc = $lang->code; @endphp
          <div class="lang-pane {{ $loop->first ? 'active' : '' }}" id="add-testi-pane-{{ $loc }}" dir="{{ $lang->dir }}">
            <div class="frow frow-2">
              <div class="fg">
                <label class="fl">Nama @if($isId)<span style="color:#ef4444">*</span>@endif</label>
                @if($isId)
                  <input type="text" name="nama" class="fc" required placeholder="Dewi R.">
                @else
                  <input type="text" name="trans[{{ $loc }}][nama]" class="fc" placeholder="(opsional)">
                @endif
              </div>
              <div class="fg">
                <label class="fl">Jabatan @if($isId)<span style="color:#ef4444">*</span>@endif</label>
                @if($isId)
                  <input type="text" name="jabatan" class="fc" required placeholder="Ibu Rumah Tangga">
                @else
                  <input type="text" name="trans[{{ $loc }}][jabatan]" class="fc" placeholder="(opsional)">
                @endif
              </div>
            </div>
            <div class="fg">
              <label class="fl">Isi Testimoni @if($isId)<span style="color:#ef4444">*</span>@endif</label>
              @if($isId)
                <textarea name="isi" class="fc" rows="3" required placeholder="Ceritakan pengalaman pelanggan..."></textarea>
              @else
                <textarea name="trans[{{ $loc }}][isi]" class="fc" rows="3" placeholder="(opsional)"></textarea>
              @endif
            </div>
          </div>
          @endforeach
        </div>
        {{-- Non-translatable --}}
        <div class="frow frow-3">
          <div class="fg">
            <label class="fl">Rating (1–5)</label>
            <input type="number" name="rating" class="fc" value="5.0" min="1" max="5" step="0.1">
          </div>
          <div class="fg">
            <label class="fl">Inisial Avatar</label>
            <input type="text" name="inisial" class="fc" maxlength="4" placeholder="DR">
          </div>
          <div class="fg">
            <label class="fl">Warna Avatar</label>
            <input type="color" name="warna" class="fc" value="#C86A44" style="height:42px;padding:4px 8px">
          </div>
        </div>
        <div class="frow frow-2">
          <div class="fg">
            <label class="fl">Urutan Tampil</label>
            <input type="number" name="urutan" class="fc" placeholder="Otomatis" min="1">
          </div>
          <div class="fg">
            <label class="fl">Foto Profil (opsional)</label>
            <input type="file" name="foto" class="fc" accept="image/*">
          </div>
        </div>
        <div class="fg" style="display:flex;align-items:center;gap:10px">
          <input type="checkbox" name="aktif" id="add-aktif" value="1" checked>
          <label for="add-aktif" style="font-size:13px;color:var(--ctm);cursor:pointer">Tampilkan di homepage</label>
        </div>
      </div>
      <div class="modal-ft">
        <button type="button" class="btn btn-outline" onclick="closeModal('m-add')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Testimoni</button>
      </div>
    </form>
  </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal-overlay" id="m-edit" onclick="handleOC(event,'m-edit')">
  <div class="modal">
    <div class="modal-hd">
      <div style="width:36px;height:36px;border-radius:var(--r2);background:var(--cpl);display:grid;place-items:center;color:var(--cp)">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
      </div>
      <div><p class="modal-title">Edit Testimoni</p><p class="modal-sub">Perbarui data testimoni</p></div>
      <button class="modal-close" onclick="closeModal('m-edit')">✕</button>
    </div>
    <form method="POST" id="edit-form" enctype="multipart/form-data">
      @csrf @method('PUT')
      <div class="modal-body">
        {{-- Translatable --}}
        <div class="lang-section">
          <div style="font-size:12px;color:var(--cmt);margin-bottom:10px;font-weight:600">🌐 Konten per Bahasa</div>
          <div class="lang-tabs" id="edit-testi-tabs">
            @foreach($languages as $lang)
            <button type="button" class="lang-tab {{ $loop->first ? 'active' : '' }}"
              onclick="switchLangTab('edit-testi', this, '{{ $lang->code }}')">
              {{ $lang->flag }} {{ $lang->native_name }}
            </button>
            @endforeach
          </div>
          @foreach($languages as $lang)
          @php $isId = $lang->code === 'id'; $loc = $lang->code; @endphp
          <div class="lang-pane {{ $loop->first ? 'active' : '' }}" id="edit-testi-pane-{{ $loc }}" dir="{{ $lang->dir }}">
            <div class="frow frow-2">
              <div class="fg">
                <label class="fl">Nama @if($isId)<span style="color:#ef4444">*</span>@endif</label>
                @if($isId)
                  <input type="text" name="nama" id="e-nama" class="fc" required>
                @else
                  <input type="text" name="trans[{{ $loc }}][nama]" id="e-nama-{{ $loc }}" class="fc" placeholder="(opsional)">
                @endif
              </div>
              <div class="fg">
                <label class="fl">Jabatan @if($isId)<span style="color:#ef4444">*</span>@endif</label>
                @if($isId)
                  <input type="text" name="jabatan" id="e-jabatan" class="fc" required>
                @else
                  <input type="text" name="trans[{{ $loc }}][jabatan]" id="e-jabatan-{{ $loc }}" class="fc" placeholder="(opsional)">
                @endif
              </div>
            </div>
            <div class="fg">
              <label class="fl">Isi Testimoni @if($isId)<span style="color:#ef4444">*</span>@endif</label>
              @if($isId)
                <textarea name="isi" id="e-isi" class="fc" rows="3" required></textarea>
              @else
                <textarea name="trans[{{ $loc }}][isi]" id="e-isi-{{ $loc }}" class="fc" rows="3" placeholder="(opsional)"></textarea>
              @endif
            </div>
          </div>
          @endforeach
        </div>
        {{-- Non-translatable --}}
        <div class="frow frow-3">
          <div class="fg">
            <label class="fl">Rating (1–5)</label>
            <input type="number" name="rating" id="e-rating" class="fc" min="1" max="5" step="0.1">
          </div>
          <div class="fg">
            <label class="fl">Inisial Avatar</label>
            <input type="text" name="inisial" id="e-inisial" class="fc" maxlength="4">
          </div>
          <div class="fg">
            <label class="fl">Warna Avatar</label>
            <input type="color" name="warna" id="e-warna" class="fc" style="height:42px;padding:4px 8px">
          </div>
        </div>
        <div class="frow frow-2">
          <div class="fg">
            <label class="fl">Urutan Tampil</label>
            <input type="number" name="urutan" id="e-urutan" class="fc" min="1">
          </div>
          <div class="fg">
            <label class="fl">Foto Profil (opsional)</label>
            <input type="file" name="foto" class="fc" accept="image/*">
          </div>
        </div>
        <div class="fg" style="display:flex;align-items:center;gap:10px">
          <input type="checkbox" name="aktif" id="e-aktif" value="1">
          <label for="e-aktif" style="font-size:13px;color:var(--ctm);cursor:pointer">Tampilkan di homepage</label>
        </div>
      </div>
      <div class="modal-ft">
        <button type="button" class="btn btn-outline" onclick="closeModal('m-edit')">Batal</button>
        <button type="submit" class="btn btn-primary">Perbarui</button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
// Auto-dismiss toast
const t = document.getElementById('auto-toast');
if (t) { setTimeout(() => t.remove(), 3500); }

// Compress foto inputs on change
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('input[type=file][name=foto]').forEach(inp => {
    inp.addEventListener('change', async () => {
      if (!inp.files || !inp.files[0]) return;
      setLoading('Mengompresi gambar...');
      await compressInputFile(inp);
      clearLoading();
    });
  });
});

function switchLangTab(section, btn, locale) {
  document.querySelectorAll(`#${section}-tabs .lang-tab`).forEach(t => t.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll(`[id^="${section}-pane-"]`).forEach(p => p.classList.remove('active'));
  const pane = document.getElementById(`${section}-pane-${locale}`);
  if (pane) pane.classList.add('active');
}

function openEdit(id, data) {
  document.getElementById('edit-form').action = '/admin/testimoni/' + id;
  // Base (ID) fields
  document.getElementById('e-nama').value    = data.nama    || '';
  document.getElementById('e-jabatan').value = data.jabatan || '';
  document.getElementById('e-isi').value     = data.isi     || '';
  document.getElementById('e-rating').value  = data.rating  || 5;
  document.getElementById('e-inisial').value = data.inisial || '';
  document.getElementById('e-warna').value   = data.warna   || '#C86A44';
  document.getElementById('e-urutan').value  = data.urutan  || '';
  document.getElementById('e-aktif').checked = data.aktif   == 1 || data.aktif === true;
  // Translation fields
  const trans = data.translations || {};
  @foreach($languages as $lang)
  @if($lang->code !== 'id')
  const tt_{{ $lang->code }} = trans['{{ $lang->code }}'] || {};
  const en_{{ $lang->code }} = document.getElementById('e-nama-{{ $lang->code }}');
  const ej_{{ $lang->code }} = document.getElementById('e-jabatan-{{ $lang->code }}');
  const ei_{{ $lang->code }} = document.getElementById('e-isi-{{ $lang->code }}');
  if (en_{{ $lang->code }}) en_{{ $lang->code }}.value = tt_{{ $lang->code }}.nama    || '';
  if (ej_{{ $lang->code }}) ej_{{ $lang->code }}.value = tt_{{ $lang->code }}.jabatan || '';
  if (ei_{{ $lang->code }}) ei_{{ $lang->code }}.value = tt_{{ $lang->code }}.isi     || '';
  @endif
  @endforeach
  // Reset to first tab
  const firstTab = document.querySelector('#edit-testi-tabs .lang-tab');
  if (firstTab) switchLangTab('edit-testi', firstTab, '{{ $languages->first()->code ?? "id" }}');
  openModal('m-edit');
}
</script>
<style>
.toast { position: fixed; bottom: 24px; right: 24px; padding: 12px 20px; border-radius: var(--r2); font-size: 13.5px; font-weight: 500; z-index: 9999; box-shadow: var(--s3); }
.toast-success { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
</style>
@endpush
@endsection
