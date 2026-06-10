@extends('layouts.admin')

@section('title', 'Pengaturan Under Construction')
@section('breadcrumb')
  <a href="{{ route('admin.pengaturan.index') }}">Pengaturan</a>
  <span class="sep">/</span><span class="cur">Under Construction</span>
@endsection

@push('styles')
<style>
  .uc-grid { display: grid; grid-template-columns: 1fr 380px; gap: 24px; }
  .uc-preview { position: sticky; top: calc(var(--th) + 20px); }
  .prev-box { background: #1a0f0a; border-radius: var(--r3); padding: 24px; color: #fff; min-height: 500px; }
  .mode-banner { padding: 10px 16px; border-radius: var(--r2); font-size: 13px; font-weight: 600; margin-bottom: 20px; text-align: center; }
  .mode-on  { background: rgba(239,68,68,.15);  color: #ef4444; border: 1px solid rgba(239,68,68,.3); }
  .mode-off { background: rgba(34,197,94,.15);  color: #22c55e; border: 1px solid rgba(34,197,94,.3); }
  @media (max-width: 1100px) { .uc-grid { grid-template-columns: 1fr; } .uc-preview { position: static; } }
</style>
@endpush

@section('content')
<div class="pg-hd">
  <div><h1>Pengaturan Under Construction</h1><p>Kontrol mode maintenance website</p></div>
  <a href="{{ route('admin.pengaturan.index') }}" class="btn btn-outline">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
    Kembali
  </a>
</div>

<form method="POST" action="{{ route('admin.pengaturan.uc.save') }}" id="uc-form">
  @csrf
  <div class="uc-grid">
    <div>
      <!-- MASTER TOGGLE -->
      <div class="card" style="margin-bottom:16px">
        <div class="card-body">
          <div style="display:flex;align-items:center;justify-content:space-between;gap:16px">
            <div>
              <div style="font-weight:600;font-size:15px;margin-bottom:4px">Mode Under Construction</div>
              <div style="font-size:13px;color:var(--cmt)">Aktifkan untuk mengalihkan semua pengunjung ke halaman under construction</div>
            </div>
            <label class="tog">
              <input type="checkbox" name="mode" value="on" id="mode-toggle" onchange="updatePreview()" {{ ($settings['mode'] ?? 'off') === 'on' ? 'checked' : '' }}>
              <span class="tog-sl"></span>
            </label>
          </div>
        </div>
      </div>

      <!-- KONTEN -->
      <div class="card" style="margin-bottom:16px">
        <div class="card-hd"><h3>Konten & Teks</h3></div>
        <div class="card-body">
          <div class="frow frow-2">
            <div class="fg"><label class="fl">Judul Baris 1</label><input type="text" name="title_line1" class="fc" value="{{ $settings['title_line1'] ?? 'Website Kami' }}" oninput="updatePreview()"></div>
            <div class="fg"><label class="fl">Judul Baris 2 (highlight)</label><input type="text" name="title_line2" class="fc" value="{{ $settings['title_line2'] ?? 'Segera Hadir!' }}" oninput="updatePreview()"></div>
          </div>
          <div class="fg"><label class="fl">Deskripsi</label><textarea name="description" class="fc" rows="3" oninput="updatePreview()">{{ $settings['description'] ?? '' }}</textarea></div>
        </div>
      </div>

      <!-- COUNTDOWN -->
      <div class="card" style="margin-bottom:16px">
        <div class="card-hd"><h3>Countdown Timer</h3></div>
        <div class="card-body">
          <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px">
            <label class="tog"><input type="checkbox" name="show_countdown" value="1" id="show-countdown" onchange="updatePreview()" {{ ($settings['show_countdown'] ?? '1') == '1' ? 'checked' : '' }}><span class="tog-sl"></span></label>
            <span style="font-size:13px">Tampilkan countdown timer</span>
          </div>
          <div class="fg"><label class="fl">Target Tanggal Launch</label><input type="datetime-local" name="launch_date" class="fc" value="{{ isset($settings['launch_date']) ? str_replace('T00:00:00','',$settings['launch_date']).'T00:00' : '' }}" oninput="updateCountdown()"></div>
        </div>
      </div>

      <!-- PROGRESS -->
      <div class="card" style="margin-bottom:16px">
        <div class="card-hd"><h3>Progress Bar</h3></div>
        <div class="card-body">
          <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px">
            <label class="tog"><input type="checkbox" name="show_progress" value="1" onchange="updatePreview()" {{ ($settings['show_progress'] ?? '1') == '1' ? 'checked' : '' }}><span class="tog-sl"></span></label>
            <span style="font-size:13px">Tampilkan progress bar</span>
          </div>
          <div class="fg">
            <label class="fl">Persentase Progress: <span id="prog-val">{{ $settings['progress'] ?? '75' }}</span>%</label>
            <input type="range" name="progress" min="0" max="100" value="{{ $settings['progress'] ?? '75' }}" style="width:100%;accent-color:var(--cp)" oninput="document.getElementById('prog-val').textContent=this.value; updatePreview()">
          </div>
        </div>
      </div>
    </div>

    <!-- PREVIEW -->
    <div class="uc-preview">
      <div style="font-size:12px;font-weight:600;color:var(--cmt);text-transform:uppercase;letter-spacing:.04em;margin-bottom:10px">Live Preview</div>
      <div class="prev-box">
        <div class="mode-banner" id="prev-mode-banner">Mode: OFF — Website Berjalan Normal</div>
        <div style="text-align:center;padding:16px 0">
          <div style="font-size:11px;color:rgba(255,255,255,.4);letter-spacing:.1em;text-transform:uppercase;margin-bottom:12px">🌿 Akar Sehat</div>
          <div style="font-size:16px;color:rgba(255,255,255,.8);margin-bottom:6px" id="prev-line1">Website Kami</div>
          <div style="font-size:22px;font-weight:700;color:#C86A44;margin-bottom:12px" id="prev-line2">Segera Hadir!</div>
          <div style="font-size:12px;color:rgba(255,255,255,.5);line-height:1.6;max-width:280px;margin:0 auto" id="prev-desc">Kami sedang menyiapkan sesuatu yang lebih baik...</div>
        </div>
        <div id="prev-countdown" style="display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin:16px 0;text-align:center">
          <div style="background:rgba(255,255,255,.07);border-radius:8px;padding:10px">
            <div style="font-size:22px;font-weight:700;color:#fff" id="cd-hari">--</div>
            <div style="font-size:10px;color:rgba(255,255,255,.4)">Hari</div>
          </div>
          <div style="background:rgba(255,255,255,.07);border-radius:8px;padding:10px">
            <div style="font-size:22px;font-weight:700;color:#fff" id="cd-jam">--</div>
            <div style="font-size:10px;color:rgba(255,255,255,.4)">Jam</div>
          </div>
          <div style="background:rgba(255,255,255,.07);border-radius:8px;padding:10px">
            <div style="font-size:22px;font-weight:700;color:#fff" id="cd-mnt">--</div>
            <div style="font-size:10px;color:rgba(255,255,255,.4)">Menit</div>
          </div>
          <div style="background:rgba(255,255,255,.07);border-radius:8px;padding:10px">
            <div style="font-size:22px;font-weight:700;color:#fff" id="cd-dtk">--</div>
            <div style="font-size:10px;color:rgba(255,255,255,.4)">Detik</div>
          </div>
        </div>
        <div id="prev-prog" style="margin:12px 0">
          <div style="height:5px;background:rgba(255,255,255,.1);border-radius:99px">
            <div id="prog-bar" style="height:100%;background:#C86A44;border-radius:99px;transition:.3s;width:{{ $settings['progress'] ?? 75 }}%"></div>
          </div>
          <div style="font-size:10px;color:rgba(255,255,255,.4);margin-top:4px;text-align:right" id="prog-pct">{{ $settings['progress'] ?? 75 }}% Selesai</div>
        </div>
      </div>
      <div style="margin-top:16px;display:flex;justify-content:flex-end">
        <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
      </div>
    </div>
  </div>
</form>
@endsection

@push('scripts')
<script>
function updatePreview() {
  const mode = document.getElementById('mode-toggle').checked;
  const banner = document.getElementById('prev-mode-banner');
  if (mode) {
    banner.textContent = '🔴 Mode: ON — Under Construction Aktif';
    banner.className = 'mode-banner mode-on';
  } else {
    banner.textContent = '🟢 Mode: OFF — Website Berjalan Normal';
    banner.className = 'mode-banner mode-off';
  }
  const line1 = document.querySelector('[name=title_line1]').value;
  const line2 = document.querySelector('[name=title_line2]').value;
  const desc = document.querySelector('[name=description]').value;
  document.getElementById('prev-line1').textContent = line1 || 'Website Kami';
  document.getElementById('prev-line2').textContent = line2 || 'Segera Hadir!';
  document.getElementById('prev-desc').textContent = desc || '...';

  const progVal = document.querySelector('[name=progress]').value;
  document.getElementById('prog-bar').style.width = progVal + '%';
  document.getElementById('prog-pct').textContent = progVal + '% Selesai';
}

let cdInterval;
function updateCountdown() {
  clearInterval(cdInterval);
  const target = new Date(document.querySelector('[name=launch_date]').value);
  if (isNaN(target)) return;
  function tick() {
    const now = new Date();
    const diff = target - now;
    if (diff <= 0) { clearInterval(cdInterval); return; }
    const d = Math.floor(diff / 86400000);
    const h = Math.floor((diff % 86400000) / 3600000);
    const m = Math.floor((diff % 3600000) / 60000);
    const s = Math.floor((diff % 60000) / 1000);
    document.getElementById('cd-hari').textContent = String(d).padStart(2,'0');
    document.getElementById('cd-jam').textContent = String(h).padStart(2,'0');
    document.getElementById('cd-mnt').textContent = String(m).padStart(2,'0');
    document.getElementById('cd-dtk').textContent = String(s).padStart(2,'0');
  }
  tick();
  cdInterval = setInterval(tick, 1000);
}

updatePreview();
updateCountdown();
</script>
@endpush
