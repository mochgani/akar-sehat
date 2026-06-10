@extends('layouts.admin')

@section('title', 'Manajemen Konsultasi')
@section('breadcrumb')
  <span class="cur">Konsultasi</span>
@endsection

@section('content')
<div class="pg-hd">
  <div>
    <h1>Manajemen Konsultasi</h1>
    <p>Total {{ $consultations->total() }} konsultasi</p>
  </div>
  <div class="pg-hd-acts">
    <button class="btn btn-primary" onclick="openModal('m-add')">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Tambah Konsultasi
    </button>
  </div>
</div>

<!-- FILTER -->
<form method="GET" class="filter-bar">
  <div class="search-wrap">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <input type="text" name="search" class="fc" placeholder="Cari nama, kontak, keluhan..." value="{{ request('search') }}">
  </div>
  <select name="status" class="fc">
    <option value="">Semua Status</option>
    <option value="baru" {{ request('status')=='baru'?'selected':'' }}>Baru</option>
    <option value="diproses" {{ request('status')=='diproses'?'selected':'' }}>Diproses</option>
    <option value="selesai" {{ request('status')=='selesai'?'selected':'' }}>Selesai</option>
    <option value="dibatalkan" {{ request('status')=='dibatalkan'?'selected':'' }}>Dibatalkan</option>
  </select>
  <select name="sumber" class="fc">
    <option value="">Semua Sumber</option>
    <option value="whatsapp" {{ request('sumber')=='whatsapp'?'selected':'' }}>WhatsApp</option>
    <option value="website" {{ request('sumber')=='website'?'selected':'' }}>Website</option>
    <option value="referral" {{ request('sumber')=='referral'?'selected':'' }}>Referral</option>
    <option value="langsung" {{ request('sumber')=='langsung'?'selected':'' }}>Langsung</option>
  </select>
  <button type="submit" class="btn btn-outline">Filter</button>
  @if(request()->hasAny(['search','status','sumber','dari','sampai']))
    <a href="{{ route('admin.konsultasi.index') }}" class="btn btn-outline">Reset</a>
  @endif
</form>

<!-- BULK BAR -->
<div class="bulk-bar" id="bulk-bar">
  <span class="bulk-info" id="bulk-info">0 dipilih</span>
  <select id="bulk-status" class="fc" style="width:auto">
    <option value="">Ubah Status...</option>
    <option value="baru">Baru</option>
    <option value="diproses">Diproses</option>
    <option value="selesai">Selesai</option>
    <option value="dibatalkan">Dibatalkan</option>
  </select>
  <button class="btn btn-outline btn-sm" onclick="bulkUpdateStatus()">Terapkan</button>
  <button class="btn btn-danger btn-sm" onclick="bulkDelete()">Hapus Terpilih</button>
  <button class="btn btn-outline btn-sm" onclick="clearSel()">Batal</button>
</div>

<div class="card">
  <div class="tbl-wrap">
    <table>
      <thead>
        <tr>
          <th style="width:36px"><input type="checkbox" id="chk-all" onchange="toggleAll(this)"></th>
          <th>#</th><th>Nama & Kontak</th><th>Keluhan</th><th>Sumber</th><th>Prioritas</th><th>Status</th><th>Tanggal</th><th style="width:80px">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($consultations as $c)
        <tr>
          <td><input type="checkbox" class="row-chk" value="{{ $c->id }}" onchange="toggleRow({{ $c->id }}, this)"></td>
          <td style="font-size:12px;color:var(--cmt);font-family:monospace">#{{ $c->id }}</td>
          <td>
            <div style="font-weight:600;font-size:13px">{{ $c->nama }}</div>
            <div style="font-size:11.5px;color:var(--cmt)">{{ $c->kontak }}</div>
          </td>
          <td style="max-width:200px;font-size:12.5px;color:var(--cmt)">{{ Str::limit($c->keluhan, 60) }}</td>
          <td><span style="font-size:12.5px;text-transform:capitalize">{{ $c->sumber }}</span></td>
          <td>
            @php
              $pColors = ['urgent' => ['#fef2f2','#ef4444'], 'tinggi' => ['#fffbeb','#f59e0b'], 'normal' => ['var(--cbg)','var(--cmt)']];
              $pc = $pColors[$c->prioritas] ?? $pColors['normal'];
            @endphp
            <span class="badge" style="background:{{ $pc[0] }};color:{{ $pc[1] }}">{{ ucfirst($c->prioritas) }}</span>
          </td>
          <td><span class="badge s-{{ $c->status }}">{{ ucfirst($c->status) }}</span></td>
          <td style="font-size:12px;color:var(--cmt);white-space:nowrap">{{ $c->created_at->format('d M Y') }}</td>
          <td>
            <div style="display:flex;gap:4px">
              <button class="act-btn" onclick="viewKonsultasi({{ $c->id }})" title="Detail">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
              <button class="act-btn" onclick="editKonsultasi({{ $c->id }})" title="Edit">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
              </button>
              <button class="act-btn del" onclick="deleteKonsultasi({{ $c->id }}, '{{ addslashes($c->nama) }}')" title="Hapus">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
              </button>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="9" style="text-align:center;padding:40px;color:var(--cmt)">Belum ada konsultasi.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($consultations->hasPages())
  <div style="padding:16px 20px;border-top:1px solid var(--cbg)">
    {{ $consultations->links('vendor.pagination.custom') }}
  </div>
  @endif
</div>

<!-- MODAL TAMBAH -->
<div class="modal-overlay" id="m-add" onclick="handleOC(event,'m-add')">
  <div class="modal">
    <div class="modal-hd">
      <div class="modal-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
      </div>
      <div><h3>Tambah Konsultasi</h3><p>Input konsultasi baru</p></div>
      <button class="modal-close" onclick="closeModal('m-add')">&times;</button>
    </div>
    <form onsubmit="submitAdd(event)">
      @csrf
      <div class="modal-body">
        <div class="frow frow-2">
          <div class="fg"><label class="fl">Nama *</label><input type="text" name="nama" class="fc" required></div>
          <div class="fg"><label class="fl">Kontak (WA/Telp) *</label><input type="text" name="kontak" class="fc" required></div>
        </div>
        <div class="fg"><label class="fl">Keluhan *</label><textarea name="keluhan" class="fc" required placeholder="Deskripsikan keluhan pasien..."></textarea></div>
        <div class="frow frow-2">
          <div class="fg">
            <label class="fl">Sumber *</label>
            <select name="sumber" class="fc" required>
              <option value="whatsapp">WhatsApp</option>
              <option value="website">Website</option>
              <option value="referral">Referral</option>
              <option value="langsung">Langsung</option>
            </select>
          </div>
          <div class="fg">
            <label class="fl">Prioritas *</label>
            <select name="prioritas" class="fc" required>
              <option value="normal">Normal</option>
              <option value="tinggi">Tinggi</option>
              <option value="urgent">Urgent</option>
            </select>
          </div>
        </div>
        <div class="fg"><label class="fl">Catatan</label><textarea name="catatan" class="fc" placeholder="Catatan internal (opsional)..."></textarea></div>
      </div>
      <div class="modal-ft">
        <button type="button" class="btn btn-outline" onclick="closeModal('m-add')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL EDIT -->
<div class="modal-overlay" id="m-edit" onclick="handleOC(event,'m-edit')">
  <div class="modal">
    <div class="modal-hd">
      <div class="modal-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
      </div>
      <div><h3>Edit Konsultasi</h3><p id="edit-sub">—</p></div>
      <button class="modal-close" onclick="closeModal('m-edit')">&times;</button>
    </div>
    <form onsubmit="submitEdit(event)">
      @csrf
      <input type="hidden" id="edit-id">
      <div class="modal-body">
        <div class="frow frow-2">
          <div class="fg"><label class="fl">Nama *</label><input type="text" id="e-nama" name="nama" class="fc" required></div>
          <div class="fg"><label class="fl">Kontak *</label><input type="text" id="e-kontak" name="kontak" class="fc" required></div>
        </div>
        <div class="fg"><label class="fl">Keluhan *</label><textarea id="e-keluhan" name="keluhan" class="fc" required></textarea></div>
        <div class="frow frow-3">
          <div class="fg">
            <label class="fl">Status</label>
            <select id="e-status" name="status" class="fc">
              <option value="baru">Baru</option>
              <option value="diproses">Diproses</option>
              <option value="selesai">Selesai</option>
              <option value="dibatalkan">Dibatalkan</option>
            </select>
          </div>
          <div class="fg">
            <label class="fl">Sumber</label>
            <select id="e-sumber" name="sumber" class="fc">
              <option value="whatsapp">WhatsApp</option>
              <option value="website">Website</option>
              <option value="referral">Referral</option>
              <option value="langsung">Langsung</option>
            </select>
          </div>
          <div class="fg">
            <label class="fl">Prioritas</label>
            <select id="e-prioritas" name="prioritas" class="fc">
              <option value="normal">Normal</option>
              <option value="tinggi">Tinggi</option>
              <option value="urgent">Urgent</option>
            </select>
          </div>
        </div>
        <div class="fg"><label class="fl">Catatan</label><textarea id="e-catatan" name="catatan" class="fc"></textarea></div>
      </div>
      <div class="modal-ft">
        <button type="button" class="btn btn-outline" onclick="closeModal('m-edit')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL DETAIL -->
<div class="modal-overlay" id="m-detail" onclick="handleOC(event,'m-detail')">
  <div class="modal modal-lg">
    <div class="modal-hd">
      <div class="modal-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      </div>
      <div><h3>Detail Konsultasi</h3><p id="det-sub">—</p></div>
      <button class="modal-close" onclick="closeModal('m-detail')">&times;</button>
    </div>
    <div class="modal-body" id="det-body"></div>
    <div class="modal-ft">
      <button class="btn btn-outline" onclick="closeModal('m-detail')">Tutup</button>
    </div>
  </div>
</div>

<script id="konsul-data" type="application/json">
  {!! json_encode($consultations->items(), JSON_UNESCAPED_UNICODE) !!}
</script>
@endsection

@push('scripts')
<script>
const DATA = JSON.parse(document.getElementById('konsul-data').textContent);
let selected = new Set();

function toggleAll(cb) {
  document.querySelectorAll('.row-chk').forEach(c => {
    c.checked = cb.checked;
    cb.checked ? selected.add(+c.value) : selected.delete(+c.value);
  });
  updateBulk();
}
function toggleRow(id, cb) { cb.checked ? selected.add(id) : selected.delete(id); updateBulk(); }
function updateBulk() {
  const n = selected.size;
  document.getElementById('bulk-bar').classList.toggle('show', n > 0);
  document.getElementById('bulk-info').textContent = n + ' dipilih';
}
function clearSel() {
  selected.clear();
  document.querySelectorAll('.row-chk, #chk-all').forEach(c => c.checked = false);
  updateBulk();
}

async function submitAdd(e) {
  e.preventDefault();
  const body = Object.fromEntries(new FormData(e.target));
  delete body._token;
  const r = await apiFetch("{{ route('admin.konsultasi.store') }}", 'POST', body);
  if (r.success) { showToast(r.message); closeModal('m-add'); location.reload(); }
  else showToast(r.message || 'Gagal menyimpan.', 'error');
}

function editKonsultasi(id) {
  const c = DATA.find(x => x.id === id);
  if (!c) return;
  document.getElementById('edit-id').value = id;
  document.getElementById('edit-sub').textContent = c.nama;
  document.getElementById('e-nama').value = c.nama;
  document.getElementById('e-kontak').value = c.kontak;
  document.getElementById('e-keluhan').value = c.keluhan;
  document.getElementById('e-catatan').value = c.catatan || '';
  document.getElementById('e-status').value = c.status;
  document.getElementById('e-sumber').value = c.sumber;
  document.getElementById('e-prioritas').value = c.prioritas;
  openModal('m-edit');
}

async function submitEdit(e) {
  e.preventDefault();
  const id = document.getElementById('edit-id').value;
  const body = Object.fromEntries(new FormData(e.target));
  delete body._token;
  const r = await apiFetch(`/admin/konsultasi/${id}`, 'PUT', body);
  if (r.success) { showToast(r.message); closeModal('m-edit'); location.reload(); }
  else showToast(r.message || 'Gagal.', 'error');
}

async function deleteKonsultasi(id, nama) {
  if (!confirm(`Hapus konsultasi dari "${nama}"?`)) return;
  const r = await apiFetch(`/admin/konsultasi/${id}`, 'DELETE');
  if (r.success) { showToast(r.message); location.reload(); }
  else showToast(r.message, 'error');
}

async function bulkUpdateStatus() {
  const status = document.getElementById('bulk-status').value;
  if (!status || !selected.size) return;
  const r = await apiFetch("{{ route('admin.konsultasi.bulk-update') }}", 'POST', { ids: [...selected], status });
  if (r.success) { showToast(r.message); location.reload(); }
  else showToast(r.message, 'error');
}

async function bulkDelete() {
  if (!selected.size || !confirm(`Hapus ${selected.size} konsultasi?`)) return;
  const r = await apiFetch("{{ route('admin.konsultasi.bulk-destroy') }}", 'POST', { ids: [...selected] });
  if (r.success) { showToast(r.message); location.reload(); }
  else showToast(r.message, 'error');
}

function viewKonsultasi(id) {
  const c = DATA.find(x => x.id === id);
  if (!c) return;
  document.getElementById('det-sub').textContent = `#${c.id} — ${c.nama}`;
  const history = c.history || [];
  const histHtml = history.length ? history.map(h => `
    <div style="display:flex;gap:10px;padding:8px 0">
      <div style="width:8px;height:8px;border-radius:50%;background:var(--cp);margin-top:5px;flex-shrink:0"></div>
      <div>
        <div style="font-size:12.5px;font-weight:600;text-transform:capitalize">${h.status}</div>
        <div style="font-size:12px;color:var(--cmt)">${h.catatan || '—'}</div>
        <div style="font-size:11px;color:var(--cms)">${h.waktu}</div>
      </div>
    </div>
  `).join('') : '<div style="color:var(--cmt);font-size:13px">Belum ada riwayat</div>';

  document.getElementById('det-body').innerHTML = `
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
      <div><div style="font-size:11px;color:var(--cmt);text-transform:uppercase;font-weight:600;margin-bottom:4px">Nama</div><div style="font-weight:600">${c.nama}</div></div>
      <div><div style="font-size:11px;color:var(--cmt);text-transform:uppercase;font-weight:600;margin-bottom:4px">Kontak</div><div>${c.kontak}</div></div>
      <div><div style="font-size:11px;color:var(--cmt);text-transform:uppercase;font-weight:600;margin-bottom:4px">Sumber</div><div style="text-transform:capitalize">${c.sumber}</div></div>
      <div><div style="font-size:11px;color:var(--cmt);text-transform:uppercase;font-weight:600;margin-bottom:4px">Prioritas</div><div style="text-transform:capitalize">${c.prioritas}</div></div>
    </div>
    <div style="margin-bottom:16px"><div style="font-size:11px;color:var(--cmt);text-transform:uppercase;font-weight:600;margin-bottom:4px">Keluhan</div><div style="font-size:13.5px;line-height:1.6">${c.keluhan}</div></div>
    ${c.catatan ? `<div style="margin-bottom:16px"><div style="font-size:11px;color:var(--cmt);text-transform:uppercase;font-weight:600;margin-bottom:4px">Catatan</div><div>${c.catatan}</div></div>` : ''}
    <div><div style="font-size:11px;color:var(--cmt);text-transform:uppercase;font-weight:600;margin-bottom:8px">Riwayat Status</div>${histHtml}</div>
  `;
  openModal('m-detail');
}
</script>
@endpush
