@extends('layouts.admin')
@section('title', 'Sertifikasi Produk')
@section('breadcrumb')
  <a href="{{ route('admin.produk.index') }}">Produk</a>
  <span class="sep">/</span>
  <span class="cur">Sertifikasi</span>
@endsection

@push('styles')
<style>
.lang-tabs { display:flex; gap:4px; border-bottom:2px solid var(--cms); margin-bottom:14px; flex-wrap:wrap; }
.lang-tab { padding:7px 16px; font-size:13px; font-weight:600; cursor:pointer; border:none; background:none; color:var(--cmt); border-bottom:2px solid transparent; margin-bottom:-2px; border-radius:4px 4px 0 0; transition:all .15s; }
.lang-tab:hover { color:var(--ctm); background:var(--cbg); }
.lang-tab.active { color:var(--cp); border-bottom-color:var(--cp); background:var(--cpl); }
.lang-pane { display:none; } .lang-pane.active { display:block; }
.cert-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:16px; }
.cert-card { background:var(--cw); border:1px solid var(--cms); border-radius:var(--r3); overflow:hidden; box-shadow:var(--s1); }
.cert-thumb { height:170px; background:var(--cbg); display:flex; align-items:center; justify-content:center; overflow:hidden; }
.cert-thumb img { width:100%; height:100%; object-fit:contain; }
.cert-body { padding:12px 14px; }
.cert-judul { font-weight:600; font-size:13.5px; color:var(--ctm); margin-bottom:8px; }
.cert-acts { display:flex; align-items:center; gap:6px; justify-content:space-between; }
.upload-box { width:100%; height:160px; border:2px dashed var(--cms); border-radius:var(--r2); display:flex; align-items:center; justify-content:center; overflow:hidden; background:var(--cbg); cursor:pointer; }
.upload-box img { width:100%; height:100%; object-fit:contain; }
</style>
@endpush

@section('content')
<div class="pg-hd">
  <div><h1>Sertifikasi Produk</h1><p>Kelola foto sertifikasi yang tampil di halaman produk (galeri).</p></div>
  <div class="pg-hd-acts">
    <a href="{{ route('admin.produk.index') }}" class="btn btn-outline">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
      Kembali ke Produk
    </a>
    <button class="btn btn-primary" onclick="openAdd()">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Tambah Sertifikasi
    </button>
  </div>
</div>

<div class="card">
  <div class="card-body">
    @if($certifications->isEmpty())
    <div style="padding:40px;text-align:center;color:var(--cmt)">
      <p>Belum ada sertifikasi. Tambahkan yang pertama.</p>
    </div>
    @else
    <div class="cert-grid">
      @foreach($certifications as $c)
      <div class="cert-card" id="cert-{{ $c->id }}" style="{{ $c->aktif ? '' : 'opacity:.55' }}">
        <div class="cert-thumb">
          @if($c->gambar_url)<img src="{{ $c->gambar_url }}" alt="{{ $c->judul }}">@else<span style="color:var(--cmt);font-size:32px">🏅</span>@endif
        </div>
        <div class="cert-body">
          <div class="cert-judul">{{ $c->judul }}</div>
          <div class="cert-acts">
            <label class="tog"><input type="checkbox" {{ $c->aktif ? 'checked' : '' }} onchange="toggleCert({{ $c->id }}, this)"><span class="tog-sl"></span></label>
            <div style="display:flex;gap:6px">
              <button class="act-btn" title="Edit" onclick="editCert({{ $c->id }})">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
              </button>
              <button class="act-btn del" title="Hapus" onclick="deleteCert({{ $c->id }}, '{{ addslashes($c->judul) }}')">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
              </button>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @endif
  </div>
</div>

{{-- MODAL --}}
<div class="modal-overlay" id="m-cert" onclick="handleOC(event,'m-cert')">
  <div class="modal">
    <div class="modal-hd">
      <div class="modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg></div>
      <div><h3 id="cert-modal-title">Tambah Sertifikasi</h3><p>Foto sertifikasi & judul (multi bahasa).</p></div>
      <button class="modal-close" onclick="closeModal('m-cert')">×</button>
    </div>
    <form onsubmit="submitCert(event)">
      <input type="hidden" id="cert-id">
      <div class="modal-body">
        <div class="fg">
          <label class="fl">Gambar Sertifikasi <span style="color:#ef4444">*</span></label>
          <div class="upload-box" onclick="document.getElementById('cert-gambar').click()" id="cert-preview">
            <span style="color:var(--cmt);font-size:13px">Klik untuk pilih gambar</span>
          </div>
          <input type="file" id="cert-gambar" accept="image/*" style="display:none" onchange="previewCert(this)">
          <p style="font-size:11px;color:var(--cmt);margin-top:4px">JPG/PNG/WEBP. Otomatis dikompres saat upload.</p>
        </div>

        <div class="fg">
          <label class="fl">Judul Sertifikasi <span style="color:#ef4444">*</span></label>
          @if($languages->count() > 1)
          <div class="lang-tabs" id="cert-tabs">
            @foreach($languages as $lang)
            <button type="button" class="lang-tab {{ $loop->first ? 'active' : '' }}" onclick="switchTab('cert', this, '{{ $lang->code }}')">{{ $lang->flag }} {{ $lang->native_name }}</button>
            @endforeach
          </div>
          @endif
          @foreach($languages as $lang)
          <div id="cert-pane-{{ $lang->code }}" class="lang-pane {{ $loop->first ? 'active' : '' }}">
            @if($lang->code === 'id')
            <input type="text" id="cert-judul" class="fc" placeholder="mis. BPOM, Halal MUI" maxlength="150">
            @else
            <input type="text" id="cert-judul-{{ $lang->code }}" class="fc" placeholder="Judul dalam {{ $lang->native_name }}" maxlength="150" dir="{{ $lang->dir ?? 'ltr' }}">
            @endif
          </div>
          @endforeach
        </div>

        <div class="frow frow-2">
          <div class="fg"><label class="fl">Nomor Urutan</label><input type="number" id="cert-urutan" class="fc" placeholder="Otomatis" min="0"></div>
          <div class="fg" style="display:flex;align-items:center;gap:10px;padding-top:20px">
            <label class="tog"><input type="checkbox" id="cert-aktif" checked><span class="tog-sl"></span></label>
            <span style="font-size:13px;color:var(--ctm)">Aktif</span>
          </div>
        </div>
      </div>
      <div class="modal-ft">
        <button type="button" class="btn btn-outline" onclick="closeModal('m-cert')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
const CERTS = @json($certifications);

function switchTab(section, btn, locale) {
  document.querySelectorAll(`#${section}-tabs .lang-tab`).forEach(t => t.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll(`[id^="${section}-pane-"]`).forEach(p => p.classList.remove('active'));
  const pane = document.getElementById(`${section}-pane-${locale}`);
  if (pane) pane.classList.add('active');
}

function resetCertForm() {
  document.getElementById('cert-id').value = '';
  document.getElementById('cert-gambar').value = '';
  document.getElementById('cert-judul').value = '';
  document.getElementById('cert-urutan').value = '';
  document.getElementById('cert-aktif').checked = true;
  document.getElementById('cert-preview').innerHTML = '<span style="color:var(--cmt);font-size:13px">Klik untuk pilih gambar</span>';
  @foreach($languages as $lang)@if($lang->code !== 'id')
  { const el = document.getElementById('cert-judul-{{ $lang->code }}'); if (el) el.value = ''; }
  @endif @endforeach
}

function openAdd() {
  resetCertForm();
  document.getElementById('cert-modal-title').textContent = 'Tambah Sertifikasi';
  openModal('m-cert');
}

async function previewCert(input) {
  if (!input.files || !input.files[0]) return;
  setLoading('Mengompresi gambar...');
  await compressInputFile(input);
  clearLoading();
  const reader = new FileReader();
  reader.onload = e => { document.getElementById('cert-preview').innerHTML = `<img src="${e.target.result}">`; };
  reader.readAsDataURL(input.files[0]);
}

function editCert(id) {
  const c = CERTS.find(x => x.id === id);
  if (!c) return;
  resetCertForm();
  document.getElementById('cert-modal-title').textContent = 'Edit Sertifikasi';
  document.getElementById('cert-id').value = id;
  document.getElementById('cert-judul').value = c.judul || '';
  document.getElementById('cert-urutan').value = c.urutan ?? '';
  document.getElementById('cert-aktif').checked = !!c.aktif;
  const trans = c.translations || {};
  @foreach($languages as $lang)@if($lang->code !== 'id')
  { const el = document.getElementById('cert-judul-{{ $lang->code }}'); if (el) el.value = (trans['{{ $lang->code }}'] || {}).judul || ''; }
  @endif @endforeach
  // tampilkan gambar saat ini
  const gambar = c.gambar_url || (c.gambar ? ('/storage/' + c.gambar) : '');
  if (gambar) document.getElementById('cert-preview').innerHTML = `<img src="${gambar}">`;
  // reset ke tab pertama
  const firstTab = document.querySelector('#cert-tabs .lang-tab');
  if (firstTab) switchTab('cert', firstTab, '{{ $languages->first()->code ?? "id" }}');
  openModal('m-cert');
}

async function submitCert(e) {
  e.preventDefault();
  const id = document.getElementById('cert-id').value;
  const judul = document.getElementById('cert-judul').value.trim();
  if (!judul) { showToast('Judul wajib diisi.', 'error'); return; }
  const fileInput = document.getElementById('cert-gambar');
  if (!id && !(fileInput.files && fileInput.files[0])) { showToast('Pilih gambar sertifikasi dulu.', 'error'); return; }

  setLoading('Menyimpan sertifikasi...');
  if (fileInput.files && fileInput.files[0]) await compressInputFile(fileInput);

  const fd = new FormData();
  fd.append('judul', judul);
  fd.append('urutan', document.getElementById('cert-urutan').value || '');
  fd.append('aktif', document.getElementById('cert-aktif').checked ? 1 : 0);
  if (fileInput.files && fileInput.files[0]) fd.append('gambar', fileInput.files[0]);
  @foreach($languages as $lang)@if($lang->code !== 'id')
  { const el = document.getElementById('cert-judul-{{ $lang->code }}'); if (el && el.value.trim()) fd.append('trans[{{ $lang->code }}][judul]', el.value.trim()); }
  @endif @endforeach

  const url = id ? `/admin/sertifikasi/${id}` : "{{ route('admin.sertifikasi.store') }}";
  const r = await apiFetch(url, 'POST', fd);
  clearLoading();
  if (r.success) { showToast(r.message); closeModal('m-cert'); location.reload(); }
  else showToast(r.message || 'Terjadi kesalahan.', 'error');
}

async function toggleCert(id, cb) {
  const r = await apiFetch(`/admin/sertifikasi/${id}/toggle`, 'PATCH');
  if (r.success) { showToast(r.message); document.getElementById(`cert-${id}`).style.opacity = r.aktif ? '1' : '.55'; }
  else { showToast(r.message || 'Gagal.', 'error'); cb.checked = !cb.checked; }
}

async function deleteCert(id, judul) {
  if (!confirm(`Hapus sertifikasi "${judul}"?`)) return;
  setLoading('Menghapus...');
  const r = await apiFetch(`/admin/sertifikasi/${id}`, 'DELETE');
  clearLoading();
  if (r.success) { showToast(r.message); document.getElementById(`cert-${id}`)?.remove(); }
  else showToast(r.message || 'Gagal menghapus.', 'error');
}
</script>
@endpush
