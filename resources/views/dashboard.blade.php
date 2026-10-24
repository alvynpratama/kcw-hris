@extends('layouts.app')

@section('page-title', 'Dashboard | PT Karunia Cipta Wasantara')
@section('topbar-title', 'Dashboard')
@section('topbar-subtitle', 'Ringkasan operasional karyawan.')

@php
    $chartTotal = max($totalEmployeeCount, 1);
    $activePercentage = round(($activeEmployeeCount / $chartTotal) * 100);
    $upcomingPercentage = round(($upcomingContractCount / $chartTotal) * 100);
    $expiredPercentage = max(0, 100 - $activePercentage - $upcomingPercentage);

    $activeStop = $activePercentage;
    $upcomingStop = $activePercentage + $upcomingPercentage;

    $priorityTotal = $upcomingWithin30Count + $expiringContractCount + $expiredContractCount;
    $priorityMax = max($upcomingWithin30Count, $expiringContractCount, $expiredContractCount, 1);
    $placementMax = max((int) ($placementDistribution->max('total') ?? 0), 1);

    /*
    |--------------------------------------------------------------------------
    | PENANDA SINKRONISASI DASHBOARD
    |--------------------------------------------------------------------------
    | Nilai ini dibandingkan oleh JavaScript setiap 15 detik. Dashboard hanya
    | diperbarui melalui Livewire ketika ada data yang benar-benar berubah.
    */
    $dashboardSignature = md5(json_encode([
        'summary' => [
            $totalEmployeeCount,
            $activeEmployeeCount,
            $upcomingContractCount,
            $upcomingWithin30Count,
            $expiringContractCount,
            $expiredContractCount,
            $placementCompanyCount,
        ],
        'placements' => $placementDistribution
            ->map(fn ($placement) => [
                'company' => $placement->placement_company,
                'total' => (int) $placement->total,
            ])
            ->values()
            ->all(),
        'attention' => $attentionContracts
            ->map(fn ($employee) => [
                'id' => $employee->id,
                'name' => $employee->full_name,
                'phone' => $employee->phone,
                'placement' => $employee->placement_company,
                'start' => optional($employee->contract_start)->format('Y-m-d'),
                'end' => optional($employee->contract_end)->format('Y-m-d'),
                'photo' => $employee->face_photo_path,
                'updated' => optional($employee->updated_at)->format('Y-m-d H:i:s'),
            ])
            ->values()
            ->all(),
    ]));
@endphp

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

    body {
        margin: 0;
        min-height: 100vh;
        color: var(--brown);
        font-family: "Segoe UI", Arial, sans-serif;
        background:
            radial-gradient(circle at 7% 0%, rgba(238, 205, 107, 0.20), transparent 25%),
            radial-gradient(circle at 96% 100%, rgba(191, 118, 21, 0.08), transparent 28%),
            linear-gradient(135deg, #fffdf7 0%, #fbf3df 100%);
    }

    a { color: inherit; text-decoration: none; }

    .app-layout {
        min-height: 100vh;
        display: grid;
        grid-template-columns: 270px minmax(0, 1fr);
    }

    .main { grid-column: 2; min-width: 0; }
    .dashboard-content { padding: 34px 38px 52px; }

    /* HERO */
    .dashboard-hero {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 28px;
        margin-bottom: 22px;
        padding: 27px 30px;
        border: 1px solid rgba(142, 94, 18, 0.32);
        border-radius: 22px;
        color: #ffffff;
        background:
            linear-gradient(115deg, rgba(255, 255, 255, 0.05) 0 57%, transparent 57%),
            linear-gradient(135deg, #2b190c 0%, #69451f 58%, #b8892c 100%);
        box-shadow: 0 19px 42px rgba(89, 53, 18, 0.18);
    }

    .dashboard-hero::before,
    .dashboard-hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .dashboard-hero::before {
        top: -126px;
        right: -80px;
        width: 270px;
        height: 270px;
        border: 1px solid rgba(255,255,255,0.15);
        box-shadow: 0 0 0 34px rgba(255,255,255,0.035);
    }

    .dashboard-hero::after {
        right: 168px;
        bottom: -112px;
        width: 178px;
        height: 178px;
        border: 1px solid rgba(255,255,255,0.08);
    }

    .dashboard-hero__content,
    .dashboard-hero__side { position: relative; z-index: 1; }

    .dashboard-hero__eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
        color: rgba(255,255,255,0.76);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.8px;
        text-transform: uppercase;
    }

    .dashboard-hero__dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #f8d76d;
        box-shadow: 0 0 0 5px rgba(248,215,109,0.14);
    }

    .dashboard-hero h1 {
        margin: 0;
        font-size: clamp(25px, 3vw, 35px);
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -1px;
    }

    .hero-date {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 11px;
        color: rgba(255,255,255,0.80);
        font-size: 11px;
        font-weight: 700;
    }

    .hero-date span {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #efca70;
    }

    .hero-actions {
        display: flex;
        gap: 9px;
        margin-top: 16px;
    }

    .hero-button,
    .hero-button--secondary {
        min-height: 39px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 0 13px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 850;
        transition: background .2s ease, color .2s ease, border-color .2s ease;
    }

    .hero-button {
        border: 1px solid rgba(255,255,255,0.36);
        color: #5b3c18;
        background: #fff9e7;
    }

    .hero-button:hover { color: #ffffff; border-color: #5b3919; background: #5b3919; }

    .hero-button--secondary {
        border: 1px solid rgba(255,255,255,0.30);
        color: #ffffff;
        background: rgba(255,255,255,0.09);
    }

    .hero-button--secondary:hover { background: rgba(255,255,255,0.18); }

    .hero-priority {
        width: 206px;
        padding: 15px 16px;
        border: 1px solid rgba(255,255,255,0.22);
        border-radius: 15px;
        background: rgba(255,255,255,0.10);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    .hero-priority__label {
        display: block;
        color: rgba(255,255,255,0.68);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.55px;
        text-transform: uppercase;
    }

    .hero-priority__value {
        display: block;
        margin-top: 5px;
        color: #ffffff;
        font-size: 28px;
        font-weight: 850;
        letter-spacing: -0.8px;
    }

    .hero-priority__note {
        display: block;
        margin-top: 4px;
        color: rgba(255,255,255,0.72);
        font-size: 10px;
    }

    /* KPI */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 22px;
    }

    .stat-card {
        position: relative;
        overflow: hidden;
        min-height: 146px;
        padding: 18px;
        border: 1px solid var(--gold-line);
        border-radius: 17px;
        background: rgba(255,255,255,0.93);
        box-shadow: 0 8px 25px rgba(86,52,20,0.05);
        transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        border-color: #d4b36d;
        box-shadow: var(--shadow-strong);
    }

    .stat-card::after {
        content: "";
        position: absolute;
        right: -31px;
        bottom: -39px;
        width: 110px;
        height: 110px;
        border: 1px solid rgba(200,154,43,0.12);
        border-radius: 50%;
        box-shadow: 0 0 0 23px rgba(200,154,43,0.035);
        pointer-events: none;
    }

    .stat-card__top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 10px;
    }

    .stat-card__label {
        color: var(--muted);
        font-size: 10px;
        font-weight: 800;
        line-height: 1.45;
        text-transform: uppercase;
        letter-spacing: 0.35px;
    }

    .stat-card__icon {
        width: 36px;
        height: 36px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
        border: 1px solid #eedca9;
        border-radius: 11px;
        color: var(--gold-deep);
        background: #fff8e5;
        font-size: 15px;
        font-weight: 850;
    }

    .stat-card__value {
        position: relative;
        z-index: 1;
        display: block;
        margin-top: 15px;
        color: var(--brown);
        font-size: 32px;
        font-weight: 850;
        letter-spacing: -1.3px;
    }

    .stat-card__note {
        position: relative;
        z-index: 1;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 7px;
        font-size: 10px;
        font-weight: 800;
    }

    .note-green { color: var(--green); }
    .note-gold { color: var(--gold-deep); }
    .note-orange { color: var(--orange); }
    .note-red { color: var(--red); }

    /* VISUAL SUMMARY */
    .visual-grid {
        display: grid;
        grid-template-columns: minmax(280px, 0.92fr) minmax(360px, 1.28fr);
        gap: 18px;
        margin-bottom: 22px;
    }

    .visual-card,
    .dashboard-section {
        overflow: hidden;
        border: 1px solid var(--gold-line);
        border-radius: 18px;
        background: rgba(255,255,255,0.92);
        box-shadow: var(--shadow);
    }

    .visual-card__header,
    .dashboard-section__header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 20px;
        border-bottom: 1px solid var(--line);
        background: linear-gradient(135deg, #fffdf8 0%, #fff8e7 100%);
    }

    .visual-card__header h2,
    .dashboard-section__header h2 {
        margin: 0;
        color: var(--brown);
        font-size: 15px;
        letter-spacing: -0.2px;
    }

    .visual-card__header span {
        color: var(--muted);
        font-size: 10px;
        font-weight: 750;
    }

    .status-overview {
        display: grid;
        grid-template-columns: 150px 1fr;
        align-items: center;
        gap: 17px;
        padding: 20px;
    }

    .status-donut {
        position: relative;
        width: 142px;
        height: 142px;
        display: grid;
        place-items: center;
        margin: 0 auto;
        border-radius: 50%;
        background:
            conic-gradient(
                var(--green) 0 var(--active-stop),
                var(--gold) var(--active-stop) var(--upcoming-stop),
                var(--red) var(--upcoming-stop) 100%
            );
    }

    .status-donut--empty { background: #f0e7d5; }

    .status-donut::before {
        content: "";
        position: absolute;
        width: 105px;
        height: 105px;
        border: 1px solid #f0e4c8;
        border-radius: 50%;
        background: #fffdf8;
    }

    .status-donut__content {
        position: relative;
        z-index: 1;
        display: grid;
        gap: 1px;
        text-align: center;
    }

    .status-donut__content strong {
        color: var(--brown);
        font-size: 26px;
        letter-spacing: -0.9px;
    }

    .status-donut__content span {
        color: var(--muted);
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.45px;
    }

    .status-legend { display: grid; gap: 10px; }

    .status-legend__item {
        display: grid;
        grid-template-columns: 10px 1fr auto;
        align-items: center;
        gap: 8px;
    }

    .status-legend__dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
    }

    .status-legend__dot--active { background: var(--green); }
    .status-legend__dot--upcoming { background: var(--gold); }
    .status-legend__dot--expired { background: var(--red); }

    .status-legend__label {
        color: var(--brown-soft);
        font-size: 11px;
        font-weight: 750;
    }

    .status-legend__value {
        color: var(--brown);
        font-size: 13px;
        font-weight: 850;
    }

    .placement-chart { padding: 18px 20px 20px; }

    .placement-chart__empty {
        display: grid;
        min-height: 166px;
        place-items: center;
        color: var(--muted);
        font-size: 12px;
        text-align: center;
    }

    .placement-row + .placement-row { margin-top: 14px; }

    .placement-row__top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 7px;
    }

    .placement-row__name {
        overflow: hidden;
        color: var(--brown-soft);
        font-size: 11px;
        font-weight: 750;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .placement-row__value {
        flex-shrink: 0;
        color: var(--gold-deep);
        font-size: 11px;
        font-weight: 850;
    }

    .placement-row__track {
        height: 8px;
        overflow: hidden;
        border-radius: 999px;
        background: #f5ecdc;
    }

    .placement-row__bar {
        width: var(--bar-width);
        height: 100%;
        border-radius: inherit;
        background: linear-gradient(90deg, #b98228, #e1bd65);
    }

    /* PRIORITAS KONTRAK — DIAGRAM BATANG HORIZONTAL */
    .priority-section {
        position: relative;
        overflow: hidden;
        margin-bottom: 22px;
        padding: 0;
        border: 1px solid var(--gold-line);
        border-radius: 18px;
        background: rgba(255,255,255,0.94);
        box-shadow: var(--shadow);
    }

    .priority-section::after {
        content: "";
        position: absolute;
        top: -94px;
        right: -78px;
        width: 192px;
        height: 192px;
        border: 1px solid rgba(189,138,41,0.10);
        border-radius: 50%;
        box-shadow: 0 0 0 28px rgba(189,138,41,0.025);
        pointer-events: none;
    }

    .priority-section__header {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 19px 20px 17px;
        border-bottom: 1px solid var(--line);
        background: linear-gradient(135deg, #fffdf8 0%, #fff8e7 100%);
    }

    .priority-section__heading {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }

    .priority-section__icon {
        width: 34px;
        height: 34px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
        border: 1px solid #ecd79d;
        border-radius: 11px;
        color: var(--gold-deep);
        background: #fff7df;
        font-size: 15px;
        font-weight: 850;
    }

    .priority-section__header h2 {
        margin: 0;
        color: var(--brown);
        font-size: 15px;
        letter-spacing: -0.2px;
    }

    .priority-section__header p {
        margin: 3px 0 0;
        color: var(--muted);
        font-size: 10px;
        font-weight: 650;
    }

    .priority-section__total {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 35px;
        height: 31px;
        padding: 0 10px;
        border: 1px solid #eedda9;
        border-radius: 999px;
        color: var(--gold-deep);
        background: var(--gold-soft);
        font-size: 12px;
        font-weight: 850;
    }

    .priority-bars {
        position: relative;
        z-index: 1;
        display: grid;
        gap: 15px;
        padding: 20px;
    }

    .priority-bar-row {
        display: grid;
        grid-template-columns: minmax(170px, 0.82fr) minmax(180px, 1.7fr) 36px;
        align-items: center;
        gap: 14px;
    }

    .priority-bar__label {
        display: flex;
        align-items: center;
        gap: 9px;
        min-width: 0;
    }

    .priority-bar__marker {
        width: 10px;
        height: 10px;
        flex-shrink: 0;
        border-radius: 50%;
        box-shadow: 0 0 0 4px rgba(189,138,41,0.11);
    }

    .priority-bar-row--upcoming .priority-bar__marker { background: var(--gold); }
    .priority-bar-row--expiring .priority-bar__marker { background: var(--orange); box-shadow: 0 0 0 4px rgba(184,109,20,0.11); }
    .priority-bar-row--expired .priority-bar__marker { background: var(--red); box-shadow: 0 0 0 4px rgba(184,59,50,0.10); }

    .priority-bar__label span {
        overflow: hidden;
        color: var(--brown-soft);
        font-size: 11px;
        font-weight: 800;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .priority-bar__chart {
        position: relative;
        min-width: 0;
    }

    .priority-bar__track {
        height: 15px;
        overflow: hidden;
        border: 1px solid #f0e4cf;
        border-radius: 999px;
        background: #f8f1e4;
    }

    .priority-bar__fill {
        width: max(2.5%, var(--bar-width));
        height: 100%;
        border-radius: inherit;
        transition: width .25s ease;
    }

    .priority-bar-row--upcoming .priority-bar__fill {
        background: linear-gradient(90deg, #b98228 0%, #e1bd65 100%);
    }

    .priority-bar-row--expiring .priority-bar__fill {
        background: linear-gradient(90deg, #b86d14 0%, #efad51 100%);
    }

    .priority-bar-row--expired .priority-bar__fill {
        background: linear-gradient(90deg, #b83b32 0%, #e88578 100%);
    }

    .priority-bar__value {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 29px;
        border-radius: 9px;
        color: var(--brown);
        background: #fffaf0;
        font-size: 13px;
        font-weight: 850;
    }

    .priority-bar-row--upcoming .priority-bar__value { border: 1px solid #ecd79d; }
    .priority-bar-row--expiring .priority-bar__value { border: 1px solid #efcf9e; }
    .priority-bar-row--expired .priority-bar__value { border: 1px solid #efc4be; }


    /* ATTENTION LIST */
    .dashboard-section__header { align-items: flex-start; }

    .dashboard-section__header p {
        margin: 5px 0 0;
        color: var(--muted);
        font-size: 11px;
        line-height: 1.55;
    }

    .section-link {
        min-height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        flex-shrink: 0;
        padding: 0 11px;
        border: 1px solid #e4c979;
        border-radius: 9px;
        color: var(--gold-deep);
        background: #fff9e8;
        font-size: 10px;
        font-weight: 850;
        white-space: nowrap;
        transition: background .2s ease, color .2s ease;
    }

    .section-link:hover { color: #ffffff; background: var(--gold-deep); }

    .contract-list { padding: 4px 19px 15px; }

    /*
    |--------------------------------------------------------------------------
    | DAFTAR KONTRAK — KOLOM TERKUNCI AGAR RAPI DAN SEJAJAR
    |--------------------------------------------------------------------------
    | Penggunaan minmax(0, ...) mencegah panjang nama/perusahaan mengubah
    | lebar grid tiap baris. Semua kolom memiliki titik awal yang sama.
    */
    .contract-row {
        width: 100%;
        display: grid;
        grid-template-columns: minmax(0, 1.42fr) minmax(0, 0.96fr) minmax(0, 0.76fr) 142px;
        align-items: stretch;
        gap: 18px;
        padding: 13px 5px;
        border-bottom: 1px solid #f0e6d5;
        transition: background .18s ease;
    }

    .contract-row:last-child { border-bottom: 0; }
    .contract-row:hover { border-radius: 12px; background: #fffdf8; }

    .contract-person,
    .contract-row__placement,
    .contract-row__date {
        min-width: 0;
        min-height: 56px;
    }

    .contract-person {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .contract-row__placement,
    .contract-row__date {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .contract-avatar {
        width: 41px;
        height: 54px;
        overflow: hidden;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        border: 2px solid #ffffff;
        border-radius: 10px;
        color: var(--gold-deep);
        background: var(--gold-soft);
        font-size: 14px;
        font-weight: 850;
        box-shadow: 0 5px 12px rgba(68,41,14,0.10);
    }

    .contract-avatar img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        object-position: center top;
    }

    .contract-person__name {
        display: block;
        overflow: hidden;
        color: var(--brown);
        font-size: 12px;
        font-weight: 850;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .contract-person__phone {
        display: block;
        margin-top: 4px;
        color: var(--muted);
        font-size: 10px;
    }

    .contract-meta-label {
        display: block;
        margin: 0 0 4px;
        color: var(--muted);
        font-size: 10px;
        line-height: 1.2;
    }

    .contract-meta-value {
        display: block;
        overflow: hidden;
        color: var(--brown-soft);
        font-size: 11px;
        font-weight: 750;
        line-height: 1.35;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .contract-status {
        align-self: center;
        justify-self: stretch;
        min-height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 0;
        padding: 8px 10px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 850;
        line-height: 1.2;
        text-align: center;
    }

    .contract-status.warning { color: var(--orange); background: var(--orange-soft); }
    .contract-status.danger { color: var(--red); background: var(--red-soft); }
    .contract-status.pending { color: var(--gold-deep); background: var(--gold-soft); }

    .empty-contract { padding: 48px 24px 52px; text-align: center; }
    .empty-contract__icon {
        width: 58px;
        height: 58px;
        display: grid;
        place-items: center;
        margin: 0 auto 14px;
        border: 1px solid #ecdcae;
        border-radius: 17px;
        color: var(--gold-deep);
        background: var(--gold-soft);
        font-size: 24px;
    }
    .empty-contract h3 { margin: 0; color: var(--brown); font-size: 15px; }
    .empty-contract p { margin: 8px auto 16px; color: var(--muted); font-size: 11px; }
    .empty-contract__button {
        min-height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 0 13px;
        border-radius: 10px;
        color: #ffffff;
        background: var(--brown);
        font-size: 10px;
        font-weight: 850;
    }
    .empty-contract__button:hover { color: #ffffff; background: #4d2d13; }


    /*
    |--------------------------------------------------------------------------
    | ANIMASI MASUK DASHBOARD
    |--------------------------------------------------------------------------
    | Animasi hanya berjalan saat halaman dimuat atau saat navigasi Livewire.
    | Tidak ada animasi berulang agar dashboard tetap profesional dan nyaman.
    */
    @keyframes dashboard-hero-enter {
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

    @keyframes dashboard-card-enter {
        from {
            opacity: 0;
            transform: translateY(16px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes dashboard-pop-enter {
        from {
            opacity: 0;
            transform: scale(0.90);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes dashboard-row-enter {
        from {
            opacity: 0;
            transform: translateX(-14px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes dashboard-bar-grow {
        from { transform: scaleX(0); }
        to { transform: scaleX(1); }
    }

    .dashboard-content:not(.dashboard-motion-ready) .dashboard-hero,
    .dashboard-content:not(.dashboard-motion-ready) .stat-card,
    .dashboard-content:not(.dashboard-motion-ready) .visual-card,
    .dashboard-content:not(.dashboard-motion-ready) .priority-section,
    .dashboard-content:not(.dashboard-motion-ready) .dashboard-section,
    .dashboard-content:not(.dashboard-motion-ready) .status-donut,
    .dashboard-content:not(.dashboard-motion-ready) .status-legend__item,
    .dashboard-content:not(.dashboard-motion-ready) .placement-row,
    .dashboard-content:not(.dashboard-motion-ready) .priority-bar-row,
    .dashboard-content:not(.dashboard-motion-ready) .contract-row {
        opacity: 0;
    }

    .dashboard-content.dashboard-motion-ready .dashboard-hero {
        animation: dashboard-hero-enter 0.72s cubic-bezier(.22, 1, .36, 1) both;
    }

    .dashboard-content.dashboard-motion-ready .dashboard-hero__content {
        animation: dashboard-card-enter 0.52s cubic-bezier(.22, 1, .36, 1) 0.12s both;
    }

    .dashboard-content.dashboard-motion-ready .dashboard-hero__side {
        animation: dashboard-pop-enter 0.52s cubic-bezier(.22, 1, .36, 1) 0.20s both;
    }

    .dashboard-content.dashboard-motion-ready .stats-grid .stat-card {
        animation: dashboard-card-enter 0.56s cubic-bezier(.22, 1, .36, 1) both;
    }

    .dashboard-content.dashboard-motion-ready .stats-grid .stat-card:nth-child(1) { animation-delay: 0.12s; }
    .dashboard-content.dashboard-motion-ready .stats-grid .stat-card:nth-child(2) { animation-delay: 0.19s; }
    .dashboard-content.dashboard-motion-ready .stats-grid .stat-card:nth-child(3) { animation-delay: 0.26s; }
    .dashboard-content.dashboard-motion-ready .stats-grid .stat-card:nth-child(4) { animation-delay: 0.33s; }

    .dashboard-content.dashboard-motion-ready .visual-grid .visual-card {
        animation: dashboard-card-enter 0.62s cubic-bezier(.22, 1, .36, 1) both;
    }

    .dashboard-content.dashboard-motion-ready .visual-grid .visual-card:nth-child(1) { animation-delay: 0.36s; }
    .dashboard-content.dashboard-motion-ready .visual-grid .visual-card:nth-child(2) { animation-delay: 0.44s; }

    .dashboard-content.dashboard-motion-ready .status-donut {
        animation: dashboard-pop-enter 0.68s cubic-bezier(.22, 1, .36, 1) 0.54s both;
    }

    .dashboard-content.dashboard-motion-ready .status-legend__item {
        animation: dashboard-row-enter 0.46s cubic-bezier(.22, 1, .36, 1) both;
    }

    .dashboard-content.dashboard-motion-ready .status-legend__item:nth-child(1) { animation-delay: 0.57s; }
    .dashboard-content.dashboard-motion-ready .status-legend__item:nth-child(2) { animation-delay: 0.64s; }
    .dashboard-content.dashboard-motion-ready .status-legend__item:nth-child(3) { animation-delay: 0.71s; }

    .dashboard-content.dashboard-motion-ready .placement-row {
        animation: dashboard-row-enter 0.46s cubic-bezier(.22, 1, .36, 1) both;
    }

    .dashboard-content.dashboard-motion-ready .placement-row:nth-child(1) { animation-delay: 0.56s; }
    .dashboard-content.dashboard-motion-ready .placement-row:nth-child(2) { animation-delay: 0.62s; }
    .dashboard-content.dashboard-motion-ready .placement-row:nth-child(3) { animation-delay: 0.68s; }
    .dashboard-content.dashboard-motion-ready .placement-row:nth-child(4) { animation-delay: 0.74s; }
    .dashboard-content.dashboard-motion-ready .placement-row:nth-child(5) { animation-delay: 0.80s; }

    .dashboard-content.dashboard-motion-ready .placement-row__bar,
    .dashboard-content.dashboard-motion-ready .priority-bar__fill {
        transform-origin: left center;
        animation: dashboard-bar-grow 0.82s cubic-bezier(.22, 1, .36, 1) both;
    }

    .dashboard-content.dashboard-motion-ready .placement-row:nth-child(1) .placement-row__bar { animation-delay: 0.63s; }
    .dashboard-content.dashboard-motion-ready .placement-row:nth-child(2) .placement-row__bar { animation-delay: 0.69s; }
    .dashboard-content.dashboard-motion-ready .placement-row:nth-child(3) .placement-row__bar { animation-delay: 0.75s; }
    .dashboard-content.dashboard-motion-ready .placement-row:nth-child(4) .placement-row__bar { animation-delay: 0.81s; }
    .dashboard-content.dashboard-motion-ready .placement-row:nth-child(5) .placement-row__bar { animation-delay: 0.87s; }

    .dashboard-content.dashboard-motion-ready .priority-section {
        animation: dashboard-card-enter 0.62s cubic-bezier(.22, 1, .36, 1) 0.50s both;
    }

    .dashboard-content.dashboard-motion-ready .priority-bar-row {
        animation: dashboard-row-enter 0.48s cubic-bezier(.22, 1, .36, 1) both;
    }

    .dashboard-content.dashboard-motion-ready .priority-bar-row:nth-child(1) { animation-delay: 0.62s; }
    .dashboard-content.dashboard-motion-ready .priority-bar-row:nth-child(2) { animation-delay: 0.70s; }
    .dashboard-content.dashboard-motion-ready .priority-bar-row:nth-child(3) { animation-delay: 0.78s; }

    .dashboard-content.dashboard-motion-ready .priority-bar-row:nth-child(1) .priority-bar__fill { animation-delay: 0.71s; }
    .dashboard-content.dashboard-motion-ready .priority-bar-row:nth-child(2) .priority-bar__fill { animation-delay: 0.79s; }
    .dashboard-content.dashboard-motion-ready .priority-bar-row:nth-child(3) .priority-bar__fill { animation-delay: 0.87s; }

    .dashboard-content.dashboard-motion-ready .dashboard-section {
        animation: dashboard-card-enter 0.62s cubic-bezier(.22, 1, .36, 1) 0.66s both;
    }

    .dashboard-content.dashboard-motion-ready .contract-row {
        animation: dashboard-row-enter 0.46s cubic-bezier(.22, 1, .36, 1) both;
    }

    .dashboard-content.dashboard-motion-ready .contract-row:nth-child(1) { animation-delay: 0.78s; }
    .dashboard-content.dashboard-motion-ready .contract-row:nth-child(2) { animation-delay: 0.85s; }
    .dashboard-content.dashboard-motion-ready .contract-row:nth-child(3) { animation-delay: 0.92s; }
    .dashboard-content.dashboard-motion-ready .contract-row:nth-child(4) { animation-delay: 0.99s; }
    .dashboard-content.dashboard-motion-ready .contract-row:nth-child(5) { animation-delay: 1.06s; }
    .dashboard-content.dashboard-motion-ready .contract-row:nth-child(6) { animation-delay: 1.13s; }

    @media (prefers-reduced-motion: reduce) {
        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
            scroll-behavior: auto !important;
        }

        .dashboard-content:not(.dashboard-motion-ready) .dashboard-hero,
        .dashboard-content:not(.dashboard-motion-ready) .stat-card,
        .dashboard-content:not(.dashboard-motion-ready) .visual-card,
        .dashboard-content:not(.dashboard-motion-ready) .priority-section,
        .dashboard-content:not(.dashboard-motion-ready) .dashboard-section,
        .dashboard-content:not(.dashboard-motion-ready) .status-donut,
        .dashboard-content:not(.dashboard-motion-ready) .status-legend__item,
        .dashboard-content:not(.dashboard-motion-ready) .placement-row,
        .dashboard-content:not(.dashboard-motion-ready) .priority-bar-row,
        .dashboard-content:not(.dashboard-motion-ready) .contract-row {
            opacity: 1;
        }
    }

    @media (max-width: 1280px) {
        .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 1100px) {
        .visual-grid { grid-template-columns: 1fr; }
        .contract-row { grid-template-columns: minmax(0, 1.28fr) minmax(0, 0.82fr) 132px; }
        .contract-row__placement { display: none; }
    }

    @media (max-width: 1050px) {
        .app-layout { grid-template-columns: 1fr; }
        .main { grid-column: 1; }
    }

    @media (max-width: 760px) {
        .dashboard-content { padding: 24px 20px 40px; }
        .dashboard-hero { align-items: flex-start; flex-direction: column; padding: 24px 22px; }
        .hero-priority { width: 100%; }
        .hero-actions { width: 100%; }
        .hero-button, .hero-button--secondary { flex: 1; }
        .dashboard-section__header { flex-direction: column; }
        .section-link { width: 100%; }
        .contract-row { grid-template-columns: 1fr; gap: 9px; padding: 15px 4px; }
        .contract-row__placement { display: flex; }
        .contract-person,
        .contract-row__placement,
        .contract-row__date { min-height: auto; }
        .contract-status { width: max-content; min-width: 112px; justify-self: start; }
    }

    @media (max-width: 620px) {
        .priority-section__header { align-items: flex-start; }
        .priority-bars { padding: 16px; }
        .priority-bar-row {
            grid-template-columns: minmax(0, 1fr) 34px;
            gap: 8px 10px;
        }
        .priority-bar__chart { grid-column: 1 / -1; grid-row: 2; }
    }

    @media (max-width: 560px) {
        .stats-grid { grid-template-columns: 1fr; }
        .status-overview { grid-template-columns: 1fr; }
        .hero-actions { flex-direction: column; }
        .hero-button, .hero-button--secondary { width: 100%; }
    }
</style>
@endpush

@section('content')
<section class="dashboard-content" data-dashboard-signature="{{ $dashboardSignature }}">
    <section class="dashboard-hero">
        <div class="dashboard-hero__content">
            <div class="dashboard-hero__eyebrow">
                <span class="dashboard-hero__dot"></span>
                PT Karunia Cipta Wasantara
            </div>

            <h1>Selamat datang, CEO.</h1>

            <div class="hero-date">
                <span></span>
                {{ now()->translatedFormat('l, d F Y') }}
            </div>

            <div class="hero-actions">
                <a href="{{ route('employees.create') }}" wire:navigate class="hero-button">
                    <span>＋</span>
                    Input Karyawan
                </a>

                <a href="{{ route('employees.index') }}" wire:navigate class="hero-button--secondary">
                    Data Karyawan
                    <span>→</span>
                </a>
            </div>
        </div>

        <div class="dashboard-hero__side">
            <div class="hero-priority">
                <span class="hero-priority__label">Perlu Tindakan</span>
                <strong class="hero-priority__value">{{ $priorityTotal }}</strong>
                <span class="hero-priority__note">Kontrak dalam 30 hari / berakhir</span>
            </div>
        </div>
    </section>

    <section class="stats-grid">
        <article class="stat-card">
            <div class="stat-card__top">
                <span class="stat-card__label">Total Karyawan</span>
                <span class="stat-card__icon">◉</span>
            </div>
            <strong class="stat-card__value">{{ $totalEmployeeCount }}</strong>
            <small class="stat-card__note note-green"><span>●</span>Seluruh data</small>
        </article>

        <article class="stat-card">
            <div class="stat-card__top">
                <span class="stat-card__label">Aktif Saat Ini</span>
                <span class="stat-card__icon">✓</span>
            </div>
            <strong class="stat-card__value">{{ $activeEmployeeCount }}</strong>
            <small class="stat-card__note note-green"><span>●</span>Masa kontrak berjalan</small>
        </article>

        <article class="stat-card">
            <div class="stat-card__top">
                <span class="stat-card__label">Belum Mulai</span>
                <span class="stat-card__icon">◷</span>
            </div>
            <strong class="stat-card__value">{{ $upcomingContractCount }}</strong>
            <small class="stat-card__note note-gold"><span>●</span>Menunggu mulai kontrak</small>
        </article>

        <article class="stat-card">
            <div class="stat-card__top">
                <span class="stat-card__label">Kontrak Berakhir</span>
                <span class="stat-card__icon">!</span>
            </div>
            <strong class="stat-card__value">{{ $expiredContractCount }}</strong>
            <small class="stat-card__note {{ $expiredContractCount > 0 ? 'note-red' : 'note-green' }}"><span>●</span>Lewat akhir kontrak</small>
        </article>
    </section>

    <section class="visual-grid">
        <article class="visual-card">
            <header class="visual-card__header">
                <h2>Status Masa Kontrak</h2>
                <span>Keseluruhan</span>
            </header>

            <div class="status-overview">
                <div
                    class="status-donut {{ $totalEmployeeCount === 0 ? 'status-donut--empty' : '' }}"
                    style="--active-stop: {{ $activeStop }}%; --upcoming-stop: {{ $upcomingStop }}%;"
                    aria-label="Diagram status masa kontrak"
                >
                    <div class="status-donut__content">
                        <strong>{{ $totalEmployeeCount }}</strong>
                        <span>Karyawan</span>
                    </div>
                </div>

                <div class="status-legend">
                    <div class="status-legend__item">
                        <span class="status-legend__dot status-legend__dot--active"></span>
                        <span class="status-legend__label">Aktif</span>
                        <strong class="status-legend__value">{{ $activeEmployeeCount }}</strong>
                    </div>

                    <div class="status-legend__item">
                        <span class="status-legend__dot status-legend__dot--upcoming"></span>
                        <span class="status-legend__label">Belum mulai</span>
                        <strong class="status-legend__value">{{ $upcomingContractCount }}</strong>
                    </div>

                    <div class="status-legend__item">
                        <span class="status-legend__dot status-legend__dot--expired"></span>
                        <span class="status-legend__label">Berakhir</span>
                        <strong class="status-legend__value">{{ $expiredContractCount }}</strong>
                    </div>
                </div>
            </div>
        </article>

        <article class="visual-card">
            <header class="visual-card__header">
                <h2>Penempatan Aktif</h2>
                <span>{{ $placementCompanyCount }} perusahaan</span>
            </header>

            <div class="placement-chart">
                @forelse ($placementDistribution as $placement)
                    @php
                        $placementWidth = round(($placement->total / $placementMax) * 100);
                    @endphp

                    <div class="placement-row">
                        <div class="placement-row__top">
                            <span class="placement-row__name">{{ $placement->placement_company }}</span>
                            <span class="placement-row__value">{{ $placement->total }}</span>
                        </div>

                        <div class="placement-row__track">
                            <div class="placement-row__bar" style="--bar-width: {{ $placementWidth }}%;"></div>
                        </div>
                    </div>
                @empty
                    <div class="placement-chart__empty">Belum ada penempatan aktif.</div>
                @endforelse
            </div>
        </article>
    </section>

    <section class="priority-section">
        <div class="priority-section__header">
            <div class="priority-section__heading">
                <span class="priority-section__icon">◷</span>
                <div>
                    <h2>Prioritas Kontrak</h2>
                    <p>Perlu ditindaklanjuti</p>
                </div>
            </div>

            <span class="priority-section__total">{{ $priorityTotal }}</span>
        </div>

        <div class="priority-bars" aria-label="Diagram batang prioritas kontrak">
            <div class="priority-bar-row priority-bar-row--upcoming">
                <div class="priority-bar__label">
                    <span class="priority-bar__marker"></span>
                    <span>Mulai ≤ 30 hari</span>
                </div>

                <div class="priority-bar__chart">
                    <div class="priority-bar__track">
                        <div
                            class="priority-bar__fill"
                            style="--bar-width: {{ round(($upcomingWithin30Count / $priorityMax) * 100) }}%;"
                        ></div>
                    </div>
                </div>

                <strong class="priority-bar__value">{{ $upcomingWithin30Count }}</strong>
            </div>

            <div class="priority-bar-row priority-bar-row--expiring">
                <div class="priority-bar__label">
                    <span class="priority-bar__marker"></span>
                    <span>Berakhir ≤ 30 hari</span>
                </div>

                <div class="priority-bar__chart">
                    <div class="priority-bar__track">
                        <div
                            class="priority-bar__fill"
                            style="--bar-width: {{ round(($expiringContractCount / $priorityMax) * 100) }}%;"
                        ></div>
                    </div>
                </div>

                <strong class="priority-bar__value">{{ $expiringContractCount }}</strong>
            </div>

            <div class="priority-bar-row priority-bar-row--expired">
                <div class="priority-bar__label">
                    <span class="priority-bar__marker"></span>
                    <span>Sudah berakhir</span>
                </div>

                <div class="priority-bar__chart">
                    <div class="priority-bar__track">
                        <div
                            class="priority-bar__fill"
                            style="--bar-width: {{ round(($expiredContractCount / $priorityMax) * 100) }}%;"
                        ></div>
                    </div>
                </div>

                <strong class="priority-bar__value">{{ $expiredContractCount }}</strong>
            </div>
        </div>
    </section>

    <section class="dashboard-section">
        <div class="dashboard-section__header">
            <div>
                <h2>Kontrak Memerlukan Perhatian</h2>
                <p>Belum mulai, akan berakhir, atau sudah berakhir.</p>
            </div>

            <a href="{{ route('employees.index') }}" wire:navigate class="section-link">
                Data Karyawan <span>→</span>
            </a>
        </div>

        @if ($attentionContracts->isNotEmpty())
            <div class="contract-list">
                @foreach ($attentionContracts as $employee)
                    @php
                        $today = now()->startOfDay();
                        $contractStart = $employee->contract_start->copy()->startOfDay();
                        $contractEnd = $employee->contract_end->copy()->startOfDay();

                        if ($today->lt($contractStart)) {
                            $daysUntilStart = $today->diffInDays($contractStart);
                            $contractClass = 'pending';
                            $contractText = 'Belum mulai · ' . $daysUntilStart . ' hari';
                            $contractDateLabel = 'Mulai Kontrak';
                            $contractDateValue = $contractStart->translatedFormat('d M Y');
                        } elseif ($today->gt($contractEnd)) {
                            $contractClass = 'danger';
                            $contractText = 'Kontrak berakhir';
                            $contractDateLabel = 'Akhir Kontrak';
                            $contractDateValue = $contractEnd->translatedFormat('d M Y');
                        } else {
                            $daysRemaining = $today->diffInDays($contractEnd);
                            $contractClass = $daysRemaining <= 7 ? 'danger' : 'warning';
                            $contractText = $daysRemaining === 0
                                ? 'Berakhir hari ini'
                                : $daysRemaining . ' hari tersisa';
                            $contractDateLabel = 'Akhir Kontrak';
                            $contractDateValue = $contractEnd->translatedFormat('d M Y');
                        }

                        $initial = strtoupper(substr($employee->full_name, 0, 1));
                    @endphp

                    <a
                        href="{{ route('employees.index', ['search' => $employee->full_name]) }}"
                        wire:navigate
                        class="contract-row"
                    >
                        <div class="contract-person">
                            <div class="contract-avatar">
                                @if ($employee->face_photo_path)
                                    <img
                                        src="{{ route('employees.document', ['employee' => $employee->id, 'type' => 'face']) }}"
                                        alt="Foto {{ $employee->full_name }}"
                                    >
                                @else
                                    {{ $initial }}
                                @endif
                            </div>

                            <div style="min-width: 0;">
                                <span class="contract-person__name">{{ $employee->full_name }}</span>
                                <span class="contract-person__phone">{{ $employee->phone }}</span>
                            </div>
                        </div>

                        <div class="contract-row__placement">
                            <span class="contract-meta-label">Penempatan</span>
                            <span class="contract-meta-value">{{ $employee->placement_company }}</span>
                        </div>

                        <div class="contract-row__date">
                            <span class="contract-meta-label">{{ $contractDateLabel }}</span>
                            <span class="contract-meta-value">{{ $contractDateValue }}</span>
                        </div>

                        <span class="contract-status {{ $contractClass }}">{{ $contractText }}</span>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty-contract">
                <div class="empty-contract__icon">✓</div>
                <h3>Tidak ada kontrak prioritas</h3>
                <p>Semua masa kontrak tercatat aman.</p>
                <a href="{{ route('employees.create') }}" wire:navigate class="empty-contract__button">
                    <span>＋</span>
                    Input Karyawan
                </a>
            </div>
        @endif
    </section>
</section>
@endsection


@push('scripts')
<script data-navigate-once>
    (function () {
        const AUTO_SYNC_INTERVAL = 15000;

        function runDashboardAnimation() {
            const dashboard = document.querySelector('.dashboard-content');

            if (!dashboard) {
                return;
            }

            dashboard.classList.remove('dashboard-motion-ready');

            window.requestAnimationFrame(function () {
                window.requestAnimationFrame(function () {
                    dashboard.classList.add('dashboard-motion-ready');
                });
            });
        }

        async function syncDashboardIfChanged() {
            const dashboard = document.querySelector('.dashboard-content');

            if (
                !dashboard ||
                document.visibilityState !== 'visible' ||
                dashboard.dataset.dashboardChecking === 'true'
            ) {
                return;
            }

            dashboard.dataset.dashboardChecking = 'true';

            try {
                const response = await fetch(window.location.href, {
                    method: 'GET',
                    credentials: 'same-origin',
                    cache: 'no-store',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Cache-Control': 'no-cache',
                    },
                });

                if (!response.ok) {
                    return;
                }

                const html = await response.text();
                const documentSnapshot = new DOMParser().parseFromString(html, 'text/html');
                const latestDashboard = documentSnapshot.querySelector('.dashboard-content');

                if (
                    !latestDashboard ||
                    latestDashboard.dataset.dashboardSignature === dashboard.dataset.dashboardSignature
                ) {
                    return;
                }

                if (window.Livewire && typeof window.Livewire.navigate === 'function') {
                    window.Livewire.navigate(window.location.href);
                }
            } catch (error) {
                // Gangguan jaringan tidak mengubah tampilan dashboard yang sedang dibuka.
            } finally {
                dashboard.dataset.dashboardChecking = 'false';
            }
        }

        if (!window.__kcwDashboardMotionBound) {
            window.__kcwDashboardMotionBound = true;

            document.addEventListener('livewire:navigated', runDashboardAnimation);
            document.addEventListener('DOMContentLoaded', runDashboardAnimation);
        }

        if (!window.__kcwDashboardAutoSyncBound) {
            window.__kcwDashboardAutoSyncBound = true;

            window.setInterval(syncDashboardIfChanged, AUTO_SYNC_INTERVAL);

            document.addEventListener('visibilitychange', function () {
                if (document.visibilityState === 'visible') {
                    syncDashboardIfChanged();
                }
            });
        }

        runDashboardAnimation();
        syncDashboardIfChanged();
    })();
</script>
@endpush
