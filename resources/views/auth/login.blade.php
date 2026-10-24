<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Masuk Sistem | PT Karunia Cipta Wasantara</title>

    <style>
        :root {
            --gold: #c89a2b;
            --gold-light: #efd98c;
            --gold-soft: #fbf3d9;

            --brown: #2c1a0d;
            --brown-soft: #5f4328;

            --cream: #fffdf4;
            --surface: #ffffff;
            --text: #27180e;
            --muted: #887564;
            --border: #eadfca;
            --danger: #b43b2f;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            min-height: 100%;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        body {
            min-height: 100vh;

            color: var(--text);

            background:
                radial-gradient(circle at 13% 10%, rgba(241, 210, 120, 0.42), transparent 25%),
                radial-gradient(circle at 90% 90%, rgba(198, 153, 43, 0.16), transparent 28%),
                linear-gradient(135deg, #fffdf5 0%, #f8efd9 46%, #f4df9e 100%);

            overflow-x: hidden;
        }

        .page-wrapper {
            position: relative;

            min-height: 100vh;

            display: grid;
            grid-template-columns: 1.12fr 0.88fr;
        }

        .page-wrapper::before,
        .page-wrapper::after {
            content: "";

            position: fixed;

            border-radius: 50%;

            pointer-events: none;

            filter: blur(2px);
            opacity: 0.55;

            animation: float-glow 9s ease-in-out infinite;
        }

        .page-wrapper::before {
            top: -85px;
            left: -90px;

            width: 270px;
            height: 270px;

            background: rgba(213, 167, 50, 0.17);
        }

        .page-wrapper::after {
            right: -140px;
            bottom: -150px;

            width: 360px;
            height: 360px;

            background: rgba(116, 73, 29, 0.10);

            animation-delay: -4s;
        }

        .brand-section {
            position: relative;
            z-index: 1;

            min-height: 100vh;
            padding: 58px 9%;

            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand-top {
            width: fit-content;

            display: inline-flex;
            align-items: center;
            gap: 12px;

            padding: 8px 14px 8px 9px;

            border: 1px solid rgba(200, 154, 43, 0.32);
            border-radius: 999px;

            color: var(--brown-soft);
            background: rgba(255, 255, 255, 0.50);

            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.3px;

            animation: fade-down 0.8s ease both;
        }

        .brand-top-dot {
            width: 10px;
            height: 10px;

            border-radius: 50%;

            background: var(--gold);
            box-shadow: 0 0 0 5px rgba(200, 154, 43, 0.15);
        }

        .logo-wrapper {
            width: 160px;
            height: 160px;

            display: grid;
            place-items: center;

            margin: 33px 0 28px;
            padding: 18px;

            border: 1px solid rgba(200, 154, 43, 0.27);
            border-radius: 32px;

            background: rgba(255, 255, 255, 0.54);

            box-shadow: 0 24px 55px rgba(102, 66, 24, 0.12);

            animation: logo-reveal 1s ease both;
        }

        .logo-wrapper img {
            width: 100%;
            height: 100%;

            object-fit: contain;
            mix-blend-mode: multiply;
        }

        .brand-section h1 {
            max-width: 690px;
            margin: 0;

            color: var(--brown);

            font-size: clamp(35px, 4vw, 60px);
            line-height: 1.1;
            letter-spacing: -2px;

            animation: fade-up 0.9s ease 0.16s both;
        }

        .brand-section h1 span {
            color: var(--gold);
        }

        .brand-section p {
            max-width: 610px;
            margin: 23px 0 0;

            color: var(--brown-soft);

            font-size: 16px;
            line-height: 1.85;

            animation: fade-up 0.9s ease 0.28s both;
        }

        .feature-list {
            display: flex;
            flex-wrap: wrap;
            gap: 11px;

            margin-top: 32px;

            animation: fade-up 0.9s ease 0.40s both;
        }

        .feature-item {
            padding: 10px 13px;

            border: 1px solid rgba(200, 154, 43, 0.26);
            border-radius: 999px;

            color: var(--brown-soft);
            background: rgba(255, 255, 255, 0.45);

            font-size: 12px;
            font-weight: 700;
        }

        .login-section {
            position: relative;
            z-index: 1;

            min-height: 100vh;
            padding: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-left: 1px solid rgba(200, 154, 43, 0.17);

            background: rgba(255, 255, 255, 0.48);

            backdrop-filter: blur(10px);
        }

        .login-card {
            width: min(100%, 435px);
            padding: 43px;

            border: 1px solid var(--border);
            border-radius: 28px;

            background: rgba(255, 255, 255, 0.91);

            box-shadow: 0 28px 70px rgba(78, 49, 18, 0.13);

            animation: card-enter 0.85s ease 0.2s both;
        }

        .login-card-header {
            margin-bottom: 30px;
        }

        .login-card-header small {
            display: block;
            margin-bottom: 10px;

            color: var(--gold);

            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.1px;
            text-transform: uppercase;
        }

        .login-card h2 {
            margin: 0;

            color: var(--brown);

            font-size: 29px;
            letter-spacing: -0.9px;
        }

        .login-card-header p {
            margin: 10px 0 0;

            color: var(--muted);

            font-size: 13px;
            line-height: 1.7;
        }

        .form-group {
            margin-bottom: 19px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;

            color: var(--brown-soft);

            font-size: 13px;
            font-weight: 750;
        }

        .form-group input {
            width: 100%;
            height: 51px;
            padding: 0 15px;

            outline: none;

            border: 1px solid var(--border);
            border-radius: 12px;

            color: var(--text);
            background: #fffefa;

            font-size: 14px;

            transition: 0.22s ease;
        }

        .form-group input::placeholder {
            color: #b9a999;
        }

        .form-group input:focus {
            border-color: var(--gold);

            background: #ffffff;

            box-shadow: 0 0 0 4px rgba(200, 154, 43, 0.14);
        }

        .login-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;

            margin: 3px 0 25px;

            color: var(--muted);

            font-size: 12px;
        }

        .remember-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            cursor: pointer;
        }

        .remember-label input {
            accent-color: var(--gold);
        }

        .access-label {
            color: var(--gold);
            font-weight: 750;
        }

        .login-button {
            width: 100%;
            min-height: 52px;

            border: 0;
            border-radius: 12px;

            color: #ffffff;
            background: linear-gradient(135deg, #a97916, #d4a63a);

            box-shadow: 0 12px 20px rgba(174, 125, 24, 0.22);

            font-size: 14px;
            font-weight: 800;
            letter-spacing: 0.1px;

            cursor: pointer;
            transition: 0.22s ease;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 17px 26px rgba(174, 125, 24, 0.29);
        }

        .login-footer {
            margin: 24px 0 0;

            color: #a08e7e;

            font-size: 11px;
            line-height: 1.6;
            text-align: center;
        }

        .alert-error {
            margin-bottom: 20px;
            padding: 13px 14px;

            border: 1px solid #f4c8c0;
            border-radius: 11px;

            color: var(--danger);
            background: #fff2ef;

            font-size: 12px;
            line-height: 1.6;
        }

        @keyframes float-glow {
            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(20px, 16px);
            }
        }

        @keyframes logo-reveal {
            from {
                opacity: 0;
                transform: translateY(-10px) scale(0.92);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes fade-down {
            from {
                opacity: 0;
                transform: translateY(-14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-up {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes card-enter {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @media (max-width: 980px) {
            .page-wrapper {
                grid-template-columns: 1fr;
            }

            .brand-section {
                min-height: auto;
                padding: 48px 9% 42px;
            }

            .login-section {
                min-height: auto;
                padding: 30px 22px 46px;

                border-top: 1px solid rgba(200, 154, 43, 0.17);
                border-left: 0;
            }

            .logo-wrapper {
                width: 118px;
                height: 118px;

                margin: 25px 0;

                border-radius: 24px;
            }
        }

        @media (max-width: 540px) {
            .brand-section {
                padding: 35px 22px 34px;
            }

            .brand-section h1 {
                font-size: 37px;
                letter-spacing: -1.3px;
            }

            .brand-section p {
                font-size: 14px;
            }

            .login-card {
                padding: 30px 23px;

                border-radius: 21px;
            }

            .login-options {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <section class="brand-section">
            <div class="brand-top">
                <span class="brand-top-dot"></span>
                SISTEM DATA KARYAWAN
            </div>

            <div class="logo-wrapper">
                <img
                    src="{{ asset('images/logo-kcw.png') }}"
                    alt="Logo PT Karunia Cipta Wasantara"
                >
            </div>

            <h1>
                Kelola data karyawan dengan lebih
                <span>teratur.</span>
            </h1>

            <p>
                Sistem PT Karunia Cipta Wasantara untuk menyimpan, mencari,
                dan memantau data karyawan secara terpusat dan aman.
            </p>

            <div class="feature-list">
                <div class="feature-item">Outsource</div>
                <div class="feature-item">Manage</div>
                <div class="feature-item">Grow</div>
            </div>
        </section>

        <section class="login-section">
            <div class="login-card">
                <div class="login-card-header">
                    <small>PT Karunia Cipta Wasantara</small>

                    <h2>Masuk ke Sistem</h2>

                    <p>
                        Masukkan email dan kata sandi untuk melanjutkan.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="alert-error">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email</label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="contoh: nama@perusahaan.com"
                            autocomplete="email"
                            required
                            autofocus
                        >
                    </div>

                    <div class="form-group">
                        <label for="password">Kata Sandi</label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan kata sandi"
                            autocomplete="current-password"
                            required
                        >
                    </div>

                    <div class="login-options">
                        <label class="remember-label">
                            <input type="checkbox" name="remember">
                            Ingat saya
                        </label>

                        <span class="access-label">Akses Perusahaan</span>
                    </div>

                    <button type="submit" class="login-button">
                        Masuk ke Dashboard
                    </button>
                </form>

                <p class="login-footer">
                    Sistem Data Karyawan PT Karunia Cipta Wasantara.
                </p>
            </div>
        </section>
    </div>
</body>
</html>