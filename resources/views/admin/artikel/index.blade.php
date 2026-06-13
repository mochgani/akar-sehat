@extends('layouts.admin')

@section('title', 'Manajemen Artikel')
@section('breadcrumb')
  <span class="cur">Artikel</span>
@endsection

@section('content')
<div class="pg-hd">
  <div>
    <h1>Manajemen Artikel</h1>
    <p>Total {{ $articles->total() }} artikel</p>
  </div>
  <div class="pg-hd-acts">
    <button class="btn btn-primary" onclick="openModal('m-add')">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Tulis Artikel
    </button>
  </div>
</div>

<!-- FILTER -->
<form method="GET" class="filter-bar">
  <div class="search-wrap">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <input type="text" name="search" class="fc" placeholder="Cari judul, penulis..." value="{{ request('search') }}">
  </div>
  <select name="status" class="fc">
    <option value="">Semua Status</option>
    <option value="terbit" {{ request('status')=='terbit'?'selected':'' }}>Terbit</option>
    <option value="draft" {{ request('status')=='draft'?'selected':'' }}>Draft</option>
    <option value="review" {{ request('status')=='review'?'selected':'' }}>Review</option>
    <option value="arsip" {{ request('status')=='arsip'?'selected':'' }}>Arsip</option>
  </select>
  <button type="submit" class="btn btn-outline">Filter</button>
  @if(request()->hasAny(['search','status']))
    <a href="{{ route('admin.artikel.index') }}" class="btn btn-outline">Reset</a>
  @endif
</form>

<div class="card">
  <div class="tbl-wrap">
    <table>
      <thead>
        <tr>
          <th style="width:36px"><input type="checkbox" id="chk-all" onchange="toggleAll(this)"></th>
          <th>Judul</th><th>Kategori</th><th>Penulis</th><th>Status</th><th>Views</th><th>Baca</th><th>Terbit</th><th style="width:80px">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($articles as $a)
        <tr>
          <td><input type="checkbox" class="row-chk" value="{{ $a->id }}" onchange="toggleRow({{ $a->id }}, this)"></td>
          <td>
            <div style="display:flex;align-items:center;gap:10px">
              @if($a->thumbnail)
              <div style="width:46px;height:30px;background:var(--cbg);border-radius:4px;flex-shrink:0;overflow:hidden">
                <img src="{{ asset('storage/'.$a->thumbnail) }}" alt="" style="width:100%;height:100%;object-fit:cover" onerror="this.parentElement.innerHTML='📝'">
              </div>
              @endif
              <div>
                <div style="font-weight:600;font-size:13px;max-width:280px">{{ Str::limit($a->judul, 65) }}</div>
                <div style="font-size:11.5px;color:var(--cmt);font-family:monospace">/edukasi/{{ $a->slug }}</div>
              </div>
            </div>
          </td>
          <td style="font-size:12.5px;color:var(--cmt)">{{ $a->kategori ?? '—' }}</td>
          <td style="font-size:12.5px">{{ $a->penulis ?? '—' }}</td>
          <td><span class="badge s-{{ $a->status }}">{{ ucfirst($a->status) }}</span></td>
          <td style="font-size:13px;font-weight:600">{{ number_format($a->views) }}</td>
          <td style="font-size:12.5px;color:var(--cmt)">{{ $a->read_time }} mnt</td>
          <td style="font-size:12px;color:var(--cmt);white-space:nowrap">
            {{ $a->published_at ? $a->published_at->format('d M Y') : '—' }}
          </td>
          <td>
            <div style="display:flex;gap:4px">
              <button class="act-btn" onclick="editArtikel({{ $a->id }})" title="Edit">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
              </button>
              @if($a->status === 'terbit')
              <a href="{{ route('edukasi.show', $a->slug) }}" class="act-btn" target="_blank" title="Lihat">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
              </a>
              @endif
              <button class="act-btn del" onclick="deleteArtikel({{ $a->id }}, '{{ addslashes(Str::limit($a->judul,30)) }}')" title="Hapus">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
              </button>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="9" style="text-align:center;padding:40px;color:var(--cmt)">Belum ada artikel.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($articles->hasPages())
  <div style="padding:16px 20px;border-top:1px solid var(--cbg)">
    {{ $articles->links('vendor.pagination.custom') }}
  </div>
  @endif
</div>

<!-- MODAL TAMBAH/EDIT -->
<div class="modal-overlay" id="m-add" onclick="handleOC(event,'m-add')">
  <div class="modal modal-xl">
    <div class="modal-hd">
      <div class="modal-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
      </div>
      <div><h3 id="modal-title">Tulis Artikel Baru</h3><p id="modal-sub">Isi konten artikel</p></div>
      <button class="modal-close" onclick="closeModal('m-add')">&times;</button>
    </div>
    <form id="f-artikel" onsubmit="submitArtikel(event)">
      @csrf
      <input type="hidden" id="a-id" value="">
      <div class="modal-body">
        {{-- Side-by-side: main left, meta right --}}
        <div style="display:grid;grid-template-columns:1fr 300px;gap:20px">
          {{-- LEFT: language tabs for content --}}
          <div>
            <div class="lang-section" style="margin-bottom:0">
              <div style="font-size:12px;color:var(--cmt);margin-bottom:10px;font-weight:600">🌐 Konten per Bahasa</div>
              <div class="lang-tabs" id="art-tabs">
                @foreach($languages as $lang)
                <button type="button" class="lang-tab {{ $loop->first ? 'active' : '' }}"
                  onclick="switchLangTab('art', this, '{{ $lang->code }}')">
                  {{ $lang->flag }} {{ $lang->native_name }}
                </button>
                @endforeach
              </div>
              @foreach($languages as $lang)
              @php $isId = $lang->code === 'id'; $loc = $lang->code; @endphp
              <div class="lang-pane {{ $loop->first ? 'active' : '' }}" id="art-pane-{{ $loc }}" dir="{{ $lang->dir }}">
                <div class="fg">
                  <label class="fl">Judul Artikel @if($isId)*@endif</label>
                  @if($isId)
                    <input type="text" id="a-judul" name="judul" class="fc" required placeholder="Tulis judul artikel..." oninput="autoSlug(this.value)">
                  @else
                    <input type="text" id="a-judul-{{ $loc }}" name="trans[{{ $loc }}][judul]" class="fc" placeholder="Terjemahan judul (opsional)">
                  @endif
                </div>
                <div class="fg">
                  <label class="fl">Konten</label>
                  @if($isId)
                  <div style="border:1px solid var(--cms);border-radius:var(--r1);overflow:hidden">
                    <div style="display:flex;gap:2px;padding:8px;background:var(--cbg);border-bottom:1px solid var(--cms);flex-wrap:wrap">
                      @foreach([['bold','B'],['italic','I'],['underline','U']] as $f)
                      <button type="button" onclick="fmtId('{{ $f[0] }}')" style="width:28px;height:28px;border:1px solid var(--cms);background:var(--cw);border-radius:4px;cursor:pointer;font-weight:600;font-size:12px">{{ $f[1] }}</button>
                      @endforeach
                      <button type="button" onclick="fmtId('formatBlock','<h2>')" style="padding:0 8px;height:28px;border:1px solid var(--cms);background:var(--cw);border-radius:4px;cursor:pointer;font-size:12px">H2</button>
                      <button type="button" onclick="fmtId('insertUnorderedList')" style="padding:0 8px;height:28px;border:1px solid var(--cms);background:var(--cw);border-radius:4px;cursor:pointer;font-size:12px">List</button>
                      <button type="button" onclick="fmtId('insertOrderedList')" style="padding:0 8px;height:28px;border:1px solid var(--cms);background:var(--cw);border-radius:4px;cursor:pointer;font-size:12px">1.</button>
                      <span style="width:1px;background:var(--cms);margin:2px 3px"></span>
                      @foreach([['Left','3,6,21,6 3,12,13,12 3,18,17,18'],['Center','3,6,21,6 6,12,18,12 5,18,19,18'],['Right','3,6,21,6 9,12,21,12 7,18,21,18'],['Full','3,6,21,6 3,12,21,12 3,18,21,18']] as $al)
                      @php [$dir,$pts]=$al; $lines=array_map(fn($l)=>explode(',',$l), explode(' ',$pts)); @endphp
                      <button type="button" onclick="alignId('{{ $dir }}')" title="Rata {{ ['Left'=>'kiri','Center'=>'tengah','Right'=>'kanan','Full'=>'kiri-kanan'][$dir] }}" style="width:28px;height:28px;border:1px solid var(--cms);background:var(--cw);border-radius:4px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">@foreach($lines as $ln)<line x1="{{ $ln[0] }}" y1="{{ $ln[1] }}" x2="{{ $ln[2] }}" y2="{{ $ln[3] }}"/>@endforeach</svg>
                      </button>
                      @endforeach
                    </div>
                    <div id="editor" contenteditable="true" style="padding:14px;min-height:200px;font-size:14px;outline:none;line-height:1.7" oninput="syncEditor()"></div>
                  </div>
                  <input type="hidden" id="a-konten" name="konten">
                  @else
                  <textarea id="a-konten-{{ $loc }}" name="trans[{{ $loc }}][konten]" class="fc" rows="10" placeholder="Terjemahan konten HTML (opsional)"></textarea>
                  @endif
                </div>
                <div class="fg">
                  <label class="fl">Kata Kunci / Tag <span style="font-size:11px;color:var(--cmt);font-weight:400">(pisahkan dengan koma)</span></label>
                  @if($isId)
                  <input type="text" id="a-keywords" class="fc" placeholder="jahe merah, imunitas, herbal">
                  @else
                  <input type="text" id="a-keywords-{{ $loc }}" class="fc" placeholder="Terjemahan tag (opsional)" dir="{{ $lang->dir ?? 'ltr' }}">
                  @endif
                </div>
                @if(!$isId)
                <div class="frow frow-2">
                  <div class="fg">
                    <label class="fl">Meta Title</label>
                    <input type="text" id="a-metatitle-{{ $loc }}" name="trans[{{ $loc }}][meta_title]" class="fc" maxlength="70" placeholder="(opsional)">
                  </div>
                  <div class="fg">
                    <label class="fl">Meta Desc</label>
                    <textarea id="a-metadesc-{{ $loc }}" name="trans[{{ $loc }}][meta_desc]" class="fc" rows="2" maxlength="160" placeholder="(opsional)"></textarea>
                  </div>
                </div>
                @endif
              </div>
              @endforeach
            </div>
          </div>

          {{-- RIGHT: non-translatable meta --}}
          <div>
            <div class="fg">
              <label class="fl">Status</label>
              <select id="a-status" name="status" class="fc">
                <option value="draft">Draft</option>
                <option value="review">Review</option>
                <option value="terbit">Terbit</option>
                <option value="arsip">Arsip</option>
              </select>
            </div>
            <div class="fg"><label class="fl">Kategori</label>
              <select id="a-kategori" name="kategori" class="fc">
                <option value="">Pilih kategori...</option>
                @foreach($kategoris as $k)<option value="{{ $k }}">{{ $k }}</option>@endforeach
              </select>
              <p style="font-size:11px;color:var(--cmt);margin-top:4px">Kelola daftar kategori di <a href="{{ route('admin.kategori-artikel.index') }}" style="color:var(--cp)">Kategori Artikel</a>.</p>
            </div>
            <div class="fg"><label class="fl">Penulis</label><input type="text" id="a-penulis" name="penulis" class="fc" value="{{ auth()->user()->name }}"></div>
            <div class="fg">
              <label class="fl">Thumbnail <span style="font-size:11px;color:var(--cmt);font-weight:400">(semua bahasa)</span></label>
              <div id="thumb-preview" style="width:100%;height:90px;background:var(--cbg);border:1px solid var(--cms);border-radius:var(--r2);display:grid;place-items:center;overflow:hidden;margin-bottom:6px;font-size:28px">🖼️</div>
              <input type="file" id="a-thumb" name="thumbnail" class="fc" accept="image/*" onchange="previewThumb(this)" style="padding:6px 8px">
              <p style="font-size:11px;color:var(--cmt);margin-top:4px">JPG/PNG/WEBP, maks 2MB.</p>
            </div>
            <div class="fg">
              <label class="fl">Slug URL</label>
              <input type="text" id="a-slug" class="fc" readonly style="background:var(--cbg);font-family:monospace;font-size:12px">
            </div>
            <div class="fg">
              <label class="fl">Meta Title ID <span style="color:var(--cmt);font-weight:400">(max 70)</span></label>
              <input type="text" id="a-metatitle" name="meta_title" class="fc" maxlength="70" oninput="document.getElementById('mc-title').textContent=this.value.length">
              <div style="font-size:11px;color:var(--cmt);text-align:right;margin-top:2px"><span id="mc-title">0</span>/70</div>
            </div>
            <div class="fg">
              <label class="fl">Meta Desc ID <span style="color:var(--cmt);font-weight:400">(max 160)</span></label>
              <textarea id="a-metadesc" name="meta_desc" class="fc" maxlength="160" rows="2" oninput="document.getElementById('mc-desc').textContent=this.value.length"></textarea>
              <div style="font-size:11px;color:var(--cmt);text-align:right;margin-top:2px"><span id="mc-desc">0</span>/160</div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-ft">
        <button type="button" class="btn btn-outline" onclick="closeModal('m-add')">Batal</button>
        <button type="button" class="btn btn-outline" onclick="saveDraft()">Simpan Draft</button>
        <button type="submit" class="btn btn-primary">Publish Artikel</button>
      </div>
    </form>
  </div>
</div>

<script id="art-data" type="application/json">{!! json_encode($articles->items(), JSON_UNESCAPED_UNICODE) !!}</script>
@endsection

@push('scripts')
<script>
const ARTS = JSON.parse(document.getElementById('art-data').textContent);
let selected = new Set();

function toggleAll(cb) {
  document.querySelectorAll('.row-chk').forEach(c => { c.checked = cb.checked; cb.checked ? selected.add(+c.value) : selected.delete(+c.value); });
}
function toggleRow(id, cb) { cb.checked ? selected.add(id) : selected.delete(id); }

function switchLangTab(section, btn, locale) {
  document.querySelectorAll(`#${section}-tabs .lang-tab`).forEach(t => t.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll(`[id^="${section}-pane-"]`).forEach(p => p.classList.remove('active'));
  const pane = document.getElementById(`${section}-pane-${locale}`);
  if (pane) pane.classList.add('active');
}

function fmtId(cmd, val) { document.execCommand(cmd, false, val || null); }
function alignId(dir) {
  document.getElementById('editor').focus();
  document.execCommand('styleWithCSS', false, true);
  document.execCommand('justify' + dir, false, null);
  document.execCommand('styleWithCSS', false, false);
  syncEditor();
}
function syncEditor() {
  document.getElementById('a-konten').value = document.getElementById('editor').innerHTML;
}
function autoSlug(v) {
  const slug = v.toLowerCase().replace(/[^a-z0-9\s-]/g,'').replace(/\s+/g,'-');
  document.getElementById('a-slug').value = slug;
}

async function submitArtikel(e) {
  e.preventDefault();
  syncEditor();
  await saveArtikel('terbit');
}
async function saveDraft() {
  syncEditor();
  document.getElementById('a-status').value = 'draft';
  await saveArtikel('draft');
}
async function saveArtikel(status) {
  setLoading('Menyimpan artikel...');
  const id = document.getElementById('a-id').value;
  syncEditor();
  const fd = new FormData();
  fd.append('judul',      document.getElementById('a-judul').value);
  fd.append('konten',     document.getElementById('a-konten').value);
  fd.append('status',     document.getElementById('a-status').value || status);
  fd.append('kategori',   document.getElementById('a-kategori').value);
  fd.append('penulis',    document.getElementById('a-penulis').value);
  fd.append('meta_title', document.getElementById('a-metatitle').value);
  fd.append('meta_desc',  document.getElementById('a-metadesc').value);
  fd.append('keywords',   document.getElementById('a-keywords').value);
  // Append translation fields for non-ID locales
  @foreach($languages as $lang)
  @if($lang->code !== 'id')
  const ae_{{ $lang->code }} = document.getElementById('a-judul-{{ $lang->code }}');
  const ak_{{ $lang->code }} = document.getElementById('a-konten-{{ $lang->code }}');
  const am_{{ $lang->code }} = document.getElementById('a-metatitle-{{ $lang->code }}');
  const ad_{{ $lang->code }} = document.getElementById('a-metadesc-{{ $lang->code }}');
  const aw_{{ $lang->code }} = document.getElementById('a-keywords-{{ $lang->code }}');
  if (ae_{{ $lang->code }}) fd.append('trans[{{ $lang->code }}][judul]',      ae_{{ $lang->code }}.value);
  if (ak_{{ $lang->code }}) fd.append('trans[{{ $lang->code }}][konten]',     ak_{{ $lang->code }}.value);
  if (am_{{ $lang->code }}) fd.append('trans[{{ $lang->code }}][meta_title]', am_{{ $lang->code }}.value);
  if (ad_{{ $lang->code }}) fd.append('trans[{{ $lang->code }}][meta_desc]',  ad_{{ $lang->code }}.value);
  if (aw_{{ $lang->code }}) fd.append('trans[{{ $lang->code }}][keywords]',   aw_{{ $lang->code }}.value);
  @endif
  @endforeach
  // Lampirkan thumbnail jika ada file baru (compress dulu)
  const thumbFile = document.getElementById('a-thumb');
  if (thumbFile.files && thumbFile.files[0]) {
    const compressed = await compressImage(thumbFile.files[0]);
    fd.append('thumbnail', compressed);
  }

  if (id) {
    fd.append('_method', 'PUT');
    const r = await apiFetch(`/admin/artikel/${id}`, 'POST', fd);
    clearLoading();
    if (r.success) { showToast(r.message); closeModal('m-add'); location.reload(); }
    else showToast(r.message || 'Gagal menyimpan.', 'error');
  } else {
    const r = await apiFetch("{{ route('admin.artikel.store') }}", 'POST', fd);
    clearLoading();
    if (r.success) { showToast(r.message); closeModal('m-add'); location.reload(); }
    else showToast(r.message || 'Gagal menyimpan.', 'error');
  }
}

function editArtikel(id) {
  const a = ARTS.find(x => x.id === id);
  if (!a) return;
  document.getElementById('modal-title').textContent = 'Edit Artikel';
  document.getElementById('a-id').value = id;
  document.getElementById('a-slug').value = a.slug;
  const katSel = document.getElementById('a-kategori');
  // Jika kategori artikel tidak ada di daftar master (mis. nonaktif/lama), tambahkan sementara agar tetap terpilih
  if (a.kategori && ![...katSel.options].some(o => o.value === a.kategori)) {
    katSel.add(new Option(a.kategori + ' (tidak aktif)', a.kategori));
  }
  katSel.value = a.kategori || '';
  document.getElementById('a-penulis').value = a.penulis || '';
  document.getElementById('a-thumb').value = '';
  const prev = document.getElementById('thumb-preview');
  if (a.thumbnail) {
    prev.innerHTML = `<img src="/storage/${a.thumbnail}" style="width:100%;height:100%;object-fit:cover">`;
  } else {
    prev.innerHTML = '🖼️';
  }
  document.getElementById('a-status').value = a.status;

  // Fill ID (base) fields
  document.getElementById('a-judul').value = a.judul;
  document.getElementById('a-metatitle').value = a.meta_title || '';
  document.getElementById('a-metadesc').value = a.meta_desc || '';
  document.getElementById('a-keywords').value = (a.keywords || []).join(', ');
  document.getElementById('editor').innerHTML = a.konten || '';
  document.getElementById('a-konten').value = a.konten || '';

  // Fill translation fields
  const trans = a.translations || {};
  @foreach($languages as $lang)
  @if($lang->code !== 'id')
  const ta_{{ $lang->code }} = trans['{{ $lang->code }}'] || {};
  const fj_{{ $lang->code }} = document.getElementById('a-judul-{{ $lang->code }}');
  const fk_{{ $lang->code }} = document.getElementById('a-konten-{{ $lang->code }}');
  const fm_{{ $lang->code }} = document.getElementById('a-metatitle-{{ $lang->code }}');
  const fd_{{ $lang->code }} = document.getElementById('a-metadesc-{{ $lang->code }}');
  const fw_{{ $lang->code }} = document.getElementById('a-keywords-{{ $lang->code }}');
  if (fj_{{ $lang->code }}) fj_{{ $lang->code }}.value = ta_{{ $lang->code }}.judul || '';
  if (fk_{{ $lang->code }}) fk_{{ $lang->code }}.value = ta_{{ $lang->code }}.konten || '';
  if (fm_{{ $lang->code }}) fm_{{ $lang->code }}.value = ta_{{ $lang->code }}.meta_title || '';
  if (fd_{{ $lang->code }}) fd_{{ $lang->code }}.value = ta_{{ $lang->code }}.meta_desc || '';
  if (fw_{{ $lang->code }}) fw_{{ $lang->code }}.value = (ta_{{ $lang->code }}.keywords || []).join(', ');
  @endif
  @endforeach

  // Reset to first tab
  const firstTab = document.querySelector('#art-tabs .lang-tab');
  if (firstTab) switchLangTab('art', firstTab, '{{ $languages->first()->code ?? "id" }}');

  openModal('m-add');
}

async function deleteArtikel(id, judul) {
  if (!confirm(`Hapus artikel "${judul}"?`)) return;
  const r = await apiFetch(`/admin/artikel/${id}`, 'DELETE');
  if (r.success) { showToast(r.message); location.reload(); }
  else showToast(r.message, 'error');
}

function previewThumb(input) {
  if (!input.files || !input.files[0]) return;
  const reader = new FileReader();
  reader.onload = e => {
    const box = document.getElementById('thumb-preview');
    box.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover">`;
  };
  reader.readAsDataURL(input.files[0]);
}
</script>
@endpush
