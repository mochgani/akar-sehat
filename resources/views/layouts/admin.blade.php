<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Dashboard') — {{ $siteSettings['name'] ?? 'Akar Sehat' }} Admin</title>
  @include('partials.favicon')
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --cp:  #C86A44; --cpd: #A8522E; --cpl: rgba(200,106,68,.10);
      --cdb: #382A21; --csi: #FAF6F1; --cbg: #F2EBE3; --cms: #D9C9B8;
      --cw:  #FFFFFF; --ctm: #3D2B1F; --cmt: #7A6355;
      --fp: 'Poppins', sans-serif; --sw: 260px; --th: 64px;
      --r1: 6px; --r2: 10px; --r3: 14px; --r4: 18px; --rr: 999px;
      --s1: 0 1px 3px rgba(56,42,33,.06), 0 1px 6px rgba(56,42,33,.04);
      --s2: 0 4px 16px rgba(56,42,33,.08); --s3: 0 8px 30px rgba(56,42,33,.12);
      --tr: .2s ease;
    }
    html, body { height: 100%; font-family: var(--fp); background: var(--csi); color: var(--ctm); font-size: 14px; }

    /* SIDEBAR */
    .sb { position: fixed; top: 0; left: 0; width: var(--sw); height: 100vh; background: var(--cdb); display: flex; flex-direction: column; z-index: 100; transition: transform var(--tr); overflow-y: auto; }
    .sb-logo { display: flex; align-items: center; gap: 10px; padding: 20px 20px 16px; border-bottom: 1px solid rgba(255,255,255,.08); }
    .sb-logo-icon { width: 36px; height: 36px; background: var(--cp); border-radius: var(--r2); display: grid; place-items: center; font-size: 18px; flex-shrink: 0; }
    .sb-logo-text strong { display: block; color: #fff; font-size: 15px; font-weight: 600; }
    .sb-logo-text span { color: rgba(255,255,255,.45); font-size: 11px; }
    .sb-nav { flex: 1; padding: 12px 0; }
    .sb-section { padding: 10px 20px 4px; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: .08em; color: rgba(255,255,255,.3); }
    .sb-a { display: flex; align-items: center; gap: 10px; padding: 9px 20px; color: rgba(255,255,255,.6); text-decoration: none; font-size: 13.5px; font-weight: 500; transition: all var(--tr); border-left: 3px solid transparent; }
    .sb-a:hover { color: #fff; background: rgba(255,255,255,.06); }
    .sb-a.active { color: #fff; background: rgba(200,106,68,.18); border-left-color: var(--cp); }
    .sb-a svg { opacity: .7; flex-shrink: 0; }
    .sb-a.active svg { opacity: 1; }
    .sb-user { padding: 16px 20px; border-top: 1px solid rgba(255,255,255,.08); display: flex; align-items: center; gap: 10px; }
    .sb-avatar { width: 34px; height: 34px; border-radius: 50%; display: grid; place-items: center; font-size: 12px; font-weight: 700; color: #fff; flex-shrink: 0; }
    .sb-user-info strong { display: block; color: #fff; font-size: 13px; font-weight: 600; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .sb-user-info span { color: rgba(255,255,255,.4); font-size: 11px; text-transform: capitalize; }
    .sb-ov { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 99; }

    /* TOPBAR */
    .mw { margin-left: var(--sw); display: flex; flex-direction: column; min-height: 100vh; }
    .topbar { height: var(--th); background: var(--cw); border-bottom: 1px solid var(--cms); display: flex; align-items: center; gap: 12px; padding: 0 24px; position: sticky; top: 0; z-index: 50; box-shadow: var(--s1); }
    .tb-hb { display: none; background: none; border: none; cursor: pointer; padding: 6px; color: var(--cmt); }
    .tb-bc { flex: 1; display: flex; align-items: center; gap: 6px; font-size: 13px; color: var(--cmt); }
    .tb-bc a { color: var(--cmt); text-decoration: none; }
    .tb-bc a:hover { color: var(--cp); }
    .tb-bc .sep { color: var(--cms); }
    .tb-bc .cur { color: var(--ctm); font-weight: 600; }
    .tb-acts { display: flex; align-items: center; gap: 8px; }
    .tb-view { display: flex; align-items: center; gap: 6px; font-size: 13px; color: var(--cmt); text-decoration: none; padding: 6px 12px; border-radius: var(--rr); border: 1px solid var(--cms); transition: all var(--tr); }
    .tb-view:hover { border-color: var(--cp); color: var(--cp); }
    .tb-btn { width: 34px; height: 34px; border-radius: 50%; display: grid; place-items: center; background: var(--cbg); border: 1px solid var(--cms); cursor: pointer; color: var(--cmt); transition: all var(--tr); position: relative; }
    .tb-btn:hover { border-color: var(--cp); color: var(--cp); }
    .tb-av { width: 34px; height: 34px; border-radius: 50%; display: grid; place-items: center; font-size: 12px; font-weight: 700; color: #fff; cursor: pointer; }
    .pg { flex: 1; padding: 28px 28px 40px; }

    /* CARDS */
    .card { background: var(--cw); border: 1px solid var(--cms); border-radius: var(--r3); box-shadow: var(--s1); }
    .card-hd { padding: 18px 20px 14px; border-bottom: 1px solid var(--cbg); display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
    .card-hd h3 { font-size: 15px; font-weight: 600; color: var(--ctm); }
    .card-body { padding: 20px; }

    /* TABLE */
    .tbl-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 13px; }
    th { background: var(--cbg); padding: 10px 14px; text-align: left; font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; color: var(--cmt); white-space: nowrap; }
    td { padding: 12px 14px; border-bottom: 1px solid var(--cbg); vertical-align: middle; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #fdfaf7; }

    /* BADGES */
    .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: var(--rr); font-size: 11.5px; font-weight: 600; }

    /* BUTTONS */
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--r1); font-size: 13px; font-weight: 500; cursor: pointer; border: none; transition: all var(--tr); text-decoration: none; font-family: var(--fp); }
    .btn-primary { background: var(--cp); color: #fff; }
    .btn-primary:hover { background: var(--cpd); }
    .btn-outline { background: var(--cw); color: var(--ctm); border: 1px solid var(--cms); }
    .btn-outline:hover { border-color: var(--cp); color: var(--cp); }
    .btn-sm { padding: 5px 10px; font-size: 12px; }
    .btn-danger { background: rgba(239,68,68,.1); color: #ef4444; border: 1px solid rgba(239,68,68,.2); }
    .btn-danger:hover { background: #ef4444; color: #fff; }
    .act-btn { width: 30px; height: 30px; border-radius: var(--r1); display: grid; place-items: center; cursor: pointer; border: 1px solid var(--cms); background: var(--cw); color: var(--cmt); transition: all var(--tr); }
    .act-btn:hover { border-color: var(--cp); color: var(--cp); }
    .act-btn.del:hover { border-color: #ef4444; color: #ef4444; }

    /* FORM */
    .fg { margin-bottom: 16px; }
    .fl { display: block; font-size: 12.5px; font-weight: 600; color: var(--ctm); margin-bottom: 6px; }
    .fc, select, textarea { width: 100%; padding: 9px 12px; border: 1px solid var(--cms); border-radius: var(--r1); font-family: var(--fp); font-size: 13px; color: var(--ctm); background: var(--cw); outline: none; transition: border-color var(--tr); }
    .fc:focus, select:focus, textarea:focus { border-color: var(--cp); box-shadow: 0 0 0 3px var(--cpl); }
    textarea { min-height: 90px; resize: vertical; }
    .frow { display: grid; gap: 14px; }
    .frow-2 { grid-template-columns: 1fr 1fr; }
    .frow-3 { grid-template-columns: 1fr 1fr 1fr; }

    /* MODAL */
    .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.45); z-index: 200; overflow-y: auto; padding: 20px; align-items: flex-start; justify-content: center; }
    .modal-overlay.show { display: flex; }
    .modal { background: var(--cw); border-radius: var(--r3); width: 100%; max-width: 520px; box-shadow: var(--s3); margin: auto; }
    .modal-lg { max-width: 760px; }
    .modal-xl { max-width: 960px; }
    .modal-hd { padding: 20px 24px 16px; border-bottom: 1px solid var(--cbg); display: flex; align-items: flex-start; gap: 14px; }
    .modal-icon { width: 42px; height: 42px; border-radius: var(--r2); background: var(--cpl); display: grid; place-items: center; flex-shrink: 0; color: var(--cp); }
    .modal-hd h3 { font-size: 15px; font-weight: 600; }
    .modal-hd p { font-size: 12.5px; color: var(--cmt); margin-top: 2px; }
    .modal-close { margin-left: auto; width: 28px; height: 28px; border-radius: var(--r1); display: grid; place-items: center; cursor: pointer; border: 1px solid var(--cms); background: none; color: var(--cmt); flex-shrink: 0; font-size: 16px; transition: all var(--tr); }
    .modal-close:hover { border-color: #ef4444; color: #ef4444; }
    .modal-body { padding: 20px 24px; }
    .modal-ft { padding: 14px 24px 20px; border-top: 1px solid var(--cbg); display: flex; justify-content: flex-end; gap: 10px; }

    /* PAGINATION */
    .pag { display: flex; align-items: center; gap: 4px; justify-content: center; margin-top: 20px; flex-wrap: wrap; }
    .pag a, .pag span { min-width: 32px; height: 32px; display: grid; place-items: center; border-radius: var(--r1); font-size: 13px; border: 1px solid var(--cms); background: var(--cw); color: var(--ctm); text-decoration: none; transition: all var(--tr); padding: 0 6px; }
    .pag a:hover { border-color: var(--cp); color: var(--cp); }
    .pag .active { background: var(--cp); border-color: var(--cp); color: #fff; }
    .pag .disabled { opacity: .45; pointer-events: none; }

    /* TOAST */
    #tf { position: fixed; bottom: 20px; right: 20px; z-index: 300; display: flex; flex-direction: column; gap: 8px; }
    .toast { background: #1a1a1a; color: #fff; padding: 12px 18px; border-radius: var(--r2); font-size: 13px; max-width: 320px; box-shadow: var(--s3); animation: slideIn .25s ease; border-left: 4px solid #22c55e; }
    .toast.error { border-left-color: #ef4444; }
    @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

    /* UPLOAD LOADING OVERLAY */
    #pg-loading { position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:9999; display:none; align-items:center; justify-content:center; }
    #pg-loading.show { display:flex; }
    .pg-loading-box { background:#fff; border-radius:var(--r3); padding:28px 40px; text-align:center; box-shadow:var(--s3); min-width:200px; }
    .pg-spinner { width:36px; height:36px; border:3px solid var(--cbg); border-top-color:var(--cp); border-radius:50%; animation:pgSpin .7s linear infinite; margin:0 auto; }
    @keyframes pgSpin { to { transform:rotate(360deg); } }
    .pg-loading-box p { margin-top:12px; font-size:13.5px; color:var(--ctm); font-weight:500; }

    /* FILTER BAR */
    .filter-bar { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 16px; align-items: center; }
    .filter-bar .fc { width: auto; min-width: 160px; }
    .search-wrap { position: relative; flex: 1; min-width: 200px; }
    .search-wrap svg { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--cmt); pointer-events: none; }
    .search-wrap input { padding-left: 34px; }

    /* BULK BAR */
    .bulk-bar { display: none; align-items: center; gap: 12px; background: var(--cpl); border: 1px solid rgba(200,106,68,.25); border-radius: var(--r2); padding: 10px 16px; margin-bottom: 14px; flex-wrap: wrap; }
    .bulk-bar.show { display: flex; }
    .bulk-info { font-size: 13px; font-weight: 600; color: var(--cp); }

    /* PAGE HEADER */
    .pg-hd { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 24px; flex-wrap: wrap; }
    .pg-hd h1 { font-size: 20px; font-weight: 700; }
    .pg-hd p { font-size: 13px; color: var(--cmt); margin-top: 2px; }
    .pg-hd-acts { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }

    /* KPI */
    .kpi-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; margin-bottom: 24px; }
    .kpi { background: var(--cw); border: 1px solid var(--cms); border-radius: var(--r3); padding: 20px; display: flex; align-items: flex-start; gap: 14px; box-shadow: var(--s1); }
    .kpi-icon { width: 44px; height: 44px; border-radius: var(--r2); display: grid; place-items: center; flex-shrink: 0; }
    .kpi-val { font-size: 24px; font-weight: 700; line-height: 1; }
    .kpi-label { font-size: 12px; color: var(--cmt); margin-top: 4px; }
    .kpi-trend { font-size: 11px; margin-top: 6px; display: flex; align-items: center; gap: 3px; }

    /* TOGGLE */
    .tog { position: relative; width: 40px; height: 22px; flex-shrink: 0; }
    .tog input { opacity: 0; width: 0; height: 0; }
    .tog-sl { position: absolute; cursor: pointer; inset: 0; background: var(--cms); border-radius: var(--rr); transition: var(--tr); }
    .tog-sl::before { content: ''; position: absolute; width: 16px; height: 16px; left: 3px; top: 3px; background: #fff; border-radius: 50%; transition: var(--tr); }
    .tog input:checked + .tog-sl { background: var(--cp); }
    .tog input:checked + .tog-sl::before { transform: translateX(18px); }

    /* CHECKBOX */
    input[type=checkbox] { width: 15px; height: 15px; accent-color: var(--cp); cursor: pointer; }

    /* STATUS COLORS */
    .s-baru      { background: rgba(59,130,246,.1);  color: #3b82f6; }
    .s-diproses  { background: rgba(245,158,11,.1);  color: #f59e0b; }
    .s-selesai   { background: rgba(34,197,94,.1);   color: #22c55e; }
    .s-dibatalkan{ background: rgba(239,68,68,.1);   color: #ef4444; }
    .s-terbit    { background: rgba(34,197,94,.1);   color: #22c55e; }
    .s-draft     { background: rgba(156,163,175,.15);color: #6b7280; }
    .s-review    { background: rgba(245,158,11,.1);  color: #f59e0b; }
    .s-arsip     { background: rgba(107,114,128,.1); color: #6b7280; }
    .s-tersedia  { background: rgba(34,197,94,.1);   color: #22c55e; }
    .s-habis     { background: rgba(239,68,68,.1);   color: #ef4444; }
    .s-hampir    { background: rgba(245,158,11,.1);  color: #f59e0b; }
    .s-aktif     { background: rgba(34,197,94,.1);   color: #22c55e; }
    .s-nonaktif  { background: rgba(156,163,175,.15);color: #6b7280; }
    .s-suspended { background: rgba(239,68,68,.1);   color: #ef4444; }

    /* RESPONSIVE */
    @media (max-width: 992px) {
      .sb { transform: translateX(-100%); }
      .sb.open { transform: translateX(0); }
      .sb-ov.show { display: block; }
      .mw { margin-left: 0; }
      .tb-hb { display: flex; }
      .kpi-grid { grid-template-columns: repeat(2,1fr); }
    }
    @media (max-width: 640px) {
      .pg { padding: 16px 14px 32px; }
      .kpi-grid { grid-template-columns: 1fr 1fr; }
      .frow-2, .frow-3 { grid-template-columns: 1fr; }
    }
    /* ── Language tabs (dipakai di pengaturan, produk, artikel, testimoni) ── */
    .lang-tabs { display:flex; gap:0; border-bottom:2px solid var(--cbg); margin-bottom:14px; flex-wrap:wrap; }
    .lang-tab  { padding:7px 14px; font-size:12.5px; font-weight:600; cursor:pointer; border:none; background:none; color:var(--cmt); border-bottom:2px solid transparent; margin-bottom:-2px; border-radius:4px 4px 0 0; transition:all .15s; white-space:nowrap; }
    .lang-tab:hover  { color:var(--ctm); background:var(--cbg); }
    .lang-tab.active { color:var(--cp); border-bottom-color:var(--cp); background:var(--cpl); }
    .lang-pane       { display:none; }
    .lang-pane.active{ display:block; }
    .lang-section    { border:1px solid var(--cbg); border-radius:var(--r2); padding:14px 16px; margin-bottom:12px; background:var(--csi); }
  </style>
  @stack('styles')
</head>
<body>
  <!-- SIDEBAR -->
  <div class="sb" id="sb">
    <div class="sb-logo">
      <div class="sb-logo-icon">
        @include('partials.logo', ['logoClass' => 'logo-svg-admin', 'logoSvgStyle' => 'width:22px;height:22px;color:#fff', 'logoStyle' => 'height:22px;width:22px;object-fit:contain;border-radius:4px'])
      </div>
      <div class="sb-logo-text">
        <strong>{{ $siteSettings['name'] ?? 'Akar Sehat' }}</strong>
        <span>Admin Panel</span>
      </div>
    </div>
    <nav class="sb-nav">
      <div class="sb-section">Menu Utama</div>
      <a href="{{ route('admin.dashboard') }}" class="sb-a {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        Dashboard
      </a>
      <a href="{{ route('admin.konsultasi.index') }}" class="sb-a {{ request()->routeIs('admin.konsultasi.*') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
        Konsultasi
      </a>
      <a href="{{ route('admin.produk.index') }}" class="sb-a {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
        Produk
      </a>
      <a href="{{ route('admin.kategori.index') }}" class="sb-a {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}" style="padding-left:36px;font-size:12.5px">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
        Kategori
      </a>
      <a href="{{ route('admin.artikel.index') }}" class="sb-a {{ request()->routeIs('admin.artikel.*') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
        Artikel
      </a>
      <a href="{{ route('admin.kategori-artikel.index') }}" class="sb-a {{ request()->routeIs('admin.kategori-artikel.*') ? 'active' : '' }}" style="padding-left:36px;font-size:12.5px">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        Kategori
      </a>
      <a href="{{ route('admin.testimoni.index') }}" class="sb-a {{ request()->routeIs('admin.testimoni.*') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/><line x1="9" y1="10" x2="15" y2="10"/><line x1="9" y1="14" x2="13" y2="14"/></svg>
        Testimoni
      </a>
      <a href="{{ route('admin.statistik') }}" class="sb-a {{ request()->routeIs('admin.statistik') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
        Statistik
      </a>
      @if(auth()->user()->isAdmin())
      <div class="sb-section">Manajemen</div>
      <a href="{{ route('admin.users.index') }}" class="sb-a {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
        Pengguna
      </a>
      <a href="{{ route('admin.pengaturan.index') }}" class="sb-a {{ request()->routeIs('admin.pengaturan.*') || request()->routeIs('admin.bahasa.*') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
        Pengaturan
      </a>
      @endif
    </nav>
    <div class="sb-user">
      <div class="sb-avatar" style="background: {{ auth()->user()->avatar_color ?? '#C86A44' }}">{{ auth()->user()->initials }}</div>
      <div class="sb-user-info">
        <strong>{{ auth()->user()->name }}</strong>
        <span>{{ auth()->user()->role }}</span>
      </div>
    </div>
  </div>
  <div class="sb-ov" id="sb-ov" onclick="closeSB()"></div>

  <!-- MAIN WRAPPER -->
  <div class="mw">
    <header class="topbar">
      <button class="tb-hb" onclick="toggleSB()">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
      <div class="tb-bc">
        <a href="{{ route('admin.dashboard') }}">Admin</a>
        @hasSection('breadcrumb')
          <span class="sep">/</span>
          @yield('breadcrumb')
        @endif
      </div>
      <div class="tb-acts">
        <a href="{{ route('home') }}" class="tb-view" target="_blank">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
          Lihat Website
        </a>
        <form method="POST" action="{{ route('admin.logout') }}" style="display:inline">
          @csrf
          <button type="submit" class="tb-btn" title="Logout">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          </button>
        </form>
        <div class="tb-av" style="background: {{ auth()->user()->avatar_color ?? '#C86A44' }}">{{ auth()->user()->initials }}</div>
      </div>
    </header>

    <div class="pg">
      @if(session('success'))
        <div class="toast" style="position:relative;margin-bottom:16px;animation:none">{{ session('success') }}</div>
      @endif
      @yield('content')
    </div>
  </div>

  <div id="tf"></div>

  <!-- UPLOAD LOADING OVERLAY -->
  <div id="pg-loading">
    <div class="pg-loading-box">
      <div class="pg-spinner"></div>
      <p id="pg-loading-msg">Memproses...</p>
    </div>
  </div>

  <script>
    function toggleSB() {
      document.getElementById('sb').classList.toggle('open');
      document.getElementById('sb-ov').classList.toggle('show');
    }
    function closeSB() {
      document.getElementById('sb').classList.remove('open');
      document.getElementById('sb-ov').classList.remove('show');
    }
    function openModal(id) {
      document.getElementById(id).classList.add('show');
      document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
      document.getElementById(id).classList.remove('show');
      document.body.style.overflow = '';
    }
    function handleOC(e, id) {
      if (e.target === document.getElementById(id)) closeModal(id);
    }
    function showToast(msg, type = 'success') {
      const el = document.createElement('div');
      el.className = 'toast' + (type === 'error' ? ' error' : '');
      el.textContent = msg;
      document.getElementById('tf').appendChild(el);
      setTimeout(() => el.remove(), 3100);
    }
    function nowStr() {
      return new Date().toISOString().slice(0, 16).replace('T', ' ');
    }
    // ── LOADING OVERLAY ──────────────────────────────────────────────────
    function setLoading(msg = 'Memproses...') {
      document.getElementById('pg-loading-msg').textContent = msg;
      document.getElementById('pg-loading').classList.add('show');
    }
    function clearLoading() {
      document.getElementById('pg-loading').classList.remove('show');
    }

    // ── IMAGE COMPRESSOR (Canvas, max 1200px, 78% quality) ──────────────
    function compressImage(file, maxW = 1200, maxH = 1200, quality = 0.78) {
      return new Promise(resolve => {
        if (!file.type.startsWith('image/') || file.size < 150 * 1024) {
          resolve(file); return;
        }
        const img = new Image();
        const url = URL.createObjectURL(file);
        img.onload = () => {
          URL.revokeObjectURL(url);
          let { width, height } = img;
          if (width > maxW || height > maxH) {
            const ratio = Math.min(maxW / width, maxH / height);
            width = Math.round(width * ratio);
            height = Math.round(height * ratio);
          }
          const canvas = document.createElement('canvas');
          canvas.width = width; canvas.height = height;
          canvas.getContext('2d').drawImage(img, 0, 0, width, height);
          canvas.toBlob(blob => {
            const out = new File([blob], file.name.replace(/\.[^.]+$/, '.jpg'),
              { type: 'image/jpeg', lastModified: Date.now() });
            resolve(out.size < file.size ? out : file);
          }, 'image/jpeg', quality);
        };
        img.onerror = () => { URL.revokeObjectURL(url); resolve(file); };
        img.src = url;
      });
    }

    // Compress & replace file in <input type=file> using DataTransfer
    async function compressInputFile(input) {
      if (!input.files || !input.files[0]) return;
      const compressed = await compressImage(input.files[0]);
      if (compressed !== input.files[0]) {
        const dt = new DataTransfer();
        dt.items.add(compressed);
        input.files = dt.files;
      }
    }

    // Show loading overlay when regular multipart forms are submitted
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('form[enctype="multipart/form-data"]').forEach(form => {
        form.addEventListener('submit', () => setLoading('Menyimpan...'));
      });
    });

    // CSRF helper untuk fetch
    const CSRF = document.querySelector('meta[name=csrf-token]').content;
    function apiFetch(url, method, body) {
      const isFormData = body instanceof FormData;
      const headers = { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' };
      if (!isFormData) headers['Content-Type'] = 'application/json';
      return fetch(url, {
        method,
        headers,
        body: isFormData ? body : (body ? JSON.stringify(body) : undefined),
      }).then(r => r.json()).catch(() => ({ success: false, message: 'Koneksi gagal atau sesi habis.' }));
    }
  </script>
  @stack('scripts')
</body>
</html>
