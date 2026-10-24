@props([
    'active' => '',
])

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
            radial-gradient(circle at 92% 3%, rgba(239, 196, 82, 0.22), transparent 25%),
            radial-gradient(circle at 7% 96%, rgba(177, 112, 20, 0.15), transparent 30%),
            linear-gradient(180deg, #211207 0%, #3e2512 54%, #2c190c 100%) !important;

        box-shadow: 12px 0 35px rgba(61, 37, 19, 0.12) !important;
    }

    /*
    |--------------------------------------------------------------------------
    | BACKGROUND GOLDEN MOTION
    |--------------------------------------------------------------------------
    */

    .sidebar::before,
    .sidebar::after {
        content: "";

        position: absolute !important;
        z-index: 0 !important;

        border-radius: 50% !important;

        pointer-events: none !important;
    }

    .sidebar::before {
        top: 250px !important;
        right: -108px !important;

        width: 240px !important;
        height: 240px !important;

        border: 1px solid rgba(242, 202, 103, 0.14) !important;

        box-shadow:
            0 0 0 25px rgba(242, 202, 103, 0.022),
            0 0 0 52px rgba(242, 202, 103, 0.012),
            0 0 0 80px rgba(242, 202, 103, 0.008) !important;

        animation: sidebar-orbit 12s ease-in-out infinite !important;
    }

    .sidebar::after {
        right: -92px !important;
        bottom: 40px !important;

        width: 205px !important;
        height: 205px !important;

        background: radial-gradient(
            circle,
            rgba(235, 188, 65, 0.18) 0%,
            rgba(235, 188, 65, 0.06) 42%,
            transparent 73%
        ) !important;

        filter: blur(2px) !important;

        animation: sidebar-glow 8s ease-in-out infinite !important;
    }

    .sidebar > * {
        position: relative !important;
        z-index: 1 !important;
    }

    /*
    |--------------------------------------------------------------------------
    | BRAND
    |--------------------------------------------------------------------------
    */

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

        border: 1px solid rgba(255, 255, 255, 0.62) !important;
        border-radius: 18px !important;

        object-fit: contain !important;
        background: #fffaf0 !important;

        box-shadow:
            0 12px 24px rgba(0, 0, 0, 0.19),
            0 0 0 5px rgba(232, 185, 70, 0.08) !important;

        animation: logo-breathe 6s ease-in-out infinite !important;
        transition: transform 0.25s ease !important;
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

        color: rgba(255, 255, 255, 0.62) !important;

        font-size: 10px !important;
        font-weight: 500 !important;
    }

    .sidebar .brand-divider {
        position: relative !important;

        width: 112px !important;
        height: 1px !important;

        overflow: hidden !important;

        margin-top: 18px !important;

        background: linear-gradient(
            90deg,
            transparent,
            rgba(241, 202, 104, 0.35),
            transparent
        ) !important;
    }

    .sidebar .brand-divider::after {
        content: "";

        position: absolute !important;
        top: 0 !important;
        left: -45px !important;

        width: 40px !important;
        height: 1px !important;

        background: #f5d675 !important;
        box-shadow: 0 0 12px rgba(245, 214, 117, 0.90) !important;

        animation: divider-shine 4.5s ease-in-out infinite !important;
    }

    /*
    |--------------------------------------------------------------------------
    | MENU
    |--------------------------------------------------------------------------
    */

    .sidebar .menu-label {
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;

        margin: 25px 11px 11px !important;

        color: rgba(255, 255, 255, 0.46) !important;

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
            rgba(240, 204, 112, 0.54),
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

        overflow: hidden !important;

        border: 1px solid transparent !important;
        border-radius: 13px !important;

        color: rgba(255, 255, 255, 0.72) !important;

        font-size: 14px !important;
        font-weight: 650 !important;
        text-decoration: none !important;

        transition:
            transform 0.22s ease,
            color 0.22s ease,
            background 0.22s ease,
            border-color 0.22s ease !important;
    }

    .sidebar .menu-link::before {
        content: "";

        position: absolute !important;
        top: 50% !important;
        left: 0 !important;

        width: 3px !important;
        height: 0 !important;

        border-radius: 0 8px 8px 0 !important;

        background: #f4cf66 !important;
        box-shadow: 0 0 12px rgba(244, 207, 102, 0.70) !important;

        transform: translateY(-50%) !important;
        transition: height 0.25s ease !important;
    }

    .sidebar .menu-link::after {
        content: "";

        position: absolute !important;
        top: 0 !important;
        left: -85% !important;

        width: 55% !important;
        height: 100% !important;

        pointer-events: none !important;

        background: linear-gradient(
            100deg,
            transparent,
            rgba(255, 245, 202, 0.16),
            transparent
        ) !important;

        transform: skewX(-20deg) !important;
    }

    .sidebar .menu-link:hover {
        color: #ffffff !important;

        background: rgba(208, 161, 51, 0.14) !important;
        transform: translateX(4px) !important;
    }

    .sidebar .menu-link:hover::before {
        height: 22px !important;
    }

    .sidebar .menu-link.active {
        color: #ffffff !important;

        border-color: rgba(238, 195, 87, 0.16) !important;

        background: linear-gradient(
            90deg,
            rgba(190, 130, 26, 0.54),
            rgba(127, 76, 12, 0.34)
        ) !important;

        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, 0.07),
            0 8px 18px rgba(11, 5, 2, 0.14) !important;

        transform: translateX(3px) !important;
    }

    .sidebar .menu-link.active::before {
        height: 28px !important;
    }

    .sidebar .menu-link.active::after {
        animation: active-shine 4.8s ease-in-out infinite !important;
    }

    .sidebar .menu-icon {
        width: 20px !important;
        flex-shrink: 0 !important;

        color: #ebc663 !important;

        font-size: 16px !important;
        text-align: center !important;

        transition: transform 0.22s ease !important;
    }

    .sidebar .menu-link:hover .menu-icon,
    .sidebar .menu-link.active .menu-icon {
        transform: scale(1.14) !important;
    }

    /*
    |--------------------------------------------------------------------------
    | DECORATIVE GOLD ORBIT
    |--------------------------------------------------------------------------
    */

    .sidebar .sidebar-visual {
        position: relative !important;

        width: 128px !important;
        height: 128px !important;

        display: grid !important;
        place-items: center !important;

        margin: 37px auto 0 !important;

        opacity: 0.92 !important;
    }

    .sidebar .visual-orbit {
        position: absolute !important;

        width: 108px !important;
        height: 108px !important;

        border: 1px solid rgba(239, 202, 108, 0.23) !important;
        border-radius: 50% !important;

        animation: orbit-float 8s ease-in-out infinite !important;
    }

    .sidebar .visual-orbit--two {
        width: 72px !important;
        height: 72px !important;

        border-color: rgba(239, 202, 108, 0.35) !important;

        animation-delay: -3.8s !important;
    }

    .sidebar .visual-center {
        width: 42px !important;
        height: 42px !important;

        display: grid !important;
        place-items: center !important;

        border: 1px solid rgba(242, 207, 121, 0.45) !important;
        border-radius: 14px !important;

        color: #f0cd68 !important;
        background: rgba(211, 159, 43, 0.10) !important;

        font-size: 18px !important;
        font-weight: 800 !important;

        box-shadow:
            0 0 0 8px rgba(221, 174, 60, 0.025),
            0 0 22px rgba(224, 179, 65, 0.12) !important;

        animation: center-float 5.5s ease-in-out infinite !important;
    }

    .sidebar .visual-particle {
        position: absolute !important;

        width: 5px !important;
        height: 5px !important;

        border-radius: 50% !important;

        background: #f3d77f !important;
        box-shadow: 0 0 10px rgba(243, 215, 127, 0.90) !important;

        animation: particle-float 4.5s ease-in-out infinite !important;
    }

    .sidebar .visual-particle--one {
        top: 17px !important;
        right: 30px !important;
    }

    .sidebar .visual-particle--two {
        bottom: 22px !important;
        left: 24px !important;

        width: 4px !important;
        height: 4px !important;

        animation-delay: -1.5s !important;
    }

    .sidebar .visual-particle--three {
        top: 50% !important;
        right: 8px !important;

        width: 3px !important;
        height: 3px !important;

        animation-delay: -3s !important;
    }

    /*
    |--------------------------------------------------------------------------
    | FOOTER
    |--------------------------------------------------------------------------
    */

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
            rgba(234, 201, 104, 0.66),
            transparent
        ) !important;
    }

    /*
    |--------------------------------------------------------------------------
    | ANIMATION
    |--------------------------------------------------------------------------
    */

    @keyframes sidebar-orbit {
        0%,
        100% {
            transform: translate(0, 0) rotate(0deg);
            opacity: 0.72;
        }

        50% {
            transform: translate(-13px, 15px) rotate(8deg);
            opacity: 1;
        }
    }

    @keyframes sidebar-glow {
        0%,
        100% {
            transform: scale(0.90);
            opacity: 0.55;
        }

        50% {
            transform: scale(1.12);
            opacity: 0.96;
        }
    }

    @keyframes logo-breathe {
        0%,
        100% {
            transform: translateY(0) scale(1);
        }

        50% {
            transform: translateY(-3px) scale(1.025);
        }
    }

    @keyframes divider-shine {
        0%,
        18% {
            left: -45px;
            opacity: 0;
        }

        34% {
            opacity: 1;
        }

        58%,
        100% {
            left: 120px;
            opacity: 0;
        }
    }

    @keyframes active-shine {
        0%,
        22% {
            left: -85%;
            opacity: 0;
        }

        38% {
            opacity: 1;
        }

        58%,
        100% {
            left: 135%;
            opacity: 0;
        }
    }

    @keyframes orbit-float {
        0%,
        100% {
            transform: scale(0.92);
            opacity: 0.38;
        }

        50% {
            transform: scale(1.08);
            opacity: 0.96;
        }
    }

    @keyframes center-float {
        0%,
        100% {
            transform: translateY(0) rotate(0deg);
        }

        50% {
            transform: translateY(-5px) rotate(7deg);
        }
    }

    @keyframes particle-float {
        0%,
        100% {
            transform: translate(0, 0) scale(0.85);
            opacity: 0.35;
        }

        50% {
            transform: translate(-8px, -10px) scale(1.25);
            opacity: 1;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | TOMBOL TUTUP KHUSUS MOBILE
    |--------------------------------------------------------------------------
    | Tombol ini berada di dalam drawer agar tombol hamburger tidak menutupi
    | area sidebar saat menu terbuka.
    */
    .sidebar-mobile-close {
        display: none;
    }

    /*
    |--------------------------------------------------------------------------
    | MOBILE DRAWER
    |--------------------------------------------------------------------------
    | Sidebar tidak disembunyikan pada tablet/ponsel. State buka/tutup
    | dikendalikan dari layouts/app.blade.php melalui class
    | body.kcw-mobile-menu-open.
    */
    @media (max-width: 1050px) {
        .sidebar-mobile-close {
            position: absolute !important;
            top: 14px !important;
            right: 14px !important;
            z-index: 5 !important;

            width: 38px !important;
            height: 38px !important;
            display: grid !important;
            place-items: center !important;

            border: 1px solid rgba(255, 255, 255, 0.24) !important;
            border-radius: 11px !important;

            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.10) !important;

            font-size: 23px !important;
            font-weight: 400 !important;
            line-height: 1 !important;

            cursor: pointer !important;
            -webkit-tap-highlight-color: transparent !important;

            transition: background 0.2s ease, border-color 0.2s ease, transform 0.2s ease !important;
        }

        .sidebar-mobile-close:hover,
        .sidebar-mobile-close:focus-visible {
            outline: none !important;
            border-color: rgba(255, 255, 255, 0.48) !important;
            background: rgba(255, 255, 255, 0.20) !important;
            transform: rotate(90deg) !important;
        }

        .sidebar {
            z-index: 210 !important;
            display: flex !important;

            width: min(270px, calc(100vw - 52px)) !important;
            max-width: 270px !important;
            height: 100dvh !important;
            min-height: 100dvh !important;

            overflow-x: hidden !important;
            overflow-y: auto !important;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;

            visibility: hidden !important;
            pointer-events: none !important;
            transform: translateX(calc(-100% - 18px)) !important;

            box-shadow: 18px 0 42px rgba(26, 14, 5, 0.26) !important;
            transition:
                transform 0.32s cubic-bezier(.22, 1, .36, 1),
                visibility 0s linear 0.32s !important;
            will-change: transform;
        }

        body.kcw-mobile-menu-open .sidebar {
            visibility: visible !important;
            pointer-events: auto !important;
            transform: translateX(0) !important;
            transition:
                transform 0.32s cubic-bezier(.22, 1, .36, 1),
                visibility 0s linear 0s !important;
        }

        .sidebar .menu-link {
            min-height: 48px !important;
            -webkit-tap-highlight-color: transparent;
        }

        .sidebar .menu-link:hover {
            transform: none !important;
        }

        .sidebar .menu-link:active {
            transform: scale(0.985) !important;
        }
    }

    @media (max-width: 520px) {
        .sidebar-mobile-close {
            top: 12px !important;
            right: 12px !important;
            width: 36px !important;
            height: 36px !important;
            border-radius: 10px !important;
            font-size: 22px !important;
        }

        .sidebar {
            width: min(278px, calc(100vw - 42px)) !important;
            padding: 20px 14px !important;
        }

        .sidebar .brand {
            padding-bottom: 15px !important;
        }

        .sidebar .menu-label {
            margin-top: 19px !important;
        }

        .sidebar .sidebar-visual {
            margin-top: 28px !important;
            transform: scale(0.92);
        }
    }

    @media (max-height: 680px) and (max-width: 1050px) {
        .sidebar .brand-logo {
            width: 50px !important;
            height: 50px !important;
            margin-bottom: 9px !important;
        }

        .sidebar .brand-divider {
            margin-top: 12px !important;
        }

        .sidebar .menu-label {
            margin-top: 16px !important;
        }

        .sidebar .sidebar-visual {
            width: 94px !important;
            height: 94px !important;
            margin-top: 20px !important;
            transform: scale(0.78);
            transform-origin: top center;
        }

        .sidebar .sidebar-footer {
            padding-top: 12px !important;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .sidebar::before,
        .sidebar::after,
        .sidebar .brand-logo,
        .sidebar .brand-divider::after,
        .sidebar .menu-link.active::after,
        .sidebar .visual-orbit,
        .sidebar .visual-center,
        .sidebar .visual-particle {
            animation: none !important;
        }
    }
</style>

<aside class="sidebar">
    <button
        type="button"
        class="sidebar-mobile-close"
        data-mobile-menu-close
        aria-label="Tutup navigasi"
    >
        ×
    </button>
    <div class="brand">
        <img
            src="{{ asset('images/logo-kcw.png') }}"
            alt="Logo PT Karunia Cipta Wasantara"
            class="brand-logo"
        >

        <h1>PT Karunia Cipta Wasantara</h1>
        <span>Sistem Data Karyawan</span>

        <div class="brand-divider" aria-hidden="true"></div>
    </div>

    <span class="menu-label">Menu Utama</span>

    <a
        href="{{ route('dashboard') }}"
        wire:navigate
        wire:current.exact="active"
        class="menu-link"
    >
        <span class="menu-icon">▦</span>
        Dashboard
    </a>

    <a
        href="{{ route('employees.create') }}"
        wire:navigate
        wire:current.exact="active"
        class="menu-link"
    >
        <span class="menu-icon">＋</span>
        Input Karyawan
    </a>

    <a
        href="{{ route('employees.index') }}"
        wire:navigate
        wire:current.exact="active"
        class="menu-link"
    >
        <span class="menu-icon">◉</span>
        Data Karyawan
    </a>

    <div class="sidebar-visual" aria-hidden="true">
        <span class="visual-orbit"></span>
        <span class="visual-orbit visual-orbit--two"></span>

        <span class="visual-particle visual-particle--one"></span>
        <span class="visual-particle visual-particle--two"></span>
        <span class="visual-particle visual-particle--three"></span>

        <div class="visual-center">✦</div>
    </div>

    <div class="sidebar-footer">
        © 2026 Karunia Cipta Wasantara
    </div>
</aside>