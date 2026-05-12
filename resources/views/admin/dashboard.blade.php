<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Admin Dashboard — Coursify</title>

<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

{{-- Google Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

{{-- Font Awesome 6 --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

{{-- Alpine.js --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
/* ══════════════════════════════════════════
   TOKENS
══════════════════════════════════════════ */
:root {
    --navy:         #0F2240;
    --navy-mid:     #1A3A5C;
    --navy-soft:    #E8EFF8;

    --purple:       #6C5CE7;
    --purple-dark:  #4834C4;
    --purple-soft:  #F0EEFE;

    --teal:         #00B87A;
    --teal-soft:    #E5F8F2;

    --amber:        #F59E0B;
    --amber-soft:   #FEF3C7;

    --rose:         #F43F5E;
    --rose-soft:    #FFE4E9;

    --sky:          #0EA5E9;
    --sky-soft:     #E0F2FE;

    --text:         #0D1B2A;
    --text-2:       #3D5166;
    --text-3:       #7A92A8;
    --border:       #E2EAF2;
    --bg:           #F4F7FB;
    --card:         #FFFFFF;

    --font-display: 'DM Serif Display', serif;
    --font-body:    'DM Sans', sans-serif;

    --radius-sm:    8px;
    --radius-md:    12px;
    --radius-lg:    16px;
    --radius-xl:    20px;

    --shadow-sm:    0 1px 3px rgba(13,27,42,0.06), 0 1px 2px rgba(13,27,42,0.04);
    --shadow-md:    0 4px 12px rgba(13,27,42,0.08), 0 2px 6px rgba(13,27,42,0.04);
    --shadow-lg:    0 12px 32px rgba(13,27,42,0.10), 0 4px 12px rgba(13,27,42,0.06);
    --shadow-focus: 0 0 0 3px rgba(108,92,231,0.2);

    --sidebar-w:    256px;
    --topbar-h:     64px;
    --transition:   0.2s ease;
}

/* ══════════════════════════════════════════
   RESET & BASE
══════════════════════════════════════════ */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: var(--font-body);
    background: var(--bg);
    color: var(--text);
    min-height: 100vh;
    -webkit-font-smoothing: antialiased;
    display: flex;
}

a { text-decoration: none; color: inherit; }
button { font-family: var(--font-body); cursor: pointer; }

/* ══════════════════════════════════════════
   SCROLLBARS
══════════════════════════════════════════ */
::-webkit-scrollbar { width: 5px; height: 5px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }
::-webkit-scrollbar-thumb:hover { background: #94A3B8; }

/* ══════════════════════════════════════════
   SIDEBAR
══════════════════════════════════════════ */
.sidebar {
    width: var(--sidebar-w);
    background: var(--navy);
    position: fixed;
    top: 0; left: 0;
    height: 100vh;
    display: flex;
    flex-direction: column;
    z-index: 100;
    overflow-y: auto;
    transition: transform var(--transition);
}

/* Logo */
.sidebar-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 20px 18px 16px;
    border-bottom: 1px solid rgba(255,255,255,0.07);
}

.sidebar-brand-img {
    width: 34px;
    height: 34px;
    border-radius: var(--radius-sm);
    object-fit: cover;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
}

.sidebar-brand-text {
    font-family: var(--font-display);
    font-size: 18px;
    color: #fff;
    letter-spacing: -0.01em;
    flex: 1;
}

.admin-pill {
    background: rgba(108,92,231,0.3);
    border: 1px solid rgba(108,92,231,0.5);
    color: #A99FF5;
    font-size: 9px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 100px;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

/* Nav sections */
.sidebar-body {
    flex: 1;
    padding: 12px 10px;
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.nav-section-label {
    font-size: 9.5px;
    font-weight: 700;
    color: rgba(255,255,255,0.3);
    text-transform: uppercase;
    letter-spacing: 0.14em;
    padding: 14px 10px 6px;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 12px;
    border-radius: var(--radius-md);
    color: rgba(255,255,255,0.55);
    font-size: 13px;
    font-weight: 500;
    transition: all var(--transition);
    position: relative;
}

.nav-item:hover {
    background: rgba(255,255,255,0.07);
    color: rgba(255,255,255,0.9);
}

.nav-item.active {
    background: rgba(108,92,231,0.25);
    color: #fff;
    font-weight: 600;
}

.nav-item.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 3px;
    height: 20px;
    background: var(--purple);
    border-radius: 0 3px 3px 0;
}

.nav-item i {
    width: 18px;
    font-size: 14px;
    text-align: center;
    flex-shrink: 0;
    opacity: 0.8;
}

.nav-item.active i { opacity: 1; }

.nav-badge {
    margin-left: auto;
    background: var(--rose);
    color: white;
    font-size: 10px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 100px;
    min-width: 20px;
    text-align: center;
    line-height: 1.4;
}

.nav-badge.amber { background: var(--amber); color: var(--text); }

/* Sidebar footer / user card */
.sidebar-footer {
    padding: 12px 10px;
    border-top: 1px solid rgba(255,255,255,0.07);
}

.sidebar-user-card {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: var(--radius-md);
    background: rgba(255,255,255,0.06);
    transition: background var(--transition);
}

.sidebar-user-card:hover { background: rgba(255,255,255,0.1); }

.su-avatar {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--purple), var(--purple-dark));
    color: white;
    font-weight: 700;
    font-size: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 2px 6px rgba(108,92,231,0.4);
}

.su-info { flex: 1; min-width: 0; }

.su-name {
    font-size: 12.5px;
    font-weight: 600;
    color: rgba(255,255,255,0.9);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.su-role {
    font-size: 10px;
    color: rgba(255,255,255,0.4);
    font-weight: 500;
    letter-spacing: 0.03em;
}

.btn-logout {
    background: none;
    border: none;
    color: rgba(255,255,255,0.35);
    padding: 4px 6px;
    border-radius: var(--radius-sm);
    transition: all var(--transition);
    font-size: 13px;
    flex-shrink: 0;
    line-height: 1;
}

.btn-logout:hover { color: var(--rose); background: rgba(244,63,94,0.1); }

/* ══════════════════════════════════════════
   MAIN LAYOUT
══════════════════════════════════════════ */
.page-wrap {
    flex: 1;
    margin-left: var(--sidebar-w);
    min-width: 0;
    display: flex;
    flex-direction: column;
}

/* ══════════════════════════════════════════
   TOP BAR
══════════════════════════════════════════ */
.topbar {
    height: var(--topbar-h);
    background: var(--card);
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 28px;
    gap: 16px;
    position: sticky;
    top: 0;
    z-index: 50;
}

.topbar-search {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    padding: 8px 14px;
    width: 280px;
    transition: all var(--transition);
}

.topbar-search:focus-within {
    background: white;
    border-color: var(--purple);
    box-shadow: var(--shadow-focus);
}

.topbar-search i {
    color: var(--text-3);
    font-size: 13px;
}

.topbar-search input {
    border: none;
    background: transparent;
    font-family: var(--font-body);
    font-size: 13px;
    color: var(--text);
    width: 100%;
    outline: none;
}

.topbar-search input::placeholder { color: var(--text-3); }

.topbar-right {
    display: flex;
    align-items: center;
    gap: 8px;
}

.topbar-btn {
    width: 36px;
    height: 36px;
    border-radius: var(--radius-md);
    border: 1px solid var(--border);
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-2);
    font-size: 14px;
    transition: all var(--transition);
    position: relative;
}

.topbar-btn:hover {
    background: var(--purple-soft);
    border-color: var(--purple);
    color: var(--purple);
}

.notif-dot {
    position: absolute;
    top: 5px; right: 5px;
    width: 7px; height: 7px;
    background: var(--rose);
    border-radius: 50%;
    border: 1.5px solid white;
}

.btn-export {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 16px;
    background: var(--purple);
    color: white;
    border: none;
    border-radius: var(--radius-md);
    font-size: 12.5px;
    font-weight: 600;
    transition: all var(--transition);
}

.btn-export:hover {
    background: var(--purple-dark);
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
}

/* ══════════════════════════════════════════
   PAGE CONTENT
══════════════════════════════════════════ */
.content {
    padding: 28px;
    flex: 1;
    min-width: 0;
}

/* Page header */
.page-header {
    margin-bottom: 24px;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
}

.page-title {
    font-family: var(--font-display);
    font-size: 30px;
    color: var(--text);
    letter-spacing: -0.02em;
    line-height: 1.1;
    margin-bottom: 5px;
}

.page-title em {
    font-style: italic;
    color: var(--purple);
}

.page-subtitle {
    font-size: 13px;
    color: var(--text-3);
    font-weight: 400;
    display: flex;
    align-items: center;
    gap: 6px;
}

.page-subtitle i { color: var(--purple); font-size: 12px; }

/* ══════════════════════════════════════════
   STAT CARDS
══════════════════════════════════════════ */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

.stat-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 20px;
    transition: all var(--transition);
    position: relative;
    overflow: hidden;
}

.stat-card::after {
    content: '';
    position: absolute;
    top: -30px; right: -30px;
    width: 80px; height: 80px;
    border-radius: 50%;
    opacity: 0.06;
}

.stat-card.purple::after  { background: var(--purple); }
.stat-card.teal::after    { background: var(--teal); }
.stat-card.amber::after   { background: var(--amber); }
.stat-card.rose::after    { background: var(--rose); }

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
    border-color: transparent;
}

.stat-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 16px;
}

.stat-icon {
    width: 42px;
    height: 42px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}

.stat-card.purple .stat-icon  { background: var(--purple-soft); color: var(--purple); }
.stat-card.teal .stat-icon    { background: var(--teal-soft);   color: var(--teal); }
.stat-card.amber .stat-icon   { background: var(--amber-soft);  color: var(--amber); }
.stat-card.rose .stat-icon    { background: var(--rose-soft);   color: var(--rose); }

.stat-badge {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 9px;
    border-radius: 100px;
}

.badge-up   { background: var(--teal-soft); color: #00855A; }
.badge-down { background: var(--rose-soft); color: var(--rose); }

.stat-value {
    font-family: var(--font-display);
    font-size: 34px;
    letter-spacing: -0.03em;
    line-height: 1;
    color: var(--text);
    margin-bottom: 5px;
}

.stat-label {
    font-size: 12.5px;
    color: var(--text-3);
    font-weight: 500;
}

.stat-progress-wrap {
    margin-top: 14px;
}

.stat-progress-bar {
    height: 3px;
    background: var(--border);
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 5px;
}

.stat-progress-fill {
    height: 100%;
    border-radius: 10px;
    transition: width 1s ease;
}

.stat-card.purple .stat-progress-fill { background: var(--purple); }
.stat-card.teal .stat-progress-fill   { background: var(--teal); }
.stat-card.amber .stat-progress-fill  { background: var(--amber); }
.stat-card.rose .stat-progress-fill   { background: var(--rose); }

.stat-progress-label {
    font-size: 10.5px;
    color: var(--text-3);
    font-weight: 500;
}

/* ══════════════════════════════════════════
   CARD BASE
══════════════════════════════════════════ */
.card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius-xl);
    padding: 22px;
    min-width: 0;
}

.card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    gap: 12px;
    flex-wrap: wrap;
}

.card-title {
    font-family: var(--font-display);
    font-size: 19px;
    color: var(--text);
    letter-spacing: -0.01em;
    line-height: 1.2;
}

.card-title em {
    font-style: italic;
    color: var(--purple);
}

.card-link {
    font-size: 12px;
    font-weight: 600;
    color: var(--purple);
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: gap var(--transition);
    white-space: nowrap;
}

.card-link:hover { gap: 8px; }

/* Tab switcher */
.tab-group {
    display: flex;
    gap: 3px;
    background: var(--bg);
    border-radius: 100px;
    padding: 3px;
    border: 1px solid var(--border);
}

.tab-btn {
    padding: 5px 12px;
    border: none;
    background: transparent;
    font-size: 11.5px;
    font-weight: 600;
    color: var(--text-3);
    border-radius: 100px;
    cursor: pointer;
    transition: all var(--transition);
}

.tab-btn.active {
    background: white;
    color: var(--text);
    box-shadow: var(--shadow-sm);
}

/* ══════════════════════════════════════════
   CHARTS ROW
══════════════════════════════════════════ */
.charts-row {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 16px;
    margin-bottom: 24px;
}

/* Revenue card summary strip */
.rev-summary {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1px;
    background: var(--border);
    border-radius: var(--radius-md);
    overflow: hidden;
    margin-bottom: 20px;
}

.rev-item {
    background: var(--bg);
    padding: 14px 16px;
}

.rev-label {
    font-size: 10px;
    font-weight: 700;
    color: var(--text-3);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-bottom: 5px;
}

.rev-value {
    font-family: var(--font-display);
    font-size: 21px;
    color: var(--text);
    letter-spacing: -0.01em;
}

.rev-value span { color: var(--purple); }

.chart-wrap {
    position: relative;
    height: 200px;
}

/* Donut card */
.donut-center-wrap {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.donut-chart-wrap {
    position: relative;
    width: 180px;
    height: 180px;
    margin: 0 auto 20px;
}

.donut-inner {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    pointer-events: none;
}

.donut-total {
    font-family: var(--font-display);
    font-size: 30px;
    color: var(--text);
    letter-spacing: -0.02em;
    line-height: 1;
}

.donut-sub {
    font-size: 10px;
    font-weight: 700;
    color: var(--text-3);
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-top: 4px;
}

.legend-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
    width: 100%;
}

.legend-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 9px 12px;
    background: var(--bg);
    border-radius: var(--radius-md);
    border: 1px solid var(--border);
}

.legend-left {
    display: flex;
    align-items: center;
    gap: 9px;
}

.legend-dot {
    width: 9px;
    height: 9px;
    border-radius: 50%;
    flex-shrink: 0;
}

.legend-lbl { font-size: 12.5px; font-weight: 600; color: var(--text-2); }
.legend-pct { font-family: var(--font-display); font-size: 17px; color: var(--text); }

/* ══════════════════════════════════════════
   USERS TABLE
══════════════════════════════════════════ */
.table-card { margin-bottom: 24px; }

.filter-group {
    display: flex;
    gap: 3px;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 100px;
    padding: 3px;
}

.filter-btn {
    padding: 5px 12px;
    border: none;
    background: transparent;
    font-size: 11.5px;
    font-weight: 600;
    color: var(--text-3);
    border-radius: 100px;
    cursor: pointer;
    transition: all var(--transition);
    white-space: nowrap;
}

.filter-btn.active {
    background: white;
    color: var(--text);
    box-shadow: var(--shadow-sm);
}

.table-scroll { overflow-x: auto; }

.data-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 720px;
}

.data-table thead tr {
    background: var(--bg);
}

.data-table th {
    padding: 11px 14px;
    text-align: left;
    font-size: 10.5px;
    font-weight: 700;
    color: var(--text-3);
    letter-spacing: 0.08em;
    text-transform: uppercase;
    white-space: nowrap;
    border-bottom: 1px solid var(--border);
}

.data-table th:first-child { border-radius: var(--radius-md) 0 0 var(--radius-md); }
.data-table th:last-child  { border-radius: 0 var(--radius-md) var(--radius-md) 0; }

.data-table td {
    padding: 13px 14px;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
}

.data-table tbody tr:last-child td { border-bottom: none; }

.data-table tbody tr {
    transition: background var(--transition);
}

.data-table tbody tr:hover { background: var(--purple-soft); }

/* User cell */
.user-cell {
    display: flex;
    align-items: center;
    gap: 11px;
    min-width: 0;
}

.uc-avatar {
    width: 36px;
    height: 36px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 13px;
    flex-shrink: 0;
}

.av-purple { background: linear-gradient(135deg, var(--purple), var(--purple-dark)); }
.av-teal   { background: linear-gradient(135deg, var(--teal), #008A5B); }
.av-amber  { background: linear-gradient(135deg, var(--amber), #D97706); }
.av-sky    { background: linear-gradient(135deg, var(--sky), #0284C7); }

.uc-info { flex: 1; min-width: 0; }

.uc-name {
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.uc-email {
    font-size: 11px;
    color: var(--text-3);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Role & Status pills */
.pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 100px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

.pill i { font-size: 10px; }

.pill-student    { background: var(--purple-soft); color: var(--purple-dark); }
.pill-instructor { background: var(--teal-soft);   color: #007A54; }
.pill-active     { background: var(--teal-soft);   color: #007A54; }
.pill-pending    { background: var(--amber-soft);  color: #92400E; }
.pill-inactive   { background: var(--bg); border: 1px solid var(--border); color: var(--text-3); }

.td-text {
    font-size: 12.5px;
    color: var(--text-2);
    font-weight: 500;
    white-space: nowrap;
}

/* Dropdown action */
.dd-wrap { position: relative; display: inline-block; }

.dd-trigger {
    width: 30px;
    height: 30px;
    border-radius: var(--radius-sm);
    border: 1px solid var(--border);
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    color: var(--text-2);
    transition: all var(--transition);
}

.dd-trigger:hover {
    background: var(--purple-soft);
    border-color: var(--purple);
    color: var(--purple);
}

.dd-menu {
    position: absolute;
    right: 0;
    top: calc(100% + 5px);
    background: white;
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 6px;
    min-width: 180px;
    box-shadow: var(--shadow-lg);
    z-index: 20;
}

.dd-item {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 8px 11px;
    border-radius: var(--radius-sm);
    font-size: 12.5px;
    font-weight: 500;
    color: var(--text-2);
    transition: all var(--transition);
}

.dd-item i { width: 14px; font-size: 12px; color: var(--text-3); }

.dd-item:hover { background: var(--bg); color: var(--text); }

.dd-divider { height: 1px; background: var(--border); margin: 4px 0; }

.dd-item.danger { color: var(--rose); }
.dd-item.danger i { color: var(--rose); }
.dd-item.danger:hover { background: var(--rose-soft); }

/* ══════════════════════════════════════════
   TWO-COL GRID
══════════════════════════════════════════ */
.two-col {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 24px;
}

/* Approvals */
.count-chip {
    background: var(--rose);
    color: white;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 100px;
    letter-spacing: 0.02em;
}

.approval-list { display: flex; flex-direction: column; gap: 10px; }

.approval-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    transition: all var(--transition);
}

.approval-row:hover {
    border-color: var(--purple);
    background: var(--purple-soft);
}

.apr-icon {
    width: 40px;
    height: 40px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}

.apr-icon.purple { background: var(--purple-soft); color: var(--purple); }
.apr-icon.teal   { background: var(--teal-soft);   color: var(--teal); }
.apr-icon.amber  { background: var(--amber-soft);  color: var(--amber); }

.apr-info { flex: 1; min-width: 0; }

.apr-title {
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.apr-meta {
    font-size: 11px;
    color: var(--text-3);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.apr-btns { display: flex; gap: 6px; flex-shrink: 0; }

.btn-approve, .btn-reject {
    width: 32px;
    height: 32px;
    border-radius: var(--radius-md);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    transition: all var(--transition);
}

.btn-approve { background: var(--teal-soft); color: var(--teal); }
.btn-approve:hover { background: var(--teal); color: white; transform: scale(1.08); }

.btn-reject { background: var(--rose-soft); color: var(--rose); }
.btn-reject:hover { background: var(--rose); color: white; transform: scale(1.08); }

/* Activity feed */
.live-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--teal-soft);
    color: var(--teal);
    font-size: 10.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    padding: 4px 10px;
    border-radius: 100px;
}

.live-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--teal);
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); box-shadow: 0 0 0 0 rgba(0,184,122,0.5); }
    50% { opacity: 0.7; transform: scale(1.2); box-shadow: 0 0 0 5px rgba(0,184,122,0); }
}

.feed { display: flex; flex-direction: column; }

.feed-item {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 10px 8px;
    border-radius: var(--radius-md);
    transition: background var(--transition);
}

.feed-item:hover { background: var(--bg); }

.feed-icon {
    width: 34px;
    height: 34px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    flex-shrink: 0;
}

.fi-purple { background: var(--purple-soft); color: var(--purple); }
.fi-teal   { background: var(--teal-soft);   color: var(--teal); }
.fi-amber  { background: var(--amber-soft);  color: var(--amber); }
.fi-sky    { background: var(--sky-soft);    color: var(--sky); }

.feed-content { flex: 1; min-width: 0; }

.feed-text {
    font-size: 12.5px;
    color: var(--text-2);
    line-height: 1.4;
}

.feed-text strong { color: var(--text); font-weight: 600; }

.feed-time {
    font-size: 10.5px;
    color: var(--text-3);
    margin-top: 2px;
}

/* ══════════════════════════════════════════
   BOTTOM GRID
══════════════════════════════════════════ */
.bottom-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 16px;
    margin-bottom: 24px;
}

/* Top courses */
.course-list { display: flex; flex-direction: column; gap: 10px; }

.course-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 13px;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    transition: all var(--transition);
    cursor: pointer;
}

.course-row:hover {
    background: white;
    border-color: var(--purple);
    box-shadow: var(--shadow-md);
    transform: translateX(3px);
}

.rank-badge {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 12px;
    flex-shrink: 0;
}

.rank-1 { background: linear-gradient(135deg, #FFD700, #FFA500); color: #7A4500; box-shadow: 0 2px 8px rgba(255,165,0,0.35); }
.rank-2 { background: linear-gradient(135deg, #D0D0D0, #A8A8A8); color: #3A3A3A; }
.rank-3 { background: linear-gradient(135deg, #CD7F32, #A0522D); color: white; }

.course-thumb {
    width: 46px;
    height: 46px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.ct-1 { background: linear-gradient(135deg, #667EEA, #764BA2); }
.ct-2 { background: linear-gradient(135deg, #F093FB, #F5576C); }
.ct-3 { background: linear-gradient(135deg, #4FACFE, #00F2FE); }

.course-info { flex: 1; min-width: 0; }

.ci-title {
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.ci-meta {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 11px;
    color: var(--text-3);
}

.ci-meta i { font-size: 10px; }

.ci-meta .star-icon { color: var(--amber); }

.course-stat {
    text-align: right;
    flex-shrink: 0;
    min-width: 68px;
}

.cs-val {
    font-family: var(--font-display);
    font-size: 15px;
    color: var(--text);
    letter-spacing: -0.01em;
    line-height: 1.1;
}

.cs-lbl {
    font-size: 9.5px;
    font-weight: 700;
    color: var(--text-3);
    text-transform: uppercase;
    letter-spacing: 0.07em;
}

/* SDG card */
.sdg-card {
    background: linear-gradient(145deg, var(--navy) 0%, var(--navy-mid) 100%);
    border-radius: var(--radius-xl);
    padding: 24px;
    color: white;
    position: relative;
    overflow: hidden;
}

.sdg-card::before {
    content: '';
    position: absolute;
    top: -50px; right: -50px;
    width: 200px; height: 200px;
    background: radial-gradient(circle, rgba(108,92,231,0.25) 0%, transparent 70%);
    pointer-events: none;
}

.sdg-card::after {
    content: '';
    position: absolute;
    bottom: -40px; left: -30px;
    width: 160px; height: 160px;
    background: radial-gradient(circle, rgba(0,184,122,0.2) 0%, transparent 70%);
    pointer-events: none;
}

.sdg-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 22px;
    position: relative; z-index: 1;
}

.sdg-eyebrow {
    font-size: 9.5px;
    font-weight: 700;
    color: rgba(255,255,255,0.4);
    text-transform: uppercase;
    letter-spacing: 0.14em;
    margin-bottom: 6px;
}

.sdg-h {
    font-family: var(--font-display);
    font-size: 22px;
    color: white;
    letter-spacing: -0.01em;
    line-height: 1.2;
}

.sdg-h em { font-style: italic; color: var(--purple); color: #A99FF5; }

.sdg-globe-icon {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: rgba(255,255,255,0.08);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.sdg-metrics {
    display: flex;
    flex-direction: column;
    gap: 14px;
    position: relative; z-index: 1;
    margin-bottom: 20px;
}

.sdg-row {
    display: flex;
    align-items: center;
    gap: 12px;
}

.sdg-num-badge {
    width: 40px;
    height: 40px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-display);
    font-size: 19px;
    color: white;
    flex-shrink: 0;
}

.sdg-n4 { background: var(--purple); }
.sdg-n8 { background: var(--teal); }
.sdg-n10 { background: var(--amber); color: var(--text); }

.sdg-info { flex: 1; min-width: 0; }

.sdg-name {
    font-size: 11px;
    color: rgba(255,255,255,0.5);
    font-weight: 500;
    margin-bottom: 3px;
}

.sdg-val-row {
    display: flex;
    align-items: baseline;
    gap: 5px;
    margin-bottom: 6px;
}

.sdg-big {
    font-family: var(--font-display);
    font-size: 22px;
    color: white;
    letter-spacing: -0.02em;
}

.sdg-unit {
    font-size: 10px;
    color: rgba(255,255,255,0.5);
}

.sdg-bar {
    height: 3px;
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
    overflow: hidden;
}

.sdg-fill {
    height: 100%;
    border-radius: 10px;
}

.sdg-f-purple { background: #A99FF5; }
.sdg-f-teal   { background: var(--teal); }
.sdg-f-amber  { background: var(--amber); }

.sdg-foot {
    padding-top: 16px;
    border-top: 1px solid rgba(255,255,255,0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative; z-index: 1;
    flex-wrap: wrap;
    gap: 8px;
}

.sdg-foot-label { font-size: 11px; color: rgba(255,255,255,0.5); }

.sdg-foot-val {
    font-family: var(--font-display);
    font-size: 16px;
    color: #A99FF5;
    letter-spacing: -0.01em;
}

/* ══════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════ */
@media (max-width: 1280px) {
    .bottom-grid { grid-template-columns: 1fr; }
    .charts-row { grid-template-columns: 1fr; }
}

@media (max-width: 1080px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 900px) {
    .two-col { grid-template-columns: 1fr; }
}

@media (max-width: 768px) {
    :root { --sidebar-w: 0px; }

    .sidebar {
        width: 256px;
        transform: translateX(-100%);
    }

    .sidebar.open { transform: translateX(0); }

    .page-wrap { margin-left: 0; }

    .topbar {
        padding: 0 16px;
    }

    .topbar-search { display: none; }

    .content { padding: 16px; }

    .stats-grid { grid-template-columns: 1fr 1fr; gap: 12px; }

    .btn-export span { display: none; }

    .mobile-menu-btn { display: flex; }
}

@media (min-width: 769px) {
    .mobile-menu-btn { display: none !important; }
}

/* Mobile menu btn */
.mobile-menu-btn {
    width: 36px;
    height: 36px;
    border-radius: var(--radius-md);
    border: 1px solid var(--border);
    background: white;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    color: var(--text-2);
    cursor: pointer;
    flex-shrink: 0;
}

/* Overlay */
.sidebar-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.4);
    z-index: 99;
}

.sidebar-overlay.active { display: block; }
</style>
</head>
<body x-data="{ sidebarOpen: false }">

{{-- Overlay (mobile) --}}
<div class="sidebar-overlay" :class="{ active: sidebarOpen }" @click="sidebarOpen = false"></div>

{{-- ═══════════ SIDEBAR ═══════════ --}}
<aside class="sidebar" :class="{ open: sidebarOpen }">

    {{-- Brand --}}
    <div class="sidebar-brand">
        <img src="{{ asset('images/logo.png') }}" alt="Coursify" class="sidebar-brand-img">
        <span class="sidebar-brand-text">Coursify</span>
        <span class="admin-pill">Admin</span>
    </div>

    {{-- Nav --}}
    <div class="sidebar-body">

        <div class="nav-section-label">Overview</div>
        <a href="#" class="nav-item active">
            <i class="fa-solid fa-gauge-high"></i>
            <span>Dashboard</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fa-solid fa-chart-line"></i>
            <span>Analytics</span>
        </a>

        <div class="nav-section-label">Management</div>
        <a href="#" class="nav-item">
            <i class="fa-solid fa-users"></i>
            <span>Users</span>
            <span class="nav-badge">3.4K</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fa-solid fa-book-open"></i>
            <span>Courses</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fa-solid fa-building-columns"></i>
            <span>Institutions</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fa-solid fa-layer-group"></i>
            <span>Categories</span>
        </a>

        <div class="nav-section-label">Moderation</div>
        <a href="#" class="nav-item">
            <i class="fa-solid fa-circle-check"></i>
            <span>Approvals</span>
            <span class="nav-badge">5</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fa-solid fa-star"></i>
            <span>Reviews</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fa-solid fa-flag"></i>
            <span>Reports</span>
            <span class="nav-badge amber">2</span>
        </a>

        <div class="nav-section-label">Finance</div>
        <a href="#" class="nav-item">
            <i class="fa-solid fa-money-bill-wave"></i>
            <span>Transactions</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fa-solid fa-wallet"></i>
            <span>Payouts</span>
        </a>

        <div class="nav-section-label">System</div>
        <a href="#" class="nav-item">
            <i class="fa-solid fa-gear"></i>
            <span>Settings</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fa-solid fa-clipboard-list"></i>
            <span>Logs</span>
        </a>
    </div>

    {{-- User card --}}
    <div class="sidebar-footer">
        <div class="sidebar-user-card">
            <div class="su-avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="su-info">
                <div class="su-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div class="su-role">Administrator</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="btn-logout" title="Logout">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- ═══════════ PAGE ═══════════ --}}
<div class="page-wrap">

    {{-- TOP BAR --}}
    <header class="topbar">
        <button class="mobile-menu-btn" @click="sidebarOpen = !sidebarOpen">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="topbar-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Search users, courses, transactions…">
        </div>

        <div class="topbar-right">
            <button class="topbar-btn" title="Notifications">
                <i class="fa-regular fa-bell"></i>
                <span class="notif-dot"></span>
            </button>
            <button class="topbar-btn" title="Help">
                <i class="fa-regular fa-circle-question"></i>
            </button>
            <a href="#" class="btn-export">
                <i class="fa-solid fa-arrow-down-to-line"></i>
                <span>Export</span>
            </a>
        </div>
    </header>

    {{-- CONTENT --}}
    <div class="content">

        {{-- Page header --}}
        <div class="page-header">
            <div>
                <h1 class="page-title">
                    Good morning, <em>{{ explode(' ', auth()->user()->name ?? 'Admin')[0] }}</em>
                </h1>
                <p class="page-subtitle">
                    <i class="fa-regular fa-calendar"></i>
                    {{ now()->format('l, d F Y') }}
                    &nbsp;·&nbsp; Platform overview
                </p>
            </div>
        </div>

        {{-- ═══ STAT CARDS ═══ --}}
        <div class="stats-grid">

            <div class="stat-card purple">
                <div class="stat-top">
                    <div class="stat-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <span class="stat-badge badge-up">
                        <i class="fa-solid fa-arrow-trend-up"></i> 12%
                    </span>
                </div>
                <div class="stat-value">{{ $totalUsers ?? '3.4K' }}</div>
                <div class="stat-label">Total Users</div>
                <div class="stat-progress-wrap">
                    <div class="stat-progress-bar">
                        <div class="stat-progress-fill" style="width: 74%"></div>
                    </div>
                    <div class="stat-progress-label">74% of monthly target</div>
                </div>
            </div>

            <div class="stat-card teal">
                <div class="stat-top">
                    <div class="stat-icon">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <span class="stat-badge badge-up">
                        <i class="fa-solid fa-arrow-trend-up"></i> 8%
                    </span>
                </div>
                <div class="stat-value">{{ $totalCourses ?? 20 }}</div>
                <div class="stat-label">Total Courses</div>
                <div class="stat-progress-wrap">
                    <div class="stat-progress-bar">
                        <div class="stat-progress-fill" style="width: 60%"></div>
                    </div>
                    <div class="stat-progress-label">60% published</div>
                </div>
            </div>

            <div class="stat-card amber">
                <div class="stat-top">
                    <div class="stat-icon">
                        <i class="fa-solid fa-sack-dollar"></i>
                    </div>
                    <span class="stat-badge badge-up">
                        <i class="fa-solid fa-arrow-trend-up"></i> 24%
                    </span>
                </div>
                <div class="stat-value">42.8M</div>
                <div class="stat-label">Revenue (IDR)</div>
                <div class="stat-progress-wrap">
                    <div class="stat-progress-bar">
                        <div class="stat-progress-fill" style="width: 85%"></div>
                    </div>
                    <div class="stat-progress-label">85% of annual target</div>
                </div>
            </div>

            <div class="stat-card rose">
                <div class="stat-top">
                    <div class="stat-icon">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <span class="stat-badge badge-up">
                        <i class="fa-solid fa-arrow-trend-up"></i> 18%
                    </span>
                </div>
                <div class="stat-value">{{ $totalEnrollments ?? '1,847' }}</div>
                <div class="stat-label">Enrollments</div>
                <div class="stat-progress-wrap">
                    <div class="stat-progress-bar">
                        <div class="stat-progress-fill" style="width: 68%"></div>
                    </div>
                    <div class="stat-progress-label">68% completion rate</div>
                </div>
            </div>

        </div>

        {{-- ═══ CHARTS ROW ═══ --}}
        <div class="charts-row">

            {{-- Revenue Chart --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Revenue <em>overview</em></h3>
                    <div class="tab-group">
                        <button class="tab-btn" onclick="switchChart('7d',this)">7D</button>
                        <button class="tab-btn active" onclick="switchChart('30d',this)">30D</button>
                        <button class="tab-btn" onclick="switchChart('1y',this)">1Y</button>
                    </div>
                </div>

                <div class="rev-summary">
                    <div class="rev-item">
                        <div class="rev-label">Total</div>
                        <div class="rev-value">Rp <span>42.8M</span></div>
                    </div>
                    <div class="rev-item">
                        <div class="rev-label">This Month</div>
                        <div class="rev-value">Rp 12.4M</div>
                    </div>
                    <div class="rev-item">
                        <div class="rev-label">Avg / Day</div>
                        <div class="rev-value">Rp 412K</div>
                    </div>
                </div>

                <div class="chart-wrap">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            {{-- Donut - User Distribution --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User <em>distribution</em></h3>
                </div>

                <div class="donut-center-wrap">
                    <div class="donut-chart-wrap">
                        <canvas id="donutChart"></canvas>
                        <div class="donut-inner">
                            <div class="donut-total">3.4K</div>
                            <div class="donut-sub">Total</div>
                        </div>
                    </div>

                    <div class="legend-list">
                        <div class="legend-row">
                            <div class="legend-left">
                                <div class="legend-dot" style="background: #6C5CE7;"></div>
                                <span class="legend-lbl">Students</span>
                            </div>
                            <span class="legend-pct">80%</span>
                        </div>
                        <div class="legend-row">
                            <div class="legend-left">
                                <div class="legend-dot" style="background: #00B87A;"></div>
                                <span class="legend-lbl">Instructors</span>
                            </div>
                            <span class="legend-pct">15%</span>
                        </div>
                        <div class="legend-row">
                            <div class="legend-left">
                                <div class="legend-dot" style="background: #F59E0B;"></div>
                                <span class="legend-lbl">Admins</span>
                            </div>
                            <span class="legend-pct">5%</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ═══ USERS TABLE ═══ --}}
        <div class="card table-card">
            <div class="card-header">
                <h3 class="card-title">Recent <em>users</em></h3>
                <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                    <div class="filter-group">
                        <button class="filter-btn active">All</button>
                        <button class="filter-btn">Students</button>
                        <button class="filter-btn">Instructors</button>
                    </div>
                    <a href="#" class="card-link">
                        View all <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="table-scroll">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:35%;">
                                <i class="fa-solid fa-user" style="margin-right:5px;"></i>User
                            </th>
                            <th><i class="fa-solid fa-tag" style="margin-right:5px;"></i>Role</th>
                            <th><i class="fa-regular fa-clock" style="margin-right:5px;"></i>Joined</th>
                            <th><i class="fa-solid fa-chart-simple" style="margin-right:5px;"></i>Activity</th>
                            <th><i class="fa-solid fa-circle-dot" style="margin-right:5px;"></i>Status</th>
                            <th style="width:56px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $recentUsers = [
                            ['name'=>'Andi Pratama',  'email'=>'andi@email.com',  'role'=>'student',    'joined'=>'2 hours ago',  'activity'=>'3 courses',         'status'=>'active',   'color'=>'av-purple'],
                            ['name'=>'Sari Wijaya',   'email'=>'sari@email.com',  'role'=>'instructor', 'joined'=>'1 day ago',    'activity'=>'1 course created',  'status'=>'active',   'color'=>'av-teal'],
                            ['name'=>'Rizky Hakim',   'email'=>'rizky@email.com', 'role'=>'student',    'joined'=>'2 days ago',   'activity'=>'5 courses',         'status'=>'active',   'color'=>'av-sky'],
                            ['name'=>'Maya Putri',    'email'=>'maya@email.com',  'role'=>'student',    'joined'=>'3 days ago',   'activity'=>'2 courses',         'status'=>'inactive', 'color'=>'av-purple'],
                            ['name'=>'Dimas Saputra', 'email'=>'dimas@email.com', 'role'=>'instructor', 'joined'=>'5 days ago',   'activity'=>'3 courses created', 'status'=>'pending',  'color'=>'av-amber'],
                        ];
                        @endphp

                        @foreach($recentUsers as $u)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <div class="uc-avatar {{ $u['color'] }}">
                                        {{ strtoupper(substr($u['name'], 0, 1)) }}
                                    </div>
                                    <div class="uc-info">
                                        <div class="uc-name">{{ $u['name'] }}</div>
                                        <div class="uc-email">{{ $u['email'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($u['role'] === 'student')
                                    <span class="pill pill-student">
                                        <i class="fa-solid fa-graduation-cap"></i> Student
                                    </span>
                                @else
                                    <span class="pill pill-instructor">
                                        <i class="fa-solid fa-chalkboard-user"></i> Instructor
                                    </span>
                                @endif
                            </td>
                            <td><span class="td-text">{{ $u['joined'] }}</span></td>
                            <td><span class="td-text">{{ $u['activity'] }}</span></td>
                            <td>
                                @if($u['status'] === 'active')
                                    <span class="pill pill-active">
                                        <i class="fa-solid fa-circle" style="font-size:6px;"></i> Active
                                    </span>
                                @elseif($u['status'] === 'pending')
                                    <span class="pill pill-pending">
                                        <i class="fa-solid fa-hourglass-half" style="font-size:9px;"></i> Pending
                                    </span>
                                @else
                                    <span class="pill pill-inactive">
                                        <i class="fa-solid fa-circle" style="font-size:6px;"></i> Inactive
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="dd-wrap" x-data="{ open: false }">
                                    <button class="dd-trigger" @click="open = !open">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                    <div x-show="open" @click.away="open = false" x-transition class="dd-menu">
                                        <a href="#" class="dd-item">
                                            <i class="fa-regular fa-eye"></i> View Profile
                                        </a>
                                        <a href="#" class="dd-item">
                                            <i class="fa-regular fa-envelope"></i> Send Message
                                        </a>
                                        <a href="#" class="dd-item">
                                            <i class="fa-solid fa-key"></i> Reset Password
                                        </a>
                                        <div class="dd-divider"></div>
                                        <a href="#" class="dd-item danger">
                                            <i class="fa-solid fa-ban"></i> Suspend User
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ═══ APPROVALS + ACTIVITY ═══ --}}
        <div class="two-col">

            {{-- Pending Approvals --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pending <em>approvals</em></h3>
                    <span class="count-chip">
                        <i class="fa-solid fa-clock" style="margin-right:4px;font-size:10px;"></i>5 pending
                    </span>
                </div>

                <div class="approval-list">
                    @php
                    $approvals = [
                        ['title'=>'Advanced Machine Learning',             'sub'=>'Sari Dewi · 2h ago',          'icon'=>'fa-book-open',        'color'=>'purple'],
                        ['title'=>'Dimas Wijaya wants to be an instructor','sub'=>'dimas@coursify.test · 5h ago', 'icon'=>'fa-chalkboard-user',  'color'=>'teal'],
                        ['title'=>'Flutter Mobile Development',            'sub'=>'Rio Ahmad · 1d ago',           'icon'=>'fa-book-open',        'color'=>'purple'],
                        ['title'=>'Inappropriate content on Lesson 12',    'sub'=>'Reported by 3 users · 2d ago', 'icon'=>'fa-flag',             'color'=>'amber'],
                    ];
                    @endphp

                    @foreach($approvals as $a)
                    <div class="approval-row">
                        <div class="apr-icon {{ $a['color'] }}">
                            <i class="fa-solid {{ $a['icon'] }}"></i>
                        </div>
                        <div class="apr-info">
                            <div class="apr-title">{{ $a['title'] }}</div>
                            <div class="apr-meta">{{ $a['sub'] }}</div>
                        </div>
                        <div class="apr-btns">
                            <button class="btn-approve" title="Approve">
                                <i class="fa-solid fa-check"></i>
                            </button>
                            <button class="btn-reject" title="Reject">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Live Activity --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Live <em>activity</em></h3>
                    <div class="live-pill">
                        <span class="live-dot"></span> Live
                    </div>
                </div>

                <div class="feed">
                    @php
                    $feed = [
                        ['icon'=>'fa-graduation-cap', 'color'=>'fi-purple', 'text'=>'New enrollment in',   'hl'=>'Laravel Fullstack',  'time'=>'30s ago'],
                        ['icon'=>'fa-user-plus',      'color'=>'fi-teal',   'text'=>'New user registered', 'hl'=>'andi@email.com',      'time'=>'1m ago'],
                        ['icon'=>'fa-credit-card',    'color'=>'fi-amber',  'text'=>'Payment received',    'hl'=>'Rp 299.000',          'time'=>'3m ago'],
                        ['icon'=>'fa-star',           'color'=>'fi-sky',    'text'=>'5-star review on',    'hl'=>'Python Basics',       'time'=>'5m ago'],
                        ['icon'=>'fa-book-open',      'color'=>'fi-purple', 'text'=>'Course published:',   'hl'=>'UI/UX Fundamentals',  'time'=>'12m ago'],
                        ['icon'=>'fa-trophy',         'color'=>'fi-amber',  'text'=>'Certificate issued:', 'hl'=>'Data Analysis',       'time'=>'18m ago'],
                    ];
                    @endphp

                    @foreach($feed as $f)
                    <div class="feed-item">
                        <div class="feed-icon {{ $f['color'] }}">
                            <i class="fa-solid {{ $f['icon'] }}"></i>
                        </div>
                        <div class="feed-content">
                            <div class="feed-text">
                                {{ $f['text'] }} <strong>{{ $f['hl'] }}</strong>
                            </div>
                            <div class="feed-time">
                                <i class="fa-regular fa-clock" style="margin-right:3px;"></i>{{ $f['time'] }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- ═══ TOP COURSES + SDG ═══ --}}
        <div class="bottom-grid">

            {{-- Top Courses --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Top <em>courses</em></h3>
                    <a href="#" class="card-link">
                        View all <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div class="course-list">
                    @php
                    $courses = [
                        ['rank'=>1,'title'=>'Fullstack Web Dev',  'instructor'=>'Budi Santoso','enrollments'=>1203,'revenue'=>'Rp 8.4M','rating'=>4.9,'thumb'=>'ct-1','icon'=>'fa-laptop-code'],
                        ['rank'=>2,'title'=>'UI/UX Design',       'instructor'=>'Sari Dewi',   'enrollments'=>856, 'revenue'=>'Rp 5.2M','rating'=>4.8,'thumb'=>'ct-2','icon'=>'fa-pen-nib'],
                        ['rank'=>3,'title'=>'Python for Data',    'instructor'=>'Rio Ahmad',   'enrollments'=>642, 'revenue'=>'Rp 3.1M','rating'=>4.9,'thumb'=>'ct-3','icon'=>'fa-chart-bar'],
                    ];
                    @endphp

                    @foreach($courses as $c)
                    <div class="course-row">
                        <div class="rank-badge rank-{{ $c['rank'] }}">{{ $c['rank'] }}</div>
                        <div class="course-thumb {{ $c['thumb'] }}">
                            <i class="fa-solid {{ $c['icon'] }}" style="color:white;font-size:18px;"></i>
                        </div>
                        <div class="course-info">
                            <div class="ci-title">{{ $c['title'] }}</div>
                            <div class="ci-meta">
                                <span><i class="fa-solid fa-chalkboard-user"></i> {{ $c['instructor'] }}</span>
                                <span><i class="fa-solid fa-star star-icon"></i> {{ $c['rating'] }}</span>
                            </div>
                        </div>
                        <div class="course-stat">
                            <div class="cs-val">{{ number_format($c['enrollments']) }}</div>
                            <div class="cs-lbl">Students</div>
                        </div>
                        <div class="course-stat">
                            <div class="cs-val">{{ $c['revenue'] }}</div>
                            <div class="cs-lbl">Revenue</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- SDG Impact --}}
            <div class="sdg-card">
                <div class="sdg-top">
                    <div>
                        <div class="sdg-eyebrow">Platform Impact</div>
                        <h3 class="sdg-h">Supporting <em>SDGs</em></h3>
                    </div>
                    <div class="sdg-globe-icon">
                        <i class="fa-solid fa-earth-asia" style="color:rgba(255,255,255,0.7);"></i>
                    </div>
                </div>

                <div class="sdg-metrics">
                    <div class="sdg-row">
                        <div class="sdg-num-badge sdg-n4">4</div>
                        <div class="sdg-info">
                            <div class="sdg-name">Quality Education</div>
                            <div class="sdg-val-row">
                                <span class="sdg-big">1,847</span>
                                <span class="sdg-unit">enrollments</span>
                            </div>
                            <div class="sdg-bar">
                                <div class="sdg-fill sdg-f-purple" style="width:85%;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="sdg-row">
                        <div class="sdg-num-badge sdg-n8">8</div>
                        <div class="sdg-info">
                            <div class="sdg-name">Decent Work</div>
                            <div class="sdg-val-row">
                                <span class="sdg-big">324</span>
                                <span class="sdg-unit">certified</span>
                            </div>
                            <div class="sdg-bar">
                                <div class="sdg-fill sdg-f-teal" style="width:65%;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="sdg-row">
                        <div class="sdg-num-badge sdg-n10">10</div>
                        <div class="sdg-info">
                            <div class="sdg-name">Reduced Inequalities</div>
                            <div class="sdg-val-row">
                                <span class="sdg-big">62%</span>
                                <span class="sdg-unit">free courses</span>
                            </div>
                            <div class="sdg-bar">
                                <div class="sdg-fill sdg-f-amber" style="width:62%;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sdg-foot">
                    <span class="sdg-foot-label">
                        <i class="fa-solid fa-users" style="margin-right:5px;opacity:0.6;"></i>
                        Total beneficiaries this year
                    </span>
                    <span class="sdg-foot-val">3,412 learners</span>
                </div>
            </div>

        </div>

        <div style="height: 20px;"></div>

    </div>{{-- /content --}}
</div>{{-- /page-wrap --}}

{{-- ═══════════ SCRIPTS ═══════════ --}}
<script>
// ── Revenue Chart ──────────────────────────────
const revCtx = document.getElementById('revenueChart').getContext('2d');

const gradient = revCtx.createLinearGradient(0, 0, 0, 200);
gradient.addColorStop(0, 'rgba(108,92,231,0.18)');
gradient.addColorStop(1, 'rgba(108,92,231,0)');

const chartData = {
    '7d': {
        labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
        data: [1.2, 1.8, 1.5, 2.1, 1.9, 2.4, 2.0]
    },
    '30d': {
        labels: ['Wk 1','Wk 2','Wk 3','Wk 4'],
        data: [8.2, 10.5, 9.8, 14.3]
    },
    '1y': {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        data: [2.1,3.4,2.8,4.2,5.1,4.7,6.3,5.8,7.2,8.1,6.9,9.4]
    }
};

const revChart = new Chart(revCtx, {
    type: 'line',
    data: {
        labels: chartData['30d'].labels,
        datasets: [{
            label: 'Revenue (juta)',
            data: chartData['30d'].data,
            borderColor: '#6C5CE7',
            borderWidth: 2.5,
            pointBackgroundColor: '#6C5CE7',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7,
            backgroundColor: gradient,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#0F2240',
                titleColor: 'rgba(255,255,255,0.6)',
                bodyColor: '#fff',
                padding: 12,
                cornerRadius: 10,
                callbacks: {
                    label: ctx => ` Rp ${ctx.parsed.y}M`
                }
            }
        },
        scales: {
            x: {
                grid: { display: false },
                border: { display: false },
                ticks: {
                    color: '#7A92A8',
                    font: { family: 'DM Sans', size: 11, weight: '600' }
                }
            },
            y: {
                grid: {
                    color: 'rgba(226,234,242,0.7)',
                    drawBorder: false
                },
                border: { display: false, dash: [4, 4] },
                ticks: {
                    color: '#7A92A8',
                    font: { family: 'DM Sans', size: 11, weight: '600' },
                    callback: v => `${v}M`
                }
            }
        }
    }
});

function switchChart(period, btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    revChart.data.labels = chartData[period].labels;
    revChart.data.datasets[0].data = chartData[period].data;
    revChart.update('active');
}

// ── Donut Chart ────────────────────────────────
const doCtx = document.getElementById('donutChart').getContext('2d');
new Chart(doCtx, {
    type: 'doughnut',
    data: {
        labels: ['Students', 'Instructors', 'Admins'],
        datasets: [{
            data: [80, 15, 5],
            backgroundColor: ['#6C5CE7', '#00B87A', '#F59E0B'],
            borderWidth: 3,
            borderColor: '#ffffff',
            hoverBorderWidth: 3,
            hoverOffset: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        cutout: '72%',
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#0F2240',
                titleColor: 'rgba(255,255,255,0.6)',
                bodyColor: '#fff',
                padding: 12,
                cornerRadius: 10,
                callbacks: {
                    label: ctx => ` ${ctx.parsed}% (${ctx.label})`
                }
            }
        }
    }
});

// ── Filter tabs ────────────────────────────────
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        this.closest('.filter-group').querySelectorAll('.filter-btn')
            .forEach(b => b.classList.remove('active'));
        this.classList.add('active');
    });
});

// ── Tab group ──────────────────────────────────
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        this.closest('.tab-group').querySelectorAll('.tab-btn')
            .forEach(b => b.classList.remove('active'));
        this.classList.add('active');
    });
});
</script>

</body>
</html>