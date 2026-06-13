@extends('layouts.admin')

@section('title', 'Manajemen Produk')
@section('breadcrumb')
  <span class="cur">Produk</span>
@endsection

@section('content')
<div class="pg-hd">
  <div>
    <h1>Manajemen Produk</h1>
    <p>Total {{ $products->total() }} produk terdaftar</p>
  </div>
  <div class="pg-hd-acts">
    <a href="{{ route('admin.produk.export-csv') }}" class="btn btn-outline">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
      Export CSV
    </a>
    <button class="btn btn-primary" onclick="openModal('m-add')">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Tambah Produk
    </button>
  </div>
</div>

<!-- FILTER -->
<form method="GET" class="filter-bar">
  <div class="search-wrap">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <input type="text" name="search" class="fc" placeholder="Cari nama, SKU..." value="{{ request('search') }}">
  </div>
  <select name="status" class="fc">
    <option value="">Semua Status</option>
    <option value="tersedia" {{ request('status')=='tersedia'?'selected':'' }}>Tersedia</option>
    <option value="hampir-habis" {{ request('status')=='hampir-habis'?'selected':'' }}>Hampir Habis</option>
    <option value="habis" {{ request('status')=='habis'?'selected':'' }}>Habis</option>
  </select>
  <select name="kategori" class="fc">
    <option value="">Semua Kategori</option>
    @foreach($kategoris as $k)
    <option value="{{ $k }}" {{ request('kategori')==$k?'selected':'' }}>{{ $k }}</option>
    @endforeach
  </select>
  <button type="submit" class="btn btn-outline">Filter</button>
  @if(request()->hasAny(['search','status','kategori']))
    <a href="{{ route('admin.produk.index') }}" class="btn btn-outline">Reset</a>
  @endif
</form>

<!-- BULK BAR -->
<div class="bulk-bar" id="bulk-bar">
  <span class="bulk-info" id="bulk-info">0 dipilih</span>
  <button class="btn btn-danger btn-sm" onclick="bulkDelete()">Hapus Terpilih</button>
  <button class="btn btn-outline btn-sm" onclick="clearSel()">Batal</button>
</div>

<!-- TABLE -->
<div class="card">
  <div class="tbl-wrap">
    <table>
      <thead>
        <tr>
          <th style="width:36px"><input type="checkbox" id="chk-all" onchange="toggleAll(this)"></th>
          <th>Produk</th><th>SKU</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Status</th><th>Featured</th><th style="width:90px">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($products as $p)
        <tr>
          <td><input type="checkbox" class="row-chk" value="{{ $p->id }}" onchange="toggleRow({{ $p->id }}, this)"></td>
          <td>
            <div style="display:flex;align-items:center;gap:10px">
              <div style="width:38px;height:38px;background:var(--cbg);border-radius:var(--r1);display:grid;place-items:center;flex-shrink:0;overflow:hidden">
                @if($p->fotos)
                  <img src="{{ asset('storage/'.($p->fotos[0] ?? '')) }}" alt="" style="width:100%;height:100%;object-fit:cover" onerror="this.style.display='none'">
                @else
                  <span style="font-size:18px">📦</span>
                @endif
              </div>
              <div>
                <div style="font-weight:600;font-size:13px">{{ $p->nama }}</div>
                <div style="font-size:11.5px;color:var(--cmt)">{{ Str::limit($p->deskripsi, 45) }}</div>
              </div>
            </div>
          </td>
          <td style="font-family:monospace;font-size:12px;color:var(--cmt)">{{ $p->sku }}</td>
          <td style="font-size:12.5px">{{ $p->kategori }}</td>
          <td style="font-weight:600;font-size:13px;white-space:nowrap">{{ $p->harga_formatted }}</td>
          <td>
            <div style="display:flex;align-items:center;gap:6px">
              <div style="flex:1;height:5px;background:var(--cbg);border-radius:99px;min-width:50px">
                <div style="height:100%;background:{{ $p->stok > 10 ? '#22c55e' : ($p->stok > 0 ? '#f59e0b' : '#ef4444') }};border-radius:99px;width:{{ min(100, $p->stok) }}%"></div>
              </div>
              <span style="font-size:12px;font-weight:600">{{ $p->stok }}</span>
            </div>
          </td>
          <td>
            <span class="badge {{ $p->status === 'tersedia' ? 's-tersedia' : ($p->status === 'habis' ? 's-habis' : 's-hampir') }}">
              {{ ucfirst($p->status) }}
            </span>
          </td>
          <td style="text-align:center">
            @if($p->is_featured)
              <span style="color:#f59e0b;font-size:16px">★</span>
            @else
              <span style="color:var(--cms);font-size:16px">☆</span>
            @endif
          </td>
          <td>
            <div style="display:flex;gap:4px">
              <button class="act-btn" onclick="editProduk({{ $p->id }})" title="Edit" data-id="{{ $p->id }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
              </button>
              <button class="act-btn del" onclick="deleteProduk({{ $p->id }}, '{{ addslashes($p->nama) }}')" title="Hapus">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
              </button>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="9" style="text-align:center;padding:40px;color:var(--cmt)">Belum ada produk.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($products->hasPages())
  <div style="padding:16px 20px;border-top:1px solid var(--cbg)">
    {{ $products->links('vendor.pagination.custom') }}
  </div>
  @endif
</div>

<!-- MODAL TAMBAH -->
<div class="modal-overlay" id="m-add" onclick="handleOC(event,'m-add')">
  <div class="modal modal-lg">
    <div class="modal-hd">
      <div class="modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg></div>
      <div><h3>Tambah Produk Baru</h3><p>Isi informasi produk herbal</p></div>
      <button class="modal-close" onclick="closeModal('m-add')">&times;</button>
    </div>
    <form id="f-add" onsubmit="submitAdd(event)">
      @csrf
      <div class="modal-body">
        {{-- Non-translatable fields --}}
        <div class="frow frow-2">
          <div class="fg"><label class="fl">SKU *</label><input type="text" name="sku" class="fc" required placeholder="AS-001" id="add-sku"></div>
          <div class="fg">
            <label class="fl">Kategori *</label>
            <select name="kategori" class="fc" required>
              <option value="">Pilih kategori...</option>
              @foreach($kategoris as $k)<option value="{{ $k }}">{{ $k }}</option>@endforeach
            </select>
          </div>
        </div>
        <div class="frow frow-2">
          <div class="fg"><label class="fl">Harga (Rp) *</label><input type="number" name="harga" class="fc" required placeholder="85000" min="0"></div>
          <div class="fg"><label class="fl">Stok *</label><input type="number" name="stok" class="fc" required placeholder="50" min="0"></div>
        </div>
        <div class="fg">
          <label class="fl">Foto Produk <span style="color:var(--cmt);font-weight:400;font-size:11px">(maks 5 foto, sama untuk semua bahasa)</span></label>
          <div class="foto-grid" id="add-foto-grid"></div>
          <input type="file" id="add-foto-input" accept="image/*" multiple style="display:none" onchange="handleAddFotos(this)">
          <p style="font-size:11px;color:var(--cmt);margin-top:4px">JPG/PNG/WEBP, maks 2MB per foto</p>
        </div>
        {{-- Translatable fields with language tabs --}}
        <div class="lang-section">
          <div style="font-size:12px;color:var(--cmt);margin-bottom:10px;font-weight:600">🌐 Konten per Bahasa</div>
          <div class="lang-tabs" id="add-prod-tabs">
            @foreach($languages as $lang)
            <button type="button" class="lang-tab {{ $loop->first ? 'active' : '' }}"
              onclick="switchLangTab('add-prod', this, '{{ $lang->code }}')">
              {{ $lang->flag }} {{ $lang->native_name }}
            </button>
            @endforeach
          </div>
          @foreach($languages as $lang)
          @php $isId = $lang->code === 'id'; $loc = $lang->code; @endphp
          <div class="lang-pane {{ $loop->first ? 'active' : '' }}" id="add-prod-pane-{{ $loc }}" dir="{{ $lang->dir }}">
            <div class="fg">
              <label class="fl">Nama Produk *</label>
              @if($isId)
                <input type="text" name="nama" class="fc" required placeholder="Jahe Merah Plus">
              @else
                <input type="text" name="trans[{{ $loc }}][nama]" class="fc" placeholder="Terjemahan nama produk (opsional)">
              @endif
            </div>
            <div class="fg">
              <label class="fl">Deskripsi</label>
              @if($isId)
                <textarea name="deskripsi" class="fc" rows="3" placeholder="Deskripsi produk..."></textarea>
              @else
                <textarea name="trans[{{ $loc }}][deskripsi]" class="fc" rows="3" placeholder="Terjemahan deskripsi (opsional)"></textarea>
              @endif
            </div>
            <div class="fg">
              <label class="fl">Cara Pakai</label>
              @if($isId)
                <textarea name="cara_pakai" class="fc" rows="2" placeholder="Cara penggunaan..."></textarea>
              @else
                <textarea name="trans[{{ $loc }}][cara_pakai]" class="fc" rows="2" placeholder="Terjemahan cara pakai (opsional)"></textarea>
              @endif
            </div>
            <div class="fg">
              <label class="fl">Kandungan <span style="color:var(--cmt);font-weight:400;font-size:11px">(pisahkan koma)</span></label>
              @if($isId)
                <input type="text" id="add-kandungan" name="kandungan_raw" class="fc" placeholder="Jahe Merah, Madu Hutan">
              @else
                <input type="text" id="add-kandungan-{{ $loc }}" name="trans[{{ $loc }}][kandungan_raw]" class="fc" placeholder="Terjemahan kandungan (opsional)" dir="{{ $lang->dir ?? 'ltr' }}">
              @endif
            </div>
          </div>
          @endforeach
        </div>

        <div style="display:flex;align-items:center;gap:8px">
          <label class="tog"><input type="checkbox" name="is_featured" value="1" id="add-featured"><span class="tog-sl"></span></label>
          <span style="font-size:13px">Tampilkan di halaman utama (Featured)</span>
        </div>
      </div>
      <div class="modal-ft">
        <button type="button" class="btn btn-outline" onclick="closeModal('m-add')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Produk</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL EDIT -->
<div class="modal-overlay" id="m-edit" onclick="handleOC(event,'m-edit')">
  <div class="modal modal-lg">
    <div class="modal-hd">
      <div class="modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></div>
      <div><h3>Edit Produk</h3><p id="edit-subtitle">Perbarui informasi produk</p></div>
      <button class="modal-close" onclick="closeModal('m-edit')">&times;</button>
    </div>
    <form id="f-edit" onsubmit="submitEdit(event)">
      @csrf @method('PUT')
      <input type="hidden" id="edit-id">
      <div class="modal-body">
        {{-- Non-translatable fields --}}
        <div class="frow frow-2">
          <div class="fg"><label class="fl">SKU *</label><input type="text" id="edit-sku" name="sku" class="fc" required></div>
          <div class="fg">
            <label class="fl">Kategori *</label>
            <select id="edit-kategori" name="kategori" class="fc" required>
              @foreach($kategoris as $k)<option value="{{ $k }}">{{ $k }}</option>@endforeach
            </select>
          </div>
        </div>
        <div class="frow frow-2">
          <div class="fg"><label class="fl">Harga (Rp) *</label><input type="number" id="edit-harga" name="harga" class="fc" required min="0"></div>
          <div class="fg"><label class="fl">Stok *</label><input type="number" id="edit-stok" name="stok" class="fc" required min="0"></div>
        </div>
        <div class="fg">
          <label class="fl">Foto Produk <span style="color:var(--cmt);font-weight:400;font-size:11px">(maks 5 foto, sama untuk semua bahasa)</span></label>
          <div class="foto-grid" id="edit-foto-grid"></div>
          <input type="file" id="edit-foto-input" accept="image/*" multiple style="display:none" onchange="handleEditFotos(this)">
          <p style="font-size:11px;color:var(--cmt);margin-top:4px">JPG/PNG/WEBP, maks 2MB per foto. Klik × untuk hapus foto lama.</p>
        </div>
        {{-- Translatable fields with language tabs --}}
        <div class="lang-section">
          <div style="font-size:12px;color:var(--cmt);margin-bottom:10px;font-weight:600">🌐 Konten per Bahasa</div>
          <div class="lang-tabs" id="edit-prod-tabs">
            @foreach($languages as $lang)
            <button type="button" class="lang-tab {{ $loop->first ? 'active' : '' }}"
              onclick="switchLangTab('edit-prod', this, '{{ $lang->code }}')">
              {{ $lang->flag }} {{ $lang->native_name }}
            </button>
            @endforeach
          </div>
          @foreach($languages as $lang)
          @php $isId = $lang->code === 'id'; $loc = $lang->code; @endphp
          <div class="lang-pane {{ $loop->first ? 'active' : '' }}" id="edit-prod-pane-{{ $loc }}" dir="{{ $lang->dir }}">
            <div class="fg">
              <label class="fl">Nama Produk *</label>
              @if($isId)
                <input type="text" id="edit-nama" name="nama" class="fc" required>
              @else
                <input type="text" id="edit-nama-{{ $loc }}" name="trans[{{ $loc }}][nama]" class="fc" placeholder="Terjemahan nama produk (opsional)">
              @endif
            </div>
            <div class="fg">
              <label class="fl">Deskripsi</label>
              @if($isId)
                <textarea id="edit-deskripsi" name="deskripsi" class="fc" rows="3"></textarea>
              @else
                <textarea id="edit-deskripsi-{{ $loc }}" name="trans[{{ $loc }}][deskripsi]" class="fc" rows="3" placeholder="Terjemahan deskripsi (opsional)"></textarea>
              @endif
            </div>
            <div class="fg">
              <label class="fl">Cara Pakai</label>
              @if($isId)
                <textarea id="edit-cara" name="cara_pakai" class="fc" rows="2"></textarea>
              @else
                <textarea id="edit-cara-{{ $loc }}" name="trans[{{ $loc }}][cara_pakai]" class="fc" rows="2" placeholder="Terjemahan cara pakai (opsional)"></textarea>
              @endif
            </div>
            <div class="fg">
              <label class="fl">Kandungan <span style="color:var(--cmt);font-weight:400;font-size:11px">(pisahkan koma)</span></label>
              @if($isId)
                <input type="text" id="edit-kandungan" name="kandungan_raw" class="fc" placeholder="Jahe Merah, Madu Hutan">
              @else
                <input type="text" id="edit-kandungan-{{ $loc }}" name="trans[{{ $loc }}][kandungan_raw]" class="fc" placeholder="Terjemahan kandungan (opsional)" dir="{{ $lang->dir ?? 'ltr' }}">
              @endif
            </div>
          </div>
          @endforeach
        </div>

        <div style="display:flex;align-items:center;gap:8px">
          <label class="tog"><input type="checkbox" id="edit-featured" name="is_featured" value="1"><span class="tog-sl"></span></label>
          <span style="font-size:13px">Tampilkan di halaman utama (Featured)</span>
        </div>
      </div>
      <div class="modal-ft">
        <button type="button" class="btn btn-outline" onclick="closeModal('m-edit')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<!-- DATA JSON -->
<script id="prod-data" type="application/json">
  {!! json_encode($products->items(), JSON_UNESCAPED_UNICODE) !!}
</script>

@endsection

@push('styles')
<style>
.foto-grid{display:flex;flex-wrap:wrap;gap:8px;min-height:84px;align-items:flex-start}
.foto-slot{width:80px;height:80px;border:2px dashed var(--cms);border-radius:var(--r2);overflow:hidden;position:relative;flex-shrink:0}
.foto-slot img{width:100%;height:100%;object-fit:cover;display:block}
.foto-rm{position:absolute;top:3px;right:3px;width:20px;height:20px;background:rgba(239,68,68,.85);color:#fff;border:none;border-radius:50%;cursor:pointer;font-size:14px;display:grid;place-items:center;padding:0;line-height:1}
.foto-rm:hover{background:#ef4444}
.foto-add-slot{cursor:pointer;background:var(--cbg);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:4px;font-size:11px;color:var(--cmt);border-style:dashed;transition:var(--tr)}
.foto-add-slot:hover{border-color:var(--cp);color:var(--cp);background:var(--cpl)}
</style>
@endpush

@push('scripts')
<script>
const PRODS = JSON.parse(document.getElementById('prod-data').textContent);
let selected = new Set();

function toggleAll(cb) {
  document.querySelectorAll('.row-chk').forEach(c => {
    c.checked = cb.checked;
    cb.checked ? selected.add(+c.value) : selected.delete(+c.value);
  });
  updateBulk();
}
function toggleRow(id, cb) {
  cb.checked ? selected.add(id) : selected.delete(id);
  updateBulk();
}
function updateBulk() {
  const n = selected.size;
  document.getElementById('bulk-bar').classList.toggle('show', n > 0);
  document.getElementById('bulk-info').textContent = n + ' produk dipilih';
}
function clearSel() {
  selected.clear();
  document.querySelectorAll('.row-chk, #chk-all').forEach(c => c.checked = false);
  updateBulk();
}

// AUTO-SKU dari nama
document.querySelector('#f-add [name=nama]').addEventListener('input', function() {
  const count = {{ $products->total() + 1 }};
  document.getElementById('add-sku').value = 'AS-' + String(count).padStart(3,'0');
});

// ─── MULTI-FOTO: Add Modal ───────────────────────────────────────────
let addFotoFiles = [];

function renderAddGrid() {
  const grid = document.getElementById('add-foto-grid');
  grid.innerHTML = '';
  addFotoFiles.forEach((file, i) => {
    const slot = document.createElement('div');
    slot.className = 'foto-slot';
    slot.innerHTML = `<img src="${URL.createObjectURL(file)}"><button type="button" class="foto-rm" onclick="removeAddFoto(${i})">×</button>`;
    grid.appendChild(slot);
  });
  if (addFotoFiles.length < 5) {
    const add = document.createElement('div');
    add.className = 'foto-slot foto-add-slot';
    add.onclick = () => document.getElementById('add-foto-input').click();
    add.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg><span>Tambah</span>';
    grid.appendChild(add);
  }
}
async function handleAddFotos(input) {
  const newFiles = Array.from(input.files).slice(0, 5 - addFotoFiles.length);
  input.value = '';
  if (!newFiles.length) return;
  setLoading('Mengompresi gambar...');
  const compressed = await Promise.all(newFiles.map(f => compressImage(f)));
  clearLoading();
  compressed.forEach(f => addFotoFiles.push(f));
  renderAddGrid();
}
function removeAddFoto(i) { addFotoFiles.splice(i, 1); renderAddGrid(); }

// Reset add modal foto state on open
document.querySelector('[onclick="openModal(\'m-add\')"]')?.addEventListener('click', () => {
  addFotoFiles = []; renderAddGrid();
});
// Also init on page load
renderAddGrid();

// Ubah field "kandungan_raw" (string koma) jadi array kandungan[] — termasuk per bahasa
function applyKandungan(fd) {
  const toArr = v => (v || '').split(',').map(s => s.trim()).filter(Boolean);
  const base = fd.get('kandungan_raw') || '';
  fd.delete('kandungan_raw');
  toArr(base).forEach(t => fd.append('kandungan[]', t));
  [...fd.keys()].filter(k => /^trans\[[a-z-]+\]\[kandungan_raw\]$/.test(k)).forEach(k => {
    const loc = k.match(/^trans\[([a-z-]+)\]/)[1];
    const val = fd.get(k);
    fd.delete(k);
    toArr(val).forEach(t => fd.append(`trans[${loc}][kandungan][]`, t));
  });
}

async function submitAdd(e) {
  e.preventDefault();
  setLoading('Menyimpan produk...');
  const fd = new FormData(e.target);
  applyKandungan(fd);
  fd.set('is_featured', fd.has('is_featured') ? 1 : 0);
  addFotoFiles.forEach(f => fd.append('fotos[]', f));

  const r = await apiFetch("{{ route('admin.produk.store') }}", 'POST', fd);
  clearLoading();
  if (r.success) { showToast(r.message); closeModal('m-add'); location.reload(); }
  else showToast(r.message || 'Terjadi kesalahan.', 'error');
}

function switchLangTab(section, btn, locale) {
  document.querySelectorAll(`#${section}-tabs .lang-tab`).forEach(t => t.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll(`[id^="${section}-pane-"]`).forEach(p => p.classList.remove('active'));
  const pane = document.getElementById(`${section}-pane-${locale}`);
  if (pane) pane.classList.add('active');
}

// ─── MULTI-FOTO: Edit Modal ───────────────────────────────────────────
let editFotosExisting = [];
let editFotoFiles = [];

function renderEditGrid() {
  const grid = document.getElementById('edit-foto-grid');
  grid.innerHTML = '';
  editFotosExisting.forEach((path, i) => {
    const slot = document.createElement('div');
    slot.className = 'foto-slot';
    slot.innerHTML = `<img src="/storage/${path}" onerror="this.style.opacity='.3'"><button type="button" class="foto-rm" onclick="removeEditExisting(${i})">×</button>`;
    grid.appendChild(slot);
  });
  editFotoFiles.forEach((file, i) => {
    const slot = document.createElement('div');
    slot.className = 'foto-slot';
    slot.innerHTML = `<img src="${URL.createObjectURL(file)}"><button type="button" class="foto-rm" onclick="removeEditNew(${i})">×</button>`;
    grid.appendChild(slot);
  });
  if (editFotosExisting.length + editFotoFiles.length < 5) {
    const add = document.createElement('div');
    add.className = 'foto-slot foto-add-slot';
    add.onclick = () => document.getElementById('edit-foto-input').click();
    add.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg><span>Tambah</span>';
    grid.appendChild(add);
  }
}
async function handleEditFotos(input) {
  const total = editFotosExisting.length + editFotoFiles.length;
  const newFiles = Array.from(input.files).slice(0, 5 - total);
  input.value = '';
  if (!newFiles.length) return;
  setLoading('Mengompresi gambar...');
  const compressed = await Promise.all(newFiles.map(f => compressImage(f)));
  clearLoading();
  compressed.forEach(f => editFotoFiles.push(f));
  renderEditGrid();
}
function removeEditExisting(i) { editFotosExisting.splice(i, 1); renderEditGrid(); }
function removeEditNew(i) { editFotoFiles.splice(i, 1); renderEditGrid(); }

function editProduk(id) {
  const p = PRODS.find(x => x.id === id);
  if (!p) return;
  document.getElementById('edit-id').value = id;
  document.getElementById('edit-subtitle').textContent = p.nama;
  document.getElementById('edit-sku').value = p.sku;
  document.getElementById('edit-harga').value = p.harga;
  document.getElementById('edit-stok').value = p.stok;
  editFotosExisting = Array.isArray(p.fotos) ? [...p.fotos] : [];
  editFotoFiles = [];
  renderEditGrid();
  document.getElementById('edit-featured').checked = !!p.is_featured;
  document.getElementById('edit-kandungan').value = (p.kandungan || []).join(', ');
  const sel = document.getElementById('edit-kategori');
  for (let o of sel.options) if (o.value === p.kategori) o.selected = true;

  // Fill ID (base) fields
  document.getElementById('edit-nama').value = p.nama || '';
  document.getElementById('edit-deskripsi').value = p.deskripsi || '';
  document.getElementById('edit-cara').value = p.cara_pakai || '';

  // Fill translation fields per non-ID locale
  const trans = p.translations || {};
  @foreach($languages as $lang)
  @if($lang->code !== 'id')
  const td_{{ $lang->code }} = trans['{{ $lang->code }}'] || {};
  const fn_{{ $lang->code }} = document.getElementById('edit-nama-{{ $lang->code }}');
  const fd_{{ $lang->code }} = document.getElementById('edit-deskripsi-{{ $lang->code }}');
  const fc_{{ $lang->code }} = document.getElementById('edit-cara-{{ $lang->code }}');
  const fk_{{ $lang->code }} = document.getElementById('edit-kandungan-{{ $lang->code }}');
  if (fn_{{ $lang->code }}) fn_{{ $lang->code }}.value = td_{{ $lang->code }}.nama || '';
  if (fd_{{ $lang->code }}) fd_{{ $lang->code }}.value = td_{{ $lang->code }}.deskripsi || '';
  if (fc_{{ $lang->code }}) fc_{{ $lang->code }}.value = td_{{ $lang->code }}.cara_pakai || '';
  if (fk_{{ $lang->code }}) fk_{{ $lang->code }}.value = (td_{{ $lang->code }}.kandungan || []).join(', ');
  @endif
  @endforeach

  // Reset to first tab
  const firstTab = document.querySelector('#edit-prod-tabs .lang-tab');
  if (firstTab) switchLangTab('edit-prod', firstTab, '{{ $languages->first()->code ?? "id" }}');

  openModal('m-edit');
}

async function submitEdit(e) {
  e.preventDefault();
  setLoading('Menyimpan produk...');
  const id = document.getElementById('edit-id').value;
  const fd = new FormData(e.target);
  applyKandungan(fd);
  fd.set('is_featured', fd.has('is_featured') ? 1 : 0);
  fd.set('_method', 'PUT');
  editFotosExisting.forEach(p => fd.append('fotos_existing[]', p));
  editFotoFiles.forEach(f => fd.append('fotos_new[]', f));

  const r = await apiFetch(`/admin/produk/${id}`, 'POST', fd);
  clearLoading();
  if (r.success) { showToast(r.message); closeModal('m-edit'); location.reload(); }
  else showToast(r.message || 'Terjadi kesalahan.', 'error');
}

async function deleteProduk(id, nama) {
  if (!confirm(`Hapus produk "${nama}"?`)) return;
  const r = await apiFetch(`/admin/produk/${id}`, 'DELETE');
  if (r.success) { showToast(r.message); location.reload(); }
  else showToast(r.message, 'error');
}

async function bulkDelete() {
  if (!selected.size || !confirm(`Hapus ${selected.size} produk?`)) return;
  const r = await apiFetch("{{ route('admin.produk.bulk-destroy') }}", 'POST', { ids: [...selected] });
  if (r.success) { showToast(r.message); location.reload(); }
  else showToast(r.message, 'error');
}

</script>
@endpush
