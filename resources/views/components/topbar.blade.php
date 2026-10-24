@props([
    'title' => 'Dashboard',
    'subtitle' => '',
])

<style>
    .topbar-kcw {
        position: sticky;
        top: 0;
        z-index: 45;

        min-height: 82px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;

        padding: 0 38px;

        background: rgba(255, 253, 248, 0.94);
        border-bottom: 1px solid rgba(220, 195, 145, 0.62);
        box-shadow: 0 8px 24px rgba(74, 45, 18, 0.06);

        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
    }

    .topbar-kcw::after {
        content: "";
        position: absolute;
        right: 0;
        bottom: -1px;
        left: 0;
        height: 2px;
        pointer-events: none;
        background: linear-gradient(
            90deg,
            transparent 0%,
            rgba(200, 154, 43, 0.20) 14%,
            rgba(200, 154, 43, 0.72) 50%,
            rgba(200, 154, 43, 0.20) 86%,
            transparent 100%
        );
    }

    .topbar-kcw__title-area {
        min-width: 0;
    }

    .topbar-kcw__title {
        overflow: hidden;
        margin: 0;
        color: #2c1a0d;
        font-size: 25px;
        font-weight: 800;
        letter-spacing: -0.8px;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .topbar-kcw__subtitle {
        overflow: hidden;
        margin: 6px 0 0;
        color: #907d69;
        font-size: 12px;
        line-height: 1.5;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .topbar-kcw__logout-form {
        flex-shrink: 0;
        margin: 0;
    }

    .topbar-kcw__logout {
        min-height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 0 15px;
        border: 1px solid #e7d4a7;
        border-radius: 11px;
        color: #79501e;
        background: #fffaf0;
        font-size: 11px;
        font-weight: 800;
        cursor: pointer;
        -webkit-tap-highlight-color: transparent;
        transition: color 0.2s ease, background 0.2s ease, border-color 0.2s ease,
            transform 0.2s ease, box-shadow 0.2s ease;
    }

    .topbar-kcw__logout:hover,
    .topbar-kcw__logout:focus-visible {
        outline: none;
        color: #ffffff;
        background: #6b421b;
        border-color: #6b421b;
        transform: translateY(-1px);
        box-shadow: 0 8px 16px rgba(87, 51, 17, 0.18);
    }

    .topbar-kcw__logout-icon {
        font-size: 15px;
        line-height: 1;
    }

    /*
    | Mobile drawer button already exists in layouts/app.blade.php.
    | This spacing ensures the page title is never covered by it.
    */
    @media (max-width: 1050px) {
        .topbar-kcw {
            min-height: 76px;
            gap: 18px;
            padding: 0 28px 0 76px !important;
        }
    }

    @media (max-width: 760px) {
        .topbar-kcw {
            min-height: 72px;
            gap: 12px;
            padding: 0 20px 0 68px !important;
        }

        .topbar-kcw__title {
            font-size: 20px;
            letter-spacing: -0.55px;
        }

        .topbar-kcw__subtitle {
            display: none;
        }

        .topbar-kcw__logout {
            min-width: 42px;
            min-height: 40px;
            padding: 0 12px;
        }
    }

    @media (max-width: 400px) {
        .topbar-kcw {
            min-height: 66px;
            gap: 8px;
            padding-right: 13px !important;
            padding-left: 63px !important;
        }

        .topbar-kcw__title {
            font-size: 18px;
        }

        .topbar-kcw__logout {
            width: 40px;
            min-width: 40px;
            height: 40px;
            min-height: 40px;
            padding: 0;
            border-radius: 10px;
        }

        .topbar-kcw__logout-label {
            display: none;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .topbar-kcw__logout {
            transition-duration: 0.01ms;
        }
    }
</style>

<header class="topbar-kcw">
    <div class="topbar-kcw__title-area">
        <h2 class="topbar-kcw__title">{{ $title }}</h2>

        @if ($subtitle)
            <p class="topbar-kcw__subtitle">{{ $subtitle }}</p>
        @endif
    </div>

    <form method="POST" action="{{ route('logout') }}" class="topbar-kcw__logout-form">
        @csrf

        <button type="submit" class="topbar-kcw__logout" aria-label="Keluar dari sistem">
            <span class="topbar-kcw__logout-icon" aria-hidden="true">↪</span>
            <span class="topbar-kcw__logout-label">Keluar</span>
        </button>
    </form>
</header>
