<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — Akar Sehat Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --cp: #C86A44; --cpd: #A8522E; --cpl: rgba(200,106,68,.10);
      --cdb: #382A21; --csi: #FAF6F1; --cms: #D9C9B8; --cw: #fff;
      --ctm: #3D2B1F; --cmt: #7A6355; --fp: 'Poppins', sans-serif;
    }
    body { font-family: var(--fp); background: var(--cdb); min-height: 100vh; display: flex; }

    .login-left {
      flex: 1; background: var(--cdb); display: flex; flex-direction: column;
      align-items: center; justify-content: center; padding: 60px 40px;
      position: relative; overflow: hidden;
    }
    .login-left::before {
      content: ''; position: absolute; width: 400px; height: 400px;
      background: radial-gradient(circle, rgba(200,106,68,.15) 0%, transparent 70%);
      top: 50%; left: 50%; transform: translate(-50%,-50%);
    }
    .ll-content { position: relative; text-align: center; max-width: 320px; }
    .ll-logo { font-size: 56px; margin-bottom: 20px; }
    .ll-brand { font-size: 28px; font-weight: 700; color: #fff; margin-bottom: 8px; }
    .ll-tagline { font-size: 14px; color: rgba(255,255,255,.5); margin-bottom: 48px; }
    .ll-feat { display: flex; flex-direction: column; gap: 14px; text-align: left; }
    .ll-feat-item { display: flex; align-items: center; gap: 12px; color: rgba(255,255,255,.65); font-size: 13.5px; }
    .ll-feat-icon { width: 36px; height: 36px; background: rgba(255,255,255,.07); border-radius: 8px; display: grid; place-items: center; flex-shrink: 0; }

    .login-right {
      width: 460px; background: var(--csi); display: flex; align-items: center;
      justify-content: center; padding: 40px; flex-shrink: 0;
    }
    .login-form { width: 100%; max-width: 360px; }
    .lf-title { font-size: 22px; font-weight: 700; color: var(--ctm); margin-bottom: 4px; }
    .lf-sub { font-size: 13px; color: var(--cmt); margin-bottom: 32px; }
    .fg { margin-bottom: 18px; }
    .fl { display: block; font-size: 12.5px; font-weight: 600; color: var(--ctm); margin-bottom: 6px; }
    .fc { width: 100%; padding: 10px 14px; border: 1px solid var(--cms); border-radius: 8px; font-family: var(--fp); font-size: 14px; color: var(--ctm); background: var(--cw); outline: none; transition: border-color .2s; }
    .fc:focus { border-color: var(--cp); box-shadow: 0 0 0 3px rgba(200,106,68,.1); }
    .fc.is-error { border-color: #ef4444; }
    .err-msg { color: #ef4444; font-size: 12px; margin-top: 5px; }
    .btn-login { width: 100%; padding: 11px; background: var(--cp); color: #fff; border: none; border-radius: 8px; font-family: var(--fp); font-size: 14px; font-weight: 600; cursor: pointer; transition: background .2s; margin-top: 8px; }
    .btn-login:hover { background: var(--cpd); }
    .remember-row { display: flex; align-items: center; gap: 8px; margin-bottom: 6px; font-size: 13px; color: var(--cmt); }
    .remember-row input { accent-color: var(--cp); }
    .lf-demo { margin-top: 24px; background: rgba(200,106,68,.08); border: 1px solid rgba(200,106,68,.2); border-radius: 8px; padding: 14px 16px; font-size: 12.5px; color: var(--cmt); }
    .lf-demo strong { color: var(--cp); }
    .lf-back { display: inline-flex; align-items: center; gap: 6px; color: var(--cmt); font-size: 12.5px; text-decoration: none; margin-top: 20px; }
    .lf-back:hover { color: var(--cp); }

    @media (max-width: 768px) {
      .login-left { display: none; }
      .login-right { width: 100%; }
    }
  </style>
</head>
<body>
  <div class="login-left">
    <div class="ll-content">
      <div class="ll-logo">🌿</div>
      <div class="ll-brand">Akar Sehat</div>
      <div class="ll-tagline">Panel Admin — Kelola konten website Anda</div>
      <div class="ll-feat">
        <div class="ll-feat-item">
          <div class="ll-feat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C86A44" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
          </div>
          Kelola konsultasi pelanggan
        </div>
        <div class="ll-feat-item">
          <div class="ll-feat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C86A44" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>
          </div>
          Manajemen produk herbal
        </div>
        <div class="ll-feat-item">
          <div class="ll-feat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C86A44" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
          </div>
          Laporan & statistik lengkap
        </div>
      </div>
    </div>
  </div>

  <div class="login-right">
    <div class="login-form">
      <div class="lf-title">Selamat Datang</div>
      <div class="lf-sub">Masuk ke panel admin Akar Sehat</div>

      @if($errors->any())
        <div style="background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);border-radius:8px;padding:12px 14px;font-size:13px;color:#ef4444;margin-bottom:16px;">
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf
        <div class="fg">
          <label class="fl" for="login">Username atau Email</label>
          <input type="text" id="login" name="login" class="fc {{ $errors->has('login') ? 'is-error' : '' }}" placeholder="admin / admin@akarsehat.id" value="{{ old('login') }}" required autofocus>
        </div>
        <div class="fg">
          <label class="fl" for="password">Password</label>
          <input type="password" id="password" name="password" class="fc" placeholder="Masukkan password" required>
        </div>
        <div class="remember-row">
          <input type="checkbox" id="remember" name="remember">
          <label for="remember">Ingat saya selama 30 hari</label>
        </div>
        <button type="submit" class="btn-login">Masuk ke Admin Panel</button>
      </form>

      <div class="lf-demo">
        <strong>Demo Login:</strong><br>
        Username: <strong>kangbahri</strong> &nbsp;|&nbsp; Password: <strong>akarsehat123</strong>
      </div>

      <a href="{{ route('home') }}" class="lf-back">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali ke website
      </a>
    </div>
  </div>
</body>
</html>
