{{-- resources/views/student/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Dashboard — Coursify</title>
<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;400;500;600&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
/* ════════════════════════════════════════════════════════════
   DESIGN SYSTEM — Coursify Premium Dashboard
   Aesthetic: Apple-refined × Linear-precise × Editorial-clean
   ════════════════════════════════════════════════════════════ */
:root {
  /* Core palette */
  --ink:        #0A0A0F;
  --ink-2:      #1C1C26;
  --ink-3:      #2E2E3E;
  --body:       #EDE5F9;       /* iOS system background grey */
  --surface:    #FFFFFF;
  --surface-2:  #F5F1FC;       /* Hover/active state for surface elements */
  --border:     rgba(0,0,0,0.06);
  --border-2:   rgba(0,0,0,0.10);

  /* Text */
  --text-1:     #0A0A0F;
  --text-2:     #3C3C50;
  --text-3:     #6B6B80;
  --text-4:     #9898AA;

  /* Accent: deep indigo */
  --accent:     #4F46E5;
  --accent-2:   #6D64F0;
  --accent-fg:  #FFFFFF;
  --accent-tint:#EEF2FF;
  --accent-glow:rgba(79,70,229,0.15);

  /* Semantic colors */
  --green:      #10B981;
  --green-tint: #ECFDF5;
  --amber:      #F59E0B;
  --amber-tint: #FFFBEB;
  --rose:       #F43F5E;
  --rose-tint:  #FFF1F2;
  --sky:        #0EA5E9;
  --sky-tint:   #F0F9FF;

  /* Typography */
  --font-display: 'Instrument Serif', Georgia, serif;
--font-body:    'Inter', -apple-system, sans-serif;

  /* Spacing */
  --sidebar-w:  252px;
  --radius-sm:  8px;
  --radius-md:  12px;
  --radius-lg:  18px;
  --radius-xl:  24px;

  /* Shadows */
  --shadow-sm:  0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
  --shadow-md:  0 4px 16px rgba(0,0,0,0.07), 0 1px 4px rgba(0,0,0,0.05);
  --shadow-lg:  0 12px 40px rgba(0,0,0,0.09), 0 2px 8px rgba(0,0,0,0.05);
  --shadow-accent: 0 8px 24px rgba(79,70,229,0.25);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

html { scroll-behavior: smooth; }

body {
  font-family: var(--font-body);
  background: linear-gradient(180deg, #EDE5F9 0%, #D8CEEE 50%, #C4B8E8 100%);
  background-attachment: fixed;
  color: var(--text-1);
  min-height: 100vh;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  display: flex;
  overflow-x: hidden;
}

/* ═══════════════════════════════════════════════
   SIDEBAR
   ═══════════════════════════════════════════════ */
.sidebar {
  width: var(--sidebar-w);
  background: var(--surface);
  border-right: 1px solid var(--border);
  position: fixed;
  height: 100vh;
  display: flex;
  flex-direction: column;
  z-index: 100;
  transition: transform 0.28s cubic-bezier(0.32, 0.72, 0, 1);
  overflow-y: auto;
  overflow-x: hidden;
  scrollbar-width: none;
}

.sidebar::-webkit-scrollbar { display: none; }

/* Logo */
.sidebar-logo {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 20px 20px 18px;
  text-decoration: none;
  color: var(--text-1);
  border-bottom: 1px solid var(--border);
  flex-shrink: 0;
}

.sidebar-logo-img {
  width: 30px; height: 30px;
  border-radius: 8px;
  object-fit: cover;
  box-shadow: var(--shadow-sm);
}

.sidebar-logo-mark {
  font-family: var(--font-body);
  font-weight: 600;
  font-size: 15px;
  letter-spacing: -0.3px;
  color: var(--text-1);
}

/* Nav sections */
.sidebar-body { flex: 1; padding: 8px 12px; }

.nav-section-label {
  font-size: 10px;
  font-weight: 600;
  color: var(--text-4);
  text-transform: uppercase;
  letter-spacing: 0.08em;
  padding: 14px 8px 6px;
}

.nav-item {
  display: flex;
  align-items: center;
  gap: 9px;
  padding: 8px 10px;
  border-radius: var(--radius-md);
  text-decoration: none;
  color: var(--text-3);
  font-size: 13.5px;
  font-weight: 500;
  transition: all 0.15s ease;
  letter-spacing: -0.1px;
  margin-bottom: 1px;
}

.nav-item:hover {
  background: var(--surface-2);
  color: var(--text-1);
}

.nav-item.active {
  background: var(--accent-tint);
  color: var(--accent);
  font-weight: 600;
}

.nav-item.active .nav-icon { color: var(--accent); }

.nav-icon {
  width: 16px;
  font-size: 13px;
  text-align: center;
  flex-shrink: 0;
  color: var(--text-4);
  transition: color 0.15s;
}

.nav-item:hover .nav-icon { color: var(--text-2); }

/* Sidebar user footer */
.sidebar-footer {
  border-top: 1px solid var(--border);
  padding: 12px;
  flex-shrink: 0;
}

.sidebar-user {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px;
  border-radius: var(--radius-md);
  cursor: pointer;
  transition: background 0.15s;
}

.sidebar-user:hover { background: var(--surface-2); }

.user-avatar {
  width: 32px; height: 32px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--accent), #818CF8);
  color: white;
  font-weight: 600;
  font-size: 13px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  letter-spacing: -0.5px;
}

.user-meta { flex: 1; min-width: 0; }

.user-name {
  font-size: 13px;
  font-weight: 600;
  color: var(--text-1);
  letter-spacing: -0.2px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.user-role {
  font-size: 11px;
  color: var(--text-4);
  font-weight: 400;
  letter-spacing: 0;
  text-transform: capitalize;
}

.logout-btn {
  background: none;
  border: none;
  cursor: pointer;
  color: var(--text-4);
  font-size: 14px;
  padding: 6px;
  border-radius: var(--radius-sm);
  transition: all 0.15s;
  display: flex;
  align-items: center;
}

.logout-btn:hover {
  color: var(--rose);
  background: var(--rose-tint);
}

/* ═══════════════════════════════════════════════
   MAIN LAYOUT
   ═══════════════════════════════════════════════ */
.main {
  flex: 1;
  margin-left: var(--sidebar-w);
  min-height: 100vh;
  max-width: calc(100vw - var(--sidebar-w));
}

.topbar {
  position: sticky;
  top: 0;
  z-index: 50;
  background: rgba(237,229,249,0.85);
  backdrop-filter: blur(16px) saturate(180%);
  -webkit-backdrop-filter: blur(16px) saturate(180%);
  border-bottom: 1px solid var(--border);
  padding: 0 32px;
  height: 56px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
}

.topbar-left {
  display: flex;
  align-items: center;
  gap: 12px;
  flex: 1;
}

.search-wrap {
  position: relative;
  width: 280px;
}

.search-input {
  width: 100%;
  height: 34px;
  padding: 0 12px 0 34px;
  background: var(--surface);
  border: 1px solid var(--border-2);
  border-radius: 8px;
  font-family: var(--font-body);
  font-size: 13px;
  color: var(--text-1);
  outline: none;
  transition: all 0.15s;
}

.search-input::placeholder { color: var(--text-4); }

.search-input:focus {
  border-color: var(--accent);
  box-shadow: 0 0 0 3px var(--accent-glow);
}

.search-icon {
  position: absolute;
  left: 10px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--text-4);
  font-size: 12px;
  pointer-events: none;
}

.topbar-actions { display: flex; align-items: center; gap: 6px; }

.topbar-btn {
  width: 34px; height: 34px;
  border-radius: var(--radius-sm);
  border: 1px solid var(--border-2);
  background: var(--surface);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  color: var(--text-3);
  font-size: 14px;
  transition: all 0.15s;
  position: relative;
}

.topbar-btn:hover {
  background: var(--surface-2);
  color: var(--text-1);
  border-color: var(--border-2);
}

.topbar-btn-dot {
  position: absolute;
  top: 6px; right: 6px;
  width: 6px; height: 6px;
  background: var(--rose);
  border-radius: 50%;
  border: 1.5px solid var(--body);
}

/* ═══════════════════════════════════════════════
   PAGE CONTENT
   ═══════════════════════════════════════════════ */
.page-content {
  padding: 28px 32px;
  display: flex;
  flex-direction: column;
  gap: 28px;
}

/* ── Hero ── */
.hero {
  background: linear-gradient(118deg, #0F0F1A 0%, #1A1535 45%, #16213E 100%);
  border-radius: var(--radius-xl);
  padding: 36px 40px;
  color: white;
  position: relative;
  overflow: hidden;
  display: grid;
  grid-template-columns: 1fr auto;
  align-items: center;
  gap: 32px;
}

/* Subtle mesh background */
.hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background:
    radial-gradient(ellipse 60% 80% at 80% 50%, rgba(99,102,241,0.18) 0%, transparent 60%),
    radial-gradient(ellipse 40% 60% at 20% 80%, rgba(16,185,129,0.10) 0%, transparent 55%);
  pointer-events: none;
}

/* Grid texture */
.hero::after {
  content: '';
  position: absolute;
  inset: 0;
  background-image: linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
  background-size: 40px 40px;
  pointer-events: none;
  opacity: 0.5;
}

.hero-content { position: relative; z-index: 1; }

.hero-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(255,255,255,0.08);
  border: 1px solid rgba(255,255,255,0.12);
  border-radius: 100px;
  padding: 4px 12px 4px 8px;
  margin-bottom: 16px;
}

.hero-eyebrow-dot {
  width: 6px; height: 6px;
  background: var(--green);
  border-radius: 50%;
  flex-shrink: 0;
}

.hero-eyebrow-text {
  font-size: 11px;
  font-weight: 500;
  color: rgba(255,255,255,0.7);
  letter-spacing: 0.02em;
}

.hero-title {
  font-family: var(--font-display);
  font-size: 38px;
  font-weight: 400;
  line-height: 1.08;
  letter-spacing: -0.5px;
  margin-bottom: 10px;
  color: white;
}

.hero-title em {
  font-style: italic;
  color: #A5B4FC;
}

.hero-sub {
  font-size: 14px;
  color: rgba(255,255,255,0.55);
  line-height: 1.6;
  max-width: 400px;
  margin-bottom: 24px;
  font-weight: 300;
}

.hero-btns { display: flex; gap: 10px; flex-wrap: wrap; }

.btn {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  padding: 9px 20px;
  height: 38px;
  border-radius: 100px;
  font-family: var(--font-body);
  font-size: 13px;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.18s ease;
  cursor: pointer;
  border: none;
  white-space: nowrap;
  letter-spacing: -0.1px;
}

.btn-white {
  background: white;
  color: var(--ink);
}

.btn-white:hover {
  transform: translateY(-1px);
  box-shadow: 0 8px 24px rgba(0,0,0,0.2);
}

.btn-ghost {
  background: rgba(255,255,255,0.1);
  color: rgba(255,255,255,0.85);
  border: 1px solid rgba(255,255,255,0.15);
}

.btn-ghost:hover {
  background: rgba(255,255,255,0.17);
}

.btn-accent {
  background: var(--accent);
  color: white;
  box-shadow: var(--shadow-accent);
}

.btn-accent:hover {
  background: var(--accent-2);
  transform: translateY(-1px);
  box-shadow: 0 12px 28px rgba(79,70,229,0.35);
}

.hero-visual {
  position: relative;
  z-index: 1;
  display: flex;
  align-items: center;
  justify-content: center;
}

.hero-icon-ring {
  width: 100px; height: 100px;
  border-radius: 28px;
  background: rgba(255,255,255,0.07);
  border: 1px solid rgba(255,255,255,0.12);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 46px;
}

/* ── Stats strip ── */
.stats-strip {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 12px;
}

.stat-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  padding: 18px 20px;
  transition: all 0.2s ease;
  cursor: default;
}

.stat-card:hover {
  border-color: var(--border-2);
  box-shadow: var(--shadow-md);
  transform: translateY(-2px);
}

.stat-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 14px;
}

.stat-label {
  font-size: 12px;
  color: var(--text-3);
  font-weight: 500;
  letter-spacing: -0.1px;
}

.stat-icon {
  width: 32px; height: 32px;
  border-radius: var(--radius-sm);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
}

.si-indigo { background: var(--accent-tint); color: var(--accent); }
.si-green  { background: var(--green-tint);  color: var(--green); }
.si-amber  { background: var(--amber-tint);  color: var(--amber); }
.si-sky    { background: var(--sky-tint);    color: var(--sky); }

.stat-value {
  font-family: var(--font-display);
  font-size: 30px;
  font-weight: 400;
  line-height: 1;
  letter-spacing: -0.5px;
  color: var(--text-1);
  margin-bottom: 6px;
}

.stat-value small {
  font-family: var(--font-body);
  font-size: 14px;
  color: var(--text-3);
  font-weight: 400;
  letter-spacing: 0;
}

.stat-trend {
  font-size: 11.5px;
  font-weight: 500;
  display: inline-flex;
  align-items: center;
  gap: 3px;
  letter-spacing: -0.1px;
}

.trend-up      { color: var(--green); }
.trend-neutral { color: var(--text-4); }

/* ── Section head ── */
.sec-head {
  display: flex;
  align-items: baseline;
  justify-content: space-between;
  margin-bottom: 14px;
}

.sec-title {
  font-family: var(--font-display);
  font-size: 22px;
  font-weight: 400;
  letter-spacing: -0.3px;
  color: var(--text-1);
}

.sec-title em {
  font-style: italic;
  color: var(--accent);
}

.sec-link {
  font-size: 12.5px;
  color: var(--accent);
  text-decoration: none;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 3px;
  letter-spacing: -0.1px;
  transition: gap 0.15s;
}

.sec-link:hover { gap: 6px; }

/* ── Continue learning card ── */
.continue-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-xl);
  padding: 24px;
  display: grid;
  grid-template-columns: auto 1fr auto;
  align-items: center;
  gap: 22px;
  transition: all 0.2s;
}

.continue-card:hover {
  border-color: var(--border-2);
  box-shadow: var(--shadow-md);
}

.continue-thumb {
  width: 110px; height: 74px;
  border-radius: var(--radius-md);
  background: linear-gradient(135deg, var(--accent) 0%, #818CF8 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow: hidden;
  flex-shrink: 0;
}

.continue-thumb-icon {
  font-size: 28px;
  color: rgba(255,255,255,0.9);
}

.continue-play {
  position: absolute;
  bottom: 7px; right: 7px;
  width: 24px; height: 24px;
  background: rgba(255,255,255,0.95);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--accent);
  font-size: 9px;
}

.continue-tag {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 10.5px;
  font-weight: 600;
  color: var(--accent);
  text-transform: uppercase;
  letter-spacing: 0.07em;
  margin-bottom: 5px;
}

.continue-dot {
  width: 5px; height: 5px;
  background: var(--accent);
  border-radius: 50%;
}

.continue-tag.done { color: var(--green); }
.continue-tag.done .continue-dot { background: var(--green); }

.continue-title {
  font-family: var(--font-display);
  font-size: 19px;
  font-weight: 400;
  letter-spacing: -0.2px;
  line-height: 1.2;
  margin-bottom: 5px;
  color: var(--text-1);
}

.continue-sub {
  font-size: 12px;
  color: var(--text-3);
  margin-bottom: 12px;
}

.progress-track {
  height: 4px;
  background: var(--surface-2);
  border-radius: 100px;
  overflow: hidden;
  margin-bottom: 5px;
}

.progress-fill {
  height: 100%;
  background: linear-gradient(90deg, var(--accent), #818CF8);
  border-radius: 100px;
  transition: width 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

.progress-fill.complete {
  background: linear-gradient(90deg, var(--green), #34D399);
}

.progress-label {
  font-size: 11px;
  color: var(--text-4);
  font-weight: 500;
}

/* ── My Courses grid ── */
.courses-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(272px, 1fr));
  gap: 14px;
}

.course-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 12px;
  overflow: hidden;
  text-decoration: none;
  color: var(--text-1);
  transition: all 0.22s;
  display: flex;
  flex-direction: column;
}

.course-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 32px rgba(0,0,0,0.12);
  border-color: var(--border-2);
}

.course-card__thumb {
  position: relative;
  aspect-ratio: 16/9;
  overflow: hidden;
  background: var(--surface-2);
  border-radius: 12px 12px 0 0;
}

.course-card__thumb img {
  width: 100%; height: 100%;
  object-fit: cover;
  transition: transform 0.4s ease;
  display: block;
}

.course-card:hover .course-card__thumb img { transform: scale(1.04); }

.course-thumb-fallback {
  width: 100%; height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 40px;
}

.course-badge {
  position: absolute;
  top: 10px; right: 10px;
  padding: 3px 9px;
  border-radius: 100px;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.04em;
  text-transform: uppercase;
}

.badge-done { background: var(--green); color: white; }
.badge-wip  { background: rgba(255,255,255,0.94); color: var(--accent); }

.course-body {
  padding: 16px;
  flex: 1;
  display: flex;
  flex-direction: column;
}

.course-cat {
  font-size: 10.5px;
  font-weight: 600;
  color: var(--text-4);
  text-transform: uppercase;
  letter-spacing: 0.07em;
  margin-bottom: 6px;
}

.course-title {
  font-family: var(--font-display);
  font-size: 16px;
  font-weight: 400;
  line-height: 1.3;
  letter-spacing: -0.2px;
  margin-bottom: 6px;
}

.course-instructor {
  font-size: 12px;
  color: var(--text-3);
  margin-bottom: 14px;
  padding-bottom: 14px;
  border-bottom: 1px solid var(--border);
}

.course-progress { margin-top: auto; }

.course-prog-header {
  display: flex;
  justify-content: space-between;
  font-size: 11px;
  color: var(--text-3);
  font-weight: 500;
  margin-bottom: 5px;
}

/* ── Two-col: Activity + Upcoming ── */
.two-col {
  display: grid;
  grid-template-columns: minmax(0, 1.5fr) minmax(0, 1fr);
  gap: 14px;
  align-items: start;
}

.panel {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-xl);
  padding: 22px 24px;
  min-width: 0;
}

.panel-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 18px;
}

.panel-title {
  font-family: var(--font-display);
  font-size: 19px;
  font-weight: 400;
  letter-spacing: -0.2px;
  color: var(--text-1);
}

.panel-title em { font-style: italic; color: var(--accent); }

.tab-group {
  display: flex;
  gap: 2px;
  background: var(--surface-2);
  border-radius: 100px;
  padding: 3px;
  border: 1px solid var(--border);
}

.tab {
  padding: 4px 12px;
  border: none;
  background: transparent;
  font-family: var(--font-body);
  font-size: 11.5px;
  font-weight: 500;
  color: var(--text-3);
  border-radius: 100px;
  cursor: pointer;
  transition: all 0.15s;
}

.tab.active {
  background: var(--surface);
  color: var(--text-1);
  font-weight: 600;
  box-shadow: var(--shadow-sm);
}

/* Activity summary */
.activity-kpi {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  margin-bottom: 16px;
}

.kpi-big {
  font-family: var(--font-display);
  font-size: 36px;
  font-weight: 400;
  line-height: 1;
  letter-spacing: -0.5px;
}

.kpi-big span { font-family: var(--font-body); font-size: 16px; color: var(--text-3); }

.kpi-label {
  font-size: 11.5px;
  color: var(--text-4);
  margin-top: 4px;
  font-weight: 400;
}

/* Bar chart */
.bar-chart {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 6px;
  height: 120px;
  align-items: end;
  margin-bottom: 12px;
}

.bar-col {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 5px;
  height: 100%;
  justify-content: flex-end;
  position: relative;
}

.bar-tip {
  position: absolute;
  top: -28px;
  background: var(--ink);
  color: white;
  padding: 2px 7px;
  border-radius: 5px;
  font-size: 10px;
  font-weight: 600;
  opacity: 0;
  transition: opacity 0.15s;
  white-space: nowrap;
  pointer-events: none;
  z-index: 10;
}

.bar-tip::after {
  content: '';
  position: absolute;
  top: 100%; left: 50%;
  transform: translateX(-50%);
  border: 3px solid transparent;
  border-top-color: var(--ink);
}

.bar-col:hover .bar-tip { opacity: 1; }

.bar-track {
  width: 100%;
  height: 88px;
  background: var(--surface-2);
  border-radius: 5px 5px 0 0;
  position: relative;
  overflow: hidden;
  cursor: pointer;
  transition: transform 0.15s;
}

.bar-col:hover .bar-track { transform: translateY(-2px); }

.bar-fill {
  position: absolute;
  bottom: 0;
  width: 100%;
  background: linear-gradient(180deg, var(--accent) 0%, var(--accent-2) 100%);
  border-radius: 5px 5px 0 0;
  transition: height 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

.bar-col.today .bar-fill {
  background: linear-gradient(180deg, var(--green) 0%, #34D399 100%);
}

.bar-col.zero .bar-track { opacity: 0.4; }

.bar-label {
  font-size: 10px;
  font-weight: 600;
  color: var(--text-4);
  text-transform: uppercase;
  letter-spacing: 0.04em;
}

.bar-col.today .bar-label { color: var(--green); font-weight: 700; }

.activity-legend {
  display: flex;
  gap: 14px;
  flex-wrap: wrap;
  padding-top: 14px;
  border-top: 1px solid var(--border);
}

.legend-item {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 11.5px;
  color: var(--text-3);
  font-weight: 400;
}

.legend-dot { width: 7px; height: 7px; border-radius: 50%; }

/* Up next list */
.upcoming-list {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.upcoming-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 10px 12px;
  border-radius: var(--radius-md);
  cursor: pointer;
  transition: background 0.15s;
  text-decoration: none;
  color: var(--text-1);
}

.upcoming-item:hover { background: var(--surface-2); }

.upcoming-time-block {
  text-align: center;
  min-width: 44px;
  flex-shrink: 0;
}

.up-day {
  font-size: 9.5px;
  font-weight: 700;
  color: var(--text-4);
  text-transform: uppercase;
  letter-spacing: 0.05em;
  margin-bottom: 1px;
}

.up-clock {
  font-family: var(--font-display);
  font-size: 15px;
  color: var(--text-1);
}

.up-icon {
  width: 36px; height: 36px;
  border-radius: var(--radius-sm);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
  flex-shrink: 0;
}

.icon-video   { background: var(--accent-tint); color: var(--accent); }
.icon-quiz    { background: var(--amber-tint);  color: var(--amber); }
.icon-project { background: var(--green-tint);  color: var(--green); }
.icon-reading { background: var(--sky-tint);    color: var(--sky); }

.up-info { flex: 1; min-width: 0; }

.up-title {
  font-size: 13px;
  font-weight: 600;
  letter-spacing: -0.1px;
  margin-bottom: 1px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.up-meta {
  font-size: 11px;
  color: var(--text-4);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.up-empty {
  text-align: center;
  padding: 32px 16px;
  color: var(--text-4);
  font-size: 13px;
}

/* ── Achievements grid ── */
.ach-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
  gap: 12px;
}

.ach-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  padding: 18px;
  text-align: center;
  transition: all 0.22s;
  cursor: default;
}

.ach-card:hover {
  transform: translateY(-3px);
  box-shadow: var(--shadow-md);
  border-color: var(--border-2);
}

.ach-icon {
  width: 52px; height: 52px;
  border-radius: 16px;
  margin: 0 auto 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
  transition: transform 0.25s;
}

.ach-card:hover .ach-icon { transform: scale(1.1) rotate(-6deg); }

.ai-indigo { background: var(--accent-tint); color: var(--accent); }
.ai-amber  { background: var(--amber-tint);  color: var(--amber); }
.ai-green  { background: var(--green-tint);  color: var(--green); }
.ai-sky    { background: var(--sky-tint);    color: var(--sky); }

.ach-title {
  font-family: var(--font-display);
  font-size: 15px;
  font-weight: 400;
  margin-bottom: 3px;
  letter-spacing: -0.1px;
}

.ach-desc {
  font-size: 11.5px;
  color: var(--text-3);
  line-height: 1.45;
  margin-bottom: 8px;
  min-height: 30px;
}

.ach-date {
  font-size: 10.5px;
  color: var(--text-4);
  font-weight: 500;
}

.ach-empty {
  grid-column: 1/-1;
  text-align: center;
  padding: 36px;
  color: var(--text-4);
  font-size: 13px;
}

/* ── Recommended grid ── */
.rec-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(272px, 1fr));
  gap: 14px;
}

.rec-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  overflow: hidden;
  text-decoration: none;
  color: var(--text-1);
  transition: all 0.22s;
  display: flex;
  flex-direction: column;
}

.rec-card:hover {
  transform: translateY(-3px);
  box-shadow: var(--shadow-lg);
  border-color: var(--border-2);
}

.rec-thumb {
  aspect-ratio: 16/9;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 44px;
  position: relative;
  overflow: hidden;
}

.rec-thumb img {
  width: 100%; height: 100%;
  object-fit: cover;
}

.rec-thumb-fallback {
  width: 100%; height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 44px;
}

.grad-1 { background: linear-gradient(135deg, #FA709A 0%, #FEE140 100%); }
.grad-2 { background: linear-gradient(135deg, #30CFD0 0%, #330867 100%); }
.grad-3 { background: linear-gradient(135deg, #A8EDEA 0%, #FED6E3 100%); }
.grad-4 { background: linear-gradient(135deg, #4776E6 0%, #8E54E9 100%); }

.rec-body {
  padding: 16px;
  flex: 1;
  display: flex;
  flex-direction: column;
}

.rec-title {
  font-family: var(--font-display);
  font-size: 16px;
  font-weight: 400;
  line-height: 1.3;
  letter-spacing: -0.2px;
  margin-bottom: 4px;
}

.rec-instructor {
  font-size: 12px;
  color: var(--text-3);
  margin-bottom: 8px;
}

.rec-meta {
  display: flex;
  gap: 10px;
  font-size: 11.5px;
  color: var(--text-4);
  margin-bottom: 12px;
  padding-bottom: 12px;
  border-bottom: 1px solid var(--border);
}

.rec-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: auto;
}

.rec-price {
  font-family: var(--font-display);
  font-size: 17px;
  letter-spacing: -0.2px;
}

.price-free { color: var(--green); }

.rec-arrow {
  color: var(--text-4);
  font-size: 14px;
  transition: all 0.2s;
}

.rec-card:hover .rec-arrow {
  color: var(--accent);
  transform: translateX(3px);
}

/* ═══════════════════════════════════════════════
   EMPTY STATES
   ═══════════════════════════════════════════════ */
.empty-continue {
  text-align: center;
  padding: 28px;
  color: var(--text-3);
}

.empty-continue p { font-size: 14px; margin-bottom: 14px; }

/* ═══════════════════════════════════════════════
   MOBILE OVERLAY + HAMBURGER
   ═══════════════════════════════════════════════ */
.sidebar-overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.35);
  z-index: 90;
  backdrop-filter: blur(3px);
}

.hamburger {
  display: none;
  position: fixed;
  bottom: 20px; right: 20px;
  z-index: 110;
  width: 46px; height: 46px;
  border-radius: 50%;
  background: var(--ink);
  color: white;
  border: none;
  font-size: 16px;
  cursor: pointer;
  align-items: center;
  justify-content: center;
  box-shadow: 0 8px 24px rgba(0,0,0,0.25);
  transition: all 0.2s;
}

.hamburger:hover { background: var(--ink-3); transform: scale(1.05); }

/* ═══════════════════════════════════════════════
   RESPONSIVE
   ═══════════════════════════════════════════════ */
@media (max-width: 1200px) {
  .two-col { grid-template-columns: 1fr; }
  .stats-strip { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 900px) {
  :root { --sidebar-w: 240px; }
}

@media (max-width: 768px) {
  .sidebar {
    transform: translateX(-100%);
    box-shadow: none;
  }

  .sidebar.open {
    transform: translateX(0);
    box-shadow: 4px 0 32px rgba(0,0,0,0.12);
  }

  .sidebar-overlay.open { display: block; }
  .hamburger { display: flex; }

  .main {
    margin-left: 0;
    max-width: 100vw;
  }

  .topbar { padding: 0 16px; }
  .search-wrap { display: none; }
  .page-content { padding: 16px; gap: 20px; }

  .hero {
    grid-template-columns: 1fr;
    padding: 28px 24px;
    gap: 20px;
  }

  .hero-title { font-size: 28px; }
  .hero-visual { display: none; }

  .stats-strip { grid-template-columns: repeat(2, 1fr); }

  .continue-card {
    grid-template-columns: 1fr;
    gap: 16px;
  }

  .continue-thumb { width: 100%; height: 120px; }
}

@media (max-width: 480px) {
  .stats-strip { grid-template-columns: 1fr 1fr; gap: 8px; }
  .courses-grid { grid-template-columns: 1fr; }
  .ach-grid { grid-template-columns: repeat(2, 1fr); }
  .rec-grid { grid-template-columns: 1fr; }
}
</style>
</head>
<body>

{{-- Mobile overlay --}}
<div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

{{-- ═══ SIDEBAR ═══ --}}
<aside class="sidebar" id="sidebar">
  <a href="{{ route('home') }}" class="sidebar-logo">
    <img src="{{ asset('images/logo.png') }}" alt="Coursify" class="sidebar-logo-img">
    <span class="sidebar-logo-mark">Coursify</span>
  </a>

  <div class="sidebar-body">
    <div class="nav-section-label">Menu</div>
    <nav>
      <a href="{{ route('student.index') }}"
         class="nav-item {{ request()->routeIs('student.index') ? 'active' : '' }}">
        <i class="fa-solid fa-gauge-high nav-icon"></i>
        <span>Dashboard</span>
      </a>
      <a href="{{ route('student.courses') }}"
         class="nav-item {{ request()->routeIs('student.courses') ? 'active' : '' }}">
        <i class="fa-solid fa-book-open nav-icon"></i>
        <span>My Courses</span>
      </a>
      <a href="{{ route('courses.index') }}"
         class="nav-item {{ request()->routeIs('courses.*') ? 'active' : '' }}">
        <i class="fa-solid fa-compass nav-icon"></i>
        <span>Browse</span>
      </a>
      <a href="{{ route('student.wishlist') }}"
         class="nav-item {{ request()->routeIs('student.wishlist') ? 'active' : '' }}">
        <i class="fa-solid fa-heart nav-icon"></i>
        <span>Wishlist</span>
      </a>
      <a href="{{ route('student.certificates') }}"
         class="nav-item {{ request()->routeIs('student.certificates') ? 'active' : '' }}">
        <i class="fa-solid fa-certificate nav-icon"></i>
        <span>Certificates</span>
      </a>
    </nav>

    <div class="nav-section-label">Account</div>
    <nav>
      <a href="{{ route('student.profile') }}"
         class="nav-item {{ request()->routeIs('student.profile') ? 'active' : '' }}">
        <i class="fa-solid fa-user nav-icon"></i>
        <span>Profile</span>
      </a>
    </nav>
  </div>

  <div class="sidebar-footer">
    <div class="sidebar-user">
      <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
      <div class="user-meta">
        <div class="user-name">{{ $user->name }}</div>
        <div class="user-role">{{ $user->role }}</div>
      </div>
      <form method="POST" action="{{ route('logout') }}" style="margin:0;display:flex;">
        @csrf
        <button type="submit" class="logout-btn" title="Logout">
          <i class="fa-solid fa-right-from-bracket"></i>
        </button>
      </form>
    </div>
  </div>
</aside>

{{-- Hamburger --}}
<button class="hamburger" id="hamburger" onclick="toggleSidebar()">
  <i class="fa-solid fa-bars" id="hamburger-icon"></i>
</button>

{{-- ═══ MAIN ═══ --}}
<main class="main">

  {{-- Topbar --}}
  <header class="topbar">
    <div class="topbar-left">
      <div class="search-wrap">
        <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
        <input type="text" class="search-input" placeholder="Search courses, lessons…">
      </div>
    </div>
    <div class="topbar-actions">
      <button class="topbar-btn" title="Notifications">
        <i class="fa-solid fa-bell"></i>
        <span class="topbar-btn-dot"></span>
      </button>
      <button class="topbar-btn" title="Help">
        <i class="fa-solid fa-circle-question"></i>
      </button>
    </div>
  </header>

  <div class="page-content">

    {{-- ── HERO ── --}}
    <div class="hero">
      <div class="hero-content">
        <div class="hero-eyebrow">
          <span class="hero-eyebrow-dot"></span>
          <span class="hero-eyebrow-text">
            {{ now()->format('l, d F Y') }} ·
            {{ now()->hour < 12 ? 'Good morning' : (now()->hour < 17 ? 'Good afternoon' : 'Good evening') }}
          </span>
        </div>
        <h1 class="hero-title">
          Welcome back,<br><em>{{ explode(' ', $user->name)[0] }}</em>
        </h1>
        <p class="hero-sub">
          @if($lastEnrollment)
            You're {{ $lastEnrollment->real_progress_percent ?? 0 }}% through
            <strong style="color:rgba(255,255,255,0.85)">{{ $lastEnrollment->course->title }}</strong>.
            Keep going!
          @else
            Start your learning journey today. Thousands of courses are waiting for you.
          @endif
        </p>
        <div class="hero-btns">
          <a href="{{ $lastEnrollment ? route('student.learn', $lastEnrollment->course->slug) : route('courses.index') }}"
             class="btn btn-white">
            <i class="fa-solid fa-play" style="font-size:10px;"></i>
            {{ $lastEnrollment ? 'Continue Learning' : 'Browse Courses' }}
          </a>
          <a href="{{ route('courses.index') }}" class="btn btn-ghost">
            <i class="fa-solid fa-compass" style="font-size:11px;"></i>
            Explore
          </a>
        </div>
      </div>

      <div class="hero-visual">
        <div class="hero-icon-ring">🎓</div>
      </div>
    </div>

    {{-- ── STATS ── --}}
    <div class="stats-strip">
      <div class="stat-card">
        <div class="stat-header">
          <span class="stat-label">Enrolled</span>
          <div class="stat-icon si-indigo"><i class="fa-solid fa-book-open"></i></div>
        </div>
        <div class="stat-value">{{ $stats['enrolled'] }}</div>
        <div class="stat-trend trend-up">
          <i class="fa-solid fa-arrow-up" style="font-size:9px;"></i>
          Active courses
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-header">
          <span class="stat-label">Completed</span>
          <div class="stat-icon si-green"><i class="fa-solid fa-circle-check"></i></div>
        </div>
        <div class="stat-value">{{ $stats['completed'] }}</div>
        <div class="stat-trend trend-neutral">
          <i class="fa-solid fa-minus" style="font-size:9px;"></i>
          Courses finished
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-header">
          <span class="stat-label">Study Time</span>
          <div class="stat-icon si-amber"><i class="fa-solid fa-clock"></i></div>
        </div>
        <div class="stat-value">
          {{ $stats['study_hours'] }}<small>h</small>
        </div>
        <div class="stat-trend {{ ($weekTrend ?? 0) >= 0 ? 'trend-up' : '' }}">
          @if($weekTrend !== null)
            <i class="fa-solid fa-arrow-{{ $weekTrend >= 0 ? 'up' : 'down' }}" style="font-size:9px;"></i>
            {{ abs($weekTrend) }}% vs last week
          @else
            <i class="fa-solid fa-minus" style="font-size:9px;"></i>
            Total tracked
          @endif
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-header">
          <span class="stat-label">Certificates</span>
          <div class="stat-icon si-sky"><i class="fa-solid fa-certificate"></i></div>
        </div>
        <div class="stat-value">{{ $stats['certificates'] }}</div>
        <div class="stat-trend trend-neutral">
          <i class="fa-solid fa-award" style="font-size:9px;"></i>
          Earned
        </div>
      </div>
    </div>

    {{-- ── CONTINUE LEARNING ── --}}
    <div>
      <div class="sec-head">
        <h2 class="sec-title">Continue <em>learning</em></h2>
        <a href="{{ route('student.courses') }}" class="sec-link">All courses →</a>
      </div>

      @if($lastEnrollment)
        @php
          $prog   = $lastEnrollment->real_progress_percent ?? 0;
          $isDone = $prog >= 100;
        @endphp
        <div class="continue-card">
          <div class="continue-thumb">
            @php
              $contThumb = $lastEnrollment->course->thumbnail_url
                  ?? ($lastEnrollment->course->thumbnail ? asset('storage/' . $lastEnrollment->course->thumbnail) : null);
            @endphp
            @if($contThumb)
              <img src="{{ $contThumb }}" alt="{{ $lastEnrollment->course->title }}"
                   style="width:100%;height:100%;object-fit:cover;border-radius:inherit;"
                   onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
              <i class="fa-solid fa-laptop-code continue-thumb-icon" style="display:none;"></i>
            @else
              <i class="fa-solid fa-laptop-code continue-thumb-icon"></i>
            @endif
            @if(!$isDone)
              <div class="continue-play"><i class="fa-solid fa-play" style="font-size:8px;margin-left:1px;"></i></div>
            @endif
          </div>

          <div>
            <div class="continue-tag {{ $isDone ? 'done' : '' }}">
              <span class="continue-dot"></span>
              {{ $isDone ? 'Completed' : 'In Progress' }}
            </div>
            <div class="continue-title">{{ $lastEnrollment->course->title }}</div>
            <div class="continue-sub">
              {{ $lastEnrollment->real_completed_lessons ?? 0 }} of
              {{ $lastEnrollment->real_total_lessons ?? 0 }} lessons
              @if(!$isDone) · {{ max(($lastEnrollment->real_total_lessons ?? 0) - ($lastEnrollment->real_completed_lessons ?? 0), 0) }} remaining @endif
            </div>
            <div class="progress-track">
              <div class="progress-fill {{ $isDone ? 'complete' : '' }}"
                   style="width: {{ $prog }}%"></div>
            </div>
            <div class="progress-label">{{ $prog }}% complete</div>
          </div>

          @php
             $canViewCert = $isDone && in_array($lastEnrollment->type, ['verified', 'honor']);
          @endphp
          <a href="{{ $canViewCert
              ? route('student.certificates')
              : route('student.learn', $lastEnrollment->course->slug) }}"
             class="btn btn-accent">
            @if($canViewCert)
              <i class="fa-solid fa-certificate" style="font-size:11px;"></i> View Certificate
            @elseif($isDone)
              <i class="fa-solid fa-rotate-right" style="font-size:11px;"></i> Review Course
            @else
              <i class="fa-solid fa-play" style="font-size:10px;"></i> Resume
            @endif
          </a>
        </div>
      @else
        <div class="continue-card">
          <div class="empty-continue">
            <p>You haven't enrolled in any course yet.</p>
            <a href="{{ route('courses.index') }}" class="btn btn-accent">
              <i class="fa-solid fa-compass" style="font-size:11px;"></i>
              Browse Courses
            </a>
          </div>
        </div>
      @endif
    </div>

    {{-- ── MY COURSES ── --}}
    @if($myCourses->count() > 0)
    <div>
      <div class="sec-head">
        <h2 class="sec-title">My <em>courses</em></h2>
        <a href="{{ route('student.courses') }}" class="sec-link">View all →</a>
      </div>
      <div class="courses-grid">
        @foreach($myCourses as $item)
          <a href="{{ route('student.learn', $item->slug) }}" class="course-card">
            <div class="course-card__thumb">
              @php
                $thumbSrc = $item->course->thumbnail_url
                    ?? ($item->course->thumbnail ? asset('storage/' . $item->course->thumbnail) : null);
              @endphp
              @if($thumbSrc)
                <img src="{{ $thumbSrc }}" alt="{{ $item->course->title }}">
              @else
                <div style="width:100%;height:100%;background:linear-gradient(135deg,#1e3a5f,#2d4d7a);display:flex;align-items:center;justify-content:center;">
                  <i class="fa-solid fa-graduation-cap" style="font-size:40px;color:rgba(255,255,255,0.3);"></i>
                </div>
              @endif

              @if($item->type === 'audit')
                <div class="course-badge" style="background:rgba(255, 255, 255, 0.2); backdrop-filter:blur(10px); border:1px solid rgba(255, 255, 255, 0.5); color:white; top:10px; right:auto; left:10px; z-index:10;">Audit</div>
              @elseif($item->type === 'verified')
                <div class="course-badge" style="background:rgba(255, 255, 255, 0.2); backdrop-filter:blur(10px); border:1px solid rgba(255, 255, 255, 0.5); color:white; top:10px; right:auto; left:10px; z-index:10;">Verified</div>
              @elseif($item->type === 'honor')
                <div class="course-badge" style="background:rgba(255, 255, 255, 0.2); backdrop-filter:blur(10px); border:1px solid rgba(255, 255, 255, 0.5); color:white; top:10px; right:auto; left:10px; z-index:10;">Honor</div>
              @endif
              @if($item->status === 'completed')
                <div class="course-badge badge-done" style="top:10px; right:10px;">
                  <i class="fa-solid fa-check"></i> Done
                </div>
              @else
                <div class="course-badge badge-wip" style="top:10px; right:10px;">In Progress</div>
              @endif
            </div>
            
            <div class="course-body" style="padding:14px 16px 16px;">
              <div class="course-cat" style="font-size:10px;font-weight:700;letter-spacing:0.09em;text-transform:uppercase;color:var(--accent);margin:0 0 6px;">{{ optional($item->course->category)->name ?? 'Course' }}</div>
              <div class="course-title" style="font-size:15px;font-weight:700;line-height:1.4;margin:0 0 6px;color:var(--text-1);display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $item->course->title }}</div>
              <div class="course-instructor" style="font-size:12px;color:var(--text-3);margin:0 0 10px;padding-bottom:10px;border-bottom:1px solid var(--border);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                {{ optional($item->course->instructors->first())->name ?? 'Instructor' }}
              </div>
              <div class="course-progress">
                <div class="course-prog-header">
                  <span>{{ $item->progress }}%</span>
                  <span>{{ $item->completed_count }}/{{ $item->total_lessons }}</span>
                </div>
                <div class="progress-track">
                  <div class="progress-fill {{ $item->status === 'completed' ? 'complete' : '' }}"
                       style="width: {{ $item->progress }}%"></div>
                </div>
              </div>
            </div>
          </a>
        @endforeach
      </div>
    </div>
    @endif

    {{-- ── TWO COL: ACTIVITY + UPCOMING ── --}}
    <div class="two-col">

      {{-- Weekly Activity --}}
      <div class="panel">
        <div class="panel-head">
          <h3 class="panel-title">Weekly <em>activity</em></h3>
          <div class="tab-group">
            <button class="tab active">Week</button>
            <button class="tab">Month</button>
          </div>
        </div>

        <div class="activity-kpi">
          <div>
            <div class="kpi-big">{{ $weekTotalHours }}<span>h</span></div>
            <div class="kpi-label">Total this week</div>
          </div>
          @if($weekTrend !== null)
            <div class="stat-trend {{ $weekTrend >= 0 ? 'trend-up' : '' }}" style="margin-bottom:8px;">
              <i class="fa-solid fa-arrow-{{ $weekTrend >= 0 ? 'up' : 'down' }}" style="font-size:9px;"></i>
              {{ abs($weekTrend) }}% vs last week
            </div>
          @endif
        </div>

        <div class="bar-chart">
          @foreach($weekActivity as $day)
            <div class="bar-col {{ $day['is_today'] ? 'today' : '' }} {{ $day['seconds'] == 0 ? 'zero' : '' }}">
              @if($day['seconds'] > 0)
                <div class="bar-tip">{{ $day['label'] }}</div>
              @endif
              <div class="bar-track">
                @if($day['seconds'] > 0)
                  <div class="bar-fill" style="height: {{ $day['percentage'] }}%;"></div>
                @endif
              </div>
              <div class="bar-label">{{ $day['day'] }}</div>
            </div>
          @endforeach
        </div>

        <div class="activity-legend">
          @if(($weekBreakdown['video'] ?? 0) > 0)
            <div class="legend-item">
              <span class="legend-dot" style="background: var(--accent);"></span>
              Video · {{ $weekBreakdown['video'] }}h
            </div>
          @endif
          @if(($weekBreakdown['exercise'] ?? 0) > 0)
            <div class="legend-item">
              <span class="legend-dot" style="background: var(--green);"></span>
              Exercise · {{ $weekBreakdown['exercise'] }}h
            </div>
          @endif
          @if(($weekBreakdown['reading'] ?? 0) > 0)
            <div class="legend-item">
              <span class="legend-dot" style="background: var(--amber);"></span>
              Reading · {{ $weekBreakdown['reading'] }}h
            </div>
          @endif
          @if(($weekBreakdown['video'] ?? 0) + ($weekBreakdown['exercise'] ?? 0) + ($weekBreakdown['reading'] ?? 0) == 0)
            <div class="legend-item" style="color: var(--text-4);">
              No activity breakdown tracked yet
            </div>
          @endif
        </div>
      </div>

      {{-- Up Next --}}
      <div class="panel">
        <div class="panel-head">
          <h3 class="panel-title">Up <em>next</em></h3>
          <a href="{{ route('student.courses') }}" class="sec-link">Schedule →</a>
        </div>

        @if($upNext->count() > 0)
          <div class="upcoming-list">
            @foreach($upNext->take(5) as $item)
              <a href="{{ route('student.learn', $item['course_slug']) }}"
                 class="upcoming-item">
                <div class="upcoming-time-block">
                  <div class="up-day">Next</div>
                  <div class="up-clock">{{ $item['duration'] }}</div>
                </div>
                <div class="up-icon icon-{{ $item['lesson_type'] ?? 'video' }}">
                  @if($item['lesson_type'] === 'quiz')
                    <i class="fa-solid fa-clipboard-question"></i>
                  @elseif($item['lesson_type'] === 'project')
                    <i class="fa-solid fa-code"></i>
                  @elseif($item['lesson_type'] === 'reading')
                    <i class="fa-solid fa-book-open"></i>
                  @else
                    <i class="fa-solid fa-play"></i>
                  @endif
                </div>
                <div class="up-info">
                  <div class="up-title">{{ $item['lesson_title'] }}</div>
                  <div class="up-meta">{{ $item['course_title'] }}</div>
                </div>
              </a>
            @endforeach
          </div>
        @else
          <div class="up-empty">
            <i class="fa-solid fa-check-circle" style="font-size:24px;color:var(--green);margin-bottom:8px;display:block;"></i>
            All caught up! Browse new courses to continue learning.
          </div>
        @endif
      </div>
    </div>

    {{-- ── ACHIEVEMENTS ── --}}
    <div>
      <div class="sec-head">
        <h2 class="sec-title">Recent <em>achievements</em></h2>
        <a href="{{ route('student.certificates') }}" class="sec-link">All badges →</a>
      </div>

      @php
        $colorMap = [
          'purple' => 'ai-indigo',
          'indigo' => 'ai-indigo',
          'orange' => 'ai-amber',
          'gold'   => 'ai-amber',
          'green'  => 'ai-green',
          'teal'   => 'ai-green',
          'sky'    => 'ai-sky',
          'blue'   => 'ai-sky',
        ];
      @endphp

      <div class="ach-grid">
        @forelse($achievements as $ach)
          <div class="ach-card">
            <div class="ach-icon {{ $colorMap[$ach['color']] ?? 'ai-indigo' }}">
              <i class="{{ $ach['icon'] }}"></i>
            </div>
            <div class="ach-title">{{ $ach['title'] }}</div>
            <div class="ach-desc">{{ $ach['description'] }}</div>
            <div class="ach-date">{{ $ach['date_label'] }}</div>
          </div>
        @empty
          <div class="ach-empty">
            <i class="fa-solid fa-trophy" style="font-size:24px;color:var(--text-4);margin-bottom:8px;display:block;"></i>
            Complete lessons to earn your first badge!
          </div>
        @endforelse
      </div>
    </div>

    {{-- ── RECOMMENDED ── --}}
    @if($recommended->count() > 0)
    <div>
      <div class="sec-head">
        <h2 class="sec-title">Recommended <em>for you</em></h2>
        <a href="{{ route('courses.index') }}" class="sec-link">Browse all →</a>
      </div>
      <div class="rec-grid">
        @foreach($recommended as $i => $rec)
          <a href="{{ route('courses.show', $rec['slug']) }}" class="rec-card">
            <div class="rec-thumb">
              @if($rec['thumbnail'] ?? null)
                <img src="{{ $rec['thumbnail'] }}"
                     alt="{{ $rec['title'] }}"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                <div class="rec-thumb-fallback grad-{{ ($i % 4) + 1 }}" style="display:none;">
                  {{ $rec['emoji'] }}
                </div>
              @else
                <div class="rec-thumb-fallback grad-{{ ($i % 4) + 1 }}">
                  {{ $rec['emoji'] }}
                </div>
              @endif
            </div>
            <div class="rec-body">
              <div class="course-cat">{{ $rec['category'] }}</div>
              <div class="rec-title">{{ $rec['title'] }}</div>
              <div class="rec-instructor">{{ $rec['instructor'] }}</div>
              <div class="rec-meta">
                <span>⭐ {{ $rec['rating'] }}</span>
                <span>👥 {{ $rec['students_count'] }}</span>
              </div>
              <div class="rec-footer">
                <div class="rec-price {{ $rec['is_free'] ? 'price-free' : '' }}">
                  {{ $rec['price'] }}
                </div>
                <span class="rec-arrow">→</span>
              </div>
            </div>
          </a>
        @endforeach
      </div>
    </div>
    @endif

    <div style="height: 32px;"></div>

  </div>{{-- /page-content --}}
</main>

<script>
function toggleSidebar() {
  const open = document.getElementById('sidebar').classList.toggle('open');
  document.getElementById('overlay').classList.toggle('open', open);
  document.getElementById('hamburger-icon').className =
    open ? 'fa-solid fa-xmark' : 'fa-solid fa-bars';
}

function closeSidebar() {
  document.getElementById('sidebar').classList.remove('open');
  document.getElementById('overlay').classList.remove('open');
  document.getElementById('hamburger-icon').className = 'fa-solid fa-bars';
}

window.addEventListener('resize', () => {
  if (window.innerWidth > 768) closeSidebar();
});

// Animate bars on load
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.bar-fill').forEach(el => {
    const target = el.style.height;
    el.style.height = '0';
    requestAnimationFrame(() => {
      el.style.transition = 'height 0.9s cubic-bezier(0.16,1,0.3,1)';
      el.style.height = target;
    });
  });

  document.querySelectorAll('.progress-fill').forEach(el => {
    const target = el.style.width;
    el.style.width = '0';
    requestAnimationFrame(() => {
      el.style.transition = 'width 1s cubic-bezier(0.16,1,0.3,1)';
      el.style.width = target;
    });
  });
});
</script>
</body>
</html>