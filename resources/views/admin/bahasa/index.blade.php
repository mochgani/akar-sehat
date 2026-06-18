@extends('layouts.admin')

@section('title', 'Manajemen Bahasa')
@section('breadcrumb')
  <a href="{{ route('admin.pengaturan.index') }}">Pengaturan</a>
  <span class="sep">/</span><span class="cur">Bahasa</span>
@endsection

@section('content')
<div class="pg-hd">
  <div>
    <h1>Manajemen Bahasa</h1>
    <p>Kelola bahasa yang tersedia di website. Konten terjemahan diisi di halaman Pengaturan Homepage / Tentang.</p>
  </div>
  <button class="btn btn-primary" onclick="openModal('m-add')">
    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Tambah Bahasa
  </button>
</div>

<div class="card">
  <div class="card-body" style="padding:0">
    <table style="width:100%;border-collapse:collapse">
      <thead>
        <tr style="border-bottom:2px solid var(--cms)">
          <th style="padding:12px 16px;text-align:left;font-size:12px;color:var(--cmt);font-weight:600;text-transform:uppercase;letter-spacing:.5px">Kode</th>
          <th style="padding:12px 16px;text-align:left;font-size:12px;color:var(--cmt);font-weight:600;text-transform:uppercase;letter-spacing:.5px">Nama Bahasa</th>
          <th style="padding:12px 16px;text-align:left;font-size:12px;color:var(--cmt);font-weight:600;text-transform:uppercase;letter-spacing:.5px">Arah Teks</th>
          <th style="padding:12px 16px;text-align:center;font-size:12px;color:var(--cmt);font-weight:600;text-transform:uppercase;letter-spacing:.5px">Urutan</th>
          <th style="padding:12px 16px;text-align:center;font-size:12px;color:var(--cmt);font-weight:600;text-transform:uppercase;letter-spacing:.5px">Status</th>
          <th style="padding:12px 16px;text-align:center;font-size:12px;color:var(--cmt);font-weight:600;text-transform:uppercase;letter-spacing:.5px">Aksi</th>
        </tr>
      </thead>
      <tbody id="lang-tbody">
        @foreach($languages as $lang)
        <tr style="border-bottom:1px solid var(--cms)" id="lang-row-{{ $lang->id }}">
          <td style="padding:14px 16px">
            <div style="display:flex;align-items:center;gap:10px">
              <span style="font-size:22px">{{ $lang->flag }}</span>
              <div>
                <div style="font-weight:700;font-size:14px;color:var(--ctm);font-family:monospace">{{ strtoupper($lang->code) }}</div>
                @if($lang->is_default)
                <span style="font-size:10px;background:var(--cpl);color:var(--cp);border-radius:4px;padding:1px 6px;font-weight:600">DEFAULT</span>
                @endif
              </div>
            </div>
          </td>
          <td style="padding:14px 16px">
            <div style="font-weight:500;color:var(--ctm)">{{ $lang->native_name }}</div>
            <div style="font-size:12px;color:var(--cmt)">{{ $lang->name }}</div>
          </td>
          <td style="padding:14px 16px">
            <span style="font-size:13px;color:var(--cmt)">
              @if($lang->dir === 'rtl')
                ← RTL (Kanan ke Kiri)
              @else
                → LTR (Kiri ke Kanan)
              @endif
            </span>
          </td>
          <td style="padding:14px 16px;text-align:center;color:var(--cmt)">{{ $lang->urutan }}</td>
          <td style="padding:14px 16px;text-align:center">
            @if($lang->is_default)
              <span class="badge" style="background:rgba(34,197,94,.1);color:#16a34a">Aktif (Default)</span>
            @elseif($lang->aktif)
              <button onclick="toggleLang({{ $lang->id }}, this)" style="background:rgba(34,197,94,.1);color:#16a34a;border:none;border-radius:20px;padding:4px 12px;font-size:12px;font-weight:600;cursor:pointer">✓ Aktif</button>
            @else
              <button onclick="toggleLang({{ $lang->id }}, this)" style="background:rgba(156,163,175,.12);color:#6b7280;border:none;border-radius:20px;padding:4px 12px;font-size:12px;font-weight:600;cursor:pointer">✗ Non-Aktif</button>
            @endif
          </td>
          <td style="padding:14px 16px;text-align:center">
            <div style="display:flex;gap:6px;justify-content:center;flex-wrap:wrap">
              @if(!$lang->is_default && $lang->aktif)
              <button onclick="setDefaultLang({{ $lang->id }}, '{{ $lang->native_name }}')" class="btn btn-sm" style="color:var(--cp);border-color:var(--cp);background:none" title="Jadikan bahasa default frontend">★ Jadikan Default</button>
              @endif
              <button onclick="editLang({{ $lang->id }}, {{ json_encode($lang) }})" class="btn btn-outline btn-sm">Edit</button>
              @if(!$lang->is_default && $lang->code !== 'id')
              <button onclick="deleteLang({{ $lang->id }}, '{{ $lang->name }}')" class="btn btn-sm" style="color:#ef4444;border-color:#ef4444;background:none">Hapus</button>
              @endif
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="card" style="margin-top:16px">
  <div class="card-hd"><h3>ℹ️ Cara Kerja Multi-Bahasa</h3></div>
  <div class="card-body">
    <ul style="font-size:13.5px;color:var(--cmt);line-height:1.9;padding-left:20px;margin:0">
      <li>Bahasa berlabel <strong>DEFAULT</strong> adalah bahasa yang otomatis ditampilkan saat pengunjung pertama kali membuka website. Tekan <strong>★ Jadikan Default</strong> untuk mengubahnya (mis. langsung tampil Bahasa Arab).</li>
      <li>Bahasa <strong>Indonesia (ID)</strong> selalu menjadi <em>fallback</em>: jika konten terjemahan tidak diisi, website otomatis menampilkan konten Bahasa Indonesia.</li>
      <li>Untuk mengisi konten terjemahan, buka <strong>Pengaturan → Homepage</strong> atau <strong>Pengaturan → Tentang</strong> dan pilih tab bahasa yang ingin diisi.</li>
      <li>Pengunjung dapat mengganti bahasa melalui switcher di <strong>footer</strong> website. Pilihan mereka akan diingat selama sesi.</li>
      <li>Hanya bahasa yang <strong>aktif</strong> yang dapat dijadikan default.</li>
    </ul>
  </div>
</div>

<!-- MODAL TAMBAH -->
<div class="modal-overlay" id="m-add" onclick="handleOC(event,'m-add')">
  <div class="modal modal-sm">
    <div class="modal-hd">
      <div style="display:flex;align-items:center;gap:12px">
        <div style="width:36px;height:36px;background:var(--cpl);border-radius:var(--r2);display:grid;place-items:center;color:var(--cp);font-size:18px">🌐</div>
        <div><div style="font-weight:700;font-size:15px">Tambah Bahasa</div><div style="font-size:12px;color:var(--cmt)">Daftarkan bahasa baru</div></div>
      </div>
      <button onclick="closeModal('m-add')" style="background:none;border:none;cursor:pointer;color:var(--cmt);font-size:20px">&times;</button>
    </div>
    <div class="modal-body">
      <div class="frow frow-2">
        <div class="fg"><label class="fl">Kode Bahasa <span style="color:#ef4444">*</span></label>
          <input type="text" id="add-code" class="fc" placeholder="en, fr, de, ja..." maxlength="10" style="text-transform:lowercase">
          <p style="font-size:11px;color:var(--cmt);margin-top:4px">2-10 karakter, huruf kecil</p>
        </div>
        <div class="fg"><label class="fl">Flag/Emoji</label>
          <input type="text" id="add-flag" class="fc" placeholder="🇬🇧" maxlength="10">
        </div>
      </div>
      <div class="frow frow-2">
        <div class="fg"><label class="fl">Nama Bahasa (EN) <span style="color:#ef4444">*</span></label>
          <input type="text" id="add-name" class="fc" placeholder="English">
        </div>
        <div class="fg"><label class="fl">Nama Bahasa Asli <span style="color:#ef4444">*</span></label>
          <input type="text" id="add-native" class="fc" placeholder="English / العربية">
        </div>
      </div>
      <div class="frow frow-2">
        <div class="fg"><label class="fl">Arah Teks <span style="color:#ef4444">*</span></label>
          <select id="add-dir" class="fc">
            <option value="ltr">LTR — Kiri ke Kanan</option>
            <option value="rtl">RTL — Kanan ke Kiri</option>
          </select>
        </div>
        <div class="fg"><label class="fl">Urutan</label>
          <input type="number" id="add-urutan" class="fc" placeholder="0" min="0" value="{{ $languages->count() + 1 }}">
        </div>
      </div>
    </div>
    <div class="modal-ft">
      <button onclick="closeModal('m-add')" class="btn btn-outline">Batal</button>
      <button onclick="submitAdd()" class="btn btn-primary">Tambah Bahasa</button>
    </div>
  </div>
</div>

<!-- MODAL EDIT -->
<div class="modal-overlay" id="m-edit" onclick="handleOC(event,'m-edit')">
  <div class="modal modal-sm">
    <div class="modal-hd">
      <div style="display:flex;align-items:center;gap:12px">
        <div style="width:36px;height:36px;background:rgba(59,130,246,.1);border-radius:var(--r2);display:grid;place-items:center;font-size:18px">✏️</div>
        <div><div style="font-weight:700;font-size:15px">Edit Bahasa</div><div style="font-size:12px;color:var(--cmt)" id="edit-sub">—</div></div>
      </div>
      <button onclick="closeModal('m-edit')" style="background:none;border:none;cursor:pointer;color:var(--cmt);font-size:20px">&times;</button>
    </div>
    <div class="modal-body">
      <input type="hidden" id="edit-id">
      <div class="frow frow-2">
        <div class="fg"><label class="fl">Nama Bahasa (EN) <span style="color:#ef4444">*</span></label>
          <input type="text" id="edit-name" class="fc">
        </div>
        <div class="fg"><label class="fl">Nama Bahasa Asli <span style="color:#ef4444">*</span></label>
          <input type="text" id="edit-native" class="fc">
        </div>
      </div>
      <div class="frow frow-2">
        <div class="fg"><label class="fl">Flag/Emoji</label>
          <input type="text" id="edit-flag" class="fc" maxlength="10">
        </div>
        <div class="fg"><label class="fl">Arah Teks <span style="color:#ef4444">*</span></label>
          <select id="edit-dir" class="fc">
            <option value="ltr">LTR — Kiri ke Kanan</option>
            <option value="rtl">RTL — Kanan ke Kiri</option>
          </select>
        </div>
      </div>
      <div class="fg"><label class="fl">Urutan</label>
        <input type="number" id="edit-urutan" class="fc" min="0">
      </div>
    </div>
    <div class="modal-ft">
      <button onclick="closeModal('m-edit')" class="btn btn-outline">Batal</button>
      <button onclick="submitEdit()" class="btn btn-primary">Simpan Perubahan</button>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
const ROUTES = {
  store:  "{{ route('admin.bahasa.store') }}",
  update: "{{ url('admin/bahasa') }}/",
  destroy:"{{ url('admin/bahasa') }}/",
  toggle: "{{ url('admin/bahasa') }}/",
  setdef: "{{ url('admin/bahasa') }}/",
};

function setDefaultLang(id, name) {
  if (!confirm(`Jadikan "${name}" sebagai bahasa default? Pengunjung baru akan melihat website dalam bahasa ini saat pertama kali dibuka.`)) return;
  apiFetch(ROUTES.setdef + id + '/default', 'POST', { _method: 'PATCH' }).then(r => {
    if (r.success) { showToast(r.message); setTimeout(() => location.reload(), 800); }
    else showToast(r.message || 'Gagal.', 'error');
  });
}

function submitAdd() {
  const body = {
    code:        document.getElementById('add-code').value.trim().toLowerCase(),
    name:        document.getElementById('add-name').value.trim(),
    native_name: document.getElementById('add-native').value.trim(),
    dir:         document.getElementById('add-dir').value,
    flag:        document.getElementById('add-flag').value.trim(),
    urutan:      parseInt(document.getElementById('add-urutan').value) || 0,
  };
  if (!body.code || !body.name || !body.native_name) {
    showToast('Kode, nama, dan nama asli wajib diisi.', 'error'); return;
  }
  apiFetch(ROUTES.store, 'POST', body).then(r => {
    if (r.success) { showToast(r.message); closeModal('m-add'); setTimeout(() => location.reload(), 800); }
    else showToast(r.message || r.errors?.code?.[0] || 'Gagal.', 'error');
  });
}

function editLang(id, data) {
  document.getElementById('edit-id').value      = id;
  document.getElementById('edit-sub').textContent= data.code.toUpperCase();
  document.getElementById('edit-name').value    = data.name;
  document.getElementById('edit-native').value  = data.native_name;
  document.getElementById('edit-flag').value    = data.flag || '';
  document.getElementById('edit-dir').value     = data.dir;
  document.getElementById('edit-urutan').value  = data.urutan;
  openModal('m-edit');
}

function submitEdit() {
  const id   = document.getElementById('edit-id').value;
  const body = {
    name:        document.getElementById('edit-name').value.trim(),
    native_name: document.getElementById('edit-native').value.trim(),
    flag:        document.getElementById('edit-flag').value.trim(),
    dir:         document.getElementById('edit-dir').value,
    urutan:      parseInt(document.getElementById('edit-urutan').value) || 0,
    _method:     'PUT',
  };
  apiFetch(ROUTES.update + id, 'POST', body).then(r => {
    if (r.success) { showToast(r.message); closeModal('m-edit'); setTimeout(() => location.reload(), 800); }
    else showToast(r.message || 'Gagal.', 'error');
  });
}

function toggleLang(id, btn) {
  apiFetch(ROUTES.toggle + id + '/toggle', 'POST', { _method: 'PATCH' }).then(r => {
    if (r.success) { showToast(r.message); setTimeout(() => location.reload(), 800); }
    else showToast(r.message || 'Gagal.', 'error');
  });
}

function deleteLang(id, name) {
  if (!confirm(`Hapus bahasa "${name}"? Data terjemahan tidak akan ikut terhapus.`)) return;
  apiFetch(ROUTES.destroy + id, 'POST', { _method: 'DELETE' }).then(r => {
    if (r.success) { showToast(r.message); setTimeout(() => location.reload(), 800); }
    else showToast(r.message || 'Gagal.', 'error');
  });
}
</script>
@endpush
