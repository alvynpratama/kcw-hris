<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('page-title', 'PT Karunia Cipta Wasantara')</title>

    <style>
.sidebar {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        z-index: 50 !important;

        width: 270px !important;
        height: 100vh !important;
        min-height: 100vh !important;
        padding: 24px 17px !important;

        display: flex !important;
        flex-direction: column !important;

        overflow: hidden !important;
        box-sizing: border-box !important;

        color: #ffffff !important;
        background:
            radial-gradient(circle at 92% 4%, rgba(226, 182, 67, 0.18), transparent 27%),
            radial-gradient(circle at 8% 96%, rgba(194, 140, 34, 0.12), transparent 28%),
            linear-gradient(180deg, #261608 0%, #3d2513 100%) !important;

        box-shadow: 12px 0 35px rgba(61, 37, 19, 0.10) !important;
    }

    .sidebar::before,
    .sidebar::after {
        content: "";
        position: absolute !important;
        z-index: 0 !important;
        border-radius: 50% !important;
        pointer-events: none !important;
    }

    .sidebar::before {
        top: 245px !important;
        right: -95px !important;

        width: 230px !important;
        height: 230px !important;

        border: 1px solid rgba(231, 190, 83, 0.11) !important;
        box-shadow:
            0 0 0 28px rgba(231, 190, 83, 0.025),
            0 0 0 56px rgba(231, 190, 83, 0.018) !important;

        animation: sidebar-orbit 10s ease-in-out infinite !important;
    }

    .sidebar::after {
        right: -75px !important;
        bottom: 75px !important;

        width: 190px !important;
        height: 190px !important;

        background: radial-gradient(
            circle,
            rgba(214, 166, 56, 0.10) 0%,
            rgba(214, 166, 56, 0.02) 52%,
            transparent 72%
        ) !important;

        animation: sidebar-glow 7s ease-in-out infinite !important;
    }

    .sidebar > * {
        position: relative !important;
        z-index: 1 !important;
    }

    .sidebar .brand {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;

        padding: 4px 6px 20px !important;
        text-align: center !important;
    }

    .sidebar .brand-logo {
        width: 58px !important;
        height: 58px !important;
        flex-shrink: 0 !important;

        margin-bottom: 12px !important;
        padding: 5px !important;

        border: 1px solid rgba(255, 255, 255, 0.58) !important;
        border-radius: 18px !important;

        object-fit: contain !important;
        background: #fffaf0 !important;

        box-shadow:
            0 12px 24px rgba(0, 0, 0, 0.18),
            0 0 0 5px rgba(225, 182, 72, 0.07) !important;

        transition: transform 0.3s ease !important;
    }

    .sidebar .brand:hover .brand-logo {
        transform: translateY(-3px) rotate(-2deg) !important;
    }

    .sidebar .brand h1 {
        margin: 0 !important;

        color: #ffffff !important;

        font-size: 13px !important;
        font-weight: 800 !important;
        line-height: 1.35 !important;
        letter-spacing: -0.15px !important;
        white-space: nowrap !important;
    }

    .sidebar .brand span {
        display: block !important;

        margin-top: 5px !important;

        color: rgba(255, 255, 255, 0.60) !important;

        font-size: 10px !important;
        font-weight: 500 !important;
    }

    .sidebar .brand-ornament {
        width: 104px !important;
        height: 14px !important;

        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;

        margin-top: 17px !important;
    }

    .sidebar .brand-ornament::before,
    .sidebar .brand-ornament::after {
        content: "";

        width: 36px !important;
        height: 1px !important;

        background: linear-gradient(
            90deg,
            transparent,
            rgba(237, 198, 96, 0.70)
        ) !important;
    }

    .sidebar .brand-ornament::after {
        transform: scaleX(-1) !important;
    }

    .sidebar .brand-ornament span {
        display: block !important;
        margin: 0 !important;

        color: #eac968 !important;

        font-size: 11px !important;
        line-height: 1 !important;

        animation: ornament-pulse 3s ease-in-out infinite !important;
    }

    .sidebar .menu-label {
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;

        margin: 25px 11px 11px !important;

        color: rgba(255, 255, 255, 0.45) !important;

        font-size: 10px !important;
        font-weight: 800 !important;
        letter-spacing: 1.2px !important;
        text-transform: uppercase !important;
    }

    .sidebar .menu-label::after {
        content: "";

        width: 35px !important;
        height: 1px !important;

        background: linear-gradient(
            90deg,
            rgba(232, 195, 101, 0.45),
            transparent
        ) !important;
    }

    .sidebar .menu-link {
        position: relative !important;

        display: flex !important;
        align-items: center !important;
        gap: 12px !important;

        width: 100% !important;
        margin: 5px 0 !important;
        padding: 13px 14px !important;

        border: 1px solid transparent !important;
        border-radius: 13px !important;

        color: rgba(255, 255, 255, 0.72) !important;

        font-size: 14px !important;
        font-weight: 650 !important;
        text-decoration: none !important;

        transition:
            transform 0.25s ease,
            background 0.25s ease,
            border-color 0.25s ease,
            color 0.25s ease !important;
    }

    .sidebar .menu-link::before {
        content: "";

        position: absolute !important;
        top: 50% !important;
        left: 0 !important;

        width: 3px !important;
        height: 0 !important;

        border-radius: 0 8px 8px 0 !important;

        background: #f0cb62 !important;

        transform: translateY(-50%) !important;
        transition: height 0.25s ease !important;
    }

    .sidebar .menu-link:hover {
        color: #ffffff !important;
        background: rgba(208, 161, 51, 0.12) !important;
        transform: translateX(4px) !important;
    }

    .sidebar .menu-link:hover::before {
        height: 22px !important;
    }

    .sidebar .menu-link.active {
        color: #ffffff !important;
        border-color: rgba(229, 185, 77, 0.14) !important;

        background:
            linear-gradient(
                90deg,
                rgba(186, 126, 25, 0.48),
                rgba(147, 92, 14, 0.34)
            ) !important;

        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, 0.06),
            0 8px 18px rgba(12, 6, 2, 0.13) !important;

        transform: translateX(3px) !important;
    }

    .sidebar .menu-link.active::before {
        height: 28px !important;
    }

    .sidebar .menu-icon {
        width: 20px !important;
        flex-shrink: 0 !important;

        color: #ebc663 !important;

        font-size: 16px !important;
        text-align: center !important;

        transition: transform 0.25s ease !important;
    }

    .sidebar .menu-link:hover .menu-icon,
    .sidebar .menu-link.active .menu-icon {
        transform: scale(1.16) !important;
    }

    .sidebar .sidebar-art {
        position: relative !important;

        width: 126px !important;
        height: 126px !important;

        display: grid !important;
        place-items: center !important;

        margin: 38px auto 0 !important;

        opacity: 0.82 !important;
    }

    .sidebar .sidebar-art::before,
    .sidebar .sidebar-art::after {
        content: "";

        position: absolute !important;

        border: 1px solid rgba(232, 195, 101, 0.20) !important;
        border-radius: 50% !important;

        animation: art-ring 7s ease-in-out infinite !important;
    }

    .sidebar .sidebar-art::before {
        width: 104px !important;
        height: 104px !important;
    }

    .sidebar .sidebar-art::after {
        width: 72px !important;
        height: 72px !important;

        border-color: rgba(232, 195, 101, 0.32) !important;

        animation-delay: -3.5s !important;
    }

    .sidebar .sidebar-art__mark {
        position: relative !important;
        z-index: 1 !important;

        width: 46px !important;
        height: 46px !important;

        display: grid !important;
        place-items: center !important;

        border: 1px solid rgba(234, 201, 104, 0.34) !important;
        border-radius: 15px !important;

        color: #efcf72 !important;
        background: rgba(214, 166, 56, 0.08) !important;

        font-size: 19px !important;
        font-weight: 800 !important;

        box-shadow: 0 0 22px rgba(225, 181, 63, 0.10) !important;

        animation: art-mark 5s ease-in-out infinite !important;
    }

    .sidebar .sidebar-art__caption {
        position: absolute !important;
        bottom: -7px !important;

        color: rgba(255, 255, 255, 0.34) !important;

        font-size: 8px !important;
        font-weight: 800 !important;
        letter-spacing: 2px !important;
    }

    .sidebar .sidebar-footer {
        width: 100% !important;

        margin-top: auto !important;
        padding: 21px 6px 0 !important;

        color: rgba(255, 255, 255, 0.55) !important;

        font-size: 10px !important;
        font-weight: 600 !important;
        line-height: 1.5 !important;
        text-align: center !important;
    }

    .sidebar .sidebar-footer::before {
        content: "";

        width: 86px !important;
        height: 1px !important;

        display: block !important;

        margin: 0 auto 13px !important;

        background: linear-gradient(
            90deg,
            transparent,
            rgba(234, 201, 104, 0.60),
            transparent
        ) !important;
    }

    @keyframes sidebar-orbit {
        0%,
        100% {
            transform: translate(0, 0) rotate(0deg);
        }

        50% {
            transform: translate(-12px, 15px) rotate(9deg);
        }
    }

    @keyframes sidebar-glow {
        0%,
        100% {
            transform: scale(0.95);
            opacity: 0.55;
        }

        50% {
            transform: scale(1.12);
            opacity: 0.95;
        }
    }

    @keyframes ornament-pulse {
        0%,
        100% {
            opacity: 0.58;
            transform: scale(0.92);
        }

        50% {
            opacity: 1;
            transform: scale(1.08);
        }
    }

    @keyframes art-ring {
        0%,
        100% {
            transform: scale(0.92);
            opacity: 0.35;
        }

        50% {
            transform: scale(1.08);
            opacity: 0.92;
        }
    }

    @keyframes art-mark {
        0%,
        100% {
            transform: translateY(0) rotate(0deg);
        }

        50% {
            transform: translateY(-5px) rotate(4deg);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | NAVIGASI MOBILE
    |--------------------------------------------------------------------------
    | Pada layar tablet dan ponsel, sidebar tetap tersedia sebagai drawer.
    | Tombol menu serta overlay dikelola dari layout agar konsisten di seluruh
    | halaman yang memakai layout ini.
    */
    .mobile-menu-toggle,
    .mobile-menu-overlay {
        display: none;
    }

    @media (max-width: 1050px) {
        .app-layout {
            grid-template-columns: 1fr !important;
        }

        .main {
            grid-column: 1 !important;
            min-width: 0 !important;
        }

        /*
        | Parent drawer harus berada di atas overlay. Sebelumnya parent memakai
        | z-index 200, sedangkan overlay 205. Karena parent membentuk stacking
        | context, seluruh isi sidebar ikut tertutup overlay sehingga tidak bisa
        | disentuh. Nilai berikut menempatkan drawer secara utuh di atas overlay.
        */
        .mobile-sidebar-shell {
            position: relative;
            z-index: 215;
        }

        .sidebar {
            display: flex !important;
            z-index: 216 !important;

            width: min(270px, calc(100vw - 52px)) !important;
            max-width: 270px !important;

            visibility: hidden !important;
            pointer-events: none !important;
            transform: translateX(calc(-100% - 18px)) !important;

            box-shadow: 18px 0 42px rgba(26, 14, 5, 0.26) !important;
            transition:
                transform 0.32s cubic-bezier(.22, 1, .36, 1),
                visibility 0s linear 0.32s !important;
            will-change: transform;
        }

        body.kcw-mobile-menu-open {
            overflow: hidden !important;
        }

        body.kcw-mobile-menu-open .sidebar {
            visibility: visible !important;
            pointer-events: auto !important;
            transform: translateX(0) !important;
            transition:
                transform 0.32s cubic-bezier(.22, 1, .36, 1),
                visibility 0s linear 0s !important;
        }

        .mobile-menu-overlay {
            position: fixed;
            inset: 0;
            z-index: 205;

            display: block;
            border: 0;

            opacity: 0;
            pointer-events: none;
            background: rgba(31, 16, 6, 0.46);

            transition: opacity 0.25s ease;
        }

        body.kcw-mobile-menu-open .mobile-menu-overlay {
            opacity: 1;
            pointer-events: auto;
        }

        .mobile-menu-toggle {
            position: fixed;
            top: 13px;
            left: 14px;
            z-index: 220;

            width: 42px;
            height: 42px;

            display: inline-flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 5px;

            padding: 0;
            border: 1px solid rgba(190, 143, 43, 0.38);
            border-radius: 12px;

            color: #5a380f;
            background: rgba(255, 253, 247, 0.94);
            box-shadow: 0 8px 20px rgba(67, 39, 12, 0.12);

            cursor: pointer;
            -webkit-tap-highlight-color: transparent;
            transition:
                color 0.2s ease,
                background 0.2s ease,
                border-color 0.2s ease,
                box-shadow 0.2s ease,
                opacity 0.2s ease,
                transform 0.2s ease;
        }

        .mobile-menu-toggle:hover,
        .mobile-menu-toggle:focus-visible {
            outline: none;
            border-color: #b77b18;
            color: #ffffff;
            background: #6b4318;
            box-shadow: 0 10px 22px rgba(67, 39, 12, 0.20);
        }

        .mobile-menu-toggle__bar {
            width: 18px;
            height: 2px;
            display: block;
            border-radius: 999px;
            background: currentColor;
            transition: transform 0.25s ease, opacity 0.2s ease;
        }

        /*
        | Saat drawer terbuka, tombol hamburger disembunyikan agar tidak
        | menutupi sidebar. Tombol × tersedia di dalam area sidebar.
        */
        body.kcw-mobile-menu-open .mobile-menu-toggle {
            opacity: 0;
            pointer-events: none;
            transform: translateY(-6px) scale(0.92);
        }

        /*
        | Memberi ruang untuk tombol menu pada topbar mobile tanpa mengubah
        | struktur komponen topbar yang sudah ada.
        */
        .topbar-kcw {
            padding-left: 70px !important;
        }

        .sidebar .menu-link {
            min-height: 48px !important;
        }
    }

    @media (max-width: 520px) {
        .mobile-menu-toggle {
            top: 11px;
            left: 12px;
            width: 40px;
            height: 40px;
            border-radius: 11px;
        }

        .topbar-kcw {
            padding-left: 64px !important;
        }

        .sidebar {
            width: min(278px, calc(100vw - 42px)) !important;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .sidebar,
        .mobile-menu-overlay,
        .mobile-menu-toggle,
        .mobile-menu-toggle__bar,
        .sidebar::before,
        .sidebar::after,
        .sidebar .brand-ornament span,
        .sidebar .sidebar-art::before,
        .sidebar .sidebar-art::after,
        .sidebar .sidebar-art__mark {
            animation: none !important;
            transition-duration: 0.01ms !important;
        }
    }
    </style>

    @stack('styles')
    @livewireStyles
</head>
<body>
    @php
        $topbarTitle = trim($__env->yieldContent('topbar-title', 'Dashboard'));
        $topbarSubtitle = trim($__env->yieldContent('topbar-subtitle', ''));
    @endphp

    <div class="app-layout">
        <button
            type="button"
            class="mobile-menu-toggle"
            data-mobile-menu-toggle
            aria-label="Buka navigasi"
            aria-controls="kcw-mobile-navigation"
            aria-expanded="false"
        >
            <span class="mobile-menu-toggle__bar"></span>
            <span class="mobile-menu-toggle__bar"></span>
            <span class="mobile-menu-toggle__bar"></span>
        </button>

        <button
            type="button"
            class="mobile-menu-overlay"
            data-mobile-menu-close
            aria-label="Tutup navigasi"
            tabindex="-1"
        ></button>

        @persist('kcw-sidebar')
            <div id="kcw-mobile-navigation" class="mobile-sidebar-shell">
                <x-sidebar />
            </div>
        @endpersist

        <main class="main">
            <x-topbar :title="$topbarTitle" :subtitle="$topbarSubtitle" />

            @yield('content')
        </main>
    </div>

    @livewireScripts
    @stack('scripts')

    <script data-navigate-once>
        (function () {
            if (window.__kcwMobileNavigationBound) {
                return;
            }

            window.__kcwMobileNavigationBound = true;

            var mobileBreakpoint = window.matchMedia('(max-width: 1050px)');

            function getToggleButton() {
                return document.querySelector('[data-mobile-menu-toggle]');
            }

            function setMenuState(isOpen) {
                var toggleButton = getToggleButton();

                document.body.classList.toggle('kcw-mobile-menu-open', isOpen);

                if (toggleButton) {
                    toggleButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                    toggleButton.setAttribute(
                        'aria-label',
                        isOpen ? 'Tutup navigasi' : 'Buka navigasi'
                    );
                }
            }

            function closeMenu() {
                setMenuState(false);
            }

            function toggleMenu() {
                if (!mobileBreakpoint.matches) {
                    return;
                }

                setMenuState(!document.body.classList.contains('kcw-mobile-menu-open'));
            }

            document.addEventListener('click', function (event) {
                if (event.target.closest('[data-mobile-menu-toggle]')) {
                    toggleMenu();
                    return;
                }

                if (event.target.closest('[data-mobile-menu-close]')) {
                    closeMenu();
                    return;
                }

                if (
                    mobileBreakpoint.matches &&
                    event.target.closest('.sidebar .menu-link')
                ) {
                    closeMenu();
                }
            });

            document.addEventListener('keydown', function (event) {
                if (
                    event.key === 'Escape' &&
                    document.body.classList.contains('kcw-mobile-menu-open')
                ) {
                    closeMenu();
                }
            });

            window.addEventListener('resize', function () {
                if (!mobileBreakpoint.matches) {
                    closeMenu();
                }
            });

            document.addEventListener('livewire:navigating', closeMenu);
            document.addEventListener('livewire:navigated', function () {
                if (!mobileBreakpoint.matches) {
                    closeMenu();
                }
            });

            closeMenu();
        })();
    </script>
</body>
</html>
