@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')
@section('breadcrumb')
  <a href="{{ route('admin.pengaturan.index') }}">Pengaturan</a>
  <span class="sep">/</span><span class="cur">Pengguna</span>
@endsection

@section('content')
<div class="pg-hd">
  <div><h1>Manajemen Pengguna</h1><p>Total {{ $users->total() }} akun terdaftar</p></div>
  <div class="pg-hd-acts">
    <button class="btn btn-primary" onclick="openModal('m-add')">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Tambah Pengguna
    </button>
  </div>
</div>

<form method="GET" class="filter-bar">
  <div class="search-wrap">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <input type="text" name="search" class="fc" placeholder="Cari nama, email, username..." value="{{ request('search') }}">
  </div>
  <select name="role" class="fc">
    <option value="">Semua Role</option>
    <option value="administrator" {{ request('role')=='administrator'?'selected':'' }}>Administrator</option>
    <option value="editor" {{ request('role')=='editor'?'selected':'' }}>Editor</option>
    <option value="penulis" {{ request('role')=='penulis'?'selected':'' }}>Penulis</option>
    <option value="viewer" {{ request('role')=='viewer'?'selected':'' }}>Viewer</option>
  </select>
  <select name="status" class="fc">
    <option value="">Semua Status</option>
    <option value="aktif" {{ request('status')=='aktif'?'selected':'' }}>Aktif</option>
    <option value="non-aktif" {{ request('status')=='non-aktif'?'selected':'' }}>Non-Aktif</option>
    <option value="suspended" {{ request('status')=='suspended'?'selected':'' }}>Suspended</option>
  </select>
  <button type="submit" class="btn btn-outline">Filter</button>
  @if(request()->hasAny(['search','role','status']))
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Reset</a>
  @endif
</form>

<div class="card">
  <div class="tbl-wrap">
    <table>
      <thead><tr><th>Pengguna</th><th>Username</th><th>Role</th><th>Status</th><th>Login Terakhir</th><th>Login</th><th style="width:90px">Aksi</th></tr></thead>
      <tbody>
        @forelse($users as $u)
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:10px">
              <div style="width:36px;height:36px;border-radius:50%;display:grid;place-items:center;font-size:12px;font-weight:700;color:#fff;flex-shrink:0;background:{{ $u->avatar_color ?? '#C86A44' }}">{{ $u->initials }}</div>
              <div>
                <div style="font-weight:600;font-size:13px">{{ $u->name }}</div>
                <div style="font-size:11.5px;color:var(--cmt)">{{ $u->email }}</div>
              </div>
            </div>
          </td>
          <td style="font-family:monospace;font-size:12.5px;color:var(--cmt)">{{ $u->username }}</td>
          <td>
            @php
              $roleColors = ['administrator' => ['var(--cpl)','var(--cp)'], 'editor' => ['rgba(59,130,246,.1)','#3b82f6'], 'penulis' => ['rgba(139,92,246,.1)','#8b5cf6'], 'viewer' => ['var(--cbg)','var(--cmt)']];
              $rc = $roleColors[$u->role] ?? $roleColors['viewer'];
            @endphp
            <span class="badge" style="background:{{ $rc[0] }};color:{{ $rc[1] }}">{{ ucfirst($u->role) }}</span>
          </td>
          <td>
            <span class="badge {{ $u->status === 'aktif' ? 's-aktif' : ($u->status === 'suspended' ? 's-suspended' : 's-nonaktif') }}">{{ ucfirst($u->status) }}</span>
          </td>
          <td style="font-size:12px;color:var(--cmt)">{{ $u->last_login_at ? $u->last_login_at->diffForHumans() : 'Belum pernah' }}</td>
          <td style="font-size:13px;font-weight:600">{{ number_format($u->login_count) }}</td>
          <td>
            <div style="display:flex;gap:4px">
              <button class="act-btn" onclick="editUser({{ $u->id }})" title="Edit">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
              </button>
              @if($u->id !== auth()->id())
              <button class="act-btn" onclick="toggleStatus({{ $u->id }}, '{{ $u->status }}')" title="Toggle Status">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="{{ $u->status === 'aktif' ? '#22c55e' : '#6b7280' }}" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
              </button>
              <button class="act-btn del" onclick="deleteUser({{ $u->id }}, '{{ addslashes($u->name) }}')" title="Hapus">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
              </button>
              @endif
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;padding:40px;color:var(--cmt)">Belum ada pengguna.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($users->hasPages())
  <div style="padding:16px 20px;border-top:1px solid var(--cbg)">{{ $users->links('vendor.pagination.custom') }}</div>
  @endif
</div>

<!-- MODAL TAMBAH -->
<div class="modal-overlay" id="m-add" onclick="handleOC(event,'m-add')">
  <div class="modal">
    <div class="modal-hd">
      <div class="modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
      <div><h3>Tambah Pengguna</h3><p>Buat akun admin baru</p></div>
      <button class="modal-close" onclick="closeModal('m-add')">&times;</button>
    </div>
    <form onsubmit="submitAdd(event)">
      @csrf
      <div class="modal-body">
        <div class="frow frow-2">
          <div class="fg"><label class="fl">Nama Lengkap *</label><input type="text" name="name" class="fc" required></div>
          <div class="fg"><label class="fl">Username *</label><input type="text" name="username" class="fc" required></div>
        </div>
        <div class="fg"><label class="fl">Email *</label><input type="email" name="email" class="fc" required></div>
        <div class="frow frow-2">
          <div class="fg"><label class="fl">Password *</label><input type="password" name="password" class="fc" required minlength="8"></div>
          <div class="fg"><label class="fl">Nomor WA</label><input type="text" name="wa" class="fc" placeholder="081234..."></div>
        </div>
        <div class="frow frow-2">
          <div class="fg">
            <label class="fl">Role *</label>
            <select name="role" class="fc" required>
              <option value="viewer">Viewer</option>
              <option value="penulis">Penulis</option>
              <option value="editor">Editor</option>
              <option value="administrator">Administrator</option>
            </select>
          </div>
          <div class="fg">
            <label class="fl">Status</label>
            <select name="status" class="fc">
              <option value="aktif">Aktif</option>
              <option value="non-aktif">Non-Aktif</option>
            </select>
          </div>
        </div>
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
      <div class="modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></div>
      <div><h3>Edit Pengguna</h3><p id="edit-sub">—</p></div>
      <button class="modal-close" onclick="closeModal('m-edit')">&times;</button>
    </div>
    <form onsubmit="submitEdit(event)">
      @csrf
      <input type="hidden" id="edit-id">
      <div class="modal-body">
        <div class="frow frow-2">
          <div class="fg"><label class="fl">Nama Lengkap *</label><input type="text" id="u-name" name="name" class="fc" required></div>
          <div class="fg"><label class="fl">Username *</label><input type="text" id="u-username" name="username" class="fc" required></div>
        </div>
        <div class="fg"><label class="fl">Email *</label><input type="email" id="u-email" name="email" class="fc" required></div>
        <div class="frow frow-2">
          <div class="fg"><label class="fl">Password Baru <span style="color:var(--cmt);font-weight:400">(kosongkan jika tidak diubah)</span></label><input type="password" name="password" class="fc" minlength="8"></div>
          <div class="fg"><label class="fl">Nomor WA</label><input type="text" id="u-wa" name="wa" class="fc"></div>
        </div>
        <div class="frow frow-2">
          <div class="fg">
            <label class="fl">Role *</label>
            <select id="u-role" name="role" class="fc" required>
              <option value="viewer">Viewer</option>
              <option value="penulis">Penulis</option>
              <option value="editor">Editor</option>
              <option value="administrator">Administrator</option>
            </select>
          </div>
          <div class="fg">
            <label class="fl">Status</label>
            <select id="u-status" name="status" class="fc">
              <option value="aktif">Aktif</option>
              <option value="non-aktif">Non-Aktif</option>
              <option value="suspended">Suspended</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-ft">
        <button type="button" class="btn btn-outline" onclick="closeModal('m-edit')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<script id="user-data" type="application/json">{!! json_encode($users->items(), JSON_UNESCAPED_UNICODE) !!}</script>
@endsection

@push('scripts')
<script>
const USERS = JSON.parse(document.getElementById('user-data').textContent);

async function submitAdd(e) {
  e.preventDefault();
  const body = Object.fromEntries(new FormData(e.target));
  delete body._token;
  const r = await apiFetch("{{ route('admin.users.store') }}", 'POST', body);
  if (r.success) { showToast(r.message); closeModal('m-add'); location.reload(); }
  else showToast(r.message || 'Gagal.', 'error');
}

function editUser(id) {
  const u = USERS.find(x => x.id === id);
  if (!u) return;
  document.getElementById('edit-id').value = id;
  document.getElementById('edit-sub').textContent = u.name;
  document.getElementById('u-name').value = u.name;
  document.getElementById('u-username').value = u.username;
  document.getElementById('u-email').value = u.email;
  document.getElementById('u-wa').value = u.wa || '';
  document.getElementById('u-role').value = u.role;
  document.getElementById('u-status').value = u.status;
  openModal('m-edit');
}

async function submitEdit(e) {
  e.preventDefault();
  const id = document.getElementById('edit-id').value;
  const body = Object.fromEntries(new FormData(e.target));
  delete body._token;
  const r = await apiFetch(`/admin/users/${id}`, 'PUT', body);
  if (r.success) { showToast(r.message); closeModal('m-edit'); location.reload(); }
  else showToast(r.message || 'Gagal.', 'error');
}

async function toggleStatus(id, currentStatus) {
  const r = await apiFetch(`/admin/users/${id}/toggle-status`, 'PATCH');
  if (r.success) { showToast(`Status diubah ke ${r.status}`); location.reload(); }
  else showToast(r.message, 'error');
}

async function deleteUser(id, nama) {
  if (!confirm(`Hapus pengguna "${nama}"?`)) return;
  const r = await apiFetch(`/admin/users/${id}`, 'DELETE');
  if (r.success) { showToast(r.message); location.reload(); }
  else showToast(r.message, 'error');
}
</script>
@endpush
