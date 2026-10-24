@extends('layouts.app')

@php
    $hasFilter = filled($search) || filled($status);
@endphp

@section('page-title', 'Data Karyawan | PT Karunia Cipta Wasantara')
@section('topbar-title', 'Data Karyawan')
@section('topbar-subtitle', 'Daftar dan informasi lengkap data karyawan.')

@push('styles')
<style>
    :root {
        --gold: #bd8a29;
        --gold-deep: #8e5e12;
        --gold-soft: #fbf2d8;
        --gold-line: #e7d5ae;

        --brown: #2e1b0d;
        --brown-soft: #674a2d;
        --muted: #8e7a66;
        --line: #eee3cf;
        --surface: #ffffff;

        --green: #197647;
        --green-soft: #eaf8ef;
        --orange: #b86d14;
        --orange-soft: #fff3df;
        --red: #b83b32;
        --red-soft: #fff0ee;

        --shadow: 0 12px 30px rgba(71, 44, 16, 0.08);
        --shadow-strong: 0 18px 38px rgba(71, 44, 16, 0.13);
    }

    * { box-sizing: border-box; }

    html { scroll-behavior: smooth; }

    body {
        margin: 0;
        min-height: 100vh;
        color: var(--brown);
        font-family: "Segoe UI", Arial, sans-serif;
        background:
            radial-gradient(circle at 8% 0%, rgba(238, 205, 107, 0.20), transparent 25%),
            linear-gradient(135deg, #fffdf7 0%, #fbf3df 100%);
    }

    a { color: inherit; text-decoration: none; }
    button, input, select { font: inherit; }
    button { cursor: pointer; }

    .app-layout {
        min-height: 100vh;
        display: grid;
        grid-template-columns: 270px minmax(0, 1fr);
    }

    .main {
        grid-column: 2;
        min-width: 0;
    }

    .employee-content {
        padding: 34px 38px 52px;
    }

    /* HERO */

    .employee-hero {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 28px;
        margin-bottom: 24px;
        padding: 29px 31px;
        border: 1px solid rgba(142, 94, 18, 0.28);
        border-radius: 22px;
        color: #ffffff;
        background:
            linear-gradient(113deg, rgba(255, 255, 255, 0.05) 0 59%, transparent 59%),
            linear-gradient(135deg, #2b190c 0%, #69451f 56%, #b8892c 100%);
        box-shadow: 0 19px 42px rgba(89, 53, 18, 0.18);
    }

    .employee-hero::before {
        content: "";
        position: absolute;
        top: -95px;
        right: -72px;
        width: 245px;
        height: 245px;
        border: 1px solid rgba(255,255,255,0.13);
        border-radius: 50%;
        box-shadow: 0 0 0 36px rgba(255,255,255,0.035);
        pointer-events: none;
    }

    .employee-hero__content,
    .employee-hero__action {
        position: relative;
        z-index: 1;
    }

    .employee-hero__eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
        color: rgba(255,255,255,0.76);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.8px;
        text-transform: uppercase;
    }

    .employee-hero__dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #f8d76d;
        box-shadow: 0 0 0 5px rgba(248,215,109,0.14);
    }

    .employee-hero h1 {
        margin: 0;
        font-size: clamp(25px, 3vw, 35px);
        font-weight: 800;
        line-height: 1.22;
        letter-spacing: -1px;
    }

    .employee-hero p {
        max-width: 680px;
        margin: 11px 0 0;
        color: rgba(255,255,255,0.76);
        font-size: 13px;
        line-height: 1.75;
    }

    .hero-button {
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 0 16px;
        border: 1px solid rgba(255,255,255,0.34);
        border-radius: 11px;
        color: #5b3c18;
        background: #fff9e7;
        font-size: 11px;
        font-weight: 850;
        white-space: nowrap;
        box-shadow: 0 10px 20px rgba(33,17,6,0.12);
        transition: background .2s ease, color .2s ease, border-color .2s ease;
    }

    .hero-button:hover {
        color: #ffffff;
        border-color: #5b3919;
        background: #5b3919;
    }

    /* ALERT */

    .success-alert {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        margin-bottom: 20px;
        padding: 15px 16px;
        border: 1px solid #bee7ce;
        border-radius: 13px;
        color: #217044;
        background: #eefbf3;
        font-size: 13px;
        line-height: 1.55;
    }

    .success-alert__icon {
        width: 25px;
        height: 25px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
        border-radius: 8px;
        color: #ffffff;
        background: var(--green);
        font-size: 13px;
        font-weight: 850;
    }

    .success-alert strong {
        display: block;
        margin-bottom: 3px;
        color: #195c37;
    }

    /* FILTER */

    .filter-card {
        display: grid;
        grid-template-columns: minmax(260px, 1fr) 185px auto;
        align-items: end;
        gap: 14px;
        margin-bottom: 30px;
        padding: 18px;
        border: 1px solid var(--line);
        border-radius: 17px;
        background: rgba(255,255,255,0.88);
        box-shadow: 0 8px 25px rgba(86,52,20,0.05);
    }

    .filter-group label {
        display: block;
        margin-bottom: 7px;
        color: var(--brown-soft);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.2px;
    }

    .filter-group input,
    .filter-group select {
        width: 100%;
        height: 45px;
        padding: 0 13px;
        outline: none;
        border: 1px solid var(--line);
        border-radius: 10px;
        color: var(--brown);
        background: #fffefa;
        font-size: 13px;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .filter-group input:focus,
    .filter-group select:focus {
        border-color: var(--gold);
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(189,138,41,0.12);
    }

    .filter-actions {
        display: flex;
        gap: 9px;
    }

    .filter-button,
    .reset-button {
        height: 45px;
        padding: 0 15px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 800;
        transition: background .2s ease, color .2s ease, border-color .2s ease;
    }

    .filter-button {
        border: 0;
        color: #ffffff;
        background: var(--brown);
    }

    .filter-button:hover { background: #482a13; }

    .reset-button {
        display: inline-flex;
        align-items: center;
        border: 1px solid var(--line);
        color: var(--brown-soft);
        background: #ffffff;
    }

    .reset-button:hover {
        border-color: var(--gold-line);
        color: var(--gold-deep);
        background: var(--gold-soft);
    }

    /* DATA HEADER */

    .data-heading {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 18px;
    }

    .data-heading h2 {
        margin: 0;
        color: var(--brown);
        font-size: 18px;
        letter-spacing: -0.3px;
    }

    .data-heading p {
        margin: 6px 0 0;
        color: var(--muted);
        font-size: 12px;
        line-height: 1.65;
    }

    .record-count {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        flex-shrink: 0;
        padding: 8px 11px;
        border: 1px solid #eedda9;
        border-radius: 999px;
        color: var(--gold-deep);
        background: var(--gold-soft);
        font-size: 11px;
        font-weight: 850;
    }

    /* EMPLOYEE CARD */

    .employee-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    /*
    |--------------------------------------------------------------------------
    | KARTU KARYAWAN — CORPORATE PROFILE CARD
    |--------------------------------------------------------------------------
    | Card dirapikan menjadi profil karyawan yang lebih tegas, berimbang,
    | dan konsisten dengan nuansa gold–brown sistem.
    */
    .employee-card {
        position: relative;
        overflow: hidden;

        border: 1px solid var(--gold-line);
        border-radius: 22px;

        background: #ffffff;
        box-shadow:
            0 1px 0 rgba(255, 255, 255, 0.92) inset,
            0 14px 32px rgba(71, 44, 16, 0.09);

        transition: border-color .22s ease, box-shadow .22s ease;
    }

    .employee-card:hover {
        border-color: #d6b36b;
        box-shadow:
            0 1px 0 rgba(255, 255, 255, 0.96) inset,
            0 18px 38px rgba(71, 44, 16, 0.13);
    }

    /*
    |--------------------------------------------------------------------------
    | BANNER GOLD BERTEKSTUR
    |--------------------------------------------------------------------------
    | Tekstur organik dibuat statis agar elegan dan tidak terasa ramai.
    */
    .employee-card__banner {
        position: relative;
        width: 100%;
        height: 112px;
        overflow: hidden;

        border-bottom: 1px solid #d7b36b;

        background: linear-gradient(110deg, #3e240f 0%, #6c451a 52%, #ac7927 100%);
    }

    .employee-card__banner::before {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;

        background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMjAwIDIyMCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CjxkZWZzPgogIDxsaW5lYXJHcmFkaWVudCBpZD0iZyIgeDE9IjAiIHkxPSIwIiB4Mj0iMSIgeTI9IjAiPjxzdG9wIG9mZnNldD0iMCIgc3RvcC1jb2xvcj0iIzNlMjQwZiIvPjxzdG9wIG9mZnNldD0iLjUyIiBzdG9wLWNvbG9yPSIjNmM0NTFhIi8+PHN0b3Agb2Zmc2V0PSIxIiBzdG9wLWNvbG9yPSIjYWM3OTI3Ii8+PC9saW5lYXJHcmFkaWVudD4KPC9kZWZzPgo8cmVjdCB3aWR0aD0iMTIwMCIgaGVpZ2h0PSIyMjAiIGZpbGw9InVybCgjZykiLz4KPGcgZmlsbD0ibm9uZSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIj4KICA8cGF0aCBkPSJNLTcwIDE4IEM4NSA3NCAxNiAxNDUgMTg1IDIxNSIgc3Ryb2tlPSIjZjRkOTk1IiBzdHJva2Utd2lkdGg9IjI4IiBvcGFjaXR5PSIuMTAiLz4KICA8cGF0aCBkPSJNMTAwIDAgQzI0NCA2NiAxOTEgMTM1IDM0MyAyMjAiIHN0cm9rZT0iI2Y2ZTNiNSIgc3Ryb2tlLXdpZHRoPSIxOCIgb3BhY2l0eT0iLjEwIi8+CiAgPHBhdGggZD0iTTM0MiAtMTUgQzUwMSA1NiA0MzggMTM2IDYxMiAyMzAiIHN0cm9rZT0iI2VlY2I3OCIgc3Ryb2tlLXdpZHRoPSIzMCIgb3BhY2l0eT0iLjEyIi8+CiAgPHBhdGggZD0iTTU5MCAtMTIgQzc0MiA2MyA2ODggMTM3IDg0NiAyMzAiIHN0cm9rZT0iI2Y4ZThiZCIgc3Ryb2tlLXdpZHRoPSIxNiIgb3BhY2l0eT0iLjExIi8+CiAgPHBhdGggZD0iTTgxMiAtMjAgQzEwMDMgNTggOTA4IDE1MCAxMDgyIDIyOSIgc3Ryb2tlPSIjZWZkMDg4IiBzdHJva2Utd2lkdGg9IjI4IiBvcGFjaXR5PSIuMTMiLz4KICA8cGF0aCBkPSJNMTAzMiAtMTAgQzExNzAgNDggMTEyMiAxMzUgMTI3MCAyMTMiIHN0cm9rZT0iI2ZhZWRjYiIgc3Ryb2tlLXdpZHRoPSIxNyIgb3BhY2l0eT0iLjEyIi8+CiAgPHBhdGggZD0iTS0xOCAzNiBDMTI1IDg3IDYzIDE1MyAyMTQgMjEwIiBzdHJva2U9IiNmZmY0ZDciIHN0cm9rZS13aWR0aD0iMiIgb3BhY2l0eT0iLjMwIi8+CiAgPHBhdGggZD0iTTMzMSAxMCBDNDgyIDY4IDQyNiAxNDUgNTk1IDIxNiIgc3Ryb2tlPSIjZmZmNGQ3IiBzdHJva2Utd2lkdGg9IjIiIG9wYWNpdHk9Ii4yNyIvPgogIDxwYXRoIGQ9Ik04MDggNCBDOTg5IDc2IDkwMSAxNDQgMTA2MCAyMTYiIHN0cm9rZT0iI2ZmZjRkNyIgc3Ryb2tlLXdpZHRoPSIyIiBvcGFjaXR5PSIuMjgiLz4KPC9nPgo8cGF0aCBkPSJNMCAxODggQzI0NCAxNDggMzkyIDIyNiA2MjggMTg1IEM4NDggMTQ4IDEwMjEgMTk4IDEyMDAgMTY0IEwxMjAwIDIyMCBMMCAyMjAgWiIgZmlsbD0iIzJmMTgwNiIgb3BhY2l0eT0iLjEwIi8+CjxyZWN0IHdpZHRoPSIxMjAwIiBoZWlnaHQ9IjIyMCIgZmlsbD0iI2ZmZmZmZiIgb3BhY2l0eT0iLjAzNSIvPgo8L3N2Zz4=");
        background-repeat: no-repeat;
        background-position: center center;
        background-size: 100% 100%;
        opacity: 0.94;
    }

    .employee-card__banner::after {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;

        background:
            linear-gradient(
                180deg,
                rgba(255, 255, 255, 0.10) 0%,
                rgba(255, 255, 255, 0.00) 48%,
                rgba(35, 18, 6, 0.14) 100%
            );
    }

    /*
    |--------------------------------------------------------------------------
    | FOTO DAN STATUS
    |--------------------------------------------------------------------------
    */
    .employee-photo {
        position: absolute;
        top: 30px;
        left: 20px;
        z-index: 2;

        width: 84px;
        height: 112px; /* rasio 3 x 4 */
        overflow: hidden;

        border: 4px solid #ffffff;
        border-radius: 18px;

        background: #f7ecd0;
        box-shadow:
            0 0 0 1px rgba(210, 176, 102, 0.28),
            0 10px 22px rgba(61, 37, 19, 0.17);
    }

    .employee-photo img {
        width: 100%;
        height: 100%;
        display: block;

        object-fit: cover;
        object-position: center top;
    }

    .employee-photo__initial {
        width: 100%;
        height: 100%;

        display: grid;
        place-items: center;

        color: var(--gold-deep);
        background: linear-gradient(180deg, #fff5d6 0%, #efddb0 100%);

        font-size: 26px;
        font-weight: 850;
    }

    .employee-status {
        position: absolute;
        top: 15px;
        right: 16px;
        z-index: 3;

        display: inline-flex;
        align-items: center;
        gap: 6px;

        padding: 7px 11px;

        border: 1px solid rgba(255, 255, 255, 0.20);
        border-radius: 999px;

        font-size: 10px;
        font-weight: 850;

        box-shadow: 0 6px 14px rgba(26, 16, 6, 0.13);
    }

    .employee-status--active {
        color: #e8fff1;
        background: #197647;
    }

    .employee-status--inactive {
        color: #fff3f2;
        background: #b83b32;
    }

    /*
    |--------------------------------------------------------------------------
    | IDENTITAS DAN RINGKASAN INFORMASI
    |--------------------------------------------------------------------------
    */
    .employee-card__content {
        position: relative;
        padding: 64px 20px 20px;

        background:
            linear-gradient(180deg, rgba(255, 252, 245, 0.78) 0%, #ffffff 20%);
    }

    .employee-name {
        display: block;
        overflow: hidden;

        color: var(--brown);

        font-size: 18px;
        font-weight: 850;
        letter-spacing: -0.35px;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .employee-phone {
        display: block;
        margin-top: 7px;

        color: var(--muted);

        font-size: 12px;
        line-height: 1.4;
    }

    /*
    | Garis pembatas dibuat sebagai ornamen gold dengan diamond di tengah,
    | bukan garis polos.
    */
    .card-divider {
        position: relative;
        height: 16px;
        margin: 17px 0 14px;

        background:
            linear-gradient(
                90deg,
                transparent 0%,
                #eadfc8 8%,
                #eadfc8 42%,
                transparent 42%,
                transparent 58%,
                #eadfc8 58%,
                #eadfc8 92%,
                transparent 100%
            );
        background-repeat: no-repeat;
        background-position: center;
        background-size: 100% 1px;
    }

    .card-divider::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;

        width: 8px;
        height: 8px;

        border: 1px solid #c9993c;
        background: #fffaf0;

        transform: translate(-50%, -50%) rotate(45deg);

        box-shadow: 0 0 0 3px #ffffff;
    }

    .card-divider::after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;

        width: 3px;
        height: 3px;

        border-radius: 50%;
        background: #bc8627;

        transform: translate(-50%, -50%);
    }

    .employee-info-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;

        margin: 0;
        padding: 10px 0;
    }

    .employee-info-row + .employee-info-row {
        border-top: 0;
    }

    .employee-info-icon {
        width: 27px;
        height: 27px;

        display: grid;
        place-items: center;
        flex-shrink: 0;

        border: 1px solid #efddb0;
        border-radius: 9px;

        color: var(--gold-deep);
        background: #fff8e6;

        font-size: 13px;
        text-align: center;
    }

    .employee-info-label {
        display: block;
        margin-bottom: 3px;

        color: var(--muted);

        font-size: 10px;
        line-height: 1.35;
    }

    .employee-info-value {
        display: block;
        overflow: hidden;

        color: var(--brown-soft);

        font-size: 12px;
        font-weight: 750;
        line-height: 1.4;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /*
    |--------------------------------------------------------------------------
    | KONTRAK DAN TOMBOL DETAIL
    |--------------------------------------------------------------------------
    */
    .contract-alert {
        display: flex;
        align-items: center;
        gap: 8px;

        margin-top: 15px;
        padding: 10px 11px;

        border: 1px solid transparent;
        border-left-width: 3px;
        border-radius: 11px;

        font-size: 11px;
        font-weight: 800;
    }

    .contract-alert > span {
        width: 18px;
        height: 18px;

        display: grid;
        place-items: center;
        flex-shrink: 0;

        border-radius: 50%;

        font-size: 10px;
        font-weight: 900;
    }

    .contract-alert--safe {
        color: var(--green);
        border-color: #cdebd9;
        border-left-color: var(--green);
        background: var(--green-soft);
    }

    .contract-alert--safe > span {
        color: #ffffff;
        background: var(--green);
    }

    .contract-alert--warning {
        color: var(--orange);
        border-color: #f1d7a7;
        border-left-color: var(--orange);
        background: var(--orange-soft);
    }

    .contract-alert--warning > span {
        color: #ffffff;
        background: var(--orange);
    }

    .contract-alert--danger {
        color: var(--red);
        border-color: #f2c8c3;
        border-left-color: var(--red);
        background: var(--red-soft);
    }

    .contract-alert--danger > span {
        color: #ffffff;
        background: var(--red);
    }

    .detail-button {
        width: 100%;
        min-height: 43px;

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;

        margin-top: 16px;

        border: 1px solid #ddbe70;
        border-radius: 11px;

        color: var(--gold-deep);
        background: linear-gradient(180deg, #fffdf8 0%, #fff6df 100%);

        font-size: 11px;
        font-weight: 850;

        transition: background .2s ease, color .2s ease, border-color .2s ease;
    }

    .detail-button:hover {
        border-color: var(--gold-deep);
        color: #ffffff;
        background: var(--gold-deep);
    }

    /* EMPTY STATE */

    .empty-state {
        padding: 72px 22px;
        border: 1px solid var(--line);
        border-radius: 18px;
        background: rgba(255,255,255,0.84);
        box-shadow: var(--shadow);
        text-align: center;
    }

    .empty-icon {
        width: 67px;
        height: 67px;
        display: grid;
        place-items: center;
        margin: 0 auto 16px;
        border: 1px solid #ecdcae;
        border-radius: 20px;
        color: var(--gold-deep);
        background: var(--gold-soft);
        font-size: 28px;
    }

    .empty-state h2 {
        margin: 0;
        color: var(--brown);
        font-size: 18px;
    }

    .empty-state p {
        max-width: 470px;
        margin: 10px auto 21px;
        color: var(--muted);
        font-size: 13px;
        line-height: 1.7;
    }

    .empty-button {
        min-height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 0 15px;
        border-radius: 10px;
        color: #ffffff;
        background: var(--brown);
        font-size: 12px;
        font-weight: 850;
    }

    .empty-button:hover { background: #4a2d15; }

    /* PAGINATION */

    .pagination {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-top: 21px;
        padding: 17px 18px;
        border: 1px solid var(--line);
        border-radius: 14px;
        background: rgba(255,255,255,0.82);
    }

    .pagination-info { color: var(--muted); font-size: 12px; }

    .pagination-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .pagination-button {
        min-width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 10px;
        border: 1px solid var(--line);
        border-radius: 8px;
        color: var(--brown-soft);
        background: #ffffff;
        font-size: 11px;
        font-weight: 800;
    }

    .pagination-button:hover {
        border-color: var(--gold-line);
        color: var(--gold-deep);
        background: var(--gold-soft);
    }

    .pagination-button--disabled {
        pointer-events: none;
        opacity: 0.45;
    }

    /* MODAL */

    .employee-modal {
        position: fixed;
        inset: 0;
        z-index: 100;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 22px;
        background: rgba(35,18,8,0.60);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
    }

    .employee-modal.show { display: flex; }

    .modal-dialog {
        width: min(100%, 940px);
        max-height: calc(100vh - 44px);
        overflow-y: auto;
        border: 1px solid rgba(255,255,255,0.28);
        border-radius: 22px;
        background: #fffdf8;
        box-shadow: 0 26px 60px rgba(24,12,5,0.34);
    }

    .modal-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        padding: 25px 27px;
        color: #ffffff;
        background:
            linear-gradient(113deg, rgba(255,255,255,.05) 0 59%, transparent 59%),
            linear-gradient(135deg, #2b190c 0%, #6e481f 62%, #b9892b 100%);
    }

    .modal-employee {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .modal-photo {
        width: 60px;
        height: 80px; /* 3 x 4 */
        overflow: hidden;
        flex-shrink: 0;
        border: 3px solid rgba(255,255,255,0.82);
        border-radius: 12px;
        background: #fff8e5;
    }

    .modal-photo img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        object-position: center top;
    }

    .modal-photo__initial {
        width: 100%;
        height: 100%;
        display: grid;
        place-items: center;
        color: var(--gold-deep);
        background: linear-gradient(180deg, #fff7df 0%, #edd9a7 100%);
        font-size: 20px;
        font-weight: 850;
    }

    .modal-header h2 {
        margin: 0;
        font-size: 20px;
        letter-spacing: -0.4px;
    }

    .modal-header p {
        margin: 5px 0 0;
        color: rgba(255,255,255,0.72);
        font-size: 12px;
    }

    .modal-close {
        width: 36px;
        height: 36px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
        border: 1px solid rgba(255,255,255,0.28);
        border-radius: 10px;
        color: #ffffff;
        background: rgba(255,255,255,0.10);
        font-size: 18px;
        transition: background .2s ease;
    }

    .modal-close:hover { background: rgba(255,255,255,0.22); }

    .modal-body { padding: 26px 27px 28px; }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 17px;
    }

    .detail-section {
        overflow: hidden;
        border: 1px solid var(--line);
        border-radius: 16px;
        background: #ffffff;
    }

    .detail-section--full { grid-column: 1 / -1; }

    .detail-section__heading {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 14px 16px;
        border-bottom: 1px solid var(--line);
        color: var(--brown);
        background: #fffaf0;
        font-size: 13px;
        font-weight: 850;
    }

    .detail-section__heading span {
        color: var(--gold-deep);
        font-size: 15px;
    }

    .detail-list { padding: 4px 16px; }

    .detail-row {
        display: grid;
        grid-template-columns: 145px 1fr;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #f2eadc;
    }

    .detail-row:last-child { border-bottom: 0; }

    .detail-label { color: var(--muted); font-size: 11px; }

    .detail-value {
        color: var(--brown-soft);
        font-size: 12px;
        font-weight: 750;
        line-height: 1.55;
        word-break: break-word;
    }

    .document-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 13px;
        padding: 16px;
    }

    .document-card {
        padding: 14px;
        border: 1px solid #efdfb8;
        border-radius: 13px;
        background: #fffdf7;
        text-align: center;
    }

    .document-card__icon {
        width: 42px;
        height: 42px;
        display: grid;
        place-items: center;
        margin: 0 auto 10px;
        border-radius: 13px;
        color: var(--gold-deep);
        background: var(--gold-soft);
        font-size: 18px;
    }

    .document-card h3 {
        margin: 0;
        color: var(--brown);
        font-size: 12px;
    }

    .document-card p {
        margin: 6px 0 11px;
        color: var(--muted);
        font-size: 10px;
        line-height: 1.45;
    }

    .document-button,
    .document-unavailable {
        min-height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 10px;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 850;
    }

    .document-button {
        border: 1px solid #e3c978;
        color: var(--gold-deep);
        background: #fff9e8;
        transition: background .2s ease, color .2s ease;
    }

    .document-button:hover {
        color: #ffffff;
        background: var(--gold-deep);
    }

    .document-unavailable {
        color: var(--muted);
        background: #f3eee4;
    }



    /*
    |--------------------------------------------------------------------------
    | ANIMASI MASUK HALAMAN DATA KARYAWAN
    |--------------------------------------------------------------------------
    | Efek hanya berjalan saat halaman dibuka atau saat Livewire berpindah
    | halaman. Tidak ada animasi berulang agar tampilan tetap profesional.
    */
    @keyframes employee-hero-enter {
        from {
            opacity: 0;
            transform: translateY(18px) scale(0.988);
            filter: blur(5px);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0);
        }
    }

    @keyframes employee-block-enter {
        from {
            opacity: 0;
            transform: translateY(14px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes employee-card-enter {
        from {
            opacity: 0;
            transform: translateY(20px) scale(0.985);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes employee-pop-enter {
        from {
            opacity: 0;
            transform: translateY(-8px) scale(0.90);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes employee-modal-fade {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes employee-modal-enter {
        from {
            opacity: 0;
            transform: translateY(16px) scale(0.975);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .employee-content.employee-motion-preparing .employee-hero,
    .employee-content.employee-motion-preparing .success-alert,
    .employee-content.employee-motion-preparing .filter-card,
    .employee-content.employee-motion-preparing .data-heading,
    .employee-content.employee-motion-preparing .employee-card,
    .employee-content.employee-motion-preparing .pagination,
    .employee-content.employee-motion-preparing .empty-state {
        opacity: 0;
    }

    .employee-content.employee-motion-ready .employee-hero {
        animation: employee-hero-enter 0.70s cubic-bezier(.22, 1, .36, 1) both;
    }

    .employee-content.employee-motion-ready .employee-hero__content {
        animation: employee-block-enter 0.48s cubic-bezier(.22, 1, .36, 1) 0.12s both;
    }

    .employee-content.employee-motion-ready .employee-hero__action {
        animation: employee-pop-enter 0.46s cubic-bezier(.22, 1, .36, 1) 0.20s both;
    }

    .employee-content.employee-motion-ready .success-alert {
        animation: employee-block-enter 0.46s cubic-bezier(.22, 1, .36, 1) 0.14s both;
    }

    .employee-content.employee-motion-ready .filter-card {
        animation: employee-block-enter 0.54s cubic-bezier(.22, 1, .36, 1) 0.18s both;
    }

    .employee-content.employee-motion-ready .data-heading {
        animation: employee-block-enter 0.48s cubic-bezier(.22, 1, .36, 1) 0.26s both;
    }

    .employee-content.employee-motion-ready .employee-grid > .employee-card {
        animation: employee-card-enter 0.56s cubic-bezier(.22, 1, .36, 1) both;
    }

    .employee-content.employee-motion-ready .employee-grid > .employee-card:nth-of-type(1) { animation-delay: 0.30s; }
    .employee-content.employee-motion-ready .employee-grid > .employee-card:nth-of-type(2) { animation-delay: 0.37s; }
    .employee-content.employee-motion-ready .employee-grid > .employee-card:nth-of-type(3) { animation-delay: 0.44s; }
    .employee-content.employee-motion-ready .employee-grid > .employee-card:nth-of-type(4) { animation-delay: 0.51s; }
    .employee-content.employee-motion-ready .employee-grid > .employee-card:nth-of-type(5) { animation-delay: 0.58s; }
    .employee-content.employee-motion-ready .employee-grid > .employee-card:nth-of-type(6) { animation-delay: 0.65s; }
    .employee-content.employee-motion-ready .employee-grid > .employee-card:nth-of-type(7) { animation-delay: 0.72s; }
    .employee-content.employee-motion-ready .employee-grid > .employee-card:nth-of-type(8) { animation-delay: 0.79s; }
    .employee-content.employee-motion-ready .employee-grid > .employee-card:nth-of-type(9) { animation-delay: 0.86s; }
    .employee-content.employee-motion-ready .employee-grid > .employee-card:nth-of-type(10) { animation-delay: 0.93s; }
    .employee-content.employee-motion-ready .employee-grid > .employee-card:nth-of-type(11) { animation-delay: 1.00s; }
    .employee-content.employee-motion-ready .employee-grid > .employee-card:nth-of-type(12) { animation-delay: 1.07s; }

    .employee-content.employee-motion-ready .employee-card .employee-photo {
        animation: employee-pop-enter 0.46s cubic-bezier(.22, 1, .36, 1) 0.53s both;
    }

    .employee-content.employee-motion-ready .employee-card .employee-status {
        animation: employee-pop-enter 0.42s cubic-bezier(.22, 1, .36, 1) 0.58s both;
    }

    .employee-content.employee-motion-ready .pagination,
    .employee-content.employee-motion-ready .empty-state {
        animation: employee-block-enter 0.56s cubic-bezier(.22, 1, .36, 1) 0.48s both;
    }

    .employee-modal.show {
        animation: employee-modal-fade 0.20s ease both;
    }

    .employee-modal.show .modal-dialog {
        animation: employee-modal-enter 0.30s cubic-bezier(.22, 1, .36, 1) both;
    }

    @media (prefers-reduced-motion: reduce) {
        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
            scroll-behavior: auto !important;
        }

        .employee-content.employee-motion-preparing .employee-hero,
        .employee-content.employee-motion-preparing .success-alert,
        .employee-content.employee-motion-preparing .filter-card,
        .employee-content.employee-motion-preparing .data-heading,
        .employee-content.employee-motion-preparing .employee-card,
        .employee-content.employee-motion-preparing .pagination,
        .employee-content.employee-motion-preparing .empty-state {
            opacity: 1;
        }
    }

    /* RESPONSIVE */

    @media (max-width: 1280px) {
        .employee-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 1100px) {
        .filter-card { grid-template-columns: 1fr 1fr; }
        .filter-actions { grid-column: span 2; }
    }

    @media (max-width: 1050px) {
        .app-layout { grid-template-columns: 1fr; }
        .main { grid-column: 1; }
    }

    @media (max-width: 760px) {
        .employee-content { padding: 24px 20px 40px; }

        .employee-hero {
            align-items: flex-start;
            flex-direction: column;
            padding: 25px 22px;
        }

        .hero-button { width: 100%; }

        .employee-grid,
        .detail-grid,
        .document-grid { grid-template-columns: 1fr; }

        .detail-section--full { grid-column: auto; }

        .modal-header,
        .modal-body {
            padding-right: 20px;
            padding-left: 20px;
        }
    }

    @media (max-width: 620px) {
        .filter-card { grid-template-columns: 1fr; }
        .filter-actions {
            grid-column: auto;
            flex-direction: column;
        }

        .filter-button,
        .reset-button {
            width: 100%;
            justify-content: center;
        }

        .data-heading,
        .pagination {
            align-items: flex-start;
            flex-direction: column;
        }

        .detail-row {
            grid-template-columns: 1fr;
            gap: 5px;
        }
    }
</style>
@endpush

@section('content')
<section class="employee-content">
    <section class="employee-hero">
        <div class="employee-hero__content">
            <div class="employee-hero__eyebrow">
                <span class="employee-hero__dot"></span>
                PT Karunia Cipta Wasantara
            </div>

            <h1>Data Karyawan</h1>

            <p>
                Kelola, cari, dan pantau informasi karyawan, perusahaan
                penempatan, periode kontrak, serta dokumen pendukung
                dalam satu halaman.
            </p>
        </div>

        <div class="employee-hero__action">
            <a
                href="{{ route('employees.create') }}"
                wire:navigate
                class="hero-button"
            >
                <span>＋</span>
                Input Karyawan
            </a>
        </div>
    </section>

    @if (session('success'))
        <div class="success-alert">
            <div class="success-alert__icon">✓</div>

            <div>
                <strong>Data berhasil disimpan</strong>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <form
        method="GET"
        action="{{ route('employees.index') }}"
        class="filter-card"
        data-kcw-filter-form
    >
        <div class="filter-group">
            <label for="search">CARI KARYAWAN</label>

            <input
                type="text"
                id="search"
                name="search"
                value="{{ $search }}"
                placeholder="Nama, HP, KTP, perusahaan, atau bagian..."
            >
        </div>

        <div class="filter-group">
            <label for="status">STATUS KARYAWAN</label>

            <select id="status" name="status">
                <option value="">Semua Status</option>
                <option value="active" @selected($status === 'active')>Aktif</option>
                <option value="inactive" @selected($status === 'inactive')>Tidak Aktif</option>
            </select>
        </div>

        <div class="filter-actions">
            <button type="submit" class="filter-button">Cari Data</button>

            <a href="{{ route('employees.index') }}" wire:navigate class="reset-button">
                Reset
            </a>
        </div>
    </form>

    <div class="data-heading">
        <div>
            <h2>Daftar Karyawan Terdaftar</h2>

            <p>
                Pilih “Lihat Informasi Lengkap” untuk membuka data pribadi,
                penempatan, kontrak, rekening, dan dokumen karyawan.
            </p>
        </div>

        <span class="record-count">
            <span>◉</span>
            {{ $employees->total() }} Karyawan
        </span>
    </div>

    @if ($employees->count() > 0)
        <div class="employee-grid">
            @foreach ($employees as $employee)
                @php
                    $today = now()->startOfDay();
                    $contractStart = $employee->contract_start->copy()->startOfDay();
                    $contractEnd = $employee->contract_end->copy()->startOfDay();

                    $isContractNotStarted = $contractStart->gt($today);
                    $isContractExpired = $contractEnd->lt($today);
                    $isManuallyInactive = $employee->status !== 'active';

                    $employeeStatusClass = 'employee-status--active';
                    $employeeStatusText = 'Aktif';
                    $contractDateLabel = 'Akhir Kontrak';
                    $contractDateValue = $contractEnd;

                    /*
                    |----------------------------------------------------------
                    | Status karyawan dihitung secara dinamis dari periode
                    | kontrak. Data yang jadwal kontraknya belum dimulai tidak
                    | dianggap aktif meskipun status tersimpan adalah active.
                    | Saat tanggal awal kontrak tiba, status akan aktif otomatis.
                    |----------------------------------------------------------
                    */
                    if ($isContractNotStarted) {
                        $daysUntilStart = $today->diffInDays($contractStart, false);

                        $employeeStatusClass = 'employee-status--inactive';
                        $employeeStatusText = 'Belum Aktif';
                        $contractClass = 'warning';
                        $contractIcon = '◷';
                        $contractText = $daysUntilStart === 1
                            ? 'Kontrak belum dimulai · 1 hari lagi'
                            : 'Kontrak belum dimulai · ' . $daysUntilStart . ' hari lagi';
                        $contractDateLabel = 'Mulai Kontrak';
                        $contractDateValue = $contractStart;
                    } elseif ($isManuallyInactive) {
                        $employeeStatusClass = 'employee-status--inactive';
                        $employeeStatusText = 'Tidak Aktif';
                        $contractClass = 'danger';
                        $contractIcon = '!';
                        $contractText = 'Status karyawan tidak aktif';
                    } elseif ($isContractExpired) {
                        $employeeStatusClass = 'employee-status--inactive';
                        $employeeStatusText = 'Tidak Aktif';
                        $contractClass = 'danger';
                        $contractIcon = '!';
                        $contractText = 'Kontrak telah berakhir';
                    } else {
                        $daysRemaining = $today->diffInDays($contractEnd, false);

                        if ($daysRemaining === 0) {
                            $contractClass = 'danger';
                            $contractIcon = '!';
                            $contractText = 'Kontrak berakhir hari ini';
                        } elseif ($daysRemaining <= 7) {
                            $contractClass = 'danger';
                            $contractIcon = '!';
                            $contractText = $daysRemaining . ' hari tersisa';
                        } elseif ($daysRemaining <= 30) {
                            $contractClass = 'warning';
                            $contractIcon = '!';
                            $contractText = $daysRemaining . ' hari tersisa';
                        } else {
                            $contractClass = 'safe';
                            $contractIcon = '✓';
                            $contractText = $daysRemaining . ' hari tersisa';
                        }
                    }

                    $initial = strtoupper(substr($employee->full_name, 0, 1));
                @endphp

                <article class="employee-card">
                    <div class="employee-card__banner"></div>

                    <div class="employee-photo">
                        @if ($employee->face_photo_path)
                            <img
                                src="{{ route('employees.document', ['employee' => $employee->id, 'type' => 'face']) }}"
                                alt="Foto {{ $employee->full_name }}"
                            >
                        @else
                            <div class="employee-photo__initial">{{ $initial }}</div>
                        @endif
                    </div>

                    <span class="employee-status {{ $employeeStatusClass }}">
                        <span>●</span>
                        {{ $employeeStatusText }}
                    </span>

                    <div class="employee-card__content">
                        <span class="employee-name">{{ $employee->full_name }}</span>
                        <span class="employee-phone">{{ $employee->phone }}</span>

                        <div class="card-divider"></div>

                        <div class="employee-info-row">
                            <div class="employee-info-icon">▣</div>

                            <div>
                                <span class="employee-info-label">Perusahaan Penempatan</span>
                                <span class="employee-info-value">{{ $employee->placement_company }}</span>
                            </div>
                        </div>

                        <div class="employee-info-row">
                            <div class="employee-info-icon">◈</div>

                            <div>
                                <span class="employee-info-label">Bagian / Divisi</span>
                                <span class="employee-info-value">{{ $employee->department }}</span>
                            </div>
                        </div>

                        <div class="employee-info-row">
                            <div class="employee-info-icon">◷</div>

                            <div>
                                <span class="employee-info-label">{{ $contractDateLabel }}</span>
                                <span class="employee-info-value">
                                    {{ $contractDateValue->translatedFormat('d F Y') }}
                                </span>
                            </div>
                        </div>

                        <div class="contract-alert contract-alert--{{ $contractClass }}">
                            <span>{{ $contractIcon }}</span>
                            {{ $contractText }}
                        </div>

                        <button
                            type="button"
                            class="detail-button"
                            data-modal-target="employee-modal-{{ $employee->id }}"
                        >
                            <span>◉</span>
                            Lihat Informasi Lengkap
                        </button>
                    </div>
                </article>

                <div
                    class="employee-modal"
                    id="employee-modal-{{ $employee->id }}"
                    data-modal
                >
                    <div
                        class="modal-dialog"
                        role="dialog"
                        aria-modal="true"
                        aria-label="Detail {{ $employee->full_name }}"
                    >
                        <div class="modal-header">
                            <div class="modal-employee">
                                <div class="modal-photo">
                                    @if ($employee->face_photo_path)
                                        <img
                                            src="{{ route('employees.document', ['employee' => $employee->id, 'type' => 'face']) }}"
                                            alt="Foto {{ $employee->full_name }}"
                                        >
                                    @else
                                        <div class="modal-photo__initial">{{ $initial }}</div>
                                    @endif
                                </div>

                                <div>
                                    <h2>{{ $employee->full_name }}</h2>

                                    <p>
                                        {{ $employee->placement_company }}
                                        ·
                                        {{ $employee->department }}
                                    </p>
                                </div>
                            </div>

                            <button
                                type="button"
                                class="modal-close"
                                data-modal-close
                                aria-label="Tutup detail"
                            >
                                ×
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="detail-grid">
                                <section class="detail-section">
                                    <div class="detail-section__heading">
                                        <span>◉</span>
                                        Informasi Pribadi
                                    </div>

                                    <div class="detail-list">
                                        <div class="detail-row">
                                            <span class="detail-label">Nama Lengkap</span>
                                            <span class="detail-value">{{ $employee->full_name }}</span>
                                        </div>

                                        <div class="detail-row">
                                            <span class="detail-label">Nomor HP</span>
                                            <span class="detail-value">{{ $employee->phone }}</span>
                                        </div>

                                        <div class="detail-row">
                                            <span class="detail-label">Tempat, Tanggal Lahir</span>
                                            <span class="detail-value">
                                                {{ $employee->birth_place }},
                                                {{ $employee->birth_date->translatedFormat('d F Y') }}
                                            </span>
                                        </div>

                                        <div class="detail-row">
                                            <span class="detail-label">Umur</span>
                                            <span class="detail-value">{{ $employee->birth_date->age }} tahun</span>
                                        </div>

                                        <div class="detail-row">
                                            <span class="detail-label">Nomor KTP</span>
                                            <span class="detail-value">{{ $employee->nik }}</span>
                                        </div>

                                        <div class="detail-row">
                                            <span class="detail-label">Alamat</span>
                                            <span class="detail-value">{{ $employee->address }}</span>
                                        </div>
                                    </div>
                                </section>

                                <section class="detail-section">
                                    <div class="detail-section__heading">
                                        <span>▣</span>
                                        Penempatan dan Kontrak
                                    </div>

                                    <div class="detail-list">
                                        <div class="detail-row">
                                            <span class="detail-label">Perusahaan Penempatan</span>
                                            <span class="detail-value">{{ $employee->placement_company }}</span>
                                        </div>

                                        <div class="detail-row">
                                            <span class="detail-label">Bagian / Divisi</span>
                                            <span class="detail-value">{{ $employee->department }}</span>
                                        </div>

                                        <div class="detail-row">
                                            <span class="detail-label">Awal Kontrak</span>
                                            <span class="detail-value">
                                                {{ $employee->contract_start->translatedFormat('d F Y') }}
                                            </span>
                                        </div>

                                        <div class="detail-row">
                                            <span class="detail-label">Akhir Kontrak</span>
                                            <span class="detail-value">
                                                {{ $employee->contract_end->translatedFormat('d F Y') }}
                                            </span>
                                        </div>

                                        <div class="detail-row">
                                            <span class="detail-label">Status Kontrak</span>
                                            <span class="detail-value">{{ $contractText }}</span>
                                        </div>

                                        <div class="detail-row">
                                            <span class="detail-label">Status Karyawan</span>
                                            <span class="detail-value">{{ $employeeStatusText }}</span>
                                        </div>
                                    </div>
                                </section>

                                <section class="detail-section detail-section--full">
                                    <div class="detail-section__heading">
                                        <span>◈</span>
                                        Data Bank
                                    </div>

                                    <div class="detail-list">
                                        <div class="detail-row">
                                            <span class="detail-label">Nama Bank</span>
                                            <span class="detail-value">{{ $employee->bank_name }}</span>
                                        </div>

                                        <div class="detail-row">
                                            <span class="detail-label">Nomor Rekening</span>
                                            <span class="detail-value">{{ $employee->bank_account_number }}</span>
                                        </div>

                                        <div class="detail-row">
                                            <span class="detail-label">Nama Pemilik Rekening</span>
                                            <span class="detail-value">{{ $employee->bank_account_holder }}</span>
                                        </div>
                                    </div>
                                </section>

                                <section class="detail-section detail-section--full">
                                    <div class="detail-section__heading">
                                        <span>▤</span>
                                        Dokumen Karyawan
                                    </div>

                                    <div class="document-grid">
                                        <div class="document-card">
                                            <div class="document-card__icon">◉</div>
                                            <h3>Foto Wajah</h3>
                                            <p>Foto identitas karyawan.</p>

                                            @if ($employee->face_photo_path)
                                                <a
                                                    href="{{ route('employees.document', ['employee' => $employee->id, 'type' => 'face']) }}"
                                                    target="_blank"
                                                    rel="noopener"
                                                    class="document-button"
                                                >
                                                    Lihat Foto
                                                </a>
                                            @else
                                                <span class="document-unavailable">Tidak tersedia</span>
                                            @endif
                                        </div>

                                        <div class="document-card">
                                            <div class="document-card__icon">▣</div>
                                            <h3>Dokumen KTP</h3>
                                            <p>Dokumen identitas karyawan.</p>

                                            @if ($employee->ktp_file_path)
                                                <a
                                                    href="{{ route('employees.document', ['employee' => $employee->id, 'type' => 'ktp']) }}"
                                                    target="_blank"
                                                    rel="noopener"
                                                    class="document-button"
                                                >
                                                    Lihat KTP
                                                </a>
                                            @else
                                                <span class="document-unavailable">Tidak tersedia</span>
                                            @endif
                                        </div>

                                        <div class="document-card">
                                            <div class="document-card__icon">▤</div>
                                            <h3>Dokumen KK</h3>
                                            <p>Dokumen pendukung karyawan.</p>

                                            @if ($employee->kk_file_path)
                                                <a
                                                    href="{{ route('employees.document', ['employee' => $employee->id, 'type' => 'kk']) }}"
                                                    target="_blank"
                                                    rel="noopener"
                                                    class="document-button"
                                                >
                                                    Lihat KK
                                                </a>
                                            @else
                                                <span class="document-unavailable">Tidak tersedia</span>
                                            @endif
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($employees->hasPages())
            <div class="pagination">
                <span class="pagination-info">
                    Menampilkan {{ $employees->firstItem() }}–{{ $employees->lastItem() }}
                    dari {{ $employees->total() }} data karyawan
                </span>

                <div class="pagination-actions">
                    <a
                        href="{{ $employees->previousPageUrl() ?? '#' }}"
                        wire:navigate
                        class="pagination-button {{ $employees->onFirstPage() ? 'pagination-button--disabled' : '' }}"
                    >
                        ← Sebelumnya
                    </a>

                    <span class="pagination-button">
                        {{ $employees->currentPage() }} / {{ $employees->lastPage() }}
                    </span>

                    <a
                        href="{{ $employees->nextPageUrl() ?? '#' }}"
                        wire:navigate
                        class="pagination-button {{ $employees->hasMorePages() ? '' : 'pagination-button--disabled' }}"
                    >
                        Berikutnya →
                    </a>
                </div>
            </div>
        @endif
    @else
        <section class="empty-state">
            <div class="empty-icon">{{ $hasFilter ? '⌕' : '◉' }}</div>

            @if ($hasFilter)
                <h2>Data karyawan tidak ditemukan</h2>

                <p>
                    Tidak ada data yang sesuai dengan kata pencarian
                    atau status yang dipilih.
                </p>

                <a href="{{ route('employees.index') }}" wire:navigate class="empty-button">
                    Reset Pencarian
                </a>
            @else
                <h2>Belum ada data karyawan</h2>

                <p>
                    Tambahkan data karyawan pertama untuk mulai menyimpan
                    informasi pribadi, penempatan, kontrak, rekening,
                    dan dokumen pendukung.
                </p>

                <a href="{{ route('employees.create') }}" wire:navigate class="empty-button">
                    <span>＋</span>
                    Input Karyawan Pertama
                </a>
            @endif
        </section>
    @endif
</section>
@endsection

@push('scripts')
<script data-navigate-once>
    (function () {
        if (window.__kcwEmployeeIndexEventsBound) {
            return;
        }

        window.__kcwEmployeeIndexEventsBound = true;

        function closeModal(modal) {
            if (!modal) {
                return;
            }

            modal.classList.remove('show');
            document.body.style.overflow = '';
        }

        function closeAllModals() {
            document.querySelectorAll('[data-modal].show').forEach(function (modal) {
                closeModal(modal);
            });
        }

        function openModal(modal) {
            if (!modal) {
                return;
            }

            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        document.addEventListener('click', function (event) {
            const detailButton = event.target.closest('[data-modal-target]');

            if (detailButton) {
                openModal(document.getElementById(detailButton.dataset.modalTarget));
                return;
            }

            const closeButton = event.target.closest('[data-modal-close]');

            if (closeButton) {
                closeModal(closeButton.closest('[data-modal]'));
                return;
            }

            const modal = event.target.closest('[data-modal]');

            if (modal && event.target === modal) {
                closeModal(modal);
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeAllModals();
            }
        });

        document.addEventListener('submit', function (event) {
            const form = event.target.closest('[data-kcw-filter-form]');

            if (!form) {
                return;
            }

            event.preventDefault();

            const url = new URL(form.action, window.location.origin);
            const formData = new FormData(form);

            formData.forEach(function (value, key) {
                const normalizedValue = String(value).trim();

                if (normalizedValue !== '') {
                    url.searchParams.set(key, normalizedValue);
                }
            });

            if (window.Livewire && typeof window.Livewire.navigate === 'function') {
                window.Livewire.navigate(url.toString());
                return;
            }

            window.location.assign(url.toString());
        });

        document.addEventListener('livewire:navigating', closeAllModals);
    })();
</script>

<script data-navigate-once>
    (function () {
        function runEmployeeIndexAnimation() {
            const page = document.querySelector('.employee-content');

            if (!page) {
                return;
            }

            page.classList.remove('employee-motion-ready');
            page.classList.add('employee-motion-preparing');

            window.requestAnimationFrame(function () {
                window.requestAnimationFrame(function () {
                    page.classList.remove('employee-motion-preparing');
                    page.classList.add('employee-motion-ready');
                });
            });
        }

        if (!window.__kcwEmployeeIndexMotionBound) {
            window.__kcwEmployeeIndexMotionBound = true;

            document.addEventListener('DOMContentLoaded', runEmployeeIndexAnimation);
            document.addEventListener('livewire:navigated', runEmployeeIndexAnimation);
        }

        runEmployeeIndexAnimation();
    })();
</script>

@endpush
