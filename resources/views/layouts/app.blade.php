<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'CampusReuse')</title>
    <style>
        :root {
            color-scheme: light;
            --page: #e7e2df;
            --surface: #f7f2f1;
            --field: #f9fbfc;
            --text: #343332;
            --muted: #716d6b;
            --border: #d3cecb;
            --button: #343332;
            --button-text: #fff;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        [data-theme="dark"] {
            color-scheme: dark;
            --page: #20201f;
            --surface: #2b2a29;
            --field: #353433;
            --text: #f3efec;
            --muted: #b8b1ad;
            --border: #4a4745;
            --button: #f0ece9;
            --button-text: #292827;
        }
        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; display: flex; flex-direction: column; background: var(--page); color: var(--text); }
        a { color: inherit; text-decoration: none; }
        button, input, select, textarea { font: inherit; }
        button, a { -webkit-tap-highlight-color: transparent; }
        .topbar { width: 100%; }
        .nav { width: min(100% - 48px, 1280px); min-height: 82px; margin: auto; display: grid; grid-template-columns: 1fr auto 1fr; align-items: center; gap: 24px; }
        .brand { justify-self: start; font-size: 15px; font-weight: 850; letter-spacing: -.5px; }
        .nav-main { display: flex; align-items: center; justify-content: center; gap: clamp(20px, 4vw, 48px); }
        .nav-main a { font-size: 10px; font-weight: 700; letter-spacing: .34em; text-transform: uppercase; white-space: nowrap; }
        .nav-tools { justify-self: end; display: flex; align-items: center; gap: 15px; }
        .nav-tools form { margin: 0; }
        .icon-link { width: 26px; height: 30px; padding: 3px; display: inline-grid; place-items: center; border: 0; background: transparent; color: var(--text); cursor: pointer; }
        .icon-link svg { width: 19px; height: 19px; fill: none; stroke: currentColor; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
        .container { flex: 1; width: min(100% - 48px, 1200px); margin: 0 auto; padding: 38px 0 64px; }
        .button { min-height: 42px; display: inline-flex; align-items: center; justify-content: center; padding: 10px 18px; border: 1px solid var(--button); border-radius: 6px; background: var(--button); color: var(--button-text); font-size: 13px; font-weight: 700; cursor: pointer; }
        .button:hover { opacity: .88; }
        .button.secondary { background: transparent; color: var(--text); border-color: var(--border); }
        .muted { color: var(--muted); }
        .field { display: grid; gap: 7px; margin-bottom: 16px; }
        .field label { font-size: 13px; font-weight: 650; }
        input, select, textarea { width: 100%; min-height: 40px; padding: 10px 12px; border: 1px solid var(--border); border-radius: 9px; background: var(--field); color: var(--text); }
        input[type="checkbox"] { width: auto; min-height: auto; }
        input[type="file"] { padding: 8px; }
        textarea { resize: vertical; }
        .error { color: #b42318; font-size: 13px; }
        .auth-page { min-height: 570px; display: grid; place-items: center; padding: 16px 0; }
        .auth-card { width: min(100%, 400px); padding: 27px 30px; border-radius: 7px; background: var(--surface); }
        .auth-card h1 { margin: 0 0 7px; font-size: 23px; letter-spacing: -.5px; }
        .auth-card > p { margin: 0 0 22px; font-size: 12px; }
        .auth-card form .button { width: 100%; }
        .auth-foot { margin: 18px 0 0 !important; text-align: center; }
        .auth-foot a { color: var(--text); font-weight: 700; text-decoration: underline; }
        .catalog-panel { min-height: 468px; padding: 28px 30px 35px; border-radius: 7px; background: var(--surface); }
        .catalog-head { margin: 0 0 17px; }
        .catalog-head h1 { margin: 0 0 8px; font-size: clamp(24px, 3vw, 32px); letter-spacing: -.8px; }
        .catalog-head p { margin: 0; font-size: 12px; }
        .filters { display: grid; gap: 0; margin-bottom: 18px; }
        .filters .field { width: min(100%, 328px); margin: 0 0 15px; }
        .filters .button { width: 100%; }
        .filters select { font-size: 12px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 18px; margin-top: 20px; }
        .card { overflow: hidden; border: 1px solid var(--border); border-radius: 8px; background: var(--field); }
        .product-image { width: 100%; height: 190px; display: grid; place-items: center; overflow: hidden; background: var(--page); color: var(--muted); }
        .product-gallery { display: flex; width: 100%; height: 100%; overflow-x: auto; scroll-snap-type: x mandatory; }
        .product-gallery img { flex: 0 0 100%; width: 100%; height: 100%; object-fit: cover; scroll-snap-align: start; }
        .card-body { padding: 15px; }
        .card-title { margin: 0 0 7px; font-size: 17px; }
        .price { color: var(--text); font-weight: 800; font-size: 16px; }
        .badges { display: flex; flex-wrap: wrap; gap: 6px; margin: 11px 0; }
        .badge { padding: 5px 8px; border: 1px solid var(--border); border-radius: 99px; color: var(--muted); font-size: 10px; font-weight: 650; }
        .badge.status { color: var(--text); }
        .owner { padding-top: 11px; margin-top: 11px; border-top: 1px solid var(--border); font-size: 12px; }
        .description { min-height: 38px; margin: 8px 0; color: var(--muted); font-size: 13px; }
        .empty { grid-column: 1 / -1; min-height: 175px; padding: 34px 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; }
        .empty h2 { margin: 0 0 8px; font-size: 21px; }
        .empty p { margin: 0 0 18px; font-size: 13px; }
        .pagination { margin-top: 24px; }
        .page-heading { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 20px; }
        .page-heading h1 { margin: 0 0 6px; font-size: clamp(26px, 4vw, 34px); }
        .page-heading p { margin: 0; font-size: 13px; }
        .form-card { width: min(100%, 650px); margin: 0 auto; padding: 24px; border-radius: 7px; background: var(--surface); }
        .form-card h1 { margin: 0 0 6px; font-size: 25px; }
        .form-card > p { margin: 0 0 20px; font-size: 12px; }
        .form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 0 14px; }
        .form-grid .wide { grid-column: 1 / -1; }
        .form-grid.offer-grid { grid-template-columns: 1fr; }
        .form-grid.offer-grid .wide { grid-column: auto; }
        .form-actions, .listing-actions { display: flex; flex-wrap: wrap; align-items: center; gap: 10px; }
        .listing-actions form { margin: 0; }
        .listing-actions select { width: auto; }
        .my-listing { display: grid; grid-template-columns: 180px minmax(0, 1fr); gap: 18px; padding: 16px; border-radius: 7px; background: var(--surface); }
        .my-listing .product-image { border-radius: 5px; }
        .my-listing-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; }
        .image-choices { display: flex; flex-wrap: wrap; gap: 12px; }
        .image-choice { display: grid; gap: 6px; width: 130px; font-size: 12px; }
        .image-choice img { width: 130px; height: 100px; border-radius: 6px; object-fit: cover; }
        .notice { margin-bottom: 18px; padding: 12px 14px; border-radius: 6px; background: var(--surface); font-size: 13px; }
        .search-page { width: min(100%, 900px); margin: 20px auto 0; }
        .search-page h1 { margin: 0 0 8px; font-size: clamp(28px, 4vw, 36px); }
        .search-page > p { margin: 0 0 25px; font-size: 13px; }
        .search-form { display: grid; grid-template-columns: 1fr auto; gap: 10px; }
        .search-input-wrap { position: relative; }
        .search-input-wrap svg { position: absolute; left: 16px; top: 13px; width: 18px; height: 18px; fill: none; stroke: var(--muted); stroke-width: 1.8; }
        .search-input-wrap input { min-height: 48px; padding-left: 44px; }
        .suggestions { margin-top: 11px; padding: 15px; border-radius: 7px; background: var(--surface); }
        .suggestions-title { margin: 0 0 8px; color: var(--muted); font-size: 11px; font-weight: 700; }
        .suggestion-link { display: flex; gap: 11px; align-items: center; padding: 9px 0; font-size: 13px; }
        .suggestion-link svg { width: 16px; height: 16px; fill: none; stroke: var(--muted); stroke-width: 1.8; }
        .popular { margin-top: 26px; }
        .popular h2 { margin: 0 0 12px; font-size: 14px; }
        .chip-list { display: flex; flex-wrap: wrap; gap: 8px; }
        .chip { display: inline-flex; padding: 9px 14px; border: 1px solid var(--border); border-radius: 6px; font-size: 12px; }
        .site-footer { width: min(100% - 48px, 1280px); margin: 0 auto; padding: 20px 0 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; font-size: 10px; }
        .footer-brand { font-size: 14px; font-weight: 850; }
        [hidden] { display: none !important; }
        @media (max-width: 760px) {
            .nav { width: min(100% - 32px, 1280px); min-height: 74px; grid-template-columns: 1fr auto; gap: 8px; }
            .nav-main { grid-column: 1 / -1; grid-row: 2; justify-content: flex-start; padding: 0 0 15px; gap: 20px; overflow-x: auto; }
            .nav-main a { font-size: 9px; }
            .nav-tools { grid-column: 2; grid-row: 1; }
            .container { width: min(100% - 32px, 1200px); padding-top: 25px; }
            .catalog-panel { padding: 22px 18px; }
        }
        @media (max-width: 560px) {
            .form-grid { grid-template-columns: 1fr; }
            .form-grid .wide { grid-column: auto; }
            .my-listing { grid-template-columns: 1fr; }
            .my-listing .product-image { height: 200px; }
            .page-heading, .my-listing-head { align-items: flex-start; flex-direction: column; }
            .search-form { grid-template-columns: 1fr; }
            .search-form .button { width: 100%; }
            .auth-page { min-height: 500px; }
            .site-footer { width: min(100% - 32px, 1280px); }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <nav class="nav" aria-label="Navigasi utama">
            <a class="brand" href="{{ route('products.index') }}">CampusReuse</a>
            <div class="nav-main">
                <a href="{{ route('products.index') }}">Katalog</a>
                <a href="{{ route('products.mine') }}">Barang Saya</a>
                <a href="{{ route('products.create') }}">Tawarkan Barang</a>
            </div>
            <div class="nav-tools">
                <a class="icon-link" href="{{ route('products.search') }}" aria-label="Cari barang" title="Cari barang">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8"></circle><path d="m16 16 4.5 4.5"></path></svg>
                </a>
                <button class="icon-link" type="button" id="theme-toggle" aria-label="Ubah tema" title="Ubah tema">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42"></path></svg>
                </button>
                <a class="icon-link" href="@auth{{ route('products.mine') }}@else{{ route('login') }}@endauth" aria-label="Akun" title="Akun">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"></circle><circle cx="12" cy="9" r="3"></circle><path d="M6.8 18.5c1.1-2.2 3-3.3 5.2-3.3s4.1 1.1 5.2 3.3"></path></svg>
                </a>
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="icon-link" type="submit" aria-label="Keluar" title="Keluar">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10 17l5-5-5-5m5 5H3"></path><path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"></path></svg>
                        </button>
                    </form>
                @endauth
            </div>
        </nav>
    </header>
    <main class="container">
        @yield('content')
    </main>
    <footer class="site-footer">
        <a class="footer-brand" href="{{ route('products.index') }}">CampusReuse</a>
        <span>CampusReuse. Belanja hemat, pilihan berkelanjutan.</span>
    </footer>
    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const savedTheme = localStorage.getItem('campusreuse-theme');
        if (savedTheme === 'dark') document.documentElement.dataset.theme = 'dark';
        themeToggle.addEventListener('click', () => {
            const isDark = document.documentElement.dataset.theme !== 'dark';
            document.documentElement.dataset.theme = isDark ? 'dark' : 'light';
            localStorage.setItem('campusreuse-theme', isDark ? 'dark' : 'light');
        });
    </script>
    @stack('scripts')
</body>
</html>
