<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $settings['title_line1'] ?? 'Website Kami' }} {{ $settings['title_line2'] ?? 'Segera Hadir!' }} | {{ $siteSettings['name'] ?? 'Akar Sehat' }}</title>
  <meta name="robots" content="noindex, nofollow">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Poppins',sans-serif;background:#1a0f0a;color:#fff;min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:40px 20px;text-align:center;overflow:hidden;position:relative}
    .bg-circles{position:absolute;inset:0;overflow:hidden;pointer-events:none}
    .circle{position:absolute;border-radius:50%;animation:pulse 4s ease-in-out infinite}
    .c1{width:400px;height:400px;border:1px solid rgba(200,106,68,.08);top:50%;left:50%;transform:translate(-50%,-50%)}
    .c2{width:600px;height:600px;border:1px solid rgba(200,106,68,.05);top:50%;left:50%;transform:translate(-50%,-50%);animation-delay:.5s}
    .c3{width:800px;height:800px;border:1px solid rgba(200,106,68,.03);top:50%;left:50%;transform:translate(-50%,-50%);animation-delay:1s}
    @keyframes pulse{0%,100%{opacity:.5}50%{opacity:1}}
    .content{position:relative;z-index:1;max-width:600px;width:100%}
    .badge{display:inline-block;background:rgba(200,106,68,.15);border:1px solid rgba(200,106,68,.3);color:#C86A44;padding:6px 16px;border-radius:99px;font-size:12.5px;font-weight:600;margin-bottom:24px}
    .site-name{font-size:14px;color:rgba(255,255,255,.4);letter-spacing:.12em;text-transform:uppercase;margin-bottom:20px}
    .title-line1{font-size:20px;color:rgba(255,255,255,.7);margin-bottom:4px}
    .title-line2{font-size:42px;font-weight:700;background:linear-gradient(135deg,#C86A44,#e8a07a);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;margin-bottom:20px}
    .desc{font-size:14px;color:rgba(255,255,255,.5);line-height:1.7;max-width:480px;margin:0 auto 36px}
    .countdown{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:32px}
    .cd-item{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.08);border-radius:12px;padding:16px 8px}
    .cd-val{font-size:32px;font-weight:700;line-height:1}
    .cd-label{font-size:11px;color:rgba(255,255,255,.4);margin-top:6px;text-transform:uppercase;letter-spacing:.06em}
    .progress-wrap{margin-bottom:32px}
    .progress-label{display:flex;justify-content:space-between;font-size:12.5px;color:rgba(255,255,255,.4);margin-bottom:8px}
    .progress-bar{height:6px;background:rgba(255,255,255,.08);border-radius:99px;overflow:hidden}
    .progress-fill{height:100%;background:linear-gradient(90deg,#C86A44,#e8a07a);border-radius:99px;transition:width 1s ease;width:0}
    .contact-row{display:flex;justify-content:center;gap:12px;flex-wrap:wrap}
    .contact-btn{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;border-radius:8px;font-size:13px;font-weight:500;text-decoration:none;transition:.2s;border:1px solid rgba(255,255,255,.1);color:rgba(255,255,255,.7)}
    .contact-btn:hover{border-color:rgba(200,106,68,.5);color:#fff}
    .contact-btn.wa{background:rgba(37,211,102,.1);border-color:rgba(37,211,102,.3);color:#25d366}
    .footer-uc{margin-top:40px;font-size:12px;color:rgba(255,255,255,.2)}
    .footer-uc a{color:rgba(200,106,68,.6);text-decoration:none}
    @media(max-width:480px){.title-line2{font-size:28px}.countdown{grid-template-columns:repeat(2,1fr)}}
  </style>
</head>
<body>
  <div class="bg-circles">
    <div class="circle c1"></div>
    <div class="circle c2"></div>
    <div class="circle c3"></div>
  </div>

  <div class="content">
    <div class="site-name">🌿 {{ $siteSettings['name'] ?? 'Akar Sehat' }}</div>
    <div class="badge">{{ $siteSettings['tagline'] ?? 'Herbal Tradisional Terpercaya' }}</div>
    <div class="title-line1">{{ $settings['title_line1'] ?? 'Website Kami' }}</div>
    <div class="title-line2">{{ $settings['title_line2'] ?? 'Segera Hadir!' }}</div>
    <p class="desc">{{ $settings['description'] ?? 'Kami sedang menyiapkan sesuatu yang lebih baik untuk Anda.' }}</p>

    @if(($settings['show_countdown'] ?? '1') == '1' && isset($settings['launch_date']))
    <div class="countdown">
      <div class="cd-item"><div class="cd-val" id="cd-d">--</div><div class="cd-label">Hari</div></div>
      <div class="cd-item"><div class="cd-val" id="cd-h">--</div><div class="cd-label">Jam</div></div>
      <div class="cd-item"><div class="cd-val" id="cd-m">--</div><div class="cd-label">Menit</div></div>
      <div class="cd-item"><div class="cd-val" id="cd-s">--</div><div class="cd-label">Detik</div></div>
    </div>
    @endif

    @if(($settings['show_progress'] ?? '1') == '1')
    <div class="progress-wrap">
      <div class="progress-label"><span>Progress Pengembangan</span><span id="prog-pct">{{ $settings['progress'] ?? 75 }}%</span></div>
      <div class="progress-bar"><div class="progress-fill" id="prog-fill"></div></div>
    </div>
    @endif

    <div class="contact-row">
      @if(isset($siteSettings['wa_number']))
      <a href="https://wa.me/{{ $siteSettings['wa_number'] }}" class="contact-btn wa" target="_blank" rel="noopener">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"/></svg>
        WhatsApp
      </a>
      @endif
      @if(isset($siteSettings['email']))
      <a href="mailto:{{ $siteSettings['email'] }}" class="contact-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        {{ $siteSettings['email'] }}
      </a>
      @endif
    </div>
  </div>

  <div class="footer-uc">
    &copy; {{ date('Y') }} {{ $siteSettings['name'] ?? 'Akar Sehat' }} &nbsp;|&nbsp;
    <a href="{{ route('admin.login') }}">Admin Panel</a>
  </div>

  <script>
    @if(($settings['show_countdown'] ?? '1') == '1' && isset($settings['launch_date']))
    (function() {
      const target = new Date('{{ $settings['launch_date'] }}');
      function tick() {
        const diff = target - new Date();
        if (diff <= 0) return;
        const d = Math.floor(diff/86400000);
        const h = Math.floor((diff%86400000)/3600000);
        const m = Math.floor((diff%3600000)/60000);
        const s = Math.floor((diff%60000)/1000);
        document.getElementById('cd-d').textContent = String(d).padStart(2,'0');
        document.getElementById('cd-h').textContent = String(h).padStart(2,'0');
        document.getElementById('cd-m').textContent = String(m).padStart(2,'0');
        document.getElementById('cd-s').textContent = String(s).padStart(2,'0');
      }
      tick(); setInterval(tick, 1000);
    })();
    @endif

    @if(($settings['show_progress'] ?? '1') == '1')
    setTimeout(() => {
      document.getElementById('prog-fill').style.width = '{{ $settings['progress'] ?? 75 }}%';
    }, 400);
    @endif
  </script>
</body>
</html>
