<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pembayaran — Coursify</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --navy:        #1E3A5F;
      --navy-dark:   #152B48;
      --lav-1:       #F5F1FC;
      --lav-2:       #E8E1F3;
      --lav-3:       #D4CDF0;
      --lav-4:       #B8AFEB;
      --purple:      #7B6FE8;
      --purple-dark: #5B4FD4;
      --teal:        #00C896;
      --orange:      #FF8A5B;
      --danger:      #ef4444;
      --text:        #1A1825;
      --text-soft:   #4A4660;
      --muted:       #8B87A8;
      --border:      rgba(123,111,232,0.15);
      --border-hover:rgba(123,111,232,0.4);
      --card-bg:     rgba(255,255,255,0.75);
      --font-serif:  'Instrument Serif', serif;
      --font-sans:   'Inter', sans-serif;
    }

    html { scroll-behavior: smooth; }

    body {
      font-family: var(--font-sans);
      color: var(--text);
      background: linear-gradient(180deg, #EDE5F9 0%, #D8CEEE 50%, #C4B8E8 100%);
      background-attachment: fixed;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      -webkit-font-smoothing: antialiased;
    }

    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background:
        radial-gradient(ellipse 800px 400px at 20% 10%, rgba(255,255,255,0.5), transparent),
        radial-gradient(ellipse 600px 300px at 80% 30%, rgba(255,255,255,0.4), transparent),
        radial-gradient(ellipse 700px 400px at 50% 90%, rgba(255,255,255,0.3), transparent);
      pointer-events: none;
      z-index: 0;
    }

    /* ── NAV ── */
    nav {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 18px 40px;
      border-bottom: 1px solid rgba(255,255,255,0.6);
      background: rgba(237,229,249,0.85);
      backdrop-filter: blur(16px);
      position: sticky;
      top: 0;
      z-index: 100;
    }
    .logo {
      font-family: var(--font-serif);
      font-size: 22px;
      font-weight: 400;
      letter-spacing: -0.3px;
      color: var(--purple);
    }
    .nav-secure {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 12px;
      font-weight: 500;
      color: var(--text-soft);
    }
    .nav-secure svg { width: 14px; height: 14px; }

    /* ── LAYOUT ── */
    .page-wrap {
      flex: 1;
      display: grid;
      grid-template-columns: 1fr 420px;
      max-width: 980px;
      margin: 0 auto;
      padding: 48px 24px;
      gap: 40px;
      width: 100%;
      position: relative;
      z-index: 1;
    }

    /* ── LEFT PANEL ── */
    .left-panel { display: flex; flex-direction: column; gap: 28px; }

    /* STEP HEADER */
    .step-header {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 4px;
    }
    .step-num {
      width: 24px; height: 24px;
      border-radius: 50%;
      background: var(--purple);
      font-size: 12px;
      font-weight: 700;
      color: white;
      display: flex; align-items: center; justify-content: center;
      font-family: var(--font-sans);
      flex-shrink: 0;
    }
    .step-num.done { background: var(--teal); }
    h2.section-title {
      font-family: var(--font-sans);
      font-size: 16px;
      font-weight: 600;
      color: var(--text);
    }

    /* PLAN PICKER */
    .plan-cards {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
    }
    .plan-card {
      border: 1.5px solid rgba(255,255,255,0.7);
      border-radius: 16px;
      padding: 18px;
      cursor: pointer;
      transition: all 0.2s;
      background: var(--card-bg);
      backdrop-filter: blur(12px);
      position: relative;
      box-shadow: 0 2px 8px rgba(123,111,232,0.06);
    }
    .plan-card:hover {
      border-color: var(--border-hover);
      background: rgba(255,255,255,0.9);
      box-shadow: 0 4px 16px rgba(123,111,232,0.15);
    }
    .plan-card.selected {
      border-color: var(--purple);
      background: rgba(123,111,232,0.08);
      box-shadow: 0 0 0 1px var(--purple) inset, 0 4px 16px rgba(123,111,232,0.15);
    }
    .plan-badge {
      position: absolute;
      top: -10px; right: 12px;
      background: var(--purple);
      color: white;
      font-size: 10px;
      font-weight: 700;
      padding: 2px 10px;
      border-radius: 20px;
      letter-spacing: 0.3px;
    }
    .plan-name {
      font-family: var(--font-sans);
      font-size: 14px;
      font-weight: 600;
      color: var(--text-soft);
      margin-bottom: 4px;
    }
    .plan-price {
      font-family: var(--font-serif);
      font-size: 30px;
      font-weight: 400;
      color: var(--purple);
      line-height: 1;
    }
    .plan-price span { font-size: 13px; font-weight: 400; color: var(--muted); font-family: var(--font-sans); }
    .plan-features {
      margin-top: 12px;
      display: flex;
      flex-direction: column;
      gap: 6px;
    }
    .plan-feature {
      font-size: 12px;
      color: var(--text-soft);
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .plan-feature::before {
      content: '✓';
      color: var(--teal);
      font-weight: 700;
      font-size: 11px;
    }
    .plan-card.selected .plan-feature { color: var(--purple-dark); }
    .plan-card.selected .plan-name { color: var(--purple); }

    /* BILLING TOGGLE */
    .billing-row {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 14px 16px;
      border-radius: 12px;
      background: rgba(255,255,255,0.6);
      backdrop-filter: blur(8px);
      border: 1px solid rgba(255,255,255,0.8);
    }
    .billing-label { font-size: 13px; color: var(--text-soft); flex: 1; }
    .billing-label strong { color: var(--text); font-weight: 600; }
    .toggle-pill {
      width: 42px; height: 22px;
      background: var(--lav-3);
      border-radius: 11px;
      position: relative;
      cursor: pointer;
      border: 1px solid var(--lav-4);
      transition: background 0.2s;
      flex-shrink: 0;
    }
    .toggle-pill.on { background: var(--purple); border-color: var(--purple); }
    .toggle-pill::after {
      content: '';
      position: absolute;
      width: 16px; height: 16px;
      background: white;
      border-radius: 50%;
      top: 2px; left: 2px;
      transition: transform 0.2s;
      box-shadow: 0 1px 3px rgba(0,0,0,0.15);
    }
    .toggle-pill.on::after { transform: translateX(20px); }
    .save-tag {
      background: rgba(0,200,150,0.12);
      color: var(--teal);
      font-size: 11px;
      font-weight: 600;
      padding: 2px 8px;
      border-radius: 20px;
    }

    /* PAYMENT METHODS */
    .method-tabs {
      display: flex;
      gap: 8px;
      padding: 4px;
      background: rgba(255,255,255,0.5);
      backdrop-filter: blur(8px);
      border-radius: 12px;
      border: 1px solid rgba(255,255,255,0.8);
    }
    .method-tab {
      flex: 1;
      padding: 10px;
      border-radius: 9px;
      cursor: pointer;
      text-align: center;
      font-size: 12.5px;
      font-weight: 500;
      color: var(--muted);
      transition: all 0.18s;
      border: none;
      background: transparent;
      font-family: var(--font-sans);
    }
    .method-tab:hover { color: var(--text-soft); background: rgba(255,255,255,0.5); }
    .method-tab.active {
      background: white;
      color: var(--text);
      box-shadow: 0 1px 4px rgba(123,111,232,0.15);
    }
    .method-tab-icon { font-size: 18px; display: block; margin-bottom: 3px; }

    /* QRIS SECTION */
    .qris-panel { display: flex; flex-direction: column; gap: 16px; }
    .ewallet-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 10px;
    }
    .ewallet-btn {
      border: 1.5px solid rgba(255,255,255,0.7);
      border-radius: 12px;
      padding: 14px 10px;
      cursor: pointer;
      background: rgba(255,255,255,0.6);
      backdrop-filter: blur(8px);
      text-align: center;
      transition: all 0.18s;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 6px;
    }
    .ewallet-btn:hover { border-color: var(--border-hover); background: rgba(255,255,255,0.85); }
    .ewallet-btn.selected { border-color: var(--purple); background: rgba(123,111,232,0.08); }
    .ewallet-logo { font-size: 26px; }
    .ewallet-name { font-size: 11px; font-weight: 600; color: var(--muted); }
    .ewallet-btn.selected .ewallet-name { color: var(--purple); }

    .phone-field {
      display: flex;
      gap: 10px;
      align-items: stretch;
    }
    .phone-prefix {
      background: rgba(255,255,255,0.6);
      border: 1px solid rgba(255,255,255,0.8);
      border-radius: 10px;
      padding: 0 14px;
      font-size: 14px;
      color: var(--text-soft);
      display: flex;
      align-items: center;
      white-space: nowrap;
    }
    input[type="tel"], input[type="text"], input[type="email"] {
      flex: 1;
      background: rgba(255,255,255,0.7);
      border: 1px solid rgba(255,255,255,0.9);
      border-radius: 10px;
      padding: 12px 16px;
      font-size: 14px;
      color: var(--text);
      font-family: var(--font-sans);
      outline: none;
      transition: border-color 0.18s, box-shadow 0.18s;
      width: 100%;
      backdrop-filter: blur(8px);
    }
    input:focus {
      border-color: var(--purple);
      box-shadow: 0 0 0 3px rgba(123,111,232,0.12);
    }
    input::placeholder { color: var(--muted); }

    .qris-box {
      border: 1px solid rgba(255,255,255,0.9);
      border-radius: 16px;
      padding: 24px;
      background: white;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 12px;
      box-shadow: 0 4px 16px rgba(123,111,232,0.1);
    }
    .qris-code {
      width: 160px; height: 160px;
      background: white;
      display: flex; align-items: center; justify-content: center;
    }
    .qris-code svg { width: 160px; height: 160px; }
    .qris-info { text-align: center; }
    .qris-info p { font-size: 13px; color: var(--text); font-weight: 500; }
    .qris-info small { font-size: 11px; color: var(--muted); }
    .qris-timer {
      background: #fef3c7;
      color: #92400e;
      font-size: 12px;
      font-weight: 600;
      padding: 6px 14px;
      border-radius: 20px;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    /* ── RIGHT PANEL (ORDER SUMMARY) ── */
    .right-panel {
      position: sticky;
      top: 90px;
      height: fit-content;
    }
    .summary-card {
      background: rgba(255,255,255,0.8);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255,255,255,0.9);
      border-radius: 20px;
      padding: 24px;
      display: flex;
      flex-direction: column;
      gap: 20px;
      box-shadow: 0 4px 24px rgba(123,111,232,0.1);
    }
    .summary-title {
      font-family: var(--font-sans);
      font-size: 15px;
      font-weight: 700;
      color: var(--text);
    }
    .summary-plan-row {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 14px;
      background: var(--lav-1);
      border-radius: 12px;
      border: 1px solid var(--lav-2);
    }
    .summary-icon {
      width: 40px; height: 40px;
      border-radius: 10px;
      background: rgba(123,111,232,0.15);
      display: flex; align-items: center; justify-content: center;
      font-size: 20px;
    }
    .summary-plan-name {
      font-family: var(--font-sans);
      font-size: 14px;
      font-weight: 700;
      color: var(--text);
    }
    .summary-plan-desc { font-size: 12px; color: var(--muted); }

    .summary-lines { display: flex; flex-direction: column; gap: 10px; }
    .summary-line {
      display: flex;
      justify-content: space-between;
      font-size: 13px;
      color: var(--muted);
    }
    .summary-line.total {
      font-size: 16px;
      font-weight: 700;
      color: var(--text);
      font-family: var(--font-sans);
      padding-top: 12px;
      border-top: 1px solid var(--lav-2);
    }
    .summary-line .val { color: var(--text); font-weight: 500; }
    .summary-line .discount { color: var(--teal); font-weight: 500; }

    .promo-row {
      display: flex;
      gap: 8px;
    }
    .promo-row input { flex: 1; }
    .promo-apply {
      background: var(--purple);
      color: white;
      border: none;
      border-radius: 10px;
      padding: 0 16px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      font-family: var(--font-sans);
      transition: background 0.18s;
    }
    .promo-apply:hover { background: var(--purple-dark); }

    /* CTA BUTTON */
    .pay-btn {
      width: 100%;
      padding: 16px;
      border-radius: 14px;
      border: none;
      background: linear-gradient(135deg, #7B6FE8, #5B4FD4);
      color: white;
      font-family: var(--font-sans);
      font-size: 16px;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.2s;
      position: relative;
      overflow: hidden;
      box-shadow: 0 4px 14px rgba(91,79,212,0.35);
    }
    .pay-btn::after {
      content: '';
      position: absolute;
      inset: 0;
      background: rgba(255,255,255,0);
      transition: background 0.18s;
    }
    .pay-btn:hover::after { background: rgba(255,255,255,0.08); }
    .pay-btn:hover { box-shadow: 0 6px 20px rgba(91,79,212,0.45); transform: translateY(-1px); }
    .pay-btn:active { transform: scale(0.98); }
    .pay-btn.loading { pointer-events: none; opacity: 0.7; }

    .guarantee {
      display: flex;
      align-items: flex-start;
      gap: 8px;
      font-size: 11.5px;
      color: var(--muted);
      line-height: 1.6;
    }
    .guarantee svg { width: 16px; height: 16px; flex-shrink: 0; margin-top: 1px; color: var(--teal); }

    /* ── STRUK MODAL ── */
    .struk-backdrop {
      position: fixed;
      inset: 0;
      background: rgba(26,24,37,0.55);
      backdrop-filter: blur(8px);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 900;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.3s;
    }
    .struk-backdrop.show { opacity: 1; pointer-events: all; }

    .struk-card {
      background: rgba(255,255,255,0.97);
      border: 1px solid rgba(255,255,255,0.95);
      border-radius: 24px;
      width: 100%;
      max-width: 420px;
      margin: 16px;
      box-shadow: 0 32px 64px rgba(91,79,212,0.18), 0 8px 24px rgba(0,0,0,0.08);
      overflow: hidden;
      transform: translateY(24px) scale(0.97);
      transition: transform 0.35s cubic-bezier(.34,1.56,.64,1);
    }
    .struk-backdrop.show .struk-card { transform: translateY(0) scale(1); }

    .struk-header {
      background: linear-gradient(135deg, #7B6FE8, #5B4FD4);
      padding: 28px 28px 26px;
      text-align: center;
    }
    .struk-icon {
      width: 52px; height: 52px;
      border-radius: 50%;
      background: rgba(255,255,255,0.18);
      border: 2px solid rgba(255,255,255,0.3);
      display: flex; align-items: center; justify-content: center;
      font-size: 22px;
      margin: 0 auto 12px;
    }
    .struk-header-title {
      font-family: var(--font-serif);
      font-size: 20px;
      font-weight: 400;
      color: #fff;
      margin-bottom: 4px;
    }
    .struk-header-sub {
      font-size: 12px;
      color: rgba(255,255,255,0.7);
      font-family: var(--font-sans);
    }

    .struk-body { padding: 24px 28px; }

    .struk-ref {
      background: var(--lav-1);
      border: 1px dashed var(--lav-4);
      border-radius: 12px;
      padding: 12px 16px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 20px;
    }
    .struk-ref-label { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 500; }
    .struk-ref-value { font-family: var(--font-sans); font-size: 13px; font-weight: 700; color: var(--purple); letter-spacing: 0.5px; }

    .struk-rows { display: flex; flex-direction: column; gap: 11px; margin-bottom: 20px; }
    .struk-row { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; }
    .struk-row-label { font-size: 13px; color: var(--muted); flex-shrink: 0; }
    .struk-row-value { font-size: 13px; color: var(--text); text-align: right; font-weight: 500; }

    .struk-divider {
      height: 1px;
      background: repeating-linear-gradient(90deg, var(--lav-3) 0, var(--lav-3) 6px, transparent 6px, transparent 12px);
      margin: 4px 0 18px;
    }

    .struk-total-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 14px 16px;
      background: rgba(0,200,150,0.07);
      border: 1px solid rgba(0,200,150,0.2);
      border-radius: 12px;
      margin-bottom: 18px;
    }
    .struk-total-label { font-family: var(--font-sans); font-size: 14px; font-weight: 600; color: var(--text); }
    .struk-total-amount { font-family: var(--font-serif); font-size: 22px; color: var(--teal); }

    .struk-notice {
      font-size: 11.5px;
      color: var(--muted);
      text-align: center;
      line-height: 1.6;
      margin-bottom: 18px;
    }

    .struk-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .struk-btn-cancel {
      padding: 13px;
      border-radius: 12px;
      border: 1.5px solid var(--lav-3);
      background: transparent;
      color: var(--text-soft);
      font-family: var(--font-sans);
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.18s;
    }
    .struk-btn-cancel:hover { border-color: var(--purple); color: var(--purple); background: var(--lav-1); }
    .struk-btn-confirm {
      padding: 13px;
      border-radius: 12px;
      border: none;
      background: linear-gradient(135deg, #7B6FE8, #5B4FD4);
      color: #fff;
      font-family: var(--font-sans);
      font-size: 13px;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.18s;
      box-shadow: 0 4px 14px rgba(91,79,212,0.3);
    }
    .struk-btn-confirm:hover { box-shadow: 0 6px 18px rgba(91,79,212,0.4); transform: translateY(-1px); }
    .struk-btn-confirm:disabled { opacity: 0.65; cursor: not-allowed; transform: none; }

    .struk-footer {
      padding: 13px 28px;
      border-top: 1px solid var(--lav-2);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      background: var(--lav-1);
    }
    .struk-footer svg { width: 13px; height: 13px; color: var(--teal); }
    .struk-footer span { font-size: 11px; color: var(--muted); }

    /* SUCCESS OVERLAY */
    .success-overlay {
      position: fixed;
      inset: 0;
      background: rgba(237,229,249,0.97);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 16px;
      z-index: 9999;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.35s;
    }
    .success-overlay.show { opacity: 1; pointer-events: all; }
    .success-circle {
      width: 72px; height: 72px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--teal), #00a87a);
      display: flex; align-items: center; justify-content: center;
      font-size: 32px;
      color: white;
      box-shadow: 0 8px 24px rgba(0,200,150,0.3);
    }
    .success-title {
      font-family: var(--font-serif);
      font-size: 32px;
      font-weight: 400;
      color: var(--text);
      text-align: center;
    }
    .success-sub { font-size: 14px; color: var(--text-soft); text-align: center; max-width: 320px; line-height: 1.6; }
    .success-back {
      margin-top: 10px;
      padding: 12px 32px;
      border-radius: 12px;
      border: 1.5px solid var(--lav-3);
      background: white;
      color: var(--text);
      font-family: var(--font-sans);
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.18s;
    }
    .success-back:hover { border-color: var(--purple); background: var(--lav-1); }

    /* FOOTER */
    footer {
      text-align: center;
      padding: 20px;
      font-size: 12px;
      color: var(--muted);
      border-top: 1px solid rgba(255,255,255,0.5);
      position: relative;
      z-index: 1;
    }
    footer a { color: var(--muted); }

    /* Section containers */
    .section-box {
      background: rgba(255,255,255,0.6);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255,255,255,0.85);
      border-radius: 16px;
      padding: 20px;
      box-shadow: 0 2px 10px rgba(123,111,232,0.07);
    }

    /* RESPONSIVE */
    @media (max-width: 720px) {
      nav { padding: 14px 20px; }
      .page-wrap { grid-template-columns: 1fr; padding: 24px 16px; }
      .right-panel { position: static; }
      .plan-cards { grid-template-columns: 1fr 1fr; }
    }
  </style>
</head>
<body>

<!-- NAV -->
<nav>
  <div class="logo">Coursify</div>
  <div class="nav-secure">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
    Pembayaran Aman & Terenkripsi
  </div>
</nav>

<!-- STRUK MODAL -->
<div class="struk-backdrop" id="strukBackdrop">
  <div class="struk-card">
    <div class="struk-header">
      <div class="struk-icon">🧾</div>
      <div class="struk-header-title">Konfirmasi Pembayaran</div>
      <div class="struk-header-sub">Periksa detail transaksi sebelum melanjutkan</div>
    </div>
    <div class="struk-body">

      <div class="struk-ref">
        <div>
          <div class="struk-ref-label">No. Referensi</div>
          <div class="struk-ref-value" id="strukRef">—</div>
        </div>
        <div style="text-align:right">
          <div class="struk-ref-label">Tanggal</div>
          <div class="struk-ref-value" id="strukDate" style="color:var(--muted);font-size:12px;font-weight:500">—</div>
        </div>
      </div>

      <div class="struk-rows">
        <div class="struk-row">
          <span class="struk-row-label">Nama</span>
          <span class="struk-row-value" id="strukName">—</span>
        </div>
        <div class="struk-row">
          <span class="struk-row-label">Email</span>
          <span class="struk-row-value" id="strukEmail" style="font-size:12px">—</span>
        </div>
        <div class="struk-row">
          <span class="struk-row-label">Paket</span>
          <span class="struk-row-value" id="strukPaket">—</span>
        </div>
        <div class="struk-row">
          <span class="struk-row-label">Billing</span>
          <span class="struk-row-value" id="strukBilling">—</span>
        </div>
        <div class="struk-row">
          <span class="struk-row-label">Metode Bayar</span>
          <span class="struk-row-value" id="strukMetode">—</span>
        </div>
        <div class="struk-row" id="strukPromoRow" style="display:none">
          <span class="struk-row-label">Promo</span>
          <span class="struk-row-value" style="color:var(--teal)" id="strukPromo">—</span>
        </div>
      </div>

      <div class="struk-divider"></div>

      <div class="struk-total-row">
        <span class="struk-total-label">Total Pembayaran</span>
        <span class="struk-total-amount" id="strukTotal">—</span>
      </div>

      <p class="struk-notice">
        Dengan mengklik <strong>Bayar Sekarang</strong>, kamu menyetujui
        Syarat &amp; Ketentuan dan Kebijakan Privasi kami.
      </p>

      <div class="struk-actions">
        <button class="struk-btn-cancel" onclick="closeStruk()">Batal</button>
        <button class="struk-btn-confirm" id="strukConfirmBtn" onclick="confirmPayment()">Bayar Sekarang →</button>
      </div>
    </div>
    <div class="struk-footer">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
      <span>Transaksi diproses dengan enkripsi SSL 256-bit</span>
    </div>
  </div>
</div>

<!-- SUCCESS OVERLAY -->
<div class="success-overlay" id="successOverlay">
  <div class="success-circle">✓</div>
  <div class="success-title">Pembayaran Berhasil! 🎉</div>
  <div class="success-sub" id="successMsg">Selamat! Akun Pro kamu sudah aktif. Cek email untuk konfirmasi.</div>
  <button class="success-back" onclick="window.location.href='{{ route('student.index') }}'">Kembali ke Dashboard</button>
</div>

<!-- MAIN -->
<div class="page-wrap">

  <!-- LEFT -->
  <div class="left-panel">

    <!-- STEP 1: PILIH PAKET -->
    <div>
      <div class="step-header">
        <div class="step-num" id="step1num">1</div>
        <h2 class="section-title">Pilih Paket</h2>
      </div>
      <div style="height:14px"></div>

      <div class="billing-row" style="margin-bottom:14px">
        <div class="billing-label"><strong>Tagihan Tahunan</strong> — bayar sekali setahun</div>
        <div class="save-tag">Hemat 20%</div>
        <div class="toggle-pill" id="billingToggle" onclick="toggleBilling()"></div>
      </div>

      <div class="plan-cards">
        <div class="plan-card selected" id="planPro" onclick="selectPlan('pro')">
          <div class="plan-badge">Populer</div>
          <div class="plan-name">Pro</div>
          <div class="plan-price" id="proPriceDisplay">Rp 99k <span>/bln</span></div>
          <div class="plan-features">
            <div class="plan-feature">500+ kursus premium</div>
            <div class="plan-feature">Sertifikat terverifikasi</div>
            <div class="plan-feature">Download offline</div>
            <div class="plan-feature">Mentoring 1-on-1</div>
          </div>
        </div>
        <div class="plan-card" id="planBusiness" onclick="selectPlan('business')">
          <div class="plan-name">Business</div>
          <div class="plan-price" id="bizPriceDisplay">Rp 499k <span>/bln</span></div>
          <div class="plan-features">
            <div class="plan-feature">Semua fitur Pro</div>
            <div class="plan-feature">25 anggota tim</div>
            <div class="plan-feature">Admin dashboard</div>
            <div class="plan-feature">Jalur belajar kustom</div>
          </div>
        </div>
      </div>
    </div>

    <!-- STEP 2: METODE PEMBAYARAN -->
    <div>
      <div class="step-header">
        <div class="step-num" id="step2num">2</div>
        <h2 class="section-title">Metode Pembayaran</h2>
      </div>
      <div style="height:14px"></div>

      <div class="method-tabs">
        <button class="method-tab active" data-method="qris" onclick="switchMethod('qris', this)">
          <span class="method-tab-icon">⚡</span>QRIS
        </button>
        <button class="method-tab" data-method="gopay" onclick="switchMethod('gopay', this)">
          <span class="method-tab-icon">💚</span>GoPay
        </button>
        <button class="method-tab" data-method="ovo" onclick="switchMethod('ovo', this)">
          <span class="method-tab-icon">💜</span>OVO
        </button>
        <button class="method-tab" data-method="dana" onclick="switchMethod('dana', this)">
          <span class="method-tab-icon">💙</span>DANA
        </button>
      </div>

      <div style="height:16px"></div>

      <!-- QRIS PANEL -->
      <div class="qris-panel" id="panel-qris">
        <p style="font-size:13px;color:var(--text-soft);line-height:1.6">Scan QR di bawah menggunakan aplikasi apapun yang mendukung QRIS (GoPay, OVO, DANA, ShopeePay, dll)</p>
        <div class="qris-box">
          <div class="qris-code">
            <svg viewBox="0 0 160 160" xmlns="http://www.w3.org/2000/svg">
              <rect width="160" height="160" fill="white"/>
              <g fill="#111">
                <rect x="10" y="10" width="50" height="50" rx="4"/>
                <rect x="100" y="10" width="50" height="50" rx="4"/>
                <rect x="10" y="100" width="50" height="50" rx="4"/>
                <rect x="18" y="18" width="34" height="34" fill="white" rx="2"/>
                <rect x="108" y="18" width="34" height="34" fill="white" rx="2"/>
                <rect x="18" y="108" width="34" height="34" fill="white" rx="2"/>
                <rect x="26" y="26" width="18" height="18" rx="1"/>
                <rect x="116" y="26" width="18" height="18" rx="1"/>
                <rect x="26" y="116" width="18" height="18" rx="1"/>
                <rect x="70" y="10" width="8" height="8"/>
                <rect x="82" y="10" width="8" height="8"/>
                <rect x="70" y="22" width="8" height="8"/>
                <rect x="70" y="34" width="8" height="8"/>
                <rect x="82" y="34" width="8" height="8"/>
                <rect x="70" y="46" width="8" height="8"/>
                <rect x="82" y="22" width="8" height="8"/>
                <rect x="10" y="70" width="8" height="8"/>
                <rect x="22" y="70" width="8" height="8"/>
                <rect x="34" y="70" width="8" height="8"/>
                <rect x="46" y="70" width="8" height="8"/>
                <rect x="58" y="70" width="8" height="8"/>
                <rect x="10" y="82" width="8" height="8"/>
                <rect x="34" y="82" width="8" height="8"/>
                <rect x="58" y="82" width="8" height="8"/>
                <rect x="70" y="70" width="8" height="8"/>
                <rect x="82" y="70" width="8" height="8"/>
                <rect x="94" y="70" width="8" height="8"/>
                <rect x="70" y="82" width="8" height="8"/>
                <rect x="94" y="82" width="8" height="8"/>
                <rect x="106" y="70" width="8" height="8"/>
                <rect x="118" y="70" width="8" height="8"/>
                <rect x="130" y="70" width="8" height="8"/>
                <rect x="142" y="70" width="8" height="8"/>
                <rect x="106" y="82" width="8" height="8"/>
                <rect x="130" y="82" width="8" height="8"/>
                <rect x="70" y="94" width="8" height="8"/>
                <rect x="82" y="94" width="8" height="8"/>
                <rect x="94" y="94" width="8" height="8"/>
                <rect x="70" y="106" width="8" height="8"/>
                <rect x="94" y="106" width="8" height="8"/>
                <rect x="106" y="94" width="8" height="8"/>
                <rect x="118" y="94" width="8" height="8"/>
                <rect x="130" y="94" width="8" height="8"/>
                <rect x="142" y="94" width="8" height="8"/>
                <rect x="118" y="106" width="8" height="8"/>
                <rect x="142" y="106" width="8" height="8"/>
                <rect x="70" y="118" width="8" height="8"/>
                <rect x="82" y="118" width="8" height="8"/>
                <rect x="94" y="118" width="8" height="8"/>
                <rect x="70" y="130" width="8" height="8"/>
                <rect x="94" y="130" width="8" height="8"/>
                <rect x="82" y="130" width="8" height="8"/>
                <rect x="70" y="142" width="8" height="8"/>
                <rect x="82" y="142" width="8" height="8"/>
                <rect x="106" y="118" width="8" height="8"/>
                <rect x="118" y="118" width="8" height="8"/>
                <rect x="130" y="118" width="8" height="8"/>
                <rect x="142" y="118" width="8" height="8"/>
                <rect x="106" y="130" width="8" height="8"/>
                <rect x="142" y="130" width="8" height="8"/>
                <rect x="118" y="130" width="8" height="8"/>
                <rect x="130" y="130" width="8" height="8"/>
                <rect x="106" y="142" width="8" height="8"/>
                <rect x="118" y="142" width="8" height="8"/>
                <rect x="130" y="142" width="8" height="8"/>
                <rect x="142" y="142" width="8" height="8"/>
              </g>
              <rect x="64" y="64" width="32" height="32" fill="white" rx="4"/>
              <text x="80" y="85" text-anchor="middle" font-size="18" fill="#7B6FE8">✦</text>
            </svg>
          </div>
          <div class="qris-info">
            <p>Scan untuk membayar</p>
            <small>QR ini berlaku selama 15 menit</small>
          </div>
          <div class="qris-timer">
            ⏱ Berakhir dalam <span id="qrisTimer">14:59</span>
          </div>
        </div>
        <p style="font-size:11.5px;color:var(--muted);text-align:center">
          ⚠️ Ganti QR di atas dengan QR asli dari payment gateway (Midtrans, Xendit, dll)
        </p>
      </div>

      <!-- GOPAY PANEL -->
      <div class="qris-panel" id="panel-gopay" style="display:none">
        <p style="font-size:13px;color:var(--text-soft);line-height:1.6">Masukkan nomor HP yang terdaftar di GoPay kamu</p>
        <div class="phone-field">
          <div class="phone-prefix">🇮🇩 +62</div>
          <input type="tel" placeholder="8xx xxxx xxxx" id="gopayPhone" />
        </div>
        <div style="padding:16px;background:rgba(0,200,150,0.08);border:1px solid rgba(0,200,150,0.2);border-radius:12px;font-size:13px;color:#00956e">
          💚 Kamu akan menerima notifikasi di aplikasi Gojek untuk konfirmasi pembayaran
        </div>
      </div>

      <!-- OVO PANEL -->
      <div class="qris-panel" id="panel-ovo" style="display:none">
        <p style="font-size:13px;color:var(--text-soft);line-height:1.6">Masukkan nomor HP yang terdaftar di OVO kamu</p>
        <div class="phone-field">
          <div class="phone-prefix">🇮🇩 +62</div>
          <input type="tel" placeholder="8xx xxxx xxxx" id="ovoPhone" />
        </div>
        <div style="padding:16px;background:rgba(123,111,232,0.08);border:1px solid rgba(123,111,232,0.2);border-radius:12px;font-size:13px;color:var(--purple-dark)">
          💜 Kamu akan menerima notifikasi di aplikasi OVO untuk konfirmasi pembayaran
        </div>
      </div>

      <!-- DANA PANEL -->
      <div class="qris-panel" id="panel-dana" style="display:none">
        <p style="font-size:13px;color:var(--text-soft);line-height:1.6">Masukkan nomor HP yang terdaftar di DANA kamu</p>
        <div class="phone-field">
          <div class="phone-prefix">🇮🇩 +62</div>
          <input type="tel" placeholder="8xx xxxx xxxx" id="danaPhone" />
        </div>
        <div style="padding:16px;background:rgba(59,130,246,0.08);border:1px solid rgba(59,130,246,0.2);border-radius:12px;font-size:13px;color:#3b82f6">
          💙 Kamu akan menerima notifikasi di aplikasi DANA untuk konfirmasi pembayaran
        </div>
      </div>
    </div>

    <!-- STEP 3: INFO AKUN -->
    <div>
      <div class="step-header">
        <div class="step-num">3</div>
        <h2 class="section-title">Informasi Akun</h2>
      </div>
      <div style="height:14px"></div>
      <div style="display:flex;flex-direction:column;gap:10px">
        <input type="email" placeholder="Alamat email kamu" id="emailInput" />
        <input type="text" placeholder="Nama lengkap" id="nameInput" />
      </div>
    </div>

  </div>

  <!-- RIGHT: ORDER SUMMARY -->
  <div class="right-panel">
    <div class="summary-card">
      <div class="summary-title">Ringkasan Pesanan</div>

      <div class="summary-plan-row">
        <div class="summary-icon">🎓</div>
        <div>
          <div class="summary-plan-name" id="summaryPlanName">Paket Pro</div>
          <div class="summary-plan-desc" id="summaryPlanDesc">Tagihan Bulanan</div>
        </div>
      </div>

      <div class="summary-lines">
        <div class="summary-line">
          <span>Harga paket</span>
          <span class="val" id="summaryBase">Rp 99.000</span>
        </div>
        <div class="summary-line" id="discountRow" style="display:none">
          <span>Diskon tahunan</span>
          <span class="discount" id="summaryDiscount">−Rp 19.800</span>
        </div>
        <div class="summary-line" id="promoRow" style="display:none">
          <span>Kode promo</span>
          <span class="discount" id="summaryPromo">−Rp 0</span>
        </div>
        <div class="summary-line">
          <span>PPN 11%</span>
          <span class="val" id="summaryTax">Rp 10.890</span>
        </div>
        <div class="summary-line total">
          <span>Total</span>
          <span id="summaryTotal">Rp 109.890</span>
        </div>
      </div>

      <div class="promo-row">
        <input type="text" placeholder="Kode promo" id="promoInput" />
        <button class="promo-apply" onclick="applyPromo()">Pakai</button>
      </div>

      <button class="pay-btn" id="payBtn" onclick="handlePay()">
        Bayar Sekarang →
      </button>

      <div class="guarantee">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        Pembayaran dienkripsi & aman. Batalkan kapan saja. Garansi uang kembali 7 hari jika tidak puas.
      </div>

      <div style="display:flex;align-items:center;justify-content:center;gap:10px;padding-top:4px">
        <span style="font-size:20px">⚡</span>
        <span style="font-size:20px">💚</span>
        <span style="font-size:20px">💜</span>
        <span style="font-size:20px">💙</span>
        <span style="font-size:11px;color:var(--muted)">Powered by Midtrans</span>
      </div>
    </div>
  </div>

</div>

<footer>
  © 2025 Coursify · <a href="#">Syarat & Ketentuan</a> · <a href="#">Kebijakan Privasi</a>
</footer>

<script>
  /* ── STATE ── */
  const state = {
    plan: 'pro',
    yearly: false,
    method: 'qris',
    promoApplied: false,
    prices: {
      pro:      { monthly: 99000,  yearly: 79200 },
      business: { monthly: 499000, yearly: 399200 }
    }
  };

  /* ── PLAN ── */
  function selectPlan(p) {
    state.plan = p;
    document.getElementById('planPro').classList.toggle('selected', p === 'pro');
    document.getElementById('planBusiness').classList.toggle('selected', p === 'business');
    updateSummary();
  }

  /* ── BILLING TOGGLE ── */
  function toggleBilling() {
    state.yearly = !state.yearly;
    const t = document.getElementById('billingToggle');
    t.classList.toggle('on', state.yearly);
    document.getElementById('proPriceDisplay').innerHTML = state.yearly ? 'Rp 79.2k <span>/bln</span>' : 'Rp 99k <span>/bln</span>';
    document.getElementById('bizPriceDisplay').innerHTML = state.yearly ? 'Rp 399.2k <span>/bln</span>' : 'Rp 499k <span>/bln</span>';
    document.getElementById('discountRow').style.display = state.yearly ? '' : 'none';
    updateSummary();
  }

  /* ── METHOD SWITCH ── */
  function switchMethod(m, tab) {
    state.method = m;
    document.querySelectorAll('.method-tab').forEach(t => t.classList.remove('active'));
    tab.classList.add('active');
    ['qris','gopay','ovo','dana'].forEach(id => {
      document.getElementById('panel-' + id).style.display = id === m ? '' : 'none';
    });
  }

  /* ── SUMMARY ── */
  function fmt(n) { return 'Rp ' + n.toLocaleString('id-ID'); }
  function updateSummary() {
    const base     = state.yearly ? state.prices[state.plan].yearly : state.prices[state.plan].monthly;
    const origBase = state.prices[state.plan].monthly;
    const discount = state.yearly ? (origBase - base) : 0;
    const promoAmt = state.promoApplied ? Math.round(base * 0.1) : 0;
    const subtotal = base - promoAmt;
    const tax      = Math.round(subtotal * 0.11);
    const total    = subtotal + tax;

    document.getElementById('summaryPlanName').textContent  = 'Paket ' + (state.plan === 'pro' ? 'Pro' : 'Business');
    document.getElementById('summaryPlanDesc').textContent  = state.yearly ? 'Tagihan Tahunan' : 'Tagihan Bulanan';
    document.getElementById('summaryBase').textContent      = fmt(origBase);
    document.getElementById('summaryDiscount').textContent  = '−' + fmt(discount);
    document.getElementById('summaryPromo').textContent     = '−' + fmt(promoAmt);
    document.getElementById('promoRow').style.display       = state.promoApplied ? '' : 'none';
    document.getElementById('summaryTax').textContent       = fmt(tax);
    document.getElementById('summaryTotal').textContent     = fmt(total);
    document.getElementById('payBtn').textContent           = 'Bayar ' + fmt(total) + ' →';
  }

  /* ── PROMO ── */
  function applyPromo() {
    const code = document.getElementById('promoInput').value.trim().toUpperCase();
    if (code === 'HEMAT10') {
      state.promoApplied = true;
      document.getElementById('promoInput').style.borderColor = 'var(--teal)';
      updateSummary();
      alert('✓ Kode promo berhasil! Diskon 10% diterapkan.');
    } else if (code === '') {
      alert('Masukkan kode promo terlebih dahulu.');
    } else {
      document.getElementById('promoInput').style.borderColor = 'var(--danger)';
      alert('Kode promo tidak valid atau sudah kadaluarsa.');
    }
  }

  /* ── STRUK HELPERS ── */
  function generateRef() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let ref = 'CRS-';
    for (let i = 0; i < 8; i++) ref += chars[Math.floor(Math.random() * chars.length)];
    return ref;
  }

  function getMethodLabel() {
    const activeTab = document.querySelector('.method-tab.active');
    const methodMap = { qris: 'QRIS', gopay: 'GoPay', ovo: 'OVO', dana: 'DANA' };
    return methodMap[activeTab?.dataset?.method] || '—';
  }

  function openStruk(name, email) {
    updateSummary();

    document.getElementById('strukRef').textContent = generateRef();
    const now = new Date();
    document.getElementById('strukDate').textContent = now.toLocaleDateString('id-ID', {
      day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'
    });

    document.getElementById('strukName').textContent    = name;
    document.getElementById('strukEmail').textContent   = email;
    document.getElementById('strukPaket').textContent   = 'Paket ' + (state.plan === 'pro' ? 'Pro' : 'Business');
    document.getElementById('strukBilling').textContent = state.yearly ? 'Tahunan' : 'Bulanan';
    document.getElementById('strukMetode').textContent  = getMethodLabel();

    const promoCode = document.getElementById('promoInput').value.trim().toUpperCase();
    if (state.promoApplied && promoCode) {
      document.getElementById('strukPromoRow').style.display = 'flex';
      document.getElementById('strukPromo').textContent = promoCode + ' (−10%)';
    } else {
      document.getElementById('strukPromoRow').style.display = 'none';
    }

    document.getElementById('strukTotal').textContent = document.getElementById('summaryTotal').textContent;

    window._strukData = { name, email, plan: state.plan === 'pro' ? 'Pro' : 'Business' };
    document.getElementById('strukBackdrop').classList.add('show');
  }

  function closeStruk() {
    document.getElementById('strukBackdrop').classList.remove('show');
  }

  function confirmPayment() {
    const btn = document.getElementById('strukConfirmBtn');
    btn.textContent = 'Memproses...';
    btn.disabled = true;

    // Simulasi (ganti dengan API call ke payment gateway)
    setTimeout(() => {
      document.getElementById('strukBackdrop').classList.remove('show');
      const { name, email, plan } = window._strukData || {};
      document.getElementById('successMsg').textContent =
        `Selamat ${name}! Akun ${plan} kamu sudah aktif. Konfirmasi dikirim ke ${email}.`;
      document.getElementById('successOverlay').classList.add('show');
      btn.textContent = 'Bayar Sekarang →';
      btn.disabled = false;
    }, 1800);
  }

  /* ── PAY ── */
  function handlePay() {
    const email = document.getElementById('emailInput').value.trim();
    const name  = document.getElementById('nameInput').value.trim();
    if (!email || !name) { alert('Lengkapi email dan nama kamu terlebih dahulu.'); return; }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { alert('Format email tidak valid.'); return; }
    openStruk(name, email);
  }

  /* ── QRIS TIMER ── */
  let secs = 14 * 60 + 59;
  setInterval(() => {
    if (secs <= 0) { document.getElementById('qrisTimer').textContent = 'Kedaluwarsa'; return; }
    secs--;
    const m = String(Math.floor(secs / 60)).padStart(2, '0');
    const s = String(secs % 60).padStart(2, '0');
    document.getElementById('qrisTimer').textContent = m + ':' + s;
  }, 1000);

  /* ── INIT ── */
  updateSummary();
</script>
</body>
</html>