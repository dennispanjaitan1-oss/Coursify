@extends('layouts.app')

@section('title', 'Forum Komunitas — Coursify')

@push('styles')
<style>
/* ══════════════════════════════════════════
   FORUM KOMUNITAS PAGE
   resources/views/forum.blade.php
   
══════════════════════════════════════════ */

/* ── Hero ── */
.forum-hero {
    text-align: center;
    padding: 56px 20px 48px;
    position: relative;
    z-index: 1;
}
.forum-hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(123,111,232,0.1);
    border: 1px solid rgba(123,111,232,0.2);
    color: var(--purple-dark);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    padding: 6px 16px;
    border-radius: 100px;
    margin-bottom: 20px;
}
.forum-hero-title {
    font-family: var(--font-serif);
    font-size: clamp(40px, 6vw, 68px);
    font-weight: 400;
    line-height: 1.08;
    letter-spacing: -0.025em;
    margin-bottom: 18px;
    color: var(--text);
}
.forum-hero-title em {
    font-style: italic;
    background: linear-gradient(135deg, #9F94F2, #7B6FE8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    padding-right: 0.08em;
}
.forum-hero-sub {
    font-size: 16px;
    color: var(--text-soft);
    line-height: 1.65;
    max-width: 500px;
    margin: 0 auto 36px;
}

/* ── Stats strip ── */
.forum-stats-strip {
    display: inline-flex;
    align-items: center;
    gap: 0;
    background: rgba(255,255,255,0.75);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.92);
    border-radius: 100px;
    padding: 6px 6px 6px 24px;
    box-shadow: 0 4px 20px rgba(30,58,95,0.06);
    margin-bottom: 32px;
}
.forum-stats-item {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 13px;
    font-weight: 600;
    color: var(--text-soft);
    padding-right: 22px;
}
.forum-stats-item i { color: var(--purple); font-size: 12px; }
.forum-stats-item:last-child { padding-right: 0; }
.forum-stats-divider {
    width: 1px;
    height: 16px;
    background: rgba(30,58,95,0.1);
    margin-right: 22px;
}
.forum-stats-action {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: var(--purple);
    color: white;
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s;
    border: none;
    cursor: pointer;
    margin-left: 10px;
    white-space: nowrap;
}
.forum-stats-action:hover { background: var(--purple-dark); transform: translateY(-1px); }

/* ── Search bar ── */
.forum-search-wrap {
    max-width: 540px;
    margin: 0 auto;
    position: relative;
}
.forum-search-icon {
    position: absolute;
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--muted);
    font-size: 16px;
    pointer-events: none;
}
.forum-search {
    width: 100%;
    padding: 15px 60px 15px 50px;
    background: rgba(255,255,255,0.88);
    backdrop-filter: blur(20px);
    border: 1.5px solid rgba(255,255,255,0.95);
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 15px;
    color: var(--text);
    outline: none;
    transition: all 0.25s;
    box-shadow: 0 8px 30px rgba(30,58,95,0.08);
}
.forum-search::placeholder { color: var(--muted); }
.forum-search:focus {
    background: white;
    border-color: var(--purple);
    box-shadow: 0 0 0 5px rgba(123,111,232,0.1), 0 8px 30px rgba(30,58,95,0.08);
}
.forum-search-clear {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: var(--lav-2);
    border: none;
    cursor: pointer;
    color: var(--muted);
    font-size: 14px;
    display: none;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}
.forum-search-clear:hover { background: var(--lav-3); color: var(--text); }
.forum-search-clear.visible { display: flex; }

/* ── Layout ── */
.forum-main {
    padding: 0 20px 80px;
    position: relative;
    z-index: 1;
}
.forum-inner {
    max-width: 1060px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 220px 1fr;
    gap: 28px;
    align-items: start;
}

/* ── Sidebar ── */
.forum-sidebar {
    position: sticky;
    top: 110px;
}
.forum-sidebar-card {
    background: rgba(255,255,255,0.68);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(255,255,255,0.92);
    border-radius: 20px;
    padding: 20px 16px;
    box-shadow: 0 4px 20px rgba(30,58,95,0.04);
    margin-bottom: 16px;
}
.forum-sidebar-title {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--muted);
    padding: 0 8px;
    margin-bottom: 10px;
}
.forum-cat-btn {
    display: flex;
    align-items: center;
    gap: 9px;
    width: 100%;
    padding: 10px 12px;
    border-radius: 10px;
    border: none;
    background: transparent;
    font-family: var(--font-sans);
    font-size: 13.5px;
    font-weight: 500;
    color: var(--text-soft);
    cursor: pointer;
    transition: all 0.2s;
    text-align: left;
    margin-bottom: 2px;
    text-decoration: none;
}
.forum-cat-btn:hover { background: var(--lav-1); color: var(--text); }
.forum-cat-btn.active {
    background: rgba(123,111,232,0.12);
    color: var(--purple-dark);
    font-weight: 600;
}
.forum-cat-btn i { width: 16px; text-align: center; font-size: 13px; opacity: 0.7; flex-shrink: 0; }
.forum-cat-count {
    margin-left: auto;
    font-size: 10px;
    font-weight: 700;
    background: var(--lav-2);
    color: var(--muted);
    padding: 1px 7px;
    border-radius: 100px;
    white-space: nowrap;
}
.forum-cat-btn.active .forum-cat-count {
    background: rgba(123,111,232,0.2);
    color: var(--purple-dark);
}
.forum-sidebar-divider {
    height: 1px;
    background: rgba(30,58,95,0.07);
    margin: 12px 8px;
}

/* ── Trending tags ── */
.forum-tag-list {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    padding: 4px 4px 0;
}
.forum-tag-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11.5px;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 100px;
    border: 1.5px solid rgba(123,111,232,0.2);
    background: rgba(123,111,232,0.06);
    color: var(--purple-dark);
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
}
.forum-tag-pill:hover { background: rgba(123,111,232,0.14); border-color: rgba(123,111,232,0.4); }

/* ── Online members mini list ── */
.forum-online-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 4px 4px 0;
}
.forum-online-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
}
.forum-online-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid rgba(255,255,255,0.9);
    box-shadow: 0 2px 8px rgba(30,58,95,0.1);
    background: var(--lav-2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
    color: var(--purple-dark);
    flex-shrink: 0;
}
.forum-online-info { min-width: 0; }
.forum-online-name {
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.forum-online-role {
    font-size: 11px;
    color: var(--muted);
}
.forum-online-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #22C55E;
    margin-left: auto;
    flex-shrink: 0;
    box-shadow: 0 0 6px rgba(34,197,94,0.6);
}

/* ── Content area ── */
.forum-content { min-width: 0; }

/* ── Toolbar ── */
.forum-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 16px;
    flex-wrap: wrap;
}
.forum-sort-tabs {
    display: flex;
    align-items: center;
    background: rgba(255,255,255,0.68);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.92);
    border-radius: 100px;
    padding: 4px;
    gap: 2px;
}
.forum-sort-tab {
    padding: 7px 16px;
    border-radius: 100px;
    border: none;
    background: transparent;
    font-family: var(--font-sans);
    font-size: 12.5px;
    font-weight: 600;
    color: var(--text-soft);
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}
.forum-sort-tab:hover { color: var(--text); }
.forum-sort-tab.active {
    background: white;
    color: var(--purple-dark);
    box-shadow: 0 2px 8px rgba(30,58,95,0.08);
}
.forum-view-toggle {
    display: flex;
    align-items: center;
    gap: 4px;
    background: rgba(255,255,255,0.68);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.92);
    border-radius: 100px;
    padding: 4px;
}
.forum-view-btn {
    width: 32px;
    height: 32px;
    border-radius: 100px;
    border: none;
    background: transparent;
    color: var(--muted);
    cursor: pointer;
    font-size: 13px;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}
.forum-view-btn.active { background: white; color: var(--purple-dark); box-shadow: 0 2px 8px rgba(30,58,95,0.08); }

/* ── Pinned banner ── */
.forum-pinned-banner {
    background: linear-gradient(135deg, rgba(123,111,232,0.1) 0%, rgba(159,148,242,0.06) 100%);
    border: 1px solid rgba(123,111,232,0.25);
    border-radius: 16px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 12px;
    text-decoration: none;
    transition: all 0.2s;
}
.forum-pinned-banner:hover { border-color: var(--purple); background: rgba(123,111,232,0.12); }
.forum-pinned-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: rgba(123,111,232,0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--purple);
    font-size: 16px;
    flex-shrink: 0;
}
.forum-pinned-text { min-width: 0; flex: 1; }
.forum-pinned-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--purple);
    margin-bottom: 2px;
}
.forum-pinned-title {
    font-size: 14px;
    font-weight: 600;
    color: var(--text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.forum-pinned-meta { font-size: 12px; color: var(--muted); margin-top: 2px; }
.forum-pinned-arrow { color: var(--muted); font-size: 14px; flex-shrink: 0; }

/* ── Thread card ── */
.forum-thread {
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 8px;
    display: flex;
    gap: 16px;
    transition: all 0.3s;
    text-decoration: none;
    cursor: pointer;
}
.forum-thread:hover { border-color: rgba(123,111,232,0.35); transform: translateY(-1px); box-shadow: 0 6px 24px rgba(30,58,95,0.07); }
.forum-thread.is-hot { border-left: 3px solid #FF8A5B; }
.forum-thread.is-solved { border-left: 3px solid #22C55E; }
.forum-thread.is-new { border-left: 3px solid var(--purple); }

/* vote column */
.forum-thread-vote {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    min-width: 42px;
    flex-shrink: 0;
}
.forum-vote-btn {
    width: 30px;
    height: 26px;
    border-radius: 8px;
    border: 1.5px solid rgba(30,58,95,0.1);
    background: rgba(255,255,255,0.6);
    color: var(--muted);
    font-size: 12px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}
.forum-vote-btn:hover { border-color: var(--purple); color: var(--purple); background: rgba(123,111,232,0.06); }
.forum-vote-btn.voted { border-color: var(--purple); color: var(--purple); background: rgba(123,111,232,0.1); }
.forum-vote-count {
    font-size: 14px;
    font-weight: 700;
    color: var(--text);
    line-height: 1;
}
.forum-vote-count.high { color: #D05020; }

/* main body */
.forum-thread-body { flex: 1; min-width: 0; }
.forum-thread-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 8px;
}
.forum-thread-badges { display: flex; gap: 5px; flex-wrap: wrap; margin-bottom: 7px; }
.forum-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    padding: 3px 9px;
    border-radius: 100px;
}
.badge-hot     { background: rgba(255,138,91,0.12); color: #D05020; }
.badge-solved  { background: rgba(34,197,94,0.12);  color: #15803D; }
.badge-new     { background: rgba(123,111,232,0.12); color: var(--purple-dark); }
.badge-pinned  { background: rgba(255,196,82,0.15);  color: #9A6E00; }
.badge-cat {
    background: var(--lav-2);
    color: var(--text-soft);
    font-size: 10px;
    font-weight: 600;
    padding: 3px 9px;
    border-radius: 100px;
}
.forum-thread-title {
    font-family: var(--font-sans);
    font-size: 15px;
    font-weight: 600;
    color: var(--text);
    line-height: 1.45;
    margin-bottom: 6px;
    transition: color 0.2s;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.forum-thread:hover .forum-thread-title { color: var(--purple-dark); }
.forum-thread-excerpt {
    font-size: 13px;
    color: var(--text-soft);
    line-height: 1.6;
    margin-bottom: 12px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.forum-thread-meta {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
}
.forum-meta-author {
    display: flex;
    align-items: center;
    gap: 7px;
    text-decoration: none;
}
.forum-meta-avatar {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    object-fit: cover;
    background: var(--lav-2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 9px;
    font-weight: 700;
    color: var(--purple-dark);
    flex-shrink: 0;
    border: 1.5px solid rgba(255,255,255,0.9);
}
.forum-meta-name { font-size: 12.5px; font-weight: 600; color: var(--text-soft); }
.forum-meta-name:hover { color: var(--purple); }
.forum-meta-stat {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    color: var(--muted);
}
.forum-meta-stat i { font-size: 11px; }
.forum-meta-time { font-size: 12px; color: var(--muted); margin-left: auto; white-space: nowrap; }

/* aside stats */
.forum-thread-aside {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 8px;
    flex-shrink: 0;
    min-width: 64px;
}
.forum-aside-stat {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: var(--lav-1);
    border-radius: 10px;
    padding: 8px 12px;
    gap: 2px;
    min-width: 56px;
}
.forum-aside-stat-num { font-size: 15px; font-weight: 700; color: var(--text); line-height: 1; }
.forum-aside-stat-label { font-size: 9.5px; color: var(--muted); font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; }

/* last reply preview */
.forum-last-reply {
    display: flex;
    align-items: center;
    gap: 6px;
}
.forum-last-reply-img {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: var(--lav-3);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 9px;
    font-weight: 700;
    color: var(--purple-dark);
    flex-shrink: 0;
}
.forum-last-reply-info { font-size: 11px; color: var(--muted); }

/* ── Pagination ── */
.forum-pagination {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin-top: 28px;
}
.forum-page-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 10px;
    border: 1.5px solid rgba(255,255,255,0.9);
    background: rgba(255,255,255,0.7);
    color: var(--text-soft);
    font-family: var(--font-sans);
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
    backdrop-filter: blur(10px);
}
.forum-page-btn:hover { border-color: rgba(123,111,232,0.4); color: var(--purple-dark); background: rgba(123,111,232,0.06); }
.forum-page-btn.active { background: var(--purple); color: white; border-color: var(--purple); box-shadow: 0 4px 12px rgba(123,111,232,0.3); }
.forum-page-btn.wide { width: auto; padding: 0 14px; }

/* ── No results ── */
.forum-no-results {
    text-align: center;
    padding: 56px 20px;
    background: rgba(255,255,255,0.5);
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.8);
    display: none;
}
.forum-no-results.visible { display: block; }
.forum-no-results-icon { font-size: 44px; margin-bottom: 14px; color: var(--lav-3); }
.forum-no-results-title {
    font-family: var(--font-serif);
    font-size: 22px;
    font-weight: 400;
    color: var(--text);
    margin-bottom: 8px;
}
.forum-no-results-desc { font-size: 13px; color: var(--muted); }

/* ── CTA ── */
.forum-cta-section { padding: 0 20px 80px; }
.forum-cta-card {
    max-width: 1060px;
    margin: 0 auto;
    background: rgba(255,255,255,0.68);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(255,255,255,0.92);
    border-radius: 24px;
    padding: 44px 48px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 28px;
    box-shadow: 0 4px 20px rgba(30,58,95,0.04);
    flex-wrap: wrap;
}
.forum-cta-left { min-width: 0; }
.forum-cta-eyebrow {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--purple);
    margin-bottom: 10px;
}
.forum-cta-title {
    font-family: var(--font-serif);
    font-size: clamp(26px, 3vw, 36px);
    font-weight: 400;
    letter-spacing: -0.02em;
    line-height: 1.15;
    color: var(--text);
    margin-bottom: 10px;
}
.forum-cta-title em { font-style: italic; color: var(--purple); }
.forum-cta-desc { font-size: 14px; color: var(--text-soft); line-height: 1.6; max-width: 440px; }
.forum-cta-buttons { display: flex; gap: 10px; flex-wrap: wrap; flex-shrink: 0; }
.btn-forum-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 13px 26px;
    background: var(--navy);
    color: white;
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(30,58,95,0.28);
    white-space: nowrap;
}
.btn-forum-primary:hover { background: #2D4D7A; transform: translateY(-2px); }
.btn-forum-ghost {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 13px 26px;
    background: rgba(255,255,255,0.7);
    color: var(--text);
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    border: 1.5px solid rgba(255,255,255,0.9);
    white-space: nowrap;
}
.btn-forum-ghost:hover { background: white; transform: translateY(-2px); }

/* ── Floating new post ── */
.forum-fab {
    position: fixed;
    bottom: 32px;
    right: 32px;
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 14px 22px;
    background: var(--purple);
    color: white;
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    border: none;
    cursor: pointer;
    box-shadow: 0 8px 28px rgba(123,111,232,0.4);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 100;
}
.forum-fab:hover { background: var(--purple-dark); transform: translateY(-3px); box-shadow: 0 14px 36px rgba(123,111,232,0.45); }
.forum-fab i { font-size: 16px; }

/* ── Responsive ── */
@media (max-width: 860px) {
    .forum-inner { grid-template-columns: 1fr; }
    .forum-sidebar { position: static; }
    .forum-sidebar-card:not(:first-child) { display: none; }
    .forum-sidebar-card:first-child {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        padding: 14px;
    }
    .forum-sidebar-card:first-child .forum-sidebar-title { width: 100%; margin-bottom: 4px; }
    .forum-sidebar-card:first-child .forum-sidebar-divider { display: none; }
    .forum-cat-btn { width: auto; padding: 8px 14px; border-radius: 100px; margin-bottom: 0; }
    .forum-cta-card { padding: 32px 28px; flex-direction: column; align-items: flex-start; }
    .forum-thread-aside { display: none; }
    .forum-fab { bottom: 20px; right: 20px; padding: 13px 18px; }
}
@media (max-width: 560px) {
    .forum-cat-btn span { display: none; }
    .forum-cat-btn i { margin: 0; }
    .forum-stats-strip { display: none; }
    .forum-thread { padding: 16px; }
    .forum-thread-vote { display: none; }
}
</style>
@endpush

@section('content')

{{-- ══════════════════════════════════════════
     HERO
══════════════════════════════════════════ --}}
<section class="forum-hero">
    <div class="container">
        <div class="forum-hero-eyebrow">
            <i class="fa-solid fa-comments"></i>
            Forum Komunitas
        </div>
        <h1 class="forum-hero-title">
            Belajar Lebih Seru<br><em>Bersama-sama</em>
        </h1>
        <p class="forum-hero-sub">
            Diskusi, tanya jawab, dan berbagi pengetahuan dengan ribuan pelajar aktif. Komunitas yang saling mendukung.
        </p>

        {{-- Stats strip --}}
        <div class="forum-stats-strip">
            <div class="forum-stats-item">
                <i class="fa-solid fa-users"></i>
                <span>24.8K anggota</span>
            </div>
            <div class="forum-stats-divider"></div>
            <div class="forum-stats-item">
                <i class="fa-solid fa-message"></i>
                <span>142K diskusi</span>
            </div>
            <div class="forum-stats-divider"></div>
            <div class="forum-stats-item">
                <i class="fa-solid fa-circle" style="font-size:8px; color:#22C55E;"></i>
                <span>312 online</span>
            </div>
            <a href="#" class="forum-stats-action" onclick="openNewPostModal(event)">
                <i class="fa-solid fa-plus"></i>
                Buat Post
            </a>
        </div>

        {{-- Search --}}
        <div class="forum-search-wrap">
            <i class="fa-solid fa-magnifying-glass forum-search-icon"></i>
            <input
                type="text"
                id="forumSearch"
                class="forum-search"
                placeholder="Cari diskusi, topik, atau anggota..."
                oninput="searchForum(this.value)"
                autocomplete="off"
            >
            <button class="forum-search-clear" id="searchClear" onclick="clearForumSearch()" aria-label="Hapus">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     MAIN
══════════════════════════════════════════ --}}
<section class="forum-main">
    <div class="forum-inner">

        {{-- ── Sidebar ── --}}
        <aside class="forum-sidebar">

            {{-- Categories --}}
            <div class="forum-sidebar-card">
                <div class="forum-sidebar-title">Kategori</div>
                <button class="forum-cat-btn active" onclick="filterForum('all', this)">
                    <i class="fa-solid fa-border-all"></i>
                    <span>Semua</span>
                    <span class="forum-cat-count" id="count-all">64</span>
                </button>
                <button class="forum-cat-btn" onclick="filterForum('webdev', this)">
                    <i class="fa-solid fa-code"></i>
                    <span>Web Dev</span>
                    <span class="forum-cat-count" id="count-webdev">18</span>
                </button>
                <button class="forum-cat-btn" onclick="filterForum('desain', this)">
                    <i class="fa-solid fa-pen-ruler"></i>
                    <span>Desain UI/UX</span>
                    <span class="forum-cat-count" id="count-desain">12</span>
                </button>
                <button class="forum-cat-btn" onclick="filterForum('data', this)">
                    <i class="fa-solid fa-chart-simple"></i>
                    <span>Data Science</span>
                    <span class="forum-cat-count" id="count-data">11</span>
                </button>
                <button class="forum-cat-btn" onclick="filterForum('mobile', this)">
                    <i class="fa-solid fa-mobile-screen"></i>
                    <span>Mobile Dev</span>
                    <span class="forum-cat-count" id="count-mobile">9</span>
                </button>
                <button class="forum-cat-btn" onclick="filterForum('karir', this)">
                    <i class="fa-solid fa-briefcase"></i>
                    <span>Karir & Kerja</span>
                    <span class="forum-cat-count" id="count-karir">14</span>
                </button>
                <div class="forum-sidebar-divider"></div>
                <button class="forum-cat-btn" onclick="filterForum('saya', this)">
                    <i class="fa-solid fa-bookmark"></i>
                    <span>Post Saya</span>
                </button>
                <button class="forum-cat-btn" onclick="filterForum('dijawab', this)">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Terjawab</span>
                    <span class="forum-cat-count">41</span>
                </button>
            </div>

            {{-- Trending tags --}}
            <div class="forum-sidebar-card">
                <div class="forum-sidebar-title">Tag Trending</div>
                <div class="forum-tag-list">
                    <a href="#" class="forum-tag-pill">#javascript</a>
                    <a href="#" class="forum-tag-pill">#reactjs</a>
                    <a href="#" class="forum-tag-pill">#laravel</a>
                    <a href="#" class="forum-tag-pill">#python</a>
                    <a href="#" class="forum-tag-pill">#figma</a>
                    <a href="#" class="forum-tag-pill">#portfolio</a>
                    <a href="#" class="forum-tag-pill">#bootcamp</a>
                    <a href="#" class="forum-tag-pill">#freelance</a>
                    <a href="#" class="forum-tag-pill">#sql</a>
                    <a href="#" class="forum-tag-pill">#flutter</a>
                </div>
            </div>

            {{-- Online members --}}
            <div class="forum-sidebar-card">
                <div class="forum-sidebar-title">Anggota Aktif</div>
                <div class="forum-online-list">
                    @php
                        $onlineMembers = [
                            ['init' => 'RD', 'name' => 'Rizky D.', 'role' => 'Instruktur'],
                            ['init' => 'SA', 'name' => 'Sinta A.', 'role' => 'Pelajar Pro'],
                            ['init' => 'BK', 'name' => 'Budi K.', 'role' => 'Pelajar'],
                            ['init' => 'FN', 'name' => 'Fadila N.', 'role' => 'Mentor'],
                            ['init' => 'YP', 'name' => 'Yuda P.', 'role' => 'Pelajar Pro'],
                        ];
                    @endphp
                    @foreach($onlineMembers as $m)
                        <div class="forum-online-item">
                            <div class="forum-online-avatar">{{ $m['init'] }}</div>
                            <div class="forum-online-info">
                                <div class="forum-online-name">{{ $m['name'] }}</div>
                                <div class="forum-online-role">{{ $m['role'] }}</div>
                            </div>
                            <div class="forum-online-dot"></div>
                        </div>
                    @endforeach
                </div>
            </div>

        </aside>

        {{-- ── Thread List ── --}}
        <div class="forum-content">

            {{-- Toolbar --}}
            <div class="forum-toolbar">
                <div class="forum-sort-tabs">
                    <button class="forum-sort-tab active" onclick="sortForum('terbaru', this)">Terbaru</button>
                    <button class="forum-sort-tab" onclick="sortForum('populer', this)">Populer</button>
                    <button class="forum-sort-tab" onclick="sortForum('belum-dijawab', this)">Belum Dijawab</button>
                </div>
                <div class="forum-view-toggle">
                    <button class="forum-view-btn active" id="viewList" onclick="setView('list')" title="List view">
                        <i class="fa-solid fa-list"></i>
                    </button>
                    <button class="forum-view-btn" id="viewCompact" onclick="setView('compact')" title="Compact view">
                        <i class="fa-solid fa-table-cells"></i>
                    </button>
                </div>
            </div>

            {{-- Pinned announcement --}}
            <a href="#" class="forum-pinned-banner">
                <div class="forum-pinned-icon"><i class="fa-solid fa-thumbtack"></i></div>
                <div class="forum-pinned-text">
                    <div class="forum-pinned-label"><i class="fa-solid fa-thumbtack"></i> Pengumuman</div>
                    <div class="forum-pinned-title">📣 Panduan Komunitas & Aturan Forum — Wajib Dibaca Sebelum Posting</div>
                    <div class="forum-pinned-meta">Diposting oleh <strong>Admin Coursify</strong> · 3 hari lalu</div>
                </div>
                <i class="fa-solid fa-chevron-right forum-pinned-arrow"></i>
            </a>

            {{-- No results --}}
            <div class="forum-no-results" id="noResults">
                <div class="forum-no-results-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
                <div class="forum-no-results-title">Tidak ada diskusi ditemukan</div>
                <p class="forum-no-results-desc">Coba kata kunci lain atau mulai diskusi baru!</p>
            </div>

            {{-- Thread items --}}
            @php
                $threads = [
                    [
                        'id'       => 1,
                        'cat'      => 'webdev',
                        'cat_label'=> 'Web Dev',
                        'badges'   => [['hot', 'fa-fire', '🔥 Hot']],
                        'title'    => 'Kenapa state di React tidak langsung update setelah setState dipanggil?',
                        'excerpt'  => 'Saya sedang belajar React dari kursus JavaScript Advanced. Setelah memanggil setState, log console masih menampilkan nilai lama. Sudah coba berbagai cara tapi tetap sama...',
                        'author'   => ['init'=>'DF', 'name'=>'Dimas F.'],
                        'votes'    => 48,
                        'replies'  => 23,
                        'views'    => '1.2K',
                        'time'     => '12 menit lalu',
                        'last_init'=> 'RD',
                        'last_name'=> 'Rizky D.',
                        'solved'   => false,
                        'is_hot'   => true,
                        'tags'     => ['#reactjs','#javascript'],
                    ],
                    [
                        'id'       => 2,
                        'cat'      => 'karir',
                        'cat_label'=> 'Karir & Kerja',
                        'badges'   => [['solved', 'fa-circle-check', '✓ Terjawab']],
                        'title'    => 'Share pengalaman: dari fresh graduate ke junior developer dalam 6 bulan',
                        'excerpt'  => 'Halo semua! Ingin berbagi cerita perjalanan saya dari lulus kuliah Manajemen sampai akhirnya diterima sebagai junior frontend di startup Series B...',
                        'author'   => ['init'=>'SA', 'name'=>'Sinta A.'],
                        'votes'    => 92,
                        'replies'  => 67,
                        'views'    => '4.5K',
                        'time'     => '1 jam lalu',
                        'last_init'=> 'YP',
                        'last_name'=> 'Yuda P.',
                        'solved'   => true,
                        'is_hot'   => false,
                        'tags'     => ['#karir','#portfolio','#frontend'],
                    ],
                    [
                        'id'       => 3,
                        'cat'      => 'desain',
                        'cat_label'=> 'Desain UI/UX',
                        'badges'   => [['new', 'fa-sparkles', 'Baru']],
                        'title'    => 'Feedback untuk portofolio Figma saya — sudah layak melamar kerja?',
                        'excerpt'  => 'Setelah 3 bulan belajar kursus UI/UX di Coursify, akhirnya saya selesaikan 4 case study. Minta feedback dari teman-teman yang sudah berpengalaman...',
                        'author'   => ['init'=>'NR', 'name'=>'Nadia R.'],
                        'votes'    => 17,
                        'replies'  => 14,
                        'views'    => '890',
                        'time'     => '3 jam lalu',
                        'last_init'=> 'FN',
                        'last_name'=> 'Fadila N.',
                        'solved'   => false,
                        'is_hot'   => false,
                        'tags'     => ['#figma','#portfolio'],
                    ],
                    [
                        'id'       => 4,
                        'cat'      => 'data',
                        'cat_label'=> 'Data Science',
                        'badges'   => [['solved', 'fa-circle-check', '✓ Terjawab']],
                        'title'    => 'Apa perbedaan mendasar antara supervised dan unsupervised learning?',
                        'excerpt'  => 'Saya sedang di modul 3 kursus Machine Learning Fundamentals. Sudah baca materi berkali-kali tapi masih bingung kapan harus pakai yang mana...',
                        'author'   => ['init'=>'BK', 'name'=>'Budi K.'],
                        'votes'    => 34,
                        'replies'  => 19,
                        'views'    => '2.1K',
                        'time'     => '5 jam lalu',
                        'last_init'=> 'RD',
                        'last_name'=> 'Rizky D.',
                        'solved'   => true,
                        'is_hot'   => false,
                        'tags'     => ['#python','#machinelearning'],
                    ],
                    [
                        'id'       => 5,
                        'cat'      => 'webdev',
                        'cat_label'=> 'Web Dev',
                        'badges'   => [],
                        'title'    => 'Tutorial: Deploy Laravel ke VPS Ubuntu menggunakan GitHub Actions CI/CD',
                        'excerpt'  => 'Hei! Setelah struggle berminggu-minggu, akhirnya berhasil setup pipeline CI/CD yang berjalan mulus. Ingin berbagi step-by-step lengkap dari awal...',
                        'author'   => ['init'=>'AG', 'name'=>'Anton G.'],
                        'votes'    => 61,
                        'replies'  => 31,
                        'views'    => '3.7K',
                        'time'     => '1 hari lalu',
                        'last_init'=> 'BK',
                        'last_name'=> 'Budi K.',
                        'solved'   => false,
                        'is_hot'   => false,
                        'tags'     => ['#laravel','#devops'],
                    ],
                    [
                        'id'       => 6,
                        'cat'      => 'mobile',
                        'cat_label'=> 'Mobile Dev',
                        'badges'   => [['hot', 'fa-fire', '🔥 Hot']],
                        'title'    => 'Flutter vs React Native di 2025 — mana yang sebaiknya dipelajari duluan?',
                        'excerpt'  => 'Sudah baca banyak artikel tapi opini-opininya saling bertentangan. Ingin dengar perspektif dari teman-teman yang sudah nyebur ke salah satunya...',
                        'author'   => ['init'=>'MH', 'name'=>'Maya H.'],
                        'votes'    => 55,
                        'replies'  => 44,
                        'views'    => '5.2K',
                        'time'     => '2 hari lalu',
                        'last_init'=> 'SA',
                        'last_name'=> 'Sinta A.',
                        'solved'   => false,
                        'is_hot'   => true,
                        'tags'     => ['#flutter','#reactnative','#mobile'],
                    ],
                    [
                        'id'       => 7,
                        'cat'      => 'karir',
                        'cat_label'=> 'Karir & Kerja',
                        'badges'   => [['new', 'fa-sparkles', 'Baru']],
                        'title'    => 'Nego gaji pertama kali — tips buat yang belum punya pengalaman kerja',
                        'excerpt'  => 'Dapat offer kerja pertama! Tapi bingung bagaimana cara negosiasi gaji yang baik tanpa terkesan terlalu agresif atau merusak kesempatan...',
                        'author'   => ['init'=>'LW', 'name'=>'Lina W.'],
                        'votes'    => 28,
                        'replies'  => 22,
                        'views'    => '1.8K',
                        'time'     => '2 hari lalu',
                        'last_init'=> 'FN',
                        'last_name'=> 'Fadila N.',
                        'solved'   => false,
                        'is_hot'   => false,
                        'tags'     => ['#karir','#freshgraduate'],
                    ],
                    [
                        'id'       => 8,
                        'cat'      => 'desain',
                        'cat_label'=> 'Desain UI/UX',
                        'badges'   => [['solved', 'fa-circle-check', '✓ Terjawab']],
                        'title'    => 'Bagaimana cara menghitung ukuran spacing yang konsisten untuk design system?',
                        'excerpt'  => 'Sedang membangun design system untuk proyek freelance pertama. Bingung tentang skala spacing — apakah harus pakai 4px, 8px, atau sistem lain?',
                        'author'   => ['init'=>'IP', 'name'=>'Irfan P.'],
                        'votes'    => 22,
                        'replies'  => 17,
                        'views'    => '1.4K',
                        'time'     => '3 hari lalu',
                        'last_init'=> 'NR',
                        'last_name'=> 'Nadia R.',
                        'solved'   => true,
                        'is_hot'   => false,
                        'tags'     => ['#figma','#designsystem'],
                    ],
                ];
            @endphp

            <div id="threadList">
                @foreach($threads as $thread)
                    @php
                        $itemClass = 'forum-thread';
                        if ($thread['is_hot']) $itemClass .= ' is-hot';
                        elseif ($thread['solved']) $itemClass .= ' is-solved';
                        elseif (!empty($thread['badges']) && $thread['badges'][0][0] === 'new') $itemClass .= ' is-new';
                    @endphp

                    <div
                        class="{{ $itemClass }}"
                        data-category="{{ $thread['cat'] }}"
                        data-title="{{ strtolower($thread['title']) }}"
                        data-excerpt="{{ strtolower($thread['excerpt']) }}"
                        onclick="window.location='#thread-{{ $thread['id'] }}'"
                    >
                        {{-- Vote --}}
                        <div class="forum-thread-vote">
                            <button class="forum-vote-btn" onclick="voteThread(event, {{ $thread['id'] }}, 'up')" title="Upvote">
                                <i class="fa-solid fa-chevron-up"></i>
                            </button>
                            <span class="forum-vote-count {{ $thread['votes'] >= 50 ? 'high' : '' }}" id="vote-{{ $thread['id'] }}">{{ $thread['votes'] }}</span>
                            <button class="forum-vote-btn" onclick="voteThread(event, {{ $thread['id'] }}, 'down')" title="Downvote">
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                        </div>

                        {{-- Body --}}
                        <div class="forum-thread-body">
                            {{-- Badges & category --}}
                            <div class="forum-thread-badges">
                                <span class="badge-cat">{{ $thread['cat_label'] }}</span>
                                @foreach($thread['badges'] as $badge)
                                    <span class="forum-badge badge-{{ $badge[0] }}">
                                        <i class="fa-solid {{ $badge[1] }}"></i>
                                        {{ $badge[2] }}
                                    </span>
                                @endforeach
                            </div>

                            <div class="forum-thread-title">{{ $thread['title'] }}</div>
                            <div class="forum-thread-excerpt">{{ $thread['excerpt'] }}</div>

                            {{-- Tags --}}
                            @if(!empty($thread['tags']))
                                <div style="display:flex; gap:5px; flex-wrap:wrap; margin-bottom:10px;">
                                    @foreach($thread['tags'] as $tag)
                                        <span style="font-size:11px; color:var(--purple-dark); background:rgba(123,111,232,0.07); border:1px solid rgba(123,111,232,0.18); border-radius:6px; padding:2px 9px; font-weight:600; cursor:pointer;">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Meta --}}
                            <div class="forum-thread-meta">
                                <a href="#" class="forum-meta-author" onclick="return false;">
                                    <div class="forum-meta-avatar">{{ $thread['author']['init'] }}</div>
                                    <span class="forum-meta-name">{{ $thread['author']['name'] }}</span>
                                </a>
                                <span class="forum-meta-stat">
                                    <i class="fa-regular fa-message"></i>
                                    {{ $thread['replies'] }} balasan
                                </span>
                                <span class="forum-meta-stat">
                                    <i class="fa-regular fa-eye"></i>
                                    {{ $thread['views'] }}
                                </span>
                                <span class="forum-meta-time">{{ $thread['time'] }}</span>
                            </div>
                        </div>

                        {{-- Aside stats --}}
                        <div class="forum-thread-aside">
                            <div class="forum-aside-stat">
                                <span class="forum-aside-stat-num">{{ $thread['replies'] }}</span>
                                <span class="forum-aside-stat-label">Balasan</span>
                            </div>
                            <div class="forum-last-reply">
                                <div class="forum-last-reply-img">{{ $thread['last_init'] }}</div>
                                <div class="forum-last-reply-info">{{ $thread['last_name'] }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="forum-pagination" id="forumPagination">
                <a href="#" class="forum-page-btn wide" onclick="return false;"><i class="fa-solid fa-chevron-left"></i></a>
                <a href="#" class="forum-page-btn active" onclick="return false;">1</a>
                <a href="#" class="forum-page-btn" onclick="return false;">2</a>
                <a href="#" class="forum-page-btn" onclick="return false;">3</a>
                <span style="color:var(--muted); font-size:14px; padding:0 2px;">…</span>
                <a href="#" class="forum-page-btn" onclick="return false;">12</a>
                <a href="#" class="forum-page-btn wide" onclick="return false;"><i class="fa-solid fa-chevron-right"></i></a>
            </div>

        </div>{{-- /.forum-content --}}
    </div>{{-- /.forum-inner --}}
</section>

{{-- ══════════════════════════════════════════
     CTA
══════════════════════════════════════════ --}}
<section class="forum-cta-section">
    <div class="forum-cta-card">
        <div class="forum-cta-left">
            <div class="forum-cta-eyebrow">
                <i class="fa-solid fa-people-group" style="margin-right:5px;"></i>
                Bergabung Sekarang
            </div>
            <h2 class="forum-cta-title">
                Jadilah bagian dari<br><em>komunitas kami</em>
            </h2>
            <p class="forum-cta-desc">
                Lebih dari 24.000 pelajar aktif saling berbagi ilmu setiap harinya. Daftar gratis dan mulai berdiskusi hari ini.
            </p>
        </div>
        <div class="forum-cta-buttons">
            <a href="{{ route('register') }}" class="btn-forum-primary">
                <i class="fa-solid fa-user-plus"></i>
                Daftar Gratis
            </a>
            <a href="{{ route('faq') }}" class="btn-forum-ghost">
                <i class="fa-solid fa-circle-question"></i>
                Pusat Bantuan
            </a>
        </div>
    </div>
</section>

{{-- FAB --}}
<button class="forum-fab" onclick="openNewPostModal(event)">
    <i class="fa-solid fa-plus"></i>
    Buat Diskusi
</button>

@endsection

@push('scripts')
<script>
/* ── Filter by category ── */
function filterForum(cat, btn) {
    document.querySelectorAll('.forum-cat-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    document.querySelectorAll('.forum-thread').forEach(thread => {
        if (cat === 'all' || thread.dataset.category === cat) {
            thread.style.display = '';
        } else {
            thread.style.display = 'none';
        }
    });

    // Reset search
    document.getElementById('forumSearch').value = '';
    document.getElementById('searchClear').classList.remove('visible');
    document.getElementById('noResults').classList.remove('visible');
    checkPagination();
}

/* ── Sort tabs ── */
function sortForum(type, btn) {
    document.querySelectorAll('.forum-sort-tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    // Sorting logic would be server-side in real implementation
}

/* ── View toggle ── */
function setView(type) {
    document.getElementById('viewList').classList.toggle('active', type === 'list');
    document.getElementById('viewCompact').classList.toggle('active', type === 'compact');
    var list = document.getElementById('threadList');
    if (type === 'compact') {
        list.style.fontSize = '0.9em';
    } else {
        list.style.fontSize = '';
    }
}

/* ── Search ── */
function searchForum(query) {
    var q = query.trim().toLowerCase();
    var clearBtn = document.getElementById('searchClear');
    var found = 0;

    clearBtn.classList.toggle('visible', q.length > 0);

    // Reset category
    document.querySelectorAll('.forum-cat-btn').forEach(b => b.classList.remove('active'));
    document.querySelector('.forum-cat-btn').classList.add('active');

    document.querySelectorAll('.forum-thread').forEach(thread => {
        if (!q) {
            thread.style.display = '';
            found++;
            return;
        }
        var searchable = (thread.dataset.title || '') + ' ' + (thread.dataset.excerpt || '');
        if (searchable.includes(q)) {
            thread.style.display = '';
            found++;
        } else {
            thread.style.display = 'none';
        }
    });

    document.getElementById('noResults').classList.toggle('visible', found === 0 && q.length > 0);
    checkPagination();
}

function clearForumSearch() {
    var input = document.getElementById('forumSearch');
    input.value = '';
    searchForum('');
    input.focus();
}

/* ── Vote ── */
var voted = {};
function voteThread(e, id, dir) {
    e.stopPropagation();
    var el = document.getElementById('vote-' + id);
    if (!el) return;
    var current = parseInt(el.textContent);
    var key = id + '-' + dir;
    if (voted[key]) {
        // unvote
        el.textContent = dir === 'up' ? current - 1 : current + 1;
        voted[key] = false;
    } else {
        el.textContent = dir === 'up' ? current + 1 : current - 1;
        voted[key] = true;
    }
    el.classList.toggle('high', parseInt(el.textContent) >= 50);
}

/* ── Pagination visibility ── */
function checkPagination() {
    var visible = document.querySelectorAll('.forum-thread:not([style*="display: none"])').length;
    document.getElementById('forumPagination').style.display = visible > 0 ? '' : 'none';
}

/* ── New post modal (placeholder) ── */
function openNewPostModal(e) {
    e.preventDefault();
    // Replace with your actual modal logic, e.g.:
    alert('Fitur buat diskusi baru segera hadir! Sementara, coba jelajahi diskusi yang sudah ada atau cek kursus terbaru kami.');
}
</script>
@endpush