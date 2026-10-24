@extends('layouts.app')

@section('page-title', 'Input Karyawan | PT Karunia Cipta Wasantara')
@section('topbar-title', 'Input Karyawan')
@section('topbar-subtitle', 'Lengkapi data karyawan, kontrak, dan dokumen pendukung.')

@push('styles')
    <style>
        :root {
            --gold: #a96f12;
            --gold-dark: #7c4d08;
            --gold-light: #e6c87b;
            --gold-soft: #fbf3d9;

            --brown: #2c1a0d;
            --brown-light: #604124;
            --brown-soft: #8e7257;

            --cream: #fffdf7;
            --white: #ffffff;
            --muted: #8d7b68;
            --border: #eadfc8;

            --green: #218353;
            --green-soft: #eaf8f0;

            --orange: #bf7615;
            --orange-soft: #fff3dd;

            --red: #bd3b30;
            --red-soft: #fff1ef;

            --shadow: 0 15px 40px rgba(76, 48, 20, 0.08);
            --shadow-hover: 0 20px 42px rgba(76, 48, 20, 0.13);
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            min-height: 100vh;

            color: var(--brown);
            font-family: "Segoe UI", Arial, sans-serif;

            background:
                radial-gradient(circle at 8% 0%, rgba(238, 205, 107, 0.24), transparent 26%),
                radial-gradient(circle at 95% 100%, rgba(191, 118, 21, 0.08), transparent 28%),
                linear-gradient(135deg, #fffdf7 0%, #fbf3df 100%);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        input,
        textarea {
            font: inherit;
        }

        button {
            cursor: pointer;
        }

        .app-layout {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 270px 1fr;
        }

        .main {
            grid-column: 2;
            min-width: 0;
        }

        .create-content {
            padding: 34px 38px 52px;
        }

        /* HERO */

        .page-hero {
            position: relative;
            overflow: hidden;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 28px;

            margin-bottom: 24px;
            padding: 29px 31px;

            border-radius: 22px;

            color: #ffffff;

            background:
                radial-gradient(circle at 90% 14%, rgba(255, 255, 255, 0.17), transparent 28%),
                linear-gradient(125deg, #2b190c 0%, #69451f 56%, #b8892c 100%);

            box-shadow: 0 19px 42px rgba(89, 53, 18, 0.18);

            animation: fade-up 0.65s ease both;
        }

        .page-hero::after {
            content: "";

            position: absolute;
            top: -125px;
            right: -90px;

            width: 295px;
            height: 295px;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.11);

            animation: float-circle 8s ease-in-out infinite;
        }

        .page-hero__content,
        .page-hero__action {
            position: relative;
            z-index: 1;
        }

        .page-hero__eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            margin-bottom: 10px;

            color: rgba(255, 255, 255, 0.76);

            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }

        .page-hero__dot {
            width: 8px;
            height: 8px;

            border-radius: 50%;

            background: #f8d76d;
            box-shadow: 0 0 0 5px rgba(248, 215, 109, 0.14);
        }

        .page-hero h1 {
            margin: 0;

            font-size: clamp(25px, 3vw, 35px);
            font-weight: 800;
            line-height: 1.22;
            letter-spacing: -1px;
        }

        .page-hero p {
            max-width: 670px;
            margin: 11px 0 0;

            color: rgba(255, 255, 255, 0.76);

            font-size: 13px;
            line-height: 1.75;
        }

        .hero-link {
            min-height: 44px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            padding: 0 15px;

            border: 1px solid rgba(255, 255, 255, 0.34);
            border-radius: 11px;

            color: #5b3c18;
            background: #fff9e7;

            font-size: 11px;
            font-weight: 850;
            white-space: nowrap;

            box-shadow: 0 10px 20px rgba(33, 17, 6, 0.12);

            transition: 0.22s ease;
        }

        .hero-link:hover {
            color: #ffffff;
            background: #5b3919;
            border-color: #5b3919;
            transform: translateY(-2px);
        }

        /* VALIDATION ALERT */

        .validation-alert {
            display: flex;
            align-items: flex-start;
            gap: 11px;

            margin-bottom: 20px;
            padding: 15px 16px;

            border: 1px solid #f2c9c2;
            border-radius: 13px;

            color: #a43a30;
            background: var(--red-soft);

            font-size: 13px;
            line-height: 1.55;

            animation: fade-up 0.45s ease both;
        }

        .validation-alert__icon {
            width: 25px;
            height: 25px;

            display: grid;
            place-items: center;

            flex-shrink: 0;

            border-radius: 8px;

            color: #ffffff;
            background: var(--red);

            font-size: 13px;
            font-weight: 850;
        }

        .validation-alert strong {
            display: block;
            margin-bottom: 4px;
        }

        .validation-alert ul {
            margin: 7px 0 0;
            padding-left: 18px;
        }

        /* FORM CARD */

        .form-card {
            overflow: hidden;

            border: 1px solid var(--border);
            border-radius: 20px;

            background: rgba(255, 255, 255, 0.93);

            box-shadow: var(--shadow);

            animation: fade-up 0.7s ease 0.08s both;
        }

        .form-card__header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;

            padding: 25px 27px;

            border-bottom: 1px solid var(--border);

            background:
                radial-gradient(circle at 92% 0%, rgba(231, 201, 112, 0.27), transparent 34%),
                linear-gradient(135deg, #fffdf8, #fff8e7);
        }

        .form-card__header h2 {
            margin: 0;

            color: var(--brown);

            font-size: 18px;
            letter-spacing: -0.2px;
        }

        .form-card__header p {
            max-width: 660px;
            margin: 8px 0 0;

            color: var(--muted);

            font-size: 12px;
            line-height: 1.7;
        }

        .form-tag {
            flex-shrink: 0;

            padding: 8px 11px;

            border: 1px solid #eddca8;
            border-radius: 999px;

            color: var(--gold-dark);
            background: #fffaf0;

            font-size: 10px;
            font-weight: 850;
            letter-spacing: 0.5px;
        }

        .form-body {
            padding: 28px 27px 31px;
        }

        .form-section {
            margin-bottom: 31px;
            padding-bottom: 31px;

            border-bottom: 1px solid #f0e7d6;
        }

        .form-section:last-of-type {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: 0;
        }

        .section-heading {
            display: flex;
            align-items: center;
            gap: 11px;

            margin-bottom: 20px;
        }

        .section-number {
            width: 30px;
            height: 30px;

            display: grid;
            place-items: center;

            flex-shrink: 0;

            border-radius: 9px;

            color: var(--gold-dark);
            background: var(--gold-soft);

            font-size: 11px;
            font-weight: 850;
        }

        .section-heading h3 {
            margin: 0;

            color: var(--brown);

            font-size: 15px;
        }

        .section-heading p {
            margin: 3px 0 0;

            color: var(--muted);

            font-size: 11px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .form-grid--three {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .field-group--full {
            grid-column: 1 / -1;
        }

        .field-group label {
            display: block;
            margin-bottom: 8px;

            color: var(--brown-light);

            font-size: 12px;
            font-weight: 800;
        }

        .required {
            color: var(--red);
        }

        .field-group input,
        .field-group textarea {
            width: 100%;

            outline: none;

            border: 1px solid var(--border);
            border-radius: 11px;

            color: var(--brown);
            background: #fffefa;

            font-size: 13px;

            transition: 0.22s ease;
        }

        .field-group input {
            height: 47px;
            padding: 0 13px;
        }

        .field-group textarea {
            min-height: 112px;
            padding: 13px;

            line-height: 1.6;
            resize: vertical;
        }

        .field-group input:focus,
        .field-group textarea:focus {
            border-color: var(--gold);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(200, 154, 43, 0.13);
        }

        .field-group input[readonly] {
            color: var(--gold-dark);
            background: #fff9e9;
            font-weight: 800;
        }

        .field-help {
            display: block;
            margin-top: 6px;

            color: var(--muted);

            font-size: 10px;
            line-height: 1.5;
        }

        .field-error {
            display: block;
            margin-top: 6px;

            color: var(--red);

            font-size: 11px;
            font-weight: 700;
        }

        .input-error {
            border-color: #e59e96 !important;
            background: #fff9f8 !important;
        }

        /* STATUS */

        .status-options {
            display: flex;
            gap: 10px;
        }

        .status-option {
            position: relative;
            flex: 1;
        }

        .status-option input {
            position: absolute;

            width: 1px;
            height: 1px;

            opacity: 0;
            pointer-events: none;
        }

        .status-option label {
            min-height: 47px;

            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            margin: 0;

            border: 1px solid var(--border);
            border-radius: 11px;

            color: var(--muted);
            background: #fffefa;

            font-size: 12px;
            font-weight: 800;

            cursor: pointer;
            transition: 0.22s ease;
        }

        .status-option input:checked+label {
            border-color: #badfc8;

            color: var(--green);
            background: var(--green-soft);

            box-shadow: 0 0 0 3px rgba(33, 131, 83, 0.08);
        }

        .status-option input[value="inactive"]:checked+label {
            border-color: #efbbb5;

            color: var(--red);
            background: var(--red-soft);

            box-shadow: 0 0 0 3px rgba(189, 59, 48, 0.09);
        }

        .status-option input[value="inactive"]:checked+label span {
            color: var(--red);
        }

        /* DOCUMENT UPLOAD */

        .upload-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .upload-card {
            position: relative;
            min-height: 310px;
            overflow: hidden;

            display: flex;
            flex-direction: column;

            border: 1px dashed rgba(181, 126, 22, 0.62);
            border-radius: 18px;

            color: var(--brown);
            background:
                radial-gradient(circle at 92% 7%, rgba(244, 218, 141, 0.28), transparent 36%),
                linear-gradient(145deg, #fffefa 0%, #fffaf0 100%);

            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.82);
            cursor: pointer;
            transition: transform 0.22s ease, border-color 0.22s ease, box-shadow 0.22s ease, background 0.22s ease;
        }

        .upload-card::before {
            content: "";
            position: absolute;
            inset: 8px;
            z-index: 0;

            border: 1px solid rgba(204, 158, 58, 0.20);
            border-radius: 12px;

            pointer-events: none;
        }

        .upload-card::after {
            content: "";
            position: absolute;
            top: -54px;
            right: -46px;
            z-index: 0;

            width: 132px;
            height: 132px;

            border: 1px solid rgba(204, 158, 58, 0.16);
            border-radius: 50%;
            box-shadow: 0 0 0 17px rgba(204, 158, 58, 0.025);

            pointer-events: none;
        }

        .upload-card>* {
            position: relative;
            z-index: 1;
        }

        .upload-card:hover,
        .upload-card:focus-visible {
            border-color: var(--gold);
            outline: none;
            transform: translateY(-3px);
            box-shadow: 0 14px 26px rgba(133, 82, 13, 0.13);
            background:
                radial-gradient(circle at 92% 7%, rgba(244, 218, 141, 0.42), transparent 38%),
                linear-gradient(145deg, #fffefa 0%, #fff7e7 100%);
        }

        .upload-card.has-file {
            border-style: solid;
            border-color: rgba(169, 111, 18, 0.52);
            background:
                radial-gradient(circle at 92% 7%, rgba(240, 204, 112, 0.34), transparent 38%),
                linear-gradient(145deg, #fffefa 0%, #fff8e8 100%);
        }

        .upload-card__visual {
            height: 98px;
            display: grid;
            place-items: center;
            padding-top: 17px;
        }

        .face-preview {
            width: 82px;
            height: 82px;
            overflow: hidden;

            border: 3px solid #ffffff;
            border-radius: 23px;

            background: linear-gradient(135deg, #fdf2cb, #f7df98);
            box-shadow: 0 9px 18px rgba(108, 69, 24, 0.14);
        }

        .face-preview[hidden] {
            display: none;
        }

        .face-preview img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
        }

        .document-preview {
            width: 46px;
            height: 46px;
            display: grid;
            place-items: center;

            color: var(--gold-dark);
            background: transparent;

            font-size: 25px;
            font-weight: 850;
        }

        .document-preview.has-preview {
            width: 82px;
            height: 82px;
            overflow: hidden;

            border: 3px solid #ffffff;
            border-radius: 22px;

            color: var(--gold-dark);
            background: linear-gradient(135deg, #fdf2cb, #f7df98);
            box-shadow: 0 9px 18px rgba(108, 69, 24, 0.14);
        }

        .document-preview img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
        }

        .document-preview--pdf {
            color: #a8382d !important;
            background: #fff0ee !important;

            font-size: 15px !important;
            font-weight: 900 !important;
            letter-spacing: 0.5px;
        }

        .upload-card__heading {
            min-height: 88px;
            padding: 0 22px;
            text-align: center;
        }

        .upload-card__heading h4 {
            margin: 0;
            color: var(--brown);
            font-size: 13px;
            font-weight: 850;
        }

        .upload-card__heading p {
            min-height: 34px;
            margin: 8px 0 0;
            color: var(--muted);
            font-size: 10.5px;
            line-height: 1.55;
        }

        .upload-content {
            display: flex;
            flex: 1;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            padding: 0 18px 19px;
            text-align: center;
        }

        .file-input {
            position: absolute;
            width: 1px;
            height: 1px;
            overflow: hidden;
            opacity: 0;
            pointer-events: none;
        }

        .upload-action-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
            min-height: 36px;
        }

        .upload-button,
        .upload-secondary-button,
        .upload-remove-button {
            min-height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 0 12px;
            border-radius: 9px;
            font-size: 10.5px;
            font-weight: 850;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .upload-secondary-button[hidden],
        .upload-remove-button[hidden],
        .file-summary[hidden] {
            display: none !important;
        }

        .upload-button {
            border: 1px solid #d6aa4a;
            color: #7c4d08;
            background: #fff7df;
        }

        .upload-button:hover {
            color: #ffffff;
            background: #7c4d08;
            border-color: #7c4d08;
        }

        .upload-secondary-button {
            border: 1px solid #d9c08a;
            color: #704719;
            background: #fffdf6;
        }

        .upload-secondary-button:hover {
            color: #ffffff;
            background: #81531a;
            border-color: #81531a;
        }

        .upload-remove-button {
            border: 1px solid #efc0ba;
            color: var(--red);
            background: #fff4f2;
        }

        .upload-remove-button:hover {
            color: #ffffff;
            background: var(--red);
            border-color: var(--red);
        }

        .file-summary {
            width: 100%;
            min-height: 50px;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 11px;
            padding: 8px 9px;
            border: 1px solid #e8d9b5;
            border-radius: 10px;
            color: var(--brown-light);
            background: rgba(255, 253, 246, 0.92);
            text-align: left;
        }

        .file-summary__icon {
            width: 28px;
            height: 28px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            border-radius: 8px;
            color: #7c4d08;
            background: #f8e8b9;
            font-size: 13px;
            font-weight: 850;
        }

        .file-summary__detail {
            min-width: 0;
        }

        .file-name {
            display: block;
            overflow: hidden;
            color: var(--brown-light);
            font-size: 10px;
            font-weight: 850;
            line-height: 1.35;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .file-meta {
            display: block;
            margin-top: 2px;
            overflow: hidden;
            color: var(--muted);
            font-size: 9px;
            line-height: 1.3;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .file-error {
            display: block;
            margin-top: 8px;
            color: var(--red);
            font-size: 10px;
            font-weight: 700;
        }

        .client-input-error {
            border-color: #df8d84 !important;
            background: #fff8f7 !important;
            box-shadow: 0 0 0 3px rgba(189, 59, 48, 0.09) !important;
        }

        .upload-card.client-input-error {
            border-color: #df8d84 !important;
            background: #fff8f7 !important;
        }

        /* KONFIRMASI HAPUS FILE */

        .remove-confirm-modal {
            position: fixed;
            inset: 0;
            z-index: 150;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 22px;
            background: rgba(39, 20, 7, 0.62);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
        }

        .remove-confirm-modal[hidden] {
            display: none;
        }

        .remove-confirm-dialog {
            width: min(100%, 430px);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.45);
            border-radius: 22px;
            background: #fffdf8;
            box-shadow: 0 28px 65px rgba(25, 11, 3, 0.36);
            animation: dialog-pop 0.24s ease both;
        }

        .remove-confirm-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 21px 23px;
            color: #ffffff;
            background: linear-gradient(135deg, #6d201b 0%, #a83d32 100%);
        }

        .remove-confirm-icon {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            border: 1px solid rgba(255, 255, 255, 0.30);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.12);
            font-size: 18px;
            font-weight: 900;
        }

        .remove-confirm-header h3 {
            margin: 0;
            font-size: 17px;
        }

        .remove-confirm-header p {
            margin: 4px 0 0;
            color: rgba(255, 255, 255, 0.78);
            font-size: 11px;
        }

        .remove-confirm-body {
            padding: 22px 23px 23px;
        }

        .remove-confirm-body p {
            margin: 0;
            color: var(--brown-light);
            font-size: 12px;
            line-height: 1.65;
        }

        .remove-confirm-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .remove-confirm-cancel,
        .remove-confirm-apply {
            min-height: 40px;
            padding: 0 14px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 850;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .remove-confirm-cancel {
            border: 1px solid var(--border);
            color: var(--brown-light);
            background: #ffffff;
        }

        .remove-confirm-cancel:hover {
            border-color: #e0c78e;
            background: #fff9ec;
        }

        .remove-confirm-apply {
            border: 1px solid #b43b2f;
            color: #ffffff;
            background: var(--red);
        }

        .remove-confirm-apply:hover {
            background: #983028;
        }

        /* PHOTO EDITOR AND VALIDATION POPUP */
        /* PHOTO EDITOR AND VALIDATION POPUP */

        .photo-editor-modal,
        .form-validation-modal {
            position: fixed;
            inset: 0;
            z-index: 140;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 22px;

            background: rgba(39, 20, 7, 0.62);

            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
        }

        .photo-editor-modal[hidden],
        .form-validation-modal[hidden] {
            display: none;
        }

        .photo-editor-dialog,
        .form-validation-dialog {
            width: min(100%, 510px);
            max-height: calc(100vh - 44px);
            overflow-y: auto;

            border: 1px solid rgba(255, 255, 255, 0.45);
            border-radius: 22px;

            background: #fffdf8;

            box-shadow: 0 28px 65px rgba(25, 11, 3, 0.36);

            animation: dialog-pop 0.24s ease both;
        }

        .photo-editor-header,
        .form-validation-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;

            padding: 22px 24px;

            color: #ffffff;

            background:
                radial-gradient(circle at 94% 5%, rgba(255, 255, 255, 0.16), transparent 30%),
                linear-gradient(135deg, #2b190c 0%, #6d481f 64%, #b98a2b 100%);
        }

        .photo-editor-header h3,
        .form-validation-header h3 {
            margin: 0;

            font-size: 18px;
            letter-spacing: -0.35px;
        }

        .photo-editor-header p,
        .form-validation-header p {
            margin: 6px 0 0;

            color: rgba(255, 255, 255, 0.76);

            font-size: 11px;
            line-height: 1.55;
        }

        .modal-close-button {
            width: 35px;
            height: 35px;

            display: grid;
            place-items: center;

            flex-shrink: 0;

            border: 1px solid rgba(255, 255, 255, 0.30);
            border-radius: 10px;

            color: #ffffff;
            background: rgba(255, 255, 255, 0.10);

            font-size: 18px;

            cursor: pointer;
            transition: 0.2s ease;
        }

        .modal-close-button:hover {
            background: rgba(255, 255, 255, 0.20);
            transform: rotate(90deg);
        }

        .photo-editor-body {
            padding: 23px 24px 24px;
        }

        .photo-crop-stage {
            width: min(100%, 285px);
            aspect-ratio: 3 / 4;

            overflow: hidden;

            margin: 0 auto;

            border: 7px solid #ffffff;
            border-radius: 24px;

            background:
                linear-gradient(45deg, #f1e7d1 25%, transparent 25%),
                linear-gradient(-45deg, #f1e7d1 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #f1e7d1 75%),
                linear-gradient(-45deg, transparent 75%, #f1e7d1 75%);
            background-position: 0 0, 0 10px, 10px -10px, -10px 0;
            background-size: 20px 20px;

            box-shadow: 0 12px 24px rgba(83, 48, 16, 0.12);
        }

        .photo-crop-stage canvas {
            width: 100%;
            height: 100%;

            display: block;

            cursor: grab;
            touch-action: none;
        }

        .photo-crop-stage canvas.is-dragging {
            cursor: grabbing;
        }

        .photo-editor-help {
            margin: 13px 0 17px;

            color: var(--muted);

            font-size: 11px;
            line-height: 1.65;
            text-align: center;
        }

        .zoom-control {
            margin-top: 12px;
        }

        .zoom-control__top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;

            margin-bottom: 8px;

            color: var(--brown-light);

            font-size: 11px;
            font-weight: 800;
        }

        .zoom-control input[type="range"] {
            width: 100%;

            accent-color: var(--gold);
        }

        .editor-actions,
        .validation-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;

            margin-top: 21px;
        }

        .editor-button,
        .validation-button {
            min-height: 42px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;

            padding: 0 14px;

            border-radius: 10px;

            font-size: 11px;
            font-weight: 850;

            cursor: pointer;
            transition: 0.2s ease;
        }

        .editor-button--secondary,
        .validation-button {
            border: 1px solid var(--border);

            color: var(--brown-light);
            background: #ffffff;
        }

        .editor-button--secondary:hover,
        .validation-button:hover {
            border-color: var(--gold-light);

            color: var(--gold-dark);
            background: var(--gold-soft);
        }

        .editor-button--primary {
            border: 0;

            color: #ffffff;
            background: linear-gradient(135deg, #a97916, #d4a63a);

            box-shadow: 0 10px 18px rgba(174, 125, 24, 0.20);
        }

        .editor-button--primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 22px rgba(174, 125, 24, 0.28);
        }

        .form-validation-body {
            padding: 23px 24px 24px;
        }

        .validation-message-intro {
            margin: 0 0 12px;

            color: var(--brown-light);

            font-size: 12px;
            line-height: 1.65;
        }

        .validation-message-list {
            margin: 0;
            padding: 0;

            list-style: none;
        }

        .validation-message-list li {
            position: relative;

            margin-top: 8px;
            padding: 10px 11px 10px 33px;

            border: 1px solid #f0c6c0;
            border-radius: 10px;

            color: #9d382e;
            background: #fff5f3;

            font-size: 11px;
            font-weight: 700;
            line-height: 1.5;
        }

        .validation-message-list li::before {
            content: "!";

            position: absolute;
            top: 10px;
            left: 11px;

            width: 15px;
            height: 15px;

            display: grid;
            place-items: center;

            border-radius: 50%;

            color: #ffffff;
            background: var(--red);

            font-size: 10px;
            font-weight: 850;
        }

        @keyframes dialog-pop {
            from {
                opacity: 0;
                transform: translateY(16px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }


        /* FORM ACTION */

        .form-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;

            margin-top: 30px;
            padding-top: 24px;

            border-top: 1px solid var(--border);
        }

        .form-actions-note {
            max-width: 620px;

            color: var(--muted);

            font-size: 11px;
            line-height: 1.65;
        }

        .action-buttons {
            display: flex;
            align-items: center;
            gap: 10px;

            flex-shrink: 0;
        }

        .cancel-button,
        .submit-button {
            min-height: 48px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;

            padding: 0 18px;

            border-radius: 11px;

            font-size: 12px;
            font-weight: 850;

            transition: 0.22s ease;
        }

        .cancel-button {
            border: 1px solid var(--border);

            color: var(--brown-light);
            background: #ffffff;
        }

        .cancel-button:hover {
            border-color: var(--gold-light);

            color: var(--gold-dark);
            background: var(--gold-soft);
        }

        .submit-button {
            border: 0;

            color: #ffffff;
            background: linear-gradient(135deg, #a97916, #d4a63a);

            box-shadow: 0 11px 20px rgba(174, 125, 24, 0.22);
        }

        .submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 25px rgba(174, 125, 24, 0.30);
        }

        /* ANIMATION */

        @keyframes fade-up {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float-circle {

            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(-17px, 16px);
            }
        }

        /* RESPONSIVE */

        @media (max-width: 1050px) {
            .app-layout {
                grid-template-columns: 1fr;
            }

            .main {
                grid-column: 1;
            }
        }

        @media (max-width: 860px) {

            .upload-grid,
            .form-grid--three {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 760px) {
            .create-content {
                padding: 24px 20px 40px;
            }

            .page-hero {
                align-items: flex-start;
                flex-direction: column;

                padding: 25px 22px;
            }

            .hero-link {
                width: 100%;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-actions {
                align-items: flex-start;
                flex-direction: column;
            }

            .action-buttons {
                width: 100%;
            }

            .cancel-button,
            .submit-button {
                flex: 1;
            }
        }

        @media (max-width: 520px) {

            .form-card__header,
            .form-body {
                padding-right: 20px;
                padding-left: 20px;
            }

            .form-card__header {
                flex-direction: column;
            }

            .status-options,
            .action-buttons {
                flex-direction: column;
            }

            .cancel-button,
            .submit-button {
                width: 100%;
            }
        }


        /*
            |--------------------------------------------------------------------------
            | PENYEMPURNAAN TAMPILAN FORM & DOKUMEN
            |--------------------------------------------------------------------------
            */

        /* Nomor tahapan dibuat lebih terang, sedangkan pemisah antartahap
               menggunakan garis emas yang lebih halus dan terarah. */
        .form-section {
            position: relative;
            margin-bottom: 34px !important;
            padding-bottom: 42px !important;
            border-bottom: 0 !important;
        }

        .form-section:not(:last-of-type)::after {
            content: "";
            position: absolute;
            right: 4%;
            bottom: 0;
            left: 4%;
            height: 1px;
            background: linear-gradient(90deg,
                    transparent 0%,
                    rgba(201, 151, 48, 0.18) 12%,
                    rgba(183, 126, 19, 0.62) 50%,
                    rgba(201, 151, 48, 0.18) 88%,
                    transparent 100%);
        }

        .form-section:not(:last-of-type)::before {
            content: "";
            position: absolute;
            bottom: -4px;
            left: 50%;
            z-index: 1;
            width: 7px;
            height: 7px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            background: #d09a32;
            box-shadow: 0 0 0 1px rgba(187, 129, 19, 0.42);
            transform: translateX(-50%);
        }

        .section-number {
            color: #82550a !important;
            background: linear-gradient(135deg, #fff2bf 0%, #f2c65a 100%) !important;
            border: 1px solid rgba(197, 143, 31, 0.38) !important;
            box-shadow: 0 5px 12px rgba(172, 115, 13, 0.14) !important;
        }

        .submit-button {
            background: linear-gradient(135deg, #6d4307 0%, #9b6510 100%) !important;
            box-shadow: 0 11px 20px rgba(102, 61, 6, 0.25) !important;
        }

        .submit-button:hover {
            background: linear-gradient(135deg, #543304 0%, #80510a 100%) !important;
            box-shadow: 0 16px 25px rgba(102, 61, 6, 0.31) !important;
        }

        /*
            |--------------------------------------------------------------------------
            | KONTENER DOKUMEN
            |--------------------------------------------------------------------------
            | Lapis luar beraksen emas, bagian dalam putih bersih tanpa percikan.
            */

        .document-upload-shell {
            padding: 3px;
            border-radius: 21px;
            background: linear-gradient(135deg,
                    #a56d12 0%,
                    #e7c46f 36%,
                    #b27813 67%,
                    #8c570b 100%);
            box-shadow: 0 13px 28px rgba(119, 74, 10, 0.15);
        }

        .document-upload-shell__inner {
            padding: 18px;
            border-radius: 18px;
            background: #ffffff;
        }

        .document-upload-shell .upload-grid {
            gap: 16px;
        }

        .document-upload-shell .upload-card {
            min-height: 224px;
            border: 1px dashed rgba(169, 111, 18, 0.62);
            border-radius: 15px;
            background: #ffffff;
            box-shadow: none;
        }

        .document-upload-shell .upload-card::before,
        .document-upload-shell .upload-card::after {
            content: none !important;
        }

        .document-upload-shell .upload-card:hover,
        .document-upload-shell .upload-card:focus-visible {
            border-color: #95600d;
            background: #ffffff;
            box-shadow: 0 10px 20px rgba(123, 76, 10, 0.10);
        }

        .document-upload-shell .upload-card.has-file {
            border-style: solid;
            border-color: rgba(138, 87, 11, 0.50);
            background: #ffffff;
        }

        .document-upload-shell .upload-card__visual {
            height: 63px;
            padding-top: 14px;
        }

        .document-upload-shell .face-preview {
            width: 72px;
            height: 72px;
            border-radius: 20px;
        }

        .document-upload-shell .document-preview {
            width: 40px;
            height: 40px;
            color: #8b590a;
            font-size: 22px;
        }

        .document-upload-shell .document-preview.has-preview {
            width: 62px;
            height: 62px;
            border-radius: 17px;
        }

        .document-upload-shell .upload-card__heading {
            min-height: 65px;
            padding: 0 18px;
        }

        .document-upload-shell .upload-card__heading h4 {
            color: #2c1a0d;
        }

        .document-upload-shell .upload-card__heading p {
            min-height: 30px;
            color: #8e7b68;
        }

        .document-upload-shell .upload-content {
            padding: 0 15px 15px;
        }

        .document-upload-shell .upload-button {
            color: #774a07;
            background: #fff7df;
            border-color: #c99629;
        }

        .document-upload-shell .upload-button:hover {
            color: #ffffff;
            background: #774a07;
            border-color: #774a07;
        }

        .document-upload-shell .file-summary {
            background: #ffffff;
            border-color: #e6d5aa;
        }

        .document-upload-shell .file-summary__icon {
            color: #744805;
            background: #fae8b6;
        }

        .document-upload-shell .file-name {
            color: #503419;
        }

        .document-upload-shell .file-meta {
            color: #8e7b68;
        }

        .upload-button[hidden] {
            display: none !important;
        }

        /* Kartu foto kosong dibuat lebih ringkas. Kartu akan melebar
               secara alami ketika file telah dipilih karena preview dan informasi file muncul. */
        .document-upload-shell .face-upload-card:not(.has-file) {
            min-height: 205px;
        }

        .document-upload-shell .face-upload-card.has-file {
            min-height: 250px;
        }

        /* Saat KTP/KK sudah terpilih, tampilan dipadatkan menjadi informasi satu baris
               agar nama file dan tipe dokumen dapat dibaca dengan cepat. */
        .document-upload-shell .upload-card.document-file-selected {
            min-height: 0;
            padding: 14px 15px;
            cursor: default;
        }

        .document-upload-shell .upload-card.document-file-selected .upload-card__visual {
            display: none;
        }

        .document-upload-shell .upload-card.document-file-selected .upload-card__heading {
            min-height: 0;
            display: flex;
            align-items: center;
            padding: 0 0 9px;
            border-bottom: 1px solid #f0e3c6;
            text-align: left;
        }

        .document-upload-shell .upload-card.document-file-selected .upload-card__heading p {
            display: none;
        }

        .document-upload-shell .upload-card.document-file-selected .upload-content {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            align-items: center;
            gap: 10px;
            padding: 10px 0 0;
            text-align: left;
        }

        .document-upload-shell .upload-card.document-file-selected .file-summary {
            grid-column: 1;
            width: 100%;
            min-height: 38px;
            margin: 0;
            padding: 0;
            border: 0;
            background: transparent;
        }

        .document-upload-shell .upload-card.document-file-selected .file-summary__icon {
            width: 28px;
            height: 28px;
        }

        .document-upload-shell .upload-card.document-file-selected .upload-action-row {
            grid-column: 2;
            min-height: 0;
            justify-content: flex-end;
        }

        .document-upload-shell .upload-card.document-file-selected .upload-remove-button {
            min-height: 32px;
            padding: 0 10px;
        }

        @media (max-width: 860px) {
            .document-upload-shell .upload-card.document-file-selected {
                min-height: 154px;
            }

            .document-upload-shell .upload-card.document-file-selected .upload-content {
                grid-template-columns: 1fr;
            }

            .document-upload-shell .upload-card.document-file-selected .upload-action-row {
                grid-column: 1;
                justify-content: flex-start;
            }
        }


        /*
            |--------------------------------------------------------------------------
            | PENYEMPURNAAN KARTU DOKUMEN
            |--------------------------------------------------------------------------
            | Ruang putih di dalam kontainer emas dibuat bersih, kartu lebih ringkas,
            | dan informasi dokumen terpilih tersusun satu baris dengan tombol hapus.
            */
        .document-upload-shell__inner {
            padding: 16px !important;
            background: #ffffff !important;
        }

        .document-upload-shell .upload-grid {
            align-items: start !important;
            gap: 14px !important;
        }

        .document-upload-shell .upload-card {
            min-height: 188px !important;
            align-self: start !important;
            border: 1px solid #d5af69 !important;
            border-radius: 15px !important;
            background: #ffffff !important;
            box-shadow: none !important;
        }

        .document-upload-shell .upload-card:hover,
        .document-upload-shell .upload-card:focus-visible {
            border-color: #a66b10 !important;
            background: #ffffff !important;
            box-shadow: 0 10px 20px rgba(123, 76, 10, 0.09) !important;
        }

        .document-upload-shell .upload-card__visual {
            height: 88px !important;
            padding-top: 13px !important;
        }

        .document-upload-shell .face-placeholder {
            width: 70px;
            height: 70px;
            display: grid;
            place-items: center;
            overflow: hidden;
            border: 1px solid #e0bd73;
            border-radius: 22px;
            color: #9a650d;
            background: linear-gradient(145deg, #fff8e8, #f7dea0);
            box-shadow: 0 8px 17px rgba(108, 69, 24, 0.11);
        }

        .document-upload-shell .face-placeholder[hidden] {
            display: none;
        }

        .document-upload-shell .face-placeholder svg {
            width: 42px;
            height: 42px;
            fill: currentColor;
        }

        .document-upload-shell .face-preview {
            width: 70px !important;
            height: 70px !important;
            border-radius: 22px !important;
        }

        .document-upload-shell .document-preview {
            width: 44px !important;
            height: 44px !important;
            font-size: 23px !important;
        }

        .document-upload-shell .upload-card__heading {
            min-height: 50px !important;
            padding: 0 17px !important;
        }

        .document-upload-shell .upload-card__heading h4 {
            font-size: 13px !important;
        }

        .document-upload-shell .upload-card__heading p {
            min-height: 28px !important;
            margin-top: 6px !important;
            font-size: 10px !important;
        }

        .document-upload-shell .upload-content {
            padding: 0 15px 15px !important;
        }

        .document-upload-shell .face-upload-card:not(.has-file) {
            min-height: 188px !important;
        }

        .document-upload-shell .face-upload-card.has-file {
            min-height: 232px !important;
        }

        /* Hanya tombol Hapus yang tersisa setelah foto selesai diproses. */
        .document-upload-shell .face-upload-card.has-file #face_choose_button {
            display: none !important;
        }

        /* Setelah KTP/KK dipilih, kartu menyusut dan berisi satu baris file + aksi. */
        .document-upload-shell .upload-card.document-file-selected {
            min-height: auto !important;
            align-self: start !important;
            padding: 14px 15px !important;
            cursor: default !important;
        }

        .document-upload-shell .upload-card.document-file-selected .upload-card__visual {
            display: none !important;
        }

        .document-upload-shell .upload-card.document-file-selected .upload-card__heading {
            min-height: 0 !important;
            display: block !important;
            margin: 0 0 10px !important;
            padding: 0 0 9px !important;
            border-bottom: 1px solid #ead9b4 !important;
            text-align: left !important;
        }

        .document-upload-shell .upload-card.document-file-selected .upload-card__heading p {
            display: none !important;
        }

        .document-upload-shell .upload-card.document-file-selected .upload-content {
            display: grid !important;
            grid-template-columns: minmax(0, 1fr) auto !important;
            align-items: center !important;
            gap: 12px !important;
            padding: 0 !important;
            text-align: left !important;
        }

        .document-upload-shell .upload-card.document-file-selected .file-summary {
            grid-column: 1 !important;
            width: 100% !important;
            min-height: 36px !important;
            margin: 0 !important;
            padding: 0 !important;
            border: 0 !important;
            border-radius: 0 !important;
            background: transparent !important;
        }

        .document-upload-shell .upload-card.document-file-selected .file-summary__icon {
            width: 30px !important;
            height: 30px !important;
            border-radius: 9px !important;
        }

        .document-upload-shell .upload-card.document-file-selected .upload-action-row {
            grid-column: 2 !important;
            min-height: 0 !important;
            justify-content: flex-end !important;
        }

        .document-upload-shell .upload-card.document-file-selected .upload-remove-button {
            min-height: 34px !important;
            padding: 0 12px !important;
            white-space: nowrap !important;
        }

        @media (max-width: 860px) {
            .document-upload-shell .upload-card.document-file-selected {
                min-height: 0 !important;
            }

            .document-upload-shell .upload-card.document-file-selected .upload-content {
                grid-template-columns: minmax(0, 1fr) auto !important;
            }
        }

        @media (max-width: 560px) {
            .document-upload-shell .upload-card.document-file-selected .upload-content {
                grid-template-columns: 1fr !important;
            }

            .document-upload-shell .upload-card.document-file-selected .upload-action-row {
                grid-column: 1 !important;
                justify-content: flex-start !important;
            }
        }



        /*
            |--------------------------------------------------------------------------
            | PREVIEW DOKUMEN 3 × 4
            |--------------------------------------------------------------------------
            | Foto wajah, KTP, dan KK memakai bingkai portrait dengan rasio 3:4.
            | File gambar memperlihatkan isi dokumen secara utuh; PDF ditampilkan
            | melalui preview halaman pertama dari peramban bila didukung.
            */

        .photo-crop-stage {
            width: min(100%, 285px) !important;
            aspect-ratio: 3 / 4 !important;
        }

        .document-upload-shell .upload-grid {
            align-items: stretch !important;
        }

        .document-upload-shell .upload-card,
        .document-upload-shell .face-upload-card:not(.has-file),
        .document-upload-shell .face-upload-card.has-file,
        .document-upload-shell .upload-card.document-file-selected {
            min-height: 344px !important;
            padding: 0 !important;
            cursor: pointer !important;
        }

        .document-upload-shell .upload-card.document-file-selected {
            display: flex !important;
            flex-direction: column !important;
        }

        .document-upload-shell .upload-card__visual,
        .document-upload-shell .upload-card.document-file-selected .upload-card__visual {
            display: grid !important;
            height: 126px !important;
            min-height: 126px !important;
            padding-top: 16px !important;
        }

        .document-upload-shell .face-placeholder,
        .document-upload-shell .face-preview,
        .document-upload-shell .document-preview,
        .document-upload-shell .document-preview.has-preview {
            width: 78px !important;
            height: 104px !important;
            min-width: 78px !important;
            min-height: 104px !important;
            overflow: hidden !important;
            border: 1px solid #e0bd73 !important;
            border-radius: 12px !important;
            background: #fffdf8 !important;
            box-shadow: 0 8px 17px rgba(108, 69, 24, 0.12) !important;
        }

        .document-upload-shell .face-placeholder {
            display: grid !important;
            place-items: center !important;
            color: #9a650d !important;
            background: linear-gradient(145deg, #fff8e8, #f7dea0) !important;
        }

        .document-upload-shell .face-placeholder[hidden],
        .document-upload-shell .face-preview[hidden] {
            display: none !important;
        }

        .document-upload-shell .face-placeholder svg {
            width: 44px !important;
            height: 44px !important;
        }

        .document-upload-shell .face-preview img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
        }

        .document-upload-shell .document-preview {
            display: grid !important;
            place-items: center !important;
            color: #8b590a !important;
            font-size: 13px !important;
            font-weight: 900 !important;
            letter-spacing: 0.7px !important;
        }

        .document-upload-shell .document-preview:not(.has-preview)>span {
            display: grid !important;
            place-items: center !important;
            width: 100% !important;
            height: 100% !important;
            border: 7px solid #fff7df !important;
            background: linear-gradient(180deg, #fffdf8 0%, #fff2c6 100%) !important;
        }

        .document-upload-shell .document-preview.has-preview {
            display: block !important;
            color: inherit !important;
            background: #ffffff !important;
        }

        .document-upload-shell .document-preview.has-preview img,
        .document-upload-shell .document-preview.has-preview iframe {
            width: 100% !important;
            height: 100% !important;
            display: block !important;
            border: 0 !important;
            background: #ffffff !important;
        }

        .document-upload-shell .document-preview.has-preview img {
            object-fit: contain !important;
        }

        .document-upload-shell .document-preview.has-preview iframe {
            pointer-events: none !important;
        }

        .document-upload-shell .document-preview--pdf {
            background: #ffffff !important;
        }

        .document-upload-shell .upload-card__heading,
        .document-upload-shell .upload-card.document-file-selected .upload-card__heading {
            display: block !important;
            min-height: 59px !important;
            margin: 0 !important;
            padding: 0 17px !important;
            border-bottom: 0 !important;
            text-align: center !important;
        }

        .document-upload-shell .upload-card__heading p {
            display: block !important;
            min-height: 28px !important;
        }

        .document-upload-shell .upload-content,
        .document-upload-shell .upload-card.document-file-selected .upload-content {
            display: flex !important;
            flex: 1 !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: flex-end !important;
            gap: 0 !important;
            padding: 0 15px 16px !important;
            text-align: center !important;
        }

        .document-upload-shell .upload-card.document-file-selected .file-summary,
        .document-upload-shell .file-summary {
            display: flex !important;
            grid-column: auto !important;
            width: 100% !important;
            min-height: 50px !important;
            margin-top: 11px !important;
            padding: 8px 9px !important;
            border: 1px solid #e6d5aa !important;
            border-radius: 10px !important;
            background: #ffffff !important;
            text-align: left !important;
        }

        .document-upload-shell .upload-card.document-file-selected .upload-action-row {
            grid-column: auto !important;
            min-height: 36px !important;
            justify-content: center !important;
        }

        .document-upload-shell .upload-card.document-file-selected .upload-remove-button {
            min-height: 36px !important;
            padding: 0 12px !important;
        }

        @media (max-width: 860px) {

            .document-upload-shell .upload-card,
            .document-upload-shell .face-upload-card:not(.has-file),
            .document-upload-shell .face-upload-card.has-file,
            .document-upload-shell .upload-card.document-file-selected {
                min-height: 310px !important;
            }
        }



        /*
            |--------------------------------------------------------------------------
            | DOKUMEN KARYAWAN — TAMPILAN RINGKAS DAN BERSIH
            |--------------------------------------------------------------------------
            | Ketika belum ada file, hanya informasi inti dan tombol pemilihan file
            | yang terlihat. Preview, informasi nama file, serta tombol hapus baru
            | muncul setelah file berhasil dipilih.
            */
        .document-upload-shell .upload-grid {
            align-items: start !important;
        }

        .document-upload-shell .upload-card,
        .document-upload-shell .face-upload-card:not(.has-file),
        .document-upload-shell .face-upload-card.has-file,
        .document-upload-shell .upload-card.document-file-selected {
            min-height: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
            cursor: pointer !important;
        }

        .document-upload-shell .upload-card:not(.has-file) {
            min-height: 176px !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
        }

        /* Tidak ada placeholder atau bingkai preview sebelum file dipilih. */
        .document-upload-shell .upload-card:not(.has-file) .upload-card__visual,
        .document-upload-shell .upload-card:not(.has-file) .face-placeholder,
        .document-upload-shell .upload-card:not(.has-file) .document-preview {
            display: none !important;
        }

        .document-upload-shell .upload-card:not(.has-file) .upload-card__heading {
            min-height: auto !important;
            padding: 0 18px !important;
            text-align: center !important;
        }

        .document-upload-shell .upload-card:not(.has-file) .upload-card__heading h4 {
            margin: 0 !important;
        }

        .document-upload-shell .upload-card:not(.has-file) .upload-card__heading p {
            min-height: 0 !important;
            margin: 7px 0 0 !important;
        }

        .document-upload-shell .upload-card:not(.has-file) .upload-content {
            flex: 0 !important;
            justify-content: flex-start !important;
            padding: 16px 15px 22px !important;
        }

        .document-upload-shell .upload-card:not(.has-file) .upload-action-row {
            min-height: 34px !important;
        }

        /* Attribute hidden harus selalu menang terhadap CSS lain. */
        .document-upload-shell .file-summary[hidden],
        .document-upload-shell .upload-remove-button[hidden],
        .document-upload-shell .upload-button[hidden] {
            display: none !important;
        }

        /* Setelah file terpilih, kartu membuka area preview portrait 3 × 4. */
        .document-upload-shell .upload-card.has-file,
        .document-upload-shell .upload-card.document-file-selected {
            min-height: 344px !important;
            display: flex !important;
            flex-direction: column !important;
            cursor: default !important;
        }

        .document-upload-shell .upload-card.has-file .upload-card__visual,
        .document-upload-shell .upload-card.document-file-selected .upload-card__visual {
            display: grid !important;
            height: 168px !important;
            min-height: 168px !important;
            padding-top: 18px !important;
            place-items: center !important;
        }

        .document-upload-shell .face-preview,
        .document-upload-shell .document-preview,
        .document-upload-shell .document-preview.has-preview {
            width: 108px !important;
            height: 144px !important;
            min-width: 108px !important;
            min-height: 144px !important;
            overflow: hidden !important;
            border: 1px solid #d9ad59 !important;
            border-radius: 10px !important;
            background: #ffffff !important;
            box-shadow: 0 8px 16px rgba(93, 56, 12, 0.12) !important;
        }

        .document-upload-shell .face-preview[hidden] {
            display: none !important;
        }

        .document-upload-shell .face-preview img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            object-position: center !important;
        }

        .document-upload-shell .document-preview.has-preview {
            display: block !important;
        }

        /* Dokumen gambar diperlihatkan utuh; tidak dipotong seperti foto wajah. */
        .document-upload-shell .document-preview.has-preview img,
        .document-upload-shell .document-preview.has-preview iframe {
            display: block !important;
            width: 100% !important;
            height: 100% !important;
            border: 0 !important;
            background: #ffffff !important;
        }

        .document-upload-shell .document-preview.has-preview img {
            object-fit: contain !important;
            object-position: center !important;
        }

        .document-upload-shell .document-preview.has-preview iframe {
            pointer-events: none !important;
        }

        /* Keterangan format tidak perlu diulang setelah file sudah terisi. */
        .document-upload-shell .upload-card.has-file .upload-card__heading,
        .document-upload-shell .upload-card.document-file-selected .upload-card__heading {
            display: block !important;
            min-height: auto !important;
            margin: 0 !important;
            padding: 0 18px !important;
            border: 0 !important;
            text-align: center !important;
        }

        .document-upload-shell .upload-card.has-file .upload-card__heading p,
        .document-upload-shell .upload-card.document-file-selected .upload-card__heading p {
            display: none !important;
        }

        .document-upload-shell .upload-card.has-file .upload-content,
        .document-upload-shell .upload-card.document-file-selected .upload-content {
            display: flex !important;
            flex: 1 !important;
            flex-direction: column !important;
            align-items: stretch !important;
            justify-content: flex-end !important;
            gap: 0 !important;
            padding: 15px 18px 18px !important;
            text-align: left !important;
        }

        .document-upload-shell .upload-card.has-file .file-summary,
        .document-upload-shell .upload-card.document-file-selected .file-summary {
            display: flex !important;
            order: 1 !important;
            width: 100% !important;
            min-height: 50px !important;
            margin: 0 !important;
            padding: 8px 10px !important;
            border: 1px solid #e6d5aa !important;
            border-radius: 10px !important;
            background: #ffffff !important;
        }

        .document-upload-shell .upload-card.has-file .upload-action-row,
        .document-upload-shell .upload-card.document-file-selected .upload-action-row {
            display: flex !important;
            order: 2 !important;
            min-height: 34px !important;
            margin-top: 10px !important;
            justify-content: center !important;
        }

        .document-upload-shell .upload-card.has-file .upload-remove-button,
        .document-upload-shell .upload-card.document-file-selected .upload-remove-button {
            min-height: 34px !important;
            padding: 0 13px !important;
        }

        @media (max-width: 860px) {

            .document-upload-shell .upload-card.has-file,
            .document-upload-shell .upload-card.document-file-selected {
                min-height: 330px !important;
            }
        }

        /*
            |--------------------------------------------------------------------------
            | PEMISAH ANTARBAGIAN FORM — KONSISTEN
            |--------------------------------------------------------------------------
            | Satu gaya garis dipakai untuk seluruh bagian 01–04: tipis, seimbang,
            | dan tanpa titik/ornamen yang terlihat terlepas dari garis.
            */
        .form-section {
            position: relative !important;
            margin-bottom: 34px !important;
            padding-bottom: 34px !important;
            border-bottom: 0 !important;
        }

        .form-section:not(:last-of-type)::before {
            content: none !important;
            display: none !important;
        }

        .form-section:not(:last-of-type)::after {
            content: "" !important;
            position: absolute !important;
            right: 0 !important;
            bottom: 0 !important;
            left: 0 !important;
            height: 1px !important;
            background: linear-gradient(90deg,
                    transparent 0%,
                    rgba(218, 194, 151, 0.40) 7%,
                    rgba(201, 154, 43, 0.82) 50%,
                    rgba(218, 194, 151, 0.40) 93%,
                    transparent 100%) !important;
        }

        .form-section:last-of-type {
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
        }

        .form-section:last-of-type::after {
            content: none !important;
            display: none !important;
        }

        @media (max-width: 760px) {
            .form-section {
                margin-bottom: 28px !important;
                padding-bottom: 28px !important;
            }

            .form-section:not(:last-of-type)::after {
                background: linear-gradient(90deg,
                        transparent 0%,
                        rgba(218, 194, 151, 0.34) 4%,
                        rgba(201, 154, 43, 0.72) 50%,
                        rgba(218, 194, 151, 0.34) 96%,
                        transparent 100%) !important;
            }
        }



        /*
            |--------------------------------------------------------------------------
            | PEMISAH ANTARBAGIAN FORM — AKSEN EMAS SERAGAM
            |--------------------------------------------------------------------------
            | Satu gaya garis emas yang sama untuk seluruh bagian form.
            */
        .form-section {
            position: relative !important;
            margin-bottom: 34px !important;
            padding-bottom: 38px !important;
            border-bottom: 0 !important;
        }

        .form-section:not(:last-of-type)::before {
            content: none !important;
            display: none !important;
        }

        .form-section:not(:last-of-type)::after {
            content: "" !important;
            position: absolute !important;
            right: 0 !important;
            bottom: 0 !important;
            left: 0 !important;

            display: block !important;
            height: 2px !important;

            border-radius: 999px !important;
            background: linear-gradient(90deg,
                    #f3e6c6 0%,
                    #dfb45d 14%,
                    #bd7b12 50%,
                    #dfb45d 86%,
                    #f3e6c6 100%) !important;
            box-shadow: 0 1px 0 rgba(133, 82, 13, 0.14) !important;
            opacity: 1 !important;
            transform: none !important;
        }

        .form-section:last-of-type {
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
            border-bottom: 0 !important;
        }

        @media (max-width: 760px) {
            .form-section {
                margin-bottom: 28px !important;
                padding-bottom: 32px !important;
            }
        }

        /*
    |--------------------------------------------------------------------------
    | GARIS PEMISAH FULL WIDTH DAN SERAGAM
    |--------------------------------------------------------------------------
    */

        .form-section {
            position: relative !important;
            margin-bottom: 34px !important;
            padding-bottom: 42px !important;
            border-bottom: 0 !important;
        }

        .form-section:not(:last-of-type)::before {
            content: none !important;
        }

        .form-section:not(:last-of-type)::after {
            content: "" !important;

            position: absolute !important;
            right: -27px !important;
            bottom: 0 !important;
            left: -27px !important;

            width: auto !important;
            height: 1px !important;

            background: #eadfc8 !important;
        }

        /* Garis sebelum tombol Simpan juga dibuat sama panjang */
        .form-actions {
            margin-right: -27px !important;
            margin-left: -27px !important;

            padding-top: 24px !important;
            padding-right: 27px !important;
            padding-left: 27px !important;

            border-top: 1px solid #eadfc8 !important;
        }

        @media (max-width: 520px) {
            .form-section:not(:last-of-type)::after {
                right: -20px !important;
                left: -20px !important;
            }

            .form-actions {
                margin-right: -20px !important;
                margin-left: -20px !important;

                padding-right: 20px !important;
                padding-left: 20px !important;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | ANIMASI MASUK — INPUT KARYAWAN
        |--------------------------------------------------------------------------
        | Animasi hanya berjalan saat halaman pertama kali dibuka atau setelah
        | navigasi Livewire. Tidak ada gerakan berulang agar form tetap nyaman
        | dan profesional saat diisi.
        */
        @keyframes create-hero-enter {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.992);
                filter: blur(4px);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes create-surface-enter {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes create-section-enter {
            from {
                opacity: 0;
                transform: translateY(13px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes create-card-enter {
            from {
                opacity: 0;
                transform: translateY(14px) scale(0.985);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes create-document-enter {
            from {
                opacity: 0;
                transform: translateY(12px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /*
         | Mengganti animasi lama agar transisi dapat diputar ulang dengan
         | wire:navigate tanpa memengaruhi fungsi input, upload, dan modal.
         */
        .page-hero,
        .validation-alert,
        .form-card {
            animation: none;
        }

        .create-content:not(.create-motion-ready) .page-hero,
        .create-content:not(.create-motion-ready) .validation-alert,
        .create-content:not(.create-motion-ready) .form-card,
        .create-content:not(.create-motion-ready) .form-card__header,
        .create-content:not(.create-motion-ready) .form-section,
        .create-content:not(.create-motion-ready) .form-actions,
        .create-content:not(.create-motion-ready) .upload-card {
            opacity: 0;
        }

        .create-content.create-motion-ready .page-hero {
            animation: create-hero-enter 0.68s cubic-bezier(.22, 1, .36, 1) both;
        }

        .create-content.create-motion-ready .page-hero__content {
            animation: create-surface-enter 0.50s cubic-bezier(.22, 1, .36, 1) 0.12s both;
        }

        .create-content.create-motion-ready .page-hero__action {
            animation: create-card-enter 0.48s cubic-bezier(.22, 1, .36, 1) 0.19s both;
        }

        .create-content.create-motion-ready .validation-alert {
            animation: create-surface-enter 0.45s cubic-bezier(.22, 1, .36, 1) 0.12s both;
        }

        .create-content.create-motion-ready .form-card {
            animation: create-surface-enter 0.62s cubic-bezier(.22, 1, .36, 1) 0.12s both;
        }

        .create-content.create-motion-ready .form-card__header {
            animation: create-surface-enter 0.46s cubic-bezier(.22, 1, .36, 1) 0.25s both;
        }

        .create-content.create-motion-ready .form-section {
            animation: create-section-enter 0.54s cubic-bezier(.22, 1, .36, 1) both;
        }

        .create-content.create-motion-ready .form-section:nth-of-type(1) {
            animation-delay: 0.31s;
        }

        .create-content.create-motion-ready .form-section:nth-of-type(2) {
            animation-delay: 0.39s;
        }

        .create-content.create-motion-ready .form-section:nth-of-type(3) {
            animation-delay: 0.47s;
        }

        .create-content.create-motion-ready .form-section:nth-of-type(4) {
            animation-delay: 0.55s;
        }

        .create-content.create-motion-ready .form-section:nth-of-type(4) .upload-card {
            animation: create-document-enter 0.48s cubic-bezier(.22, 1, .36, 1) both;
        }

        .create-content.create-motion-ready .form-section:nth-of-type(4) .upload-card:nth-child(1) {
            animation-delay: 0.66s;
        }

        .create-content.create-motion-ready .form-section:nth-of-type(4) .upload-card:nth-child(2) {
            animation-delay: 0.73s;
        }

        .create-content.create-motion-ready .form-section:nth-of-type(4) .upload-card:nth-child(3) {
            animation-delay: 0.80s;
        }

        .create-content.create-motion-ready .form-actions {
            animation: create-surface-enter 0.50s cubic-bezier(.22, 1, .36, 1) 0.70s both;
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

            .create-content:not(.create-motion-ready) .page-hero,
            .create-content:not(.create-motion-ready) .validation-alert,
            .create-content:not(.create-motion-ready) .form-card,
            .create-content:not(.create-motion-ready) .form-card__header,
            .create-content:not(.create-motion-ready) .form-section,
            .create-content:not(.create-motion-ready) .form-actions,
            .create-content:not(.create-motion-ready) .upload-card {
                opacity: 1;
            }
        }
    </style>
@endpush

@section('content')
    <section class="create-content">
        <section class="page-hero">
            <div class="page-hero__content">
                <div class="page-hero__eyebrow">
                    <span class="page-hero__dot"></span>
                    PT Karunia Cipta Wasantara
                </div>

                <h1>Input Data Karyawan</h1>

                <p>
                    Lengkapi identitas, perusahaan penempatan, data bank,
                    periode kontrak, dan dokumen pendukung sebelum menyimpan data.
                </p>
            </div>

            <div class="page-hero__action">
                <a href="{{ route('employees.index') }}" wire:navigate class="hero-link">
                    <span>◉</span>
                    Lihat Data Karyawan
                </a>
            </div>
        </section>

        @if ($errors->any())
            <div class="validation-alert">
                <div class="validation-alert__icon">!</div>

                <div>
                    <strong>Data belum dapat disimpan.</strong>
                    Periksa kembali bagian yang diberi tanda merah.

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <section class="form-card">
            <div class="form-card__header">
                <div>
                    <h2>Formulir Data Karyawan</h2>

                    <p>
                        Data yang disimpan akan langsung tersedia pada menu
                        Data Karyawan setelah proses input berhasil.
                    </p>
                </div>

                <span class="form-tag">DATA KARYAWAN</span>
            </div>

            <form method="POST" action="{{ route('employees.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-body">
                    <section class="form-section">
                        <div class="section-heading">
                            <div class="section-number">01</div>

                            <div>
                                <h3>Informasi Pribadi</h3>
                                <p>Identitas utama karyawan.</p>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="field-group">
                                <label for="full_name">
                                    Nama Lengkap <span class="required">*</span>
                                </label>

                                <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}"
                                    placeholder="Masukkan nama lengkap" class="@error('full_name') input-error @enderror"
                                    required>

                                @error('full_name')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="field-group">
                                <label for="phone">
                                    Nomor HP <span class="required">*</span>
                                </label>

                                <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                                    placeholder="Contoh: 081234567890" class="@error('phone') input-error @enderror"
                                    required>

                                @error('phone')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="field-group">
                                <label for="birth_place">
                                    Tempat Lahir <span class="required">*</span>
                                </label>

                                <input type="text" id="birth_place" name="birth_place" value="{{ old('birth_place') }}"
                                    placeholder="Contoh: Surabaya" class="@error('birth_place') input-error @enderror"
                                    required>

                                @error('birth_place')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="field-group">
                                <label for="birth_date">
                                    Tanggal Lahir <span class="required">*</span>
                                </label>

                                <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}"
                                    class="@error('birth_date') input-error @enderror" required>

                                @error('birth_date')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="field-group">
                                <label for="age_preview">Umur</label>

                                <input type="text" id="age_preview" value="-" readonly>

                                <span class="field-help">
                                    Dihitung otomatis berdasarkan tanggal lahir.
                                </span>
                            </div>

                            <div class="field-group">
                                <label for="nik">
                                    Nomor KTP <span class="required">*</span>
                                </label>

                                <input type="text" id="nik" name="nik" value="{{ old('nik') }}"
                                    placeholder="Masukkan nomor KTP" class="@error('nik') input-error @enderror" required>

                                @error('nik')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="field-group field-group--full">
                                <label for="address">
                                    Alamat Lengkap <span class="required">*</span>
                                </label>

                                <textarea id="address" name="address" placeholder="Masukkan alamat lengkap sesuai identitas"
                                    class="@error('address') input-error @enderror" required>{{ old('address') }}</textarea>

                                @error('address')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <section class="form-section">
                        <div class="section-heading">
                            <div class="section-number">02</div>

                            <div>
                                <h3>Penempatan dan Kontrak</h3>
                                <p>Informasi perusahaan penempatan, bagian kerja, dan periode kontrak.</p>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="field-group">
                                <label for="placement_company">
                                    Perusahaan Penempatan <span class="required">*</span>
                                </label>

                                <input type="text" id="placement_company" name="placement_company"
                                    value="{{ old('placement_company') }}" placeholder="Contoh: PT Mitra Sejahtera"
                                    class="@error('placement_company') input-error @enderror" required>

                                @error('placement_company')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="field-group">
                                <label for="department">
                                    Bagian / Divisi <span class="required">*</span>
                                </label>

                                <input type="text" id="department" name="department" value="{{ old('department') }}"
                                    placeholder="Contoh: Security" class="@error('department') input-error @enderror"
                                    required>

                                @error('department')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="field-group">
                                <label for="contract_start">
                                    Awal Kontrak <span class="required">*</span>
                                </label>

                                <input type="date" id="contract_start" name="contract_start"
                                    value="{{ old('contract_start') }}"
                                    class="@error('contract_start') input-error @enderror" required>

                                @error('contract_start')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="field-group">
                                <label for="contract_end">
                                    Akhir Kontrak <span class="required">*</span>
                                </label>

                                <input type="date" id="contract_end" name="contract_end"
                                    value="{{ old('contract_end') }}"
                                    class="@error('contract_end') input-error @enderror" required>

                                <span class="field-help">
                                    Sistem akan memberi tanda saat kontrak mendekati akhir.
                                </span>

                                @error('contract_end')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="field-group field-group--full">
                                <label>
                                    Status Karyawan <span class="required">*</span>
                                </label>

                                <div class="status-options">
                                    <div class="status-option">
                                        <input type="radio" id="status_active" name="status" value="active"
                                            @checked(old('status', 'active') === 'active')>

                                        <label for="status_active">
                                            <span>●</span>
                                            Aktif
                                        </label>
                                    </div>

                                    <div class="status-option">
                                        <input type="radio" id="status_inactive" name="status" value="inactive"
                                            @checked(old('status') === 'inactive')>

                                        <label for="status_inactive">
                                            <span>●</span>
                                            Tidak Aktif
                                        </label>
                                    </div>
                                </div>

                                @error('status')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <section class="form-section">
                        <div class="section-heading">
                            <div class="section-number">03</div>

                            <div>
                                <h3>Data Bank</h3>
                                <p>Informasi rekening karyawan.</p>
                            </div>
                        </div>

                        <div class="form-grid form-grid--three">
                            <div class="field-group">
                                <label for="bank_name">
                                    Nama Bank <span class="required">*</span>
                                </label>

                                <input type="text" id="bank_name" name="bank_name" value="{{ old('bank_name') }}"
                                    placeholder="Contoh: BCA" class="@error('bank_name') input-error @enderror" required>

                                @error('bank_name')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="field-group">
                                <label for="bank_account_number">
                                    Nomor Rekening <span class="required">*</span>
                                </label>

                                <input type="text" id="bank_account_number" name="bank_account_number"
                                    value="{{ old('bank_account_number') }}" placeholder="Masukkan nomor rekening"
                                    class="@error('bank_account_number') input-error @enderror" required>

                                @error('bank_account_number')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="field-group">
                                <label for="bank_account_holder">
                                    Nama Pemilik Rekening
                                </label>

                                <input type="text" id="bank_account_holder" name="bank_account_holder"
                                    value="{{ old('bank_account_holder') }}"
                                    placeholder="Kosongkan bila sama dengan nama karyawan"
                                    class="@error('bank_account_holder') input-error @enderror">

                                @error('bank_account_holder')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <section class="form-section">
                        <div class="section-heading">
                            <div class="section-number">04</div>

                            <div>
                                <h3>Dokumen Karyawan</h3>
                                <p>Unggah foto wajah, KTP, dan KK.</p>
                            </div>
                        </div>

                        <div class="document-upload-shell">
                            <div class="document-upload-shell__inner">
                                <div class="upload-grid">
                                    <div class="upload-card face-upload-card" id="face_upload_card"
                                        data-upload-target="face_photo" role="button" tabindex="0"
                                        aria-label="Pilih foto wajah">
                                        <div class="upload-card__visual">
                                            <div class="face-preview" id="face_preview" aria-label="Preview foto wajah"
                                                hidden></div>

                                            <div class="face-placeholder" id="face_placeholder" aria-hidden="true">
                                                <svg viewBox="0 0 64 64" focusable="false" aria-hidden="true">
                                                    <circle cx="32" cy="22" r="12"></circle>
                                                    <path d="M12 58c1.8-12.2 9.7-19 20-19s18.2 6.8 20 19H12z"></path>
                                                </svg>
                                            </div>
                                        </div>

                                        <div class="upload-card__heading">
                                            <h4>Foto Wajah <span class="required">*</span></h4>
                                            <p>JPG, JPEG, atau PNG.</p>
                                        </div>

                                        <div class="upload-content">
                                            <input type="file" id="face_photo" name="face_photo" class="file-input"
                                                accept=".jpg,.jpeg,.png,image/jpeg,image/png" required>

                                            <div class="upload-action-row">
                                                <label for="face_photo" id="face_choose_button" class="upload-button">
                                                    Pilih File
                                                </label>

                                                <button type="button" id="face_remove_button"
                                                    class="upload-remove-button" hidden>
                                                    Hapus
                                                </button>
                                            </div>

                                            <div class="file-summary" id="face_file_summary" hidden>
                                                <span class="file-summary__icon">◉</span>

                                                <span class="file-summary__detail">
                                                    <span class="file-name" id="face_file_name">
                                                        Belum ada file dipilih
                                                    </span>

                                                    <span class="file-meta" id="face_file_meta">
                                                        Foto wajah
                                                    </span>
                                                </span>
                                            </div>

                                            @error('face_photo')
                                                <span class="file-error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="upload-card" id="ktp_upload_card" data-upload-target="ktp_file"
                                        role="button" tabindex="0" aria-label="Pilih dokumen KTP">
                                        <div class="upload-card__visual">
                                            <div class="document-preview" id="ktp_preview"
                                                aria-label="Preview dokumen KTP">
                                                <span>KTP</span>
                                            </div>
                                        </div>

                                        <div class="upload-card__heading">
                                            <h4>Dokumen KTP <span class="required">*</span></h4>
                                            <p>JPG, JPEG, PNG, atau PDF.</p>
                                        </div>

                                        <div class="upload-content">
                                            <input type="file" id="ktp_file" name="ktp_file" class="file-input"
                                                accept=".jpg,.jpeg,.png,.pdf,image/jpeg,image/png,application/pdf"
                                                required>

                                            <div class="upload-action-row">
                                                <label for="ktp_file" id="ktp_choose_button" class="upload-button">
                                                    Pilih File
                                                </label>

                                                <button type="button" id="ktp_remove_button"
                                                    class="upload-remove-button" hidden>
                                                    Hapus
                                                </button>
                                            </div>

                                            <div class="file-summary" id="ktp_file_summary" hidden>
                                                <span class="file-summary__icon">▣</span>

                                                <span class="file-summary__detail">
                                                    <span class="file-name" id="ktp_file_name">
                                                        Belum ada file dipilih
                                                    </span>

                                                    <span class="file-meta" id="ktp_file_meta">
                                                        Dokumen pendukung
                                                    </span>
                                                </span>
                                            </div>

                                            @error('ktp_file')
                                                <span class="file-error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="upload-card" id="kk_upload_card" data-upload-target="kk_file"
                                        role="button" tabindex="0" aria-label="Pilih dokumen KK">
                                        <div class="upload-card__visual">
                                            <div class="document-preview" id="kk_preview"
                                                aria-label="Preview dokumen KK">
                                                <span>KK</span>
                                            </div>
                                        </div>

                                        <div class="upload-card__heading">
                                            <h4>Dokumen KK <span class="required">*</span></h4>
                                            <p>JPG, JPEG, PNG, atau PDF.</p>
                                        </div>

                                        <div class="upload-content">
                                            <input type="file" id="kk_file" name="kk_file" class="file-input"
                                                accept=".jpg,.jpeg,.png,.pdf,image/jpeg,image/png,application/pdf"
                                                required>

                                            <div class="upload-action-row">
                                                <label for="kk_file" id="kk_choose_button" class="upload-button">
                                                    Pilih File
                                                </label>

                                                <button type="button" id="kk_remove_button" class="upload-remove-button"
                                                    hidden>
                                                    Hapus
                                                </button>
                                            </div>

                                            <div class="file-summary" id="kk_file_summary" hidden>
                                                <span class="file-summary__icon">▤</span>

                                                <span class="file-summary__detail">
                                                    <span class="file-name" id="kk_file_name">
                                                        Belum ada file dipilih
                                                    </span>

                                                    <span class="file-meta" id="kk_file_meta">
                                                        Dokumen pendukung
                                                    </span>
                                                </span>
                                            </div>

                                            @error('kk_file')
                                                <span class="file-error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="form-actions">
                        <div class="form-actions-note">
                            Pastikan nama, nomor KTP, nomor rekening, periode kontrak,
                            serta dokumen yang dipilih sudah sesuai sebelum data disimpan.
                        </div>

                        <div class="action-buttons">
                            <a href="{{ route('employees.index') }}" wire:navigate class="cancel-button">
                                Batal
                            </a>

                            <button type="submit" class="submit-button">
                                <span>✓</span>
                                Simpan Data Karyawan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </section>

        <div id="photo_editor_modal" class="photo-editor-modal" hidden role="dialog" aria-modal="true"
            aria-labelledby="photo_editor_title">
            <div class="photo-editor-dialog">
                <div class="photo-editor-header">
                    <div>
                        <h3 id="photo_editor_title">Atur Tampilan Foto</h3>
                        <p>Geser foto dan atur pembesaran agar wajah tampil proporsional pada kartu karyawan.</p>
                    </div>

                    <button type="button" id="photo_editor_close" class="modal-close-button"
                        aria-label="Tutup pengaturan foto">
                        ×
                    </button>
                </div>

                <div class="photo-editor-body">
                    <div class="photo-crop-stage">
                        <canvas id="photo_crop_canvas" width="600" height="800"
                            aria-label="Area pengaturan foto"></canvas>
                    </div>

                    <p class="photo-editor-help">
                        Tarik foto langsung pada bingkai untuk mengatur posisi wajah.
                        Gunakan penggeser untuk memperbesar atau memperkecil foto.
                    </p>

                    <div class="zoom-control">
                        <div class="zoom-control__top">
                            <span>Ukuran Foto</span>
                            <span id="photo_zoom_value">100%</span>
                        </div>

                        <input type="range" id="photo_zoom" min="1" max="3" step="0.01"
                            value="1" aria-label="Atur pembesaran foto">
                    </div>

                    <div class="editor-actions">
                        <button type="button" id="photo_editor_reset" class="editor-button editor-button--secondary">
                            Atur Ulang
                        </button>

                        <button type="button" id="photo_editor_cancel" class="editor-button editor-button--secondary">
                            Batal
                        </button>

                        <button type="button" id="photo_editor_apply" class="editor-button editor-button--primary">
                            <span>✓</span>
                            Gunakan Foto
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="form_validation_modal" class="form-validation-modal" hidden role="alertdialog" aria-modal="true"
            aria-labelledby="form_validation_title">
            <div class="form-validation-dialog">
                <div class="form-validation-header">
                    <div>
                        <h3 id="form_validation_title">Data Belum Lengkap</h3>
                        <p>Periksa kembali bagian berikut sebelum menyimpan data.</p>
                    </div>

                    <button type="button" id="form_validation_close" class="modal-close-button"
                        aria-label="Tutup pemberitahuan">
                        ×
                    </button>
                </div>

                <div class="form-validation-body">
                    <p class="validation-message-intro" id="form_validation_intro">
                        Lengkapi seluruh data yang diperlukan agar proses penyimpanan dapat dilanjutkan.
                    </p>

                    <ul class="validation-message-list" id="form_validation_messages"></ul>

                    <div class="validation-actions">
                        <button type="button" id="form_validation_ok" class="validation-button">
                            Mengerti
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <div id="remove_confirm_modal" class="remove-confirm-modal" hidden role="alertdialog" aria-modal="true"
            aria-labelledby="remove_confirm_title">
            <div class="remove-confirm-dialog">
                <div class="remove-confirm-header">
                    <div class="remove-confirm-icon">!</div>
                    <div>
                        <h3 id="remove_confirm_title">Hapus File?</h3>
                        <p id="remove_confirm_subtitle">Konfirmasi penghapusan file.</p>
                    </div>
                </div>

                <div class="remove-confirm-body">
                    <p id="remove_confirm_message">
                        File yang telah dipilih akan dibatalkan dan tidak ikut disimpan.
                    </p>

                    <div class="remove-confirm-actions">
                        <button type="button" id="remove_confirm_cancel" class="remove-confirm-cancel">Batal</button>
                        <button type="button" id="remove_confirm_apply" class="remove-confirm-apply">Ya, Hapus</button>
                    </div>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <script id="server_validation_messages" type="application/json">
                    @json($errors->all())
                </script>
        @endif
    </section>
@endsection

@push('scripts')
    <script data-navigate-once>
        (function() {
            const MAX_FILE_SIZE = 2 * 1024 * 1024;

            const cropState = {
                image: null,
                sourceFile: null,
                sourceUrl: null,
                previewUrl: null,
                originalName: '',
                zoom: 1,
                offsetX: 0,
                offsetY: 0,
                baseScale: 1,
                pendingNewPhoto: false,
                isDragging: false,
                lastPointerX: 0,
                lastPointerY: 0,
            };

            const documentPreviewUrls = {
                ktp: null,
                kk: null,
            };

            let validationFocusTarget = null;
            let pendingRemovalType = null;

            function getById(id) {
                return document.getElementById(id);
            }

            function humanFileSize(bytes) {
                if (!bytes) {
                    return '0 KB';
                }

                if (bytes < 1024 * 1024) {
                    return Math.max(1, Math.round(bytes / 1024)) + ' KB';
                }

                return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
            }

            function getFileExtension(file) {
                const name = (file && file.name ? file.name : '').toLowerCase();
                const parts = name.split('.');

                return parts.length > 1 ? parts.pop() : '';
            }

            function isImageFile(file) {
                const extension = getFileExtension(file);

                return [
                    'image/jpeg',
                    'image/png',
                ].includes(file.type) || ['jpg', 'jpeg', 'png'].includes(extension);
            }

            function isDocumentFile(file) {
                const extension = getFileExtension(file);

                return [
                    'image/jpeg',
                    'image/png',
                    'application/pdf',
                ].includes(file.type) || ['jpg', 'jpeg', 'png', 'pdf'].includes(extension);
            }

            function getLatestForm() {
                return document.querySelector('form[enctype="multipart/form-data"]');
            }

            function clearInputError(element) {
                if (!element) {
                    return;
                }

                element.classList.remove('client-input-error');

                const uploadCard = element.closest('.upload-card');

                if (uploadCard) {
                    uploadCard.classList.remove('client-input-error');
                }

                const statusOptions = element.closest('.status-options');

                if (statusOptions) {
                    statusOptions.classList.remove('client-input-error');
                }
            }

            function markInputError(element) {
                if (!element) {
                    return;
                }

                const uploadCard = element.closest('.upload-card');

                if (uploadCard) {
                    uploadCard.classList.add('client-input-error');
                    return;
                }

                const statusOptions = element.closest('.status-options');

                if (statusOptions) {
                    statusOptions.classList.add('client-input-error');
                    return;
                }

                element.classList.add('client-input-error');
            }

            function showValidationModal(messages, focusTarget = null, title = 'Data Belum Lengkap') {
                const modal = getById('form_validation_modal');
                const titleElement = getById('form_validation_title');
                const messageList = getById('form_validation_messages');

                if (!modal || !messageList) {
                    return;
                }

                validationFocusTarget = focusTarget;

                if (titleElement) {
                    titleElement.textContent = title;
                }

                messageList.innerHTML = '';

                [...new Set(messages)].forEach(function(message) {
                    const item = document.createElement('li');
                    item.textContent = message;
                    messageList.appendChild(item);
                });

                modal.hidden = false;
                document.body.style.overflow = 'hidden';
            }

            function closeValidationModal() {
                const modal = getById('form_validation_modal');

                if (modal) {
                    modal.hidden = true;
                }

                if (!getById('photo_editor_modal') || getById('photo_editor_modal').hidden) {
                    document.body.style.overflow = '';
                }

                if (validationFocusTarget && typeof validationFocusTarget.focus === 'function') {
                    validationFocusTarget.focus();
                }

                validationFocusTarget = null;
            }

            function resetFacePreview() {
                const preview = getById('face_preview');
                const summary = getById('face_file_summary');
                const name = getById('face_file_name');
                const meta = getById('face_file_meta');
                const chooseButton = getById('face_choose_button');
                const placeholder = getById('face_placeholder');
                const removeButton = getById('face_remove_button');
                const card = getById('face_upload_card');

                if (preview) {
                    preview.innerHTML = '';
                    preview.hidden = true;
                }

                if (placeholder) {
                    placeholder.hidden = false;
                }

                if (summary) {
                    summary.hidden = true;
                }

                if (name) {
                    name.textContent = 'Belum ada file dipilih';
                }

                if (meta) {
                    meta.textContent = 'Foto wajah';
                }

                if (chooseButton) {
                    chooseButton.hidden = false;
                }

                if (removeButton) {
                    removeButton.hidden = true;
                }

                if (card) {
                    card.classList.remove('has-file', 'client-input-error');
                }
            }

            function clearFaceSelection() {
                const input = getById('face_photo');

                if (input) {
                    input.value = '';
                }

                if (cropState.sourceUrl) {
                    URL.revokeObjectURL(cropState.sourceUrl);
                }

                if (cropState.previewUrl) {
                    URL.revokeObjectURL(cropState.previewUrl);
                }

                cropState.image = null;
                cropState.sourceFile = null;
                cropState.sourceUrl = null;
                cropState.previewUrl = null;
                cropState.originalName = '';
                cropState.zoom = 1;
                cropState.offsetX = 0;
                cropState.offsetY = 0;
                cropState.baseScale = 1;
                cropState.pendingNewPhoto = false;

                resetFacePreview();
            }

            function setFacePreview(file) {
                const preview = getById('face_preview');
                const summary = getById('face_file_summary');
                const name = getById('face_file_name');
                const meta = getById('face_file_meta');
                const chooseButton = getById('face_choose_button');
                const placeholder = getById('face_placeholder');
                const removeButton = getById('face_remove_button');
                const card = getById('face_upload_card');

                if (!preview || !file) {
                    return;
                }

                if (cropState.previewUrl) {
                    URL.revokeObjectURL(cropState.previewUrl);
                }

                cropState.previewUrl = URL.createObjectURL(file);

                const image = document.createElement('img');
                image.src = cropState.previewUrl;
                image.alt = 'Preview foto wajah';

                preview.innerHTML = '';
                preview.hidden = false;
                preview.appendChild(image);

                if (placeholder) {
                    placeholder.hidden = true;
                }

                if (name) {
                    name.textContent = file.name;
                }

                if (meta) {
                    meta.textContent = 'Foto sudah diatur · ' + humanFileSize(file.size);
                }

                if (summary) {
                    summary.hidden = false;
                }

                if (chooseButton) {
                    chooseButton.hidden = true;
                }

                if (removeButton) {
                    removeButton.hidden = false;
                }

                if (card) {
                    card.classList.add('has-file');
                    card.classList.remove('client-input-error');
                }
            }

            function resetDocumentPreview(documentType) {
                const preview = getById(documentType + '_preview');
                const summary = getById(documentType + '_file_summary');
                const name = getById(documentType + '_file_name');
                const meta = getById(documentType + '_file_meta');
                const chooseButton = getById(documentType + '_choose_button');
                const removeButton = getById(documentType + '_remove_button');
                const card = getById(documentType + '_upload_card');
                const symbol = documentType === 'ktp' ? 'KTP' : 'KK';

                if (documentPreviewUrls[documentType]) {
                    URL.revokeObjectURL(documentPreviewUrls[documentType]);
                    documentPreviewUrls[documentType] = null;
                }

                if (preview) {
                    preview.classList.remove('document-preview--pdf', 'has-preview');
                    preview.innerHTML = '<span>' + symbol + '</span>';
                }

                if (summary) {
                    summary.hidden = true;
                }

                if (name) {
                    name.textContent = 'Belum ada file dipilih';
                }

                if (meta) {
                    meta.textContent = 'Dokumen pendukung';
                }

                if (chooseButton) {
                    chooseButton.hidden = false;
                }

                if (removeButton) {
                    removeButton.hidden = true;
                }

                if (card) {
                    card.classList.remove(
                        'has-file',
                        'document-file-selected',
                        'client-input-error'
                    );
                }
            }

            function clearDocumentSelection(documentType) {
                const input = getById(documentType + '_file');

                if (input) {
                    input.value = '';
                }

                resetDocumentPreview(documentType);
            }

            function setDocumentPreview(documentType, file) {
                const preview = getById(documentType + '_preview');
                const summary = getById(documentType + '_file_summary');
                const name = getById(documentType + '_file_name');
                const meta = getById(documentType + '_file_meta');
                const chooseButton = getById(documentType + '_choose_button');
                const removeButton = getById(documentType + '_remove_button');
                const card = getById(documentType + '_upload_card');

                if (!preview || !file) {
                    return;
                }

                if (documentPreviewUrls[documentType]) {
                    URL.revokeObjectURL(documentPreviewUrls[documentType]);
                    documentPreviewUrls[documentType] = null;
                }

                preview.classList.remove('document-preview--pdf');
                preview.classList.add('has-preview');

                documentPreviewUrls[documentType] = URL.createObjectURL(file);

                if (isImageFile(file)) {
                    const image = document.createElement('img');
                    image.src = documentPreviewUrls[documentType];
                    image.alt = 'Preview dokumen ' + documentType.toUpperCase();

                    preview.innerHTML = '';
                    preview.appendChild(image);
                } else {
                    preview.classList.add('document-preview--pdf');

                    const pdfFrame = document.createElement('iframe');
                    pdfFrame.src = documentPreviewUrls[documentType] +
                        '#toolbar=0&navpanes=0&scrollbar=0&view=FitH';
                    pdfFrame.title = 'Preview halaman pertama dokumen ' +
                        documentType.toUpperCase();
                    pdfFrame.setAttribute('tabindex', '-1');
                    pdfFrame.setAttribute('aria-hidden', 'true');

                    preview.innerHTML = '';
                    preview.appendChild(pdfFrame);
                }

                if (name) {
                    name.textContent = file.name;
                }

                if (meta) {
                    meta.textContent = (
                        isImageFile(file) ? 'Gambar' : 'Dokumen PDF'
                    ) + ' · ' + humanFileSize(file.size);
                }

                if (summary) {
                    summary.hidden = false;
                }

                if (chooseButton) {
                    chooseButton.hidden = true;
                }

                if (removeButton) {
                    removeButton.hidden = false;
                }

                if (card) {
                    card.classList.add('has-file', 'document-file-selected');
                    card.classList.remove('client-input-error');
                }

                const input = getById(documentType + '_file');
                clearInputError(input);
            }


            function showRemoveConfirmation(type) {
                const modal = getById('remove_confirm_modal');
                const title = getById('remove_confirm_title');
                const subtitle = getById('remove_confirm_subtitle');
                const message = getById('remove_confirm_message');

                if (!modal) {
                    return;
                }

                const labels = {
                    face: 'foto wajah',
                    ktp: 'dokumen KTP',
                    kk: 'dokumen KK',
                };

                const label = labels[type] || 'file ini';
                pendingRemovalType = type;

                if (title) {
                    title.textContent = 'Hapus ' + label.charAt(0).toUpperCase() + label.slice(1) + '?';
                }

                if (subtitle) {
                    subtitle.textContent = 'Konfirmasi penghapusan ' + label + '.';
                }

                if (message) {
                    message.textContent =
                        'File yang telah dipilih akan dibatalkan dan tidak ikut disimpan. Anda tetap dapat memilih file lain setelahnya.';
                }

                modal.hidden = false;
                document.body.style.overflow = 'hidden';
            }

            function closeRemoveConfirmation() {
                const modal = getById('remove_confirm_modal');

                if (modal) {
                    modal.hidden = true;
                }

                if (
                    (!getById('photo_editor_modal') || getById('photo_editor_modal').hidden) &&
                    (!getById('form_validation_modal') || getById('form_validation_modal').hidden)
                ) {
                    document.body.style.overflow = '';
                }

                pendingRemovalType = null;
            }

            function confirmPendingRemoval() {
                if (pendingRemovalType === 'face') {
                    clearFaceSelection();
                }

                if (pendingRemovalType === 'ktp' || pendingRemovalType === 'kk') {
                    clearDocumentSelection(pendingRemovalType);
                }

                closeRemoveConfirmation();
            }

            function getCropCanvas() {
                return getById('photo_crop_canvas');
            }

            function clampCropOffsets() {
                const canvas = getCropCanvas();

                if (!canvas || !cropState.image) {
                    return;
                }

                const scaledWidth = cropState.image.width * cropState.baseScale * cropState.zoom;
                const scaledHeight = cropState.image.height * cropState.baseScale * cropState.zoom;

                const maxOffsetX = Math.max(0, (scaledWidth - canvas.width) / 2);
                const maxOffsetY = Math.max(0, (scaledHeight - canvas.height) / 2);

                cropState.offsetX = Math.min(maxOffsetX, Math.max(-maxOffsetX, cropState.offsetX));
                cropState.offsetY = Math.min(maxOffsetY, Math.max(-maxOffsetY, cropState.offsetY));
            }

            function drawCropCanvas() {
                const canvas = getCropCanvas();

                if (!canvas || !cropState.image) {
                    return;
                }

                const context = canvas.getContext('2d');
                const scale = cropState.baseScale * cropState.zoom;
                const drawWidth = cropState.image.width * scale;
                const drawHeight = cropState.image.height * scale;

                clampCropOffsets();

                context.clearRect(0, 0, canvas.width, canvas.height);
                context.fillStyle = '#f6ead0';
                context.fillRect(0, 0, canvas.width, canvas.height);

                const x = (canvas.width - drawWidth) / 2 + cropState.offsetX;
                const y = (canvas.height - drawHeight) / 2 + cropState.offsetY;

                context.drawImage(cropState.image, x, y, drawWidth, drawHeight);

                const zoomValue = getById('photo_zoom_value');

                if (zoomValue) {
                    zoomValue.textContent = Math.round(cropState.zoom * 100) + '%';
                }
            }

            function resetCropPosition() {
                const zoom = getById('photo_zoom');

                cropState.zoom = 1;
                cropState.offsetX = 0;
                cropState.offsetY = 0;

                if (zoom) {
                    zoom.value = '1';
                }

                drawCropCanvas();
            }

            function openPhotoEditor() {
                const modal = getById('photo_editor_modal');

                if (!modal || !cropState.image) {
                    return;
                }

                modal.hidden = false;
                document.body.style.overflow = 'hidden';
                drawCropCanvas();
            }

            function closePhotoEditor(clearPendingPhoto = false) {
                const modal = getById('photo_editor_modal');

                if (modal) {
                    modal.hidden = true;
                }

                if (!getById('form_validation_modal') || getById('form_validation_modal').hidden) {
                    document.body.style.overflow = '';
                }

                if (clearPendingPhoto && cropState.pendingNewPhoto) {
                    clearFaceSelection();
                }
            }

            function loadPhotoForEditor(file) {
                if (cropState.sourceUrl) {
                    URL.revokeObjectURL(cropState.sourceUrl);
                }

                cropState.sourceFile = file;
                cropState.originalName = file.name;
                cropState.pendingNewPhoto = true;
                cropState.sourceUrl = URL.createObjectURL(file);

                const image = new Image();

                image.onload = function() {
                    const canvas = getCropCanvas();

                    if (!canvas) {
                        return;
                    }

                    cropState.image = image;
                    cropState.baseScale = Math.max(
                        canvas.width / image.width,
                        canvas.height / image.height
                    );

                    resetCropPosition();
                    openPhotoEditor();
                };

                image.onerror = function() {
                    clearFaceSelection();
                    showValidationModal([
                        'Foto wajah tidak dapat diproses. Gunakan file JPG atau PNG lain.'
                    ], getById('face_photo'), 'Foto Tidak Dapat Diproses');
                };

                image.src = cropState.sourceUrl;
            }

            function applyCroppedPhoto() {
                const canvas = getCropCanvas();
                const input = getById('face_photo');

                if (!canvas || !input || !cropState.image) {
                    return;
                }

                canvas.toBlob(function(blob) {
                    if (!blob) {
                        showValidationModal([
                            'Foto tidak dapat diproses. Silakan pilih file foto lain.'
                        ], input, 'Foto Tidak Dapat Diproses');

                        return;
                    }

                    const baseName = (cropState.originalName || 'foto-wajah')
                        .replace(/\.[^/.]+$/, '');

                    const croppedFile = new File(
                        [blob],
                        baseName + '-crop.jpg', {
                            type: 'image/jpeg'
                        }
                    );

                    if (croppedFile.size > MAX_FILE_SIZE) {
                        showValidationModal([
                            'Hasil foto melebihi batas 2 MB. Gunakan foto dengan ukuran lebih kecil.'
                        ], input, 'Ukuran Foto Terlalu Besar');

                        return;
                    }

                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(croppedFile);
                    input.files = dataTransfer.files;

                    cropState.pendingNewPhoto = false;

                    setFacePreview(croppedFile);
                    clearInputError(input);
                    closePhotoEditor(false);
                }, 'image/jpeg', 0.90);
            }

            function validateSelectedFile(file, type) {
                if (!file) {
                    return type === 'face' ?
                        'Foto wajah wajib dipilih.' :
                        'Dokumen ' + type.toUpperCase() + ' wajib dipilih.';
                }

                if (file.size > MAX_FILE_SIZE) {
                    return type === 'face' ?
                        'Ukuran foto wajah maksimal 2 MB.' :
                        'Ukuran dokumen ' + type.toUpperCase() + ' maksimal 2 MB.';
                }

                if (type === 'face' && !isImageFile(file)) {
                    return 'Foto wajah hanya boleh menggunakan format JPG, JPEG, atau PNG.';
                }

                if (type !== 'face' && !isDocumentFile(file)) {
                    return 'Dokumen ' + type.toUpperCase() + ' hanya boleh menggunakan JPG, JPEG, PNG, atau PDF.';
                }

                return null;
            }

            function validateCreateEmployeeForm(form) {
                const errors = [];
                let firstInvalid = null;

                function addError(element, message) {
                    errors.push(message);
                    markInputError(element);

                    if (!firstInvalid) {
                        firstInvalid = element;
                    }
                }

                const requiredTextFields = [
                    ['full_name', 'Nama lengkap wajib diisi.'],
                    ['phone', 'Nomor HP wajib diisi.'],
                    ['birth_place', 'Tempat lahir wajib diisi.'],
                    ['birth_date', 'Tanggal lahir wajib diisi.'],
                    ['nik', 'Nomor KTP wajib diisi.'],
                    ['address', 'Alamat lengkap wajib diisi.'],
                    ['placement_company', 'Perusahaan penempatan wajib diisi.'],
                    ['department', 'Bagian atau divisi wajib diisi.'],
                    ['contract_start', 'Tanggal awal kontrak wajib diisi.'],
                    ['contract_end', 'Tanggal akhir kontrak wajib diisi.'],
                    ['bank_name', 'Nama bank wajib diisi.'],
                    ['bank_account_number', 'Nomor rekening wajib diisi.'],
                ];

                requiredTextFields.forEach(function([id, message]) {
                    const field = getById(id);

                    if (!field || !field.value.trim()) {
                        addError(field, message);
                    }
                });

                const birthDate = getById('birth_date');
                const contractStart = getById('contract_start');
                const contractEnd = getById('contract_end');

                if (birthDate && birthDate.value) {
                    const selectedBirthDate = new Date(birthDate.value + 'T00:00:00');
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);

                    if (selectedBirthDate > today) {
                        addError(birthDate, 'Tanggal lahir tidak boleh melebihi hari ini.');
                    }
                }

                if (contractStart && contractEnd && contractStart.value && contractEnd.value) {
                    if (contractEnd.value < contractStart.value) {
                        addError(contractEnd, 'Tanggal akhir kontrak harus sama atau setelah tanggal awal kontrak.');
                    }
                }

                const selectedStatus = document.querySelector('input[name="status"]:checked');

                if (!selectedStatus) {
                    const statusGroup = document.querySelector('.status-options');
                    addError(statusGroup, 'Status karyawan wajib dipilih.');
                }

                [
                    ['face_photo', 'face'],
                    ['ktp_file', 'ktp'],
                    ['kk_file', 'kk'],
                ].forEach(function([inputId, type]) {
                    const input = getById(inputId);
                    const file = input && input.files ? input.files[0] : null;
                    const error = validateSelectedFile(file, type);

                    if (error) {
                        addError(input, error);
                    }
                });

                return {
                    errors: errors,
                    firstInvalid: firstInvalid,
                };
            }

            function bindCropCanvas() {
                const canvas = getCropCanvas();

                if (!canvas || canvas.dataset.cropBound === 'true') {
                    return;
                }

                canvas.dataset.cropBound = 'true';

                canvas.addEventListener('pointerdown', function(event) {
                    if (!cropState.image) {
                        return;
                    }

                    cropState.isDragging = true;
                    cropState.lastPointerX = event.clientX;
                    cropState.lastPointerY = event.clientY;

                    canvas.classList.add('is-dragging');
                    canvas.setPointerCapture(event.pointerId);
                });

                canvas.addEventListener('pointermove', function(event) {
                    if (!cropState.isDragging || !cropState.image) {
                        return;
                    }

                    const rect = canvas.getBoundingClientRect();
                    const factorX = canvas.width / rect.width;
                    const factorY = canvas.height / rect.height;

                    cropState.offsetX += (event.clientX - cropState.lastPointerX) * factorX;
                    cropState.offsetY += (event.clientY - cropState.lastPointerY) * factorY;

                    cropState.lastPointerX = event.clientX;
                    cropState.lastPointerY = event.clientY;

                    drawCropCanvas();
                });

                function stopDragging(event) {
                    cropState.isDragging = false;
                    canvas.classList.remove('is-dragging');

                    if (event && canvas.hasPointerCapture(event.pointerId)) {
                        canvas.releasePointerCapture(event.pointerId);
                    }
                }

                canvas.addEventListener('pointerup', stopDragging);
                canvas.addEventListener('pointercancel', stopDragging);
                canvas.addEventListener('pointerleave', function() {
                    if (cropState.isDragging) {
                        cropState.isDragging = false;
                        canvas.classList.remove('is-dragging');
                    }
                });
            }

            function initializeCreateEmployeeForm() {
                const form = getLatestForm();

                if (!form || form.dataset.kcwFormInitialized === 'true') {
                    return;
                }

                form.dataset.kcwFormInitialized = 'true';
                form.noValidate = true;

                bindCropCanvas();

                const birthDateInput = getById('birth_date');
                const agePreview = getById('age_preview');

                function updateAgePreview() {
                    if (!birthDateInput || !agePreview || !birthDateInput.value) {
                        if (agePreview) {
                            agePreview.value = '-';
                        }

                        return;
                    }

                    const birthDate = new Date(birthDateInput.value + 'T00:00:00');
                    const today = new Date();

                    let age = today.getFullYear() - birthDate.getFullYear();

                    const monthDifference = today.getMonth() - birthDate.getMonth();
                    const dayDifference = today.getDate() - birthDate.getDate();

                    if (
                        monthDifference < 0 ||
                        (monthDifference === 0 && dayDifference < 0)
                    ) {
                        age--;
                    }

                    agePreview.value = age >= 0 ? age + ' tahun' : '-';
                }

                if (birthDateInput) {
                    birthDateInput.addEventListener('change', updateAgePreview);
                    updateAgePreview();
                }

                const contractStart = getById('contract_start');
                const contractEnd = getById('contract_end');

                function updateContractMinimumDate() {
                    if (!contractStart || !contractEnd) {
                        return;
                    }

                    contractEnd.min = contractStart.value;

                    if (
                        contractEnd.value &&
                        contractStart.value &&
                        contractEnd.value < contractStart.value
                    ) {
                        contractEnd.value = '';
                    }
                }

                if (contractStart && contractEnd) {
                    contractStart.addEventListener('change', updateContractMinimumDate);
                    updateContractMinimumDate();
                }

                const faceInput = getById('face_photo');

                if (faceInput) {
                    faceInput.addEventListener('change', function() {
                        const file = faceInput.files && faceInput.files[0];
                        const error = validateSelectedFile(file, 'face');

                        if (error) {
                            clearFaceSelection();
                            showValidationModal([error], faceInput, 'Foto Wajah Belum Sesuai');
                            return;
                        }

                        clearInputError(faceInput);
                        loadPhotoForEditor(file);
                    });
                }

                ['ktp', 'kk'].forEach(function(documentType) {
                    const input = getById(documentType + '_file');

                    if (!input) {
                        return;
                    }

                    input.addEventListener('change', function() {
                        const file = input.files && input.files[0];
                        const error = validateSelectedFile(file, documentType);

                        if (error) {
                            clearDocumentSelection(documentType);
                            showValidationModal([error], input, 'Dokumen Belum Sesuai');
                            return;
                        }

                        setDocumentPreview(documentType, file);
                    });
                });

                form.querySelectorAll('input, textarea, select').forEach(function(field) {
                    field.addEventListener('input', function() {
                        clearInputError(field);
                    });

                    field.addEventListener('change', function() {
                        clearInputError(field);
                    });
                });

                form.addEventListener('submit', function(event) {
                    form.querySelectorAll('.client-input-error').forEach(function(element) {
                        element.classList.remove('client-input-error');
                    });

                    const result = validateCreateEmployeeForm(form);

                    if (result.errors.length > 0) {
                        event.preventDefault();

                        showValidationModal(
                            result.errors,
                            result.firstInvalid,
                            'Data Belum Dapat Disimpan'
                        );
                    }
                });



                form.querySelectorAll('[data-upload-target]').forEach(function(card) {
                    if (card.dataset.uploadCardBound === 'true') {
                        return;
                    }

                    card.dataset.uploadCardBound = 'true';

                    card.addEventListener('keydown', function(event) {
                        if (event.key !== 'Enter' && event.key !== ' ') {
                            return;
                        }

                        event.preventDefault();

                        if (card.classList.contains('has-file')) {
                            return;
                        }

                        const targetInput = getById(card.dataset.uploadTarget);

                        if (targetInput) {
                            targetInput.click();
                        }
                    });
                });

                const serverErrors = getById('server_validation_messages');

                if (serverErrors) {
                    try {
                        const messages = JSON.parse(serverErrors.textContent);

                        if (Array.isArray(messages) && messages.length > 0) {
                            window.setTimeout(function() {
                                showValidationModal(
                                    messages,
                                    null,
                                    'Data Belum Dapat Disimpan'
                                );
                            }, 120);
                        }
                    } catch (error) {
                        console.error('Server validation messages could not be read.', error);
                    }
                }
            }

            document.addEventListener('click', function(event) {
                const uploadCard = event.target.closest('[data-upload-target]');

                if (
                    uploadCard &&
                    !uploadCard.classList.contains('has-file') &&
                    !event.target.closest('button, label, input, a, [role="dialog"]')
                ) {
                    const targetInput = getById(uploadCard.dataset.uploadTarget);

                    if (targetInput) {
                        targetInput.click();
                    }

                    return;
                }

                const faceRemove = event.target.closest('#face_remove_button');

                if (faceRemove) {
                    showRemoveConfirmation('face');
                    return;
                }

                const ktpRemove = event.target.closest('#ktp_remove_button');

                if (ktpRemove) {
                    showRemoveConfirmation('ktp');
                    return;
                }

                const kkRemove = event.target.closest('#kk_remove_button');

                if (kkRemove) {
                    showRemoveConfirmation('kk');
                    return;
                }

                if (event.target.closest('#remove_confirm_apply')) {
                    confirmPendingRemoval();
                    return;
                }

                if (event.target.closest('#remove_confirm_cancel')) {
                    closeRemoveConfirmation();
                    return;
                }

                const removeModal = getById('remove_confirm_modal');

                if (removeModal && event.target === removeModal) {
                    closeRemoveConfirmation();
                    return;
                }

                if (event.target.closest('#photo_editor_close') || event.target.closest(
                    '#photo_editor_cancel')) {
                    closePhotoEditor(true);
                    return;
                }

                if (event.target.closest('#photo_editor_reset')) {
                    resetCropPosition();
                    return;
                }

                if (event.target.closest('#photo_editor_apply')) {
                    applyCroppedPhoto();
                    return;
                }

                if (event.target.closest('#form_validation_close') || event.target.closest(
                        '#form_validation_ok')) {
                    closeValidationModal();
                    return;
                }

                const photoModal = getById('photo_editor_modal');

                if (photoModal && event.target === photoModal) {
                    closePhotoEditor(true);
                    return;
                }

                const validationModal = getById('form_validation_modal');

                if (validationModal && event.target === validationModal) {
                    closeValidationModal();
                }
            });

            document.addEventListener('input', function(event) {
                if (event.target && event.target.id === 'photo_zoom') {
                    cropState.zoom = Number(event.target.value) || 1;
                    drawCropCanvas();
                }
            });

            document.addEventListener('keydown', function(event) {
                if (event.key !== 'Escape') {
                    return;
                }

                const photoModal = getById('photo_editor_modal');
                const validationModal = getById('form_validation_modal');
                const removeModal = getById('remove_confirm_modal');

                if (removeModal && !removeModal.hidden) {
                    closeRemoveConfirmation();
                    return;
                }

                if (photoModal && !photoModal.hidden) {
                    closePhotoEditor(true);
                    return;
                }

                if (validationModal && !validationModal.hidden) {
                    closeValidationModal();
                }
            });

            function runCreateEntryAnimation() {
                const createContent = document.querySelector('.create-content');

                if (!createContent) {
                    return;
                }

                createContent.classList.remove('create-motion-ready');

                window.requestAnimationFrame(function() {
                    window.requestAnimationFrame(function() {
                        createContent.classList.add('create-motion-ready');
                    });
                });
            }

            if (!window.__kcwCreateMotionBound) {
                window.__kcwCreateMotionBound = true;

                document.addEventListener('livewire:navigated', function() {
                    initializeCreateEmployeeForm();
                    runCreateEntryAnimation();
                });

                document.addEventListener('DOMContentLoaded', runCreateEntryAnimation);
            }

            initializeCreateEmployeeForm();
            runCreateEntryAnimation();
        })();
    </script>
@endpush
