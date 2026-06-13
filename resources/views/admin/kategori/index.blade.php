@extends('layouts.admin')
@section('title', 'Kategori Produk')
@section('breadcrumb')
  <a href="{{ route('admin.produk.index') }}">Produk</a>
  <span class="sep">/</span>
  <span class="cur">Kategori</span>
@endsection

@section('content')
<div class="pg-hd">
  <div>
    <h1>Kategori Produk</h1>
    <p>Kelola kategori untuk pengelompokan produk.</p>
  </div>
  <div class="pg-hd-acts">
    <a href="{{ route('admin.produk.index') }}" class="btn btn-outline">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
      Kembali ke Produk
    </a>
    <button class="btn btn-primary" onclick="openModal('m-add')">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Tambah Kategori
    </button>
  </div>
</div>

{{-- KPI --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px">
  <div class="kpi">
    <div class="kpi-icon" style="background:var(--cpl)">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--cp)" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
    </div>
    <div><div class="kpi-val">{{ $kategoris->count() }}</div><div class="kpi-label">Total Kategori</div></div>
  </div>
  <div class="kpi">
    <div class="kpi-icon" style="background:rgba(34,197,94,.1)">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    </div>
    <div><div class="kpi-val">{{ $kategoris->where('aktif', true)->count() }}</div><div class="kpi-label">Kategori Aktif</div></div>
  </div>
  <div class="kpi">
    <div class="kpi-icon" style="background:rgba(59,130,246,.1)">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>
    </div>
    <div><div class="kpi-val">{{ $kategoris->sum('products_count') }}</div><div class="kpi-label">Total Produk</div></div>
  </div>
</div>

{{-- TABLE --}}
<div class="card">
  <div class="card-hd">
    <h3>Daftar Kategori</h3>
    <div style="font-size:12px;color:var(--cmt)">Urut berdasarkan nomor urutan</div>
  </div>
  <div class="card-body" style="padding:0">
    @if($kategoris->isEmpty())
    <div style="padding:48px;text-align:center;color:var(--cmt)">
      <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom:12px;opacity:.4"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
      <p>Belum ada kategori. Tambahkan kategori pertama.</p>
    </div>
    @else
    <div class="tbl-wrap">
      <table>
        <thead>
          <tr>
            <th style="width:48px">Urutan</th>
            <th>Nama (ID)</th>
            @foreach($languages as $lang)
            @if($lang->code !== 'id')
            <th>{{ $lang->flag }} {{ $lang->native_name }}</th>
            @endif
            @endforeach
            <th style="width:100px;text-align:center">Jml Produk</th>
            <th style="width:80px;text-align:center">Status</th>
            <th style="width:90px;text-align:right">Aksi</th>
          </tr>
        </thead>
        <tbody id="kat-tbody">
          @foreach($kategoris as $kat)
          <tr id="row-{{ $kat->id }}">
            <td style="text-align:center;font-weight:600;color:var(--cmt)">{{ $kat->urutan }}</td>
            <td><span style="font-weight:600;color:var(--ctm)">{{ $kat->nama }}</span><div style="font-size:11px;color:var(--cmt);font-family:monospace">{{ $kat->slug }}</div></td>
            @foreach($languages as $lang)
            @if($lang->code !== 'id')
            <td style="font-size:12.5px;color:var(--cmt)">
              {{ ($kat->translations[$lang->code]['nama'] ?? '') ?: '—' }}
            </td>
            @endif
            @endforeach
            <td style="text-align:center"><span class="badge" style="background:rgba(59,130,246,.1);color:#3b82f6">{{ $kat->products_count }} produk</span></td>
            <td style="text-align:center">
              <label class="tog">
                <input type="checkbox" {{ $kat->aktif ? 'checked' : '' }} onchange="toggleKat({{ $kat->id }}, this)">
                <span class="tog-sl"></span>
              </label>
            </td>
            <td style="text-align:right">
              <div style="display:flex;gap:6px;justify-content:flex-end">
                <button class="act-btn" title="Edit" onclick="editKat({{ $kat->id }})">
                  <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </button>
                <button class="act-btn del" title="Hapus" onclick="deleteKat({{ $kat->id }}, '{{ addslashes($kat->nama) }}', {{ $kat->products_count }})">
                  <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                </button>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @endif
  </div>
</div>

{{-- MODAL TAMBAH --}}
<div class="modal-overlay" id="m-add" onclick="handleOC(event,'m-add')">
  <div class="modal">
    <div class="modal-hd">
      <div class="modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg></div>
      <div><h3>Tambah Kategori</h3><p>Buat kategori baru untuk produk.</p></div>
      <button class="modal-close" onclick="closeModal('m-add')">×</button>
    </div>
    <form onsubmit="submitAdd(event)">
      <div class="modal-body">

        {{-- Nama per bahasa --}}
        <div class="fg">
          <label class="fl">Nama Kategori <span style="color:#ef4444">*</span></label>
          @if($languages->count() > 1)
          <div class="lang-tabs" id="add-kat-tabs">
            @foreach($languages as $lang)
            <button type="button" class="lang-tab {{ $loop->first ? 'active' : '' }}"
              onclick="switchLangTab('add-kat', this, '{{ $lang->code }}')">
              {{ $lang->flag }} {{ $lang->native_name }}
            </button>
            @endforeach
          </div>
          @endif
          @foreach($languages as $lang)
          <div id="add-kat-pane-{{ $lang->code }}" class="lang-pane {{ $loop->first ? 'active' : '' }}">
            @if($lang->code === 'id')
            <input type="text" id="add-nama" class="fc" placeholder="Minuman Herbal" {{ $loop->first ? 'required' : '' }} maxlength="100"
              oninput="document.getElementById('add-slug-preview').textContent = slugify(this.value)">
            @else
            <input type="text" id="add-nama-{{ $lang->code }}" class="fc"
              placeholder="Nama dalam {{ $lang->native_name }}" maxlength="100" dir="{{ $lang->dir ?? 'ltr' }}">
            @endif
          </div>
          @endforeach
          <div style="margin-top:5px;font-size:11.5px;color:var(--cmt)">
            Slug: <span id="add-slug-preview" style="font-family:monospace"></span>
          </div>
        </div>

        <div class="frow frow-2">
          <div class="fg">
            <label class="fl">Nomor Urutan</label>
            <input type="number" id="add-urutan" class="fc" placeholder="Otomatis" min="0">
          </div>
          <div class="fg" style="display:flex;align-items:center;gap:10px;padding-top:20px">
            <label class="tog"><input type="checkbox" id="add-aktif" checked><span class="tog-sl"></span></label>
            <span style="font-size:13px;color:var(--ctm)">Aktif</span>
          </div>
        </div>
      </div>
      <div class="modal-ft">
        <button type="button" class="btn btn-outline" onclick="closeModal('m-add')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Kategori</button>
      </div>
    </form>
  </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal-overlay" id="m-edit" onclick="handleOC(event,'m-edit')">
  <div class="modal">
    <div class="modal-hd">
      <div class="modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></div>
      <div><h3>Edit Kategori</h3><p id="edit-subtitle" style="font-size:12.5px;color:var(--cmt)"></p></div>
      <button class="modal-close" onclick="closeModal('m-edit')">×</button>
    </div>
    <form onsubmit="submitEdit(event)">
      <input type="hidden" id="edit-id">
      <div class="modal-body">

        {{-- Nama per bahasa --}}
        <div class="fg">
          <label class="fl">Nama Kategori <span style="color:#ef4444">*</span></label>
          @if($languages->count() > 1)
          <div class="lang-tabs" id="edit-kat-tabs">
            @foreach($languages as $lang)
            <button type="button" class="lang-tab {{ $loop->first ? 'active' : '' }}"
              onclick="switchLangTab('edit-kat', this, '{{ $lang->code }}')">
              {{ $lang->flag }} {{ $lang->native_name }}
            </button>
            @endforeach
          </div>
          @endif
          @foreach($languages as $lang)
          <div id="edit-kat-pane-{{ $lang->code }}" class="lang-pane {{ $loop->first ? 'active' : '' }}">
            @if($lang->code === 'id')
            <input type="text" id="edit-nama" class="fc" required maxlength="100"
              oninput="document.getElementById('edit-slug-preview').textContent = slugify(this.value);
                       document.getElementById('edit-rename-warn').style.display = (this.value.trim() !== editOrigNama) ? 'block' : 'none'">
            @else
            <input type="text" id="edit-nama-{{ $lang->code }}" class="fc"
              placeholder="Nama dalam {{ $lang->native_name }}" maxlength="100" dir="{{ $lang->dir ?? 'ltr' }}">
            @endif
          </div>
          @endforeach
          <div style="margin-top:5px;font-size:11.5px;color:var(--cmt)">
            Slug: <span id="edit-slug-preview" style="font-family:monospace"></span>
          </div>
        </div>

        <div class="frow frow-2">
          <div class="fg">
            <label class="fl">Nomor Urutan</label>
            <input type="number" id="edit-urutan" class="fc" min="0">
          </div>
          <div class="fg" style="display:flex;align-items:center;gap:10px;padding-top:20px">
            <label class="tog"><input type="checkbox" id="edit-aktif"><span class="tog-sl"></span></label>
            <span style="font-size:13px;color:var(--ctm)">Aktif</span>
          </div>
        </div>
        <div id="edit-rename-warn" style="display:none;background:rgba(245,158,11,.08);border:1px solid rgba(245,158,11,.3);border-radius:var(--r1);padding:10px 12px;font-size:12.5px;color:#b45309">
          ⚠️ Mengubah nama kategori akan otomatis memperbarui semua produk yang menggunakan kategori ini.
        </div>
      </div>
      <div class="modal-ft">
        <button type="button" class="btn btn-outline" onclick="closeModal('m-edit')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
const KATS = @json($kategoris);

function slugify(str) {
  return str.toLowerCase().trim()
    .replace(/[^a-z0-9\s-]/g, '')
    .replace(/[\s_]+/g, '-')
    .replace(/-+/g, '-');
}

function switchLangTab(section, btn, locale) {
  document.querySelectorAll(`#${section}-kat-tabs .lang-tab`).forEach(t => t.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll(`[id^="${section}-kat-pane-"]`).forEach(p => p.classList.remove('active'));
  const pane = document.getElementById(`${section}-kat-pane-${locale}`);
  if (pane) pane.classList.add('active');
}

function getTransPayload(prefix) {
  const trans = {};
  @foreach($languages as $lang)
  @if($lang->code !== 'id')
  const el_{{ $lang->code }} = document.getElementById(`${prefix}-nama-{{ $lang->code }}`);
  if (el_{{ $lang->code }} && el_{{ $lang->code }}.value.trim()) {
    trans['{{ $lang->code }}'] = { nama: el_{{ $lang->code }}.value.trim() };
  }
  @endif
  @endforeach
  return trans;
}

// ── ADD ──────────────────────────────────────────────────────────────────
async function submitAdd(e) {
  e.preventDefault();
  const nama = document.getElementById('add-nama').value.trim();
  if (!nama) return;
  setLoading('Menyimpan kategori...');
  const trans = getTransPayload('add');
  const payload = {
    nama,
    urutan: document.getElementById('add-urutan').value || null,
    aktif:  document.getElementById('add-aktif').checked ? 1 : 0,
  };
  // flatten translations into trans[locale][field]
  Object.keys(trans).forEach(loc => {
    Object.keys(trans[loc]).forEach(field => {
      payload[`trans[${loc}][${field}]`] = trans[loc][field];
    });
  });
  const r = await apiFetch("{{ route('admin.kategori.store') }}", 'POST', payload);
  clearLoading();
  if (r.success) { showToast(r.message); closeModal('m-add'); location.reload(); }
  else showToast(r.message || 'Terjadi kesalahan.', 'error');
}

// ── EDIT ─────────────────────────────────────────────────────────────────
let editOrigNama = '';
function editKat(id) {
  const k = KATS.find(x => x.id === id);
  if (!k) return;
  editOrigNama = k.nama;
  document.getElementById('edit-id').value      = id;
  document.getElementById('edit-subtitle').textContent = k.nama;
  document.getElementById('edit-nama').value    = k.nama;
  document.getElementById('edit-slug-preview').textContent = k.slug;
  document.getElementById('edit-urutan').value  = k.urutan;
  document.getElementById('edit-aktif').checked = !!k.aktif;
  document.getElementById('edit-rename-warn').style.display = 'none';
  // Fill translation fields
  const trans = k.translations || {};
  @foreach($languages as $lang)
  @if($lang->code !== 'id')
  const el_{{ $lang->code }} = document.getElementById('edit-nama-{{ $lang->code }}');
  if (el_{{ $lang->code }}) el_{{ $lang->code }}.value = (trans['{{ $lang->code }}'] || {}).nama || '';
  @endif
  @endforeach
  // Reset to first tab
  const firstTab = document.querySelector('#edit-kat-tabs .lang-tab');
  if (firstTab) switchLangTab('edit', firstTab, '{{ $languages->first()->code ?? "id" }}');
  openModal('m-edit');
}

async function submitEdit(e) {
  e.preventDefault();
  const id = document.getElementById('edit-id').value;
  setLoading('Menyimpan kategori...');
  const trans = getTransPayload('edit');
  const payload = {
    nama:   document.getElementById('edit-nama').value.trim(),
    urutan: document.getElementById('edit-urutan').value || 0,
    aktif:  document.getElementById('edit-aktif').checked ? 1 : 0,
  };
  Object.keys(trans).forEach(loc => {
    Object.keys(trans[loc]).forEach(field => {
      payload[`trans[${loc}][${field}]`] = trans[loc][field];
    });
  });
  const r = await apiFetch(`/admin/kategori/${id}`, 'PUT', payload);
  clearLoading();
  if (r.success) { showToast(r.message); closeModal('m-edit'); location.reload(); }
  else showToast(r.message || 'Terjadi kesalahan.', 'error');
}

// ── TOGGLE ───────────────────────────────────────────────────────────────
async function toggleKat(id, checkbox) {
  const r = await apiFetch(`/admin/kategori/${id}/toggle`, 'PATCH');
  if (r.success) showToast(r.message);
  else { showToast(r.message || 'Gagal.', 'error'); checkbox.checked = !checkbox.checked; }
}

// ── DELETE ───────────────────────────────────────────────────────────────
async function deleteKat(id, nama, count) {
  if (count > 0) { showToast(`Tidak bisa dihapus — ada ${count} produk di kategori ini.`, 'error'); return; }
  if (!confirm(`Hapus kategori "${nama}"?`)) return;
  setLoading('Menghapus...');
  const r = await apiFetch(`/admin/kategori/${id}`, 'DELETE');
  clearLoading();
  if (r.success) { showToast(r.message); document.getElementById(`row-${id}`)?.remove(); }
  else showToast(r.message || 'Gagal menghapus.', 'error');
}
</script>
@endpush
