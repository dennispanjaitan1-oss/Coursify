@extends('layouts.app')

@section('title', 'Coursify - Learn Anything, Anytime')

@push('styles')
<style>
    /* ═══ HERO ═══ */
    .hero {
        width: 100%;
        padding: 90px 40px 70px;
        text-align: left;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeInUp 0.8s ease-out 0.2s both;
        border-radius: 0; /* Ensures full width no radius */
        margin: 0;
    }
    .hero-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        max-width: 1200px;
        width: 100%;
        gap: 60px;
        margin: 0 auto;
    }
    .hero-content {
        flex: 1;
        max-width: 600px;
    }
    .hero-visual {
        flex: 1;
        display: flex;
        justify-content: flex-end;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,255,255,0.85);
        backdrop-filter: blur(30px);
        border: 1px solid rgba(123,111,232,0.25);
        padding: 8px 18px;
        border-radius: 100px;
        font-size: 13px;
        font-weight: 500;
        color: var(--text-soft);
        margin-bottom: 20px;
        box-shadow: 0 8px 24px rgba(30,58,95,0.08);
        transition: all 0.3s ease;
    }
    .hero-badge:hover {
        background: rgba(255,255,255,0.95);
        border-color: rgba(123,111,232,0.4);
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(30,58,95,0.12);
    }
    .hero-badge-dot {
        width: 6px;
        height: 6px;
        background: var(--teal);
        border-radius: 50%;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.3); }
    }

    .hero-title {
        font-family: var(--font-serif);
        font-size: clamp(48px, 8vw, 88px);
        font-weight: 400;
        line-height: 1.15;
        letter-spacing: -0.03em;
        margin-bottom: 18px;
        color: var(--text);
        white-space: nowrap;
    }
    .hero-title-static {
        display: inline;
    }
    .hero-title-dynamic-container {
        position: relative;
        display: inline-block;
        height: 1.25em;
        width: 8.5ch;
        overflow: hidden;
        vertical-align: -0.35em;
    }
    .hero-title-dynamic-word {
        position: absolute;
        left: 0;
        top: 0;
        white-space: nowrap;
        opacity: 0;
        font-style: italic;
        padding-right: 0.5ch;
        background: linear-gradient(135deg, #9F94F2, #7B6FE8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        transform: translateY(130%);
        transition: transform 0.8s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.8s cubic-bezier(0.25, 1, 0.5, 1);
        display: inline-block;
    }
    .hero-title-dynamic-word.active {
        opacity: 1;
        transform: translateY(0);
        z-index: 2;
    }
    .hero-title-dynamic-word.exit {
        opacity: 0;
        transform: translateY(-130%);
        z-index: 1;
    }

    .hero-subtitle {
        font-size: 16px;
        line-height: 1.6;
        color: var(--text-soft);
        max-width: 500px;
        margin: 0 auto 28px;
    }

    .hero-cta {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 14px;
        margin-bottom: 36px;
        width: 100%;
        max-width: 620px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Subject & Skill Selector Glassmorphism - Refined & Compacted */
    .hero-selector-form {
        width: 100%;
        max-width: 780px;
        margin: 0 auto;
        position: relative;
        z-index: 10;
    }
    .selector-container {
        display: flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.45);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 20px; /* Lengkungan elegan, bukan pill bulat panjang */
        padding: 5px 6px 5px 22px;
        box-shadow: 0 10px 30px rgba(30, 58, 95, 0.04);
        transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
    }
    .selector-container:hover {
        background: rgba(255, 255, 255, 0.52);
        border-color: rgba(255, 255, 255, 0.65);
        box-shadow: 0 12px 35px rgba(30, 58, 95, 0.06);
    }
    .selector-container:focus-within {
        background: rgba(255, 255, 255, 0.65);
        border-color: rgba(123, 111, 232, 0.4);
        box-shadow: 0 15px 35px rgba(123, 111, 232, 0.08);
        transform: translateY(-1px);
    }
    .selector-group {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-width: 0;
        text-align: left;
        padding: 4px 10px;
        border-radius: 12px;
        transition: background-color 0.25s ease;
    }
    .selector-group:hover {
        background-color: rgba(123, 111, 232, 0.05);
    }
    .selector-label {
        font-family: var(--font-sans);
        font-size: 10px;
        font-weight: 700;
        color: var(--text-soft);
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 1px;
        transition: color 0.25s ease;
    }
    .selector-group:hover .selector-label {
        color: var(--purple);
    }
    .selector-dropdown {
        border: none;
        background: transparent;
        font-family: var(--font-sans);
        font-size: 14px;
        font-weight: 500;
        color: var(--text);
        outline: none;
        cursor: pointer;
        padding: 2px 20px 2px 0;
        width: 100%;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%237B6FE8' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 4px center;
        background-size: 12px;
        transition: all 0.25s ease;
    }
    .selector-dropdown:focus {
        color: var(--purple-dark);
    }
    .selector-divider {
        width: 1px;
        height: 28px;
        background: rgba(123, 111, 232, 0.12);
        margin: 0 16px;
    }
    .selector-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #100F17;
        color: white;
        border: none;
        padding: 10px 22px;
        border-radius: 14px; /* Senada dengan lengkungan luar */
        font-family: var(--font-sans);
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        flex-shrink: 0;
        white-space: nowrap;
    }
    .selector-btn:hover {
        background: #252335;
        transform: scale(1.02);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.16);
    }
    .selector-btn:active {
        transform: scale(0.98);
    }
    .selector-btn i {
        transition: transform 0.25s ease;
    }
    .selector-btn:hover i {
        transform: translateX(3px);
    }

    @media (max-width: 768px) {
        .hero { padding: 60px 20px 40px; }
        .hero-container { flex-direction: column; gap: 40px; }
        .hero-visual { display: none; /* Hide the mockups on small screens to save space or adjust if needed */ }
        .selector-container {
            flex-direction: column;
            border-radius: 18px;
            padding: 16px;
            gap: 12px;
        }
        .selector-group {
            width: 100%;
            padding: 8px 12px;
        }
        .selector-dropdown {
            background-position: right 12px center;
            padding: 8px 24px 8px 12px;
            background-color: rgba(255, 255, 255, 0.45);
            border-radius: 10px;
            border: 1px solid rgba(123, 111, 232, 0.08);
        }
        .selector-label {
            margin-left: 8px;
            margin-bottom: 4px;
        }
        .selector-divider {
            display: none;
        }
        .selector-btn {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
        }
    }

    .trust-indicators {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 24px;
        flex-wrap: wrap;
        margin-bottom: 50px;
        opacity: 0.85;
    }
    .trust-label {
        font-size: 11px;
        color: var(--muted);
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }
    .trust-logos { display: flex; gap: 24px; flex-wrap: wrap; align-items: center; }
    .trust-logo {
        font-family: var(--font-serif);
        font-style: italic;
        font-size: 16px;
        color: var(--text-soft);
        opacity: 0.65;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    .trust-logo:hover { opacity: 0.95; transform: translateY(-1px); }

    /* ═══ PHONE MOCKUP ═══ */
    .mockup-stage {
        position: relative;
        max-width: 600px;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        align-items: flex-end;
        gap: 10px;
        height: 480px;
    }
    .phone {
        background: white;
        border-radius: 36px;
        padding: 5px;
        box-shadow: 0 20px 60px rgba(30,58,95,0.18);
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .phone-main {
        width: 220px;
        height: 450px;
        z-index: 2;
        position: relative;
        animation: floatMain 4s ease-in-out infinite;
    }
    .phone-side {
        width: 150px;
        height: 340px;
        opacity: 0.92;
    }
    .phone-side-left {
        transform: rotate(-8deg) translate(20px, 20px);
        animation: floatLeft 5s ease-in-out infinite;
    }
    .phone-side-right {
        transform: rotate(8deg) translate(-20px, 20px);
        animation: floatRight 5s ease-in-out infinite 0.5s;
    }
    @keyframes floatMain {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    @keyframes floatLeft {
        0%, 100% { transform: rotate(-8deg) translate(20px, 20px); }
        50% { transform: rotate(-8deg) translate(20px, 10px); }
    }
    @keyframes floatRight {
        0%, 100% { transform: rotate(8deg) translate(-20px, 20px); }
        50% { transform: rotate(8deg) translate(-20px, 10px); }
    }
    .phone:hover { transform: translateY(-8px) scale(1.02); }

    .phone-screen {
        width: 100%;
        height: 100%;
        background: linear-gradient(180deg, #F5F1FC, #E8E1F3);
        border-radius: 32px;
        padding: 18px 12px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        position: relative;
        overflow: hidden;
    }
    .phone-status {
        font-size: 11px;
        color: var(--text-soft);
        text-align: center;
        font-weight: 600;
        margin-bottom: 4px;
    }
    .phone-label {
        font-size: 10px;
        color: var(--muted);
        text-align: center;
        margin-bottom: 4px;
        font-weight: 500;
    }
    .phone-card {
        background: rgba(255,255,255,0.95);
        border-radius: 14px;
        padding: 10px;
    }
    .phone-avatar {
        width: 100%;
        aspect-ratio: 1;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--navy), #2D4D7A);
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        position: relative;
        overflow: hidden;
    }
    .phone-avatar::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, transparent 40%, rgba(0,0,0,0.15));
    }
    .phone-name {
        font-family: var(--font-serif);
        font-size: 17px;
        text-align: center;
        letter-spacing: -0.01em;
    }
    .phone-skill-tags {
        display: flex;
        gap: 4px;
        justify-content: center;
        margin-top: 6px;
        flex-wrap: wrap;
    }
    .phone-skill-tag {
        background: rgba(123,111,232,0.15);
        color: var(--purple-dark);
        padding: 2px 8px;
        border-radius: 100px;
        font-size: 9px;
        font-weight: 600;
    }

    /* ═══ STATS ═══ */
    .stats { padding: 20px; margin-top: -20px; }
    .stats-bar {
        background: rgba(255,255,255,0.5);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.8);
        border-radius: 24px;
        padding: 28px 40px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        box-shadow: 0 10px 40px rgba(30,58,95,0.06);
    }
    .stat-item { text-align: center; border-right: 1px solid rgba(30,58,95,0.08); }
    .stat-item:last-child { border-right: none; }
    .stat-value {
        font-family: var(--font-serif);
        font-size: 36px;
        font-weight: 400;
        color: var(--text);
        line-height: 1;
        letter-spacing: -0.02em;
        margin-bottom: 4px;
    }
    .stat-value em { font-style: italic; color: var(--purple); }
    .stat-label {
        font-size: 11px;
        color: var(--muted);
        font-weight: 500;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    /* ═══ SECTIONS ═══ */
    .section {
         padding: 70px 20px;
        position: relative;
        z-index: 1;
        clear: both;
    }
    .section-header { text-align: center; max-width: 640px; margin: 0 auto 40px; }
    .section-eyebrow {
        display: inline-block;
        font-size: 11px;
        color: var(--purple);
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        margin-bottom: 10px;
    }
    .section-title {
        font-family: var(--font-serif);
        font-size: clamp(36px, 5vw, 52px);
        font-weight: 400;
        line-height: 1.1;
        letter-spacing: -0.02em;
        margin-bottom: 12px;
    }
    .section-title em { font-style: italic; color: var(--purple); }
    .section-subtitle {
        font-size: 15px;
        line-height: 1.6;
        color: var(--muted);
        max-width: 480px;
        margin: 0 auto;
    }

    /* ═══ CATEGORIES ═══ */
    .cat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        max-width: 960px;
        margin: 0 auto;
    }
    .cat-card {
        background: rgba(255,255,255,0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.9);
        border-radius: 20px;
        padding: 20px 16px;
        text-align: center;
        text-decoration: none;
        color: var(--text);
        transition: all 0.3s;
        cursor: pointer;
    }
    .cat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(30,58,95,0.1);
        border-color: var(--purple);
    }
    .cat-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, var(--lav-2), var(--lav-3));
        border-radius: 14px;
        margin: 0 auto 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        transition: transform 0.3s;
    }
    .cat-card:hover .cat-icon { transform: scale(1.1) rotate(-5deg); }
    .cat-name { font-family: var(--font-serif); font-size: 16px; margin-bottom: 2px; }
    .cat-count { font-size: 11px; color: var(--muted); font-weight: 500; }

    /* ═══ EXPLORE SECTION (edX-style) ═══ */
    .explore-section { padding: 60px 20px; }
    .subject-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 32px;
    }
    .subject-card {
        display: flex;
        align-items: center;
        gap: 14px;
        border-radius: 22px;
        border: 1px solid rgba(123,111,232,0.16);
        background: rgba(255,255,255,0.95);
        padding: 18px 18px;
        text-decoration: none;
        color: var(--text);
        transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
    }
    .subject-card:hover {
        transform: translateY(-3px);
        border-color: rgba(123,111,232,0.3);
        box-shadow: 0 18px 40px rgba(91,88,137,0.08);
    }
    .subject-card-icon {
        width: 44px;
        height: 44px;
        min-width: 44px;
        border-radius: 14px;
        display: grid;
        place-items: center;
        background: rgba(123,111,232,0.08);
        color: var(--purple);
        font-size: 18px;
    }
    .subject-card-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 4px;
    }
    .subject-card-meta {
        font-size: 12px;
        color: var(--muted);
    }
    .explore-meta-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        margin-bottom: 28px;
        color: var(--text-soft);
        font-size: 14px;
    }
    .explore-meta-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 18px;
        border-radius: 999px;
        border: 1px solid rgba(123,111,232,0.25);
        color: var(--purple);
        text-decoration: none;
        font-weight: 600;
        transition: background 0.2s ease, transform 0.2s ease;
    }
    .explore-meta-link:hover {
        background: rgba(123,111,232,0.08);
        transform: translateY(-1px);
    }
    .explore-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 24px;
        max-width: 1200px;
        margin: 0 auto;
    }
    .explore-column {
        display: flex;
        flex-direction: column;
        gap: 18px;
        border-radius: 24px;
        border: 1px solid rgba(123,111,232,0.14);
        background: rgba(255,255,255,0.95);
        padding: 22px;
    }
    .explore-col-header {
        display: grid;
        gap: 8px;
        padding-bottom: 12px;
        border-bottom: 1px solid rgba(0,0,0,0.06);
    }
    .explore-col-title {
        font-family: var(--font-serif);
        font-size: 16px;
        font-weight: 700;
        color: var(--text);
        margin: 0;
    }
    .explore-col-subtitle {
        font-size: 13px;
        color: var(--muted);
        margin: 0;
        line-height: 1.5;
    }
    .explore-col-links {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .explore-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        text-decoration: none;
        color: var(--text-soft);
        font-size: 14px;
        transition: color 0.2s ease, transform 0.2s ease;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .explore-link:last-child {
        border-bottom: none;
    }
    .explore-link:hover {
        color: var(--purple);
        transform: translateX(4px);
    }
    .explore-link-cta {
        color: var(--purple);
        font-weight: 700;
    }
    .explore-empty {
        color: var(--muted);
        font-size: 13px;
        margin: 0;
    }
    .beginner-bar {
        margin-top: 28px;
        padding: 20px 22px;
        border-radius: 20px;
        background: rgba(123,111,232,0.07);
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        align-items: center;
    }
    .beginner-label {
        font-weight: 700;
        color: var(--text);
        min-width: 180px;
    }
    .beginner-list {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        flex: 1;
    }
    .beginner-chip {
        display: inline-flex;
        align-items: center;
        padding: 10px 16px;
        border-radius: 999px;
        border: 1px solid rgba(123,111,232,0.18);
        background: white;
        color: var(--text);
        text-decoration: none;
        font-size: 13px;
        transition: all 0.2s ease;
    }
    .beginner-chip:hover {
        background: rgba(123,111,232,0.1);
        color: var(--purple);
    }
    @media (max-width: 1024px) {
        .subject-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .explore-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .explore-meta-row { flex-direction: column; align-items: stretch; }
    }
    @media (max-width: 768px) {
        .explore-section { padding: 40px 20px; }
        .subject-grid, .explore-grid { grid-template-columns: 1fr; }
        .explore-meta-row { gap: 12px; }
    }

    /* ═══ LATEST SECTION ═══ */
    .latest-section { background: transparent; padding: 80px 0; border-top: none; }
    .latest-header { text-align: center; margin-bottom: 50px; }
    .latest-badge { 
        background: rgba(255,255,255,0.4); backdrop-filter: blur(12px) saturate(180%); 
        border: 1px solid rgba(255,255,255,0.6); box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        color: var(--navy); padding: 4px 10px; border-radius: 6px; font-weight: 800; font-size: 13px; 
        vertical-align: middle; margin-right: 12px; display: inline-block; letter-spacing: 0.05em; 
    }
    .latest-title { font-family: var(--font-serif, serif); font-size: 46px; color: var(--navy, #153759); font-weight: 800; display: inline-block; vertical-align: middle; margin: 0; line-height: 1.1; }
    .latest-subtitle { margin-top: 14px; font-size: 18px; color: rgba(21, 55, 89, 0.8); }
    
    .latest-slider-wrapper { position: relative; display: flex; align-items: stretch; max-width: 1240px; margin: 0 auto; gap: 10px; }
    .latest-nav { background: rgba(255,255,255,0.6); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.8); box-shadow: 0 4px 12px rgba(0,0,0,0.05); border-radius: 50%; font-size: 18px; cursor: pointer; color: var(--navy); width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; transition: 0.3s; align-self: center; flex-shrink: 0; z-index: 2; }
    .latest-nav:hover { background: #fff; color: var(--purple); transform: scale(1.1); border-color: #fff; }
    
    .latest-slider { display: flex; gap: 24px; overflow-x: auto; scroll-snap-type: x mandatory; scrollbar-width: none; flex: 1; padding: 20px 5px; scroll-behavior: smooth; }
    .latest-slider::-webkit-scrollbar { display: none; }
    
    .latest-card { flex: 0 0 calc(33.333% - 16px); min-width: 280px; background: #fff; border-radius: 16px; border: 1px solid rgba(255,255,255,0.4); overflow: hidden; scroll-snap-align: center; display: flex; flex-direction: column; transition: transform 0.35s, box-shadow 0.35s; box-shadow: 0 8px 24px rgba(30,58,95,0.08); text-decoration: none; }
    .latest-card:hover { transform: translateY(-8px); box-shadow: 0 16px 32px rgba(30,58,95,0.15); border-color: #fff; }
    .latest-card-header { display: flex; justify-content: space-between; align-items: center; padding: 14px 18px; background: rgba(123,111,232,0.03); font-weight: 700; color: var(--navy); font-size: 13px; border-bottom: 1px solid rgba(123,111,232,0.08); }
    .latest-card-badge { 
        background: rgba(255,255,255,0.6); backdrop-filter: blur(8px); border: 1px solid rgba(123,111,232,0.2); 
        color: var(--purple); padding: 3px 8px; border-radius: 4px; font-size: 10px; font-weight: 800; letter-spacing: 0.05em; 
    }
    .latest-card-thumb { position: relative; height: 150px; background: #ddd; }
    .latest-card-thumb > img { width: 100%; height: 100%; object-fit: cover; }
    .latest-card-logo { position: absolute; bottom: -20px; left: 18px; width: 70px; height: 40px; background: #fff; border-radius: 6px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.08); overflow: hidden; padding: 6px; border: 1px solid rgba(0,0,0,0.04); }
    .latest-card-logo img { max-width: 100%; max-height: 100%; object-fit: contain; }
    
    .latest-card-body { padding: 36px 18px 20px; flex: 1; display: flex; flex-direction: column; }
    .latest-card-title { font-size: 18px; font-family: var(--font-serif, serif); font-weight: 700; color: var(--navy); line-height: 1.3; margin-bottom: 8px; }
    .latest-card-inst { font-size: 14px; color: var(--text-soft); margin-bottom: 24px; flex: 1; }
    .latest-card-meta { display: flex; flex-direction: column; gap: 10px; font-size: 13px; color: var(--text-soft); font-weight: 500; }
    .latest-card-meta i { width: 18px; text-align: center; margin-right: 6px; color: var(--purple, #7B6FE8); }
    
    .latest-dots { display: flex; justify-content: center; gap: 8px; margin-top: 10px; }
    .latest-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--purple); opacity: 0.2; cursor: pointer; transition: 0.3s; border: none; padding: 0; }
    .latest-dot.active { opacity: 1; width: 24px; border-radius: 100px; }
    
    .latest-btn-browse { background: var(--purple, #7B6FE8); color: #fff; font-weight: 600; font-size: 15px; padding: 14px 32px; border-radius: 999px; text-decoration: none; display: inline-block; transition: all 0.3s; box-shadow: 0 8px 20px rgba(123,111,232,0.25); }
    .latest-btn-browse:hover { background: var(--navy, #153759); box-shadow: 0 10px 24px rgba(21,55,89,0.3); transform: translateY(-2px); }

    @media(max-width: 1024px) { .latest-card { flex: 0 0 calc(33.333% - 16px); } }
    @media(max-width: 768px) { .latest-card { flex: 0 0 calc(50% - 12px); } .latest-title { font-size: 32px; } }
    @media(max-width: 480px) { .latest-card { flex: 0 0 100%; scroll-snap-align: center; } }

    /* ═══ COURSES ═══ */
    .courses-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        max-width: 1000px;
        margin: 0 auto;
    }
    .course-card {
        background: var(--color-card, #fff);
        border-radius: 12px;
        border: 1px solid var(--border, rgba(0,0,0,0.08));
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        cursor: pointer;
    }
    .course-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.12);
    }
    .course-card__thumb img {
        transition: transform 0.3s ease;
    }
    .course-card:hover .course-card__thumb img {
        transform: scale(1.04);
    }

    @media (max-width: 768px) {
        .stats-bar { grid-template-columns: repeat(2, 1fr); padding: 20px; gap: 16px; }
        .stat-item { border-right: none; }
        .cat-grid { grid-template-columns: repeat(2, 1fr); }
        .courses-grid { grid-template-columns: 1fr; }
        .phone-side { display: none; }
        .mockup-stage { height: auto; }
        .trust-indicators { flex-direction: column; gap: 10px; }
    }
    /* ═══ PROMO BANNER SLIDER ═══ */
.promo-bar {
    position: relative;
    width: 100%;
    overflow: hidden;
    height: 460px;
    background: linear-gradient(135deg, #0f0c29, #1a1630);
    perspective: 1000px;
    box-shadow: inset 0 2px 8px rgba(0,0,0,0.1), 0 10px 30px rgba(0,0,0,0.2);
    border-radius: 32px;
}
.promo-slides { position: relative; width: 100%; height: 100%; }
.promo-slide {
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity 0.7s ease;
    pointer-events: none;
    transform-style: preserve-3d;
}
.promo-slide.active { 
    opacity: 1; 
    pointer-events: all;
}
.promo-slide-bg { 
    position: absolute; 
    inset: 0; 
    z-index: 0;
    transform: translateZ(0);
    box-shadow: inset 0 4px 15px rgba(0,0,0,0.08);
}
.promo-slide-content {
    position: relative;
    z-index: 1;
    max-width: none;
    width: 100%;
    margin: 0;
    padding: 50px 40px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: center;
    height: 100%;
    transform: translateZ(20px);
}
.promo-slide-left { 
    color: white;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.promo-eyebrow {
    display: inline-block;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.6);
    margin-bottom: 10px;
}
.promo-slide-title {
    font-family: var(--font-serif);
    font-size: clamp(28px, 3.5vw, 48px);
    font-weight: 800;
    line-height: 1.2;
    letter-spacing: -0.02em;
    margin-bottom: 0;
    margin-top: 8px;
    color: white;
}
.promo-slide-title em { font-style: italic; color: #b8aef7; }
.promo-slide-desc {
    font-size: 14px;
    color: rgba(255,255,255,0.75);
    line-height: 1.6;
    margin-bottom: 0;
    margin-top: 12px;
    max-width: 400px;
}
.promo-code {
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.28);
    padding: 2px 9px;
    border-radius: 5px;
    font-family: monospace;
    font-size: 13px;
    font-weight: 700;
    color: #ffd700;
    letter-spacing: 0.05em;
}
.promo-slide-actions { 
    display: flex; 
    gap: 10px; 
    flex-wrap: wrap;
    margin-top: 24px;
}
.promo-btn-primary {
    background: white;
    color: #1a1a2e;
    padding: 10px 22px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s;
    display: inline-block;
}
.promo-btn-primary:hover { background: #f0ecff; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.2); }
.promo-btn-outline {
    border: 1.5px solid rgba(255,255,255,0.35);
    color: white;
    padding: 10px 22px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    display: inline-block;
}
.promo-btn-outline:hover { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.65); transform: translateY(-2px); }

/* Promo Course Cards */
.promo-slide-right {
    display: flex;
    gap: 16px;
    align-items: flex-start;
    justify-content: flex-end;
}
.hero-course-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid rgba(0,0,0,0.07);
    overflow: hidden;
    width: 200px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    flex-shrink: 0;
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    display: block;
    color: var(--text);
}
.hero-course-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0,0,0,0.15);
}
.hero-card__thumb {
    position: relative;
    width: 100%;
    aspect-ratio: 16/9;
    overflow: hidden;
    background: #e5e7eb;
}
.hero-card__thumb img {
    transition: transform 0.3s ease;
}
.hero-course-card:hover .hero-card__thumb img {
    transform: scale(1.04);
}
.hero-card__body {
    padding: 10px 12px 12px;
}
.hero-card__category {
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 0.08em;
    color: #6366f1;
    margin: 0 0 4px;
    text-transform: uppercase;
}
.hero-card__title {
    font-size: 13px;
    font-weight: 700;
    line-height: 1.35;
    color: #111;
    margin: 0 0 4px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.hero-card__instructor {
    font-size: 10px;
    color: #6b7280;
    margin: 0 0 6px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.hero-card__meta {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 10px;
    color: #6b7280;
}
.promo-card-offset { margin-top: 36px; }

.promo-card-thumb {
    aspect-ratio: 16/10;
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #667EEA, #764BA2);
    display: flex;
    align-items: center;
    justify-content: center;
}
.promo-card-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}
.promo-course-card:hover .promo-card-thumb img {
    transform: scale(1.05);
}
.promo-thumb-gradient {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--navy), #2D4D7A);
}
.promo-card-badge {
    position: absolute;
    top: 10px; left: 10px;
    z-index: 2;
    padding: 4px 10px;
    border-radius: 100px;
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    backdrop-filter: blur(10px);
    display: none;
}
.promo-card-badge.badge-free { background: rgba(0,200,150,0.9); color: white; }
/* .promo-card-badge.badge-new { background: rgba(123,111,232,0.92); color: white; } */
/* .promo-card-badge.badge-bestseller { background: rgba(255,200,50,0.95); color: #5A3A00; } */
.promo-card-badge.badge-cert { background: rgba(247, 151, 30, 0.95); color: white; }

.promo-card-body { padding: 14px 14px 16px; }
.promo-card-category {
    font-size: 9px;
    color: var(--purple);
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 6px;
}
.promo-card-title {
    font-family: var(--font-serif);
    font-size: 14px;
    line-height: 1.3;
    margin-bottom: 5px;
    color: var(--text);
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    letter-spacing: -0.01em;
}
.promo-card-instructor {
    font-size: 10px;
    color: var(--text-soft);
    margin-bottom: 10px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.promo-card-meta {
    display: flex;
    gap: 8px;
    font-size: 10px;
    color: var(--muted);
    margin-bottom: 12px;
    padding-bottom: 12px;
    border-bottom: 1px solid rgba(0,0,0,0.06);
}
.promo-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.promo-card-price {
    font-family: var(--font-serif);
    font-size: 15px;
    font-weight: 400;
    color: var(--text);
    letter-spacing: -0.01em;
}
.promo-price-free {
    color: var(--purple);
    font-weight: 600;
    font-style: italic;
}
.promo-card-arrow {
    font-size: 16px;
    color: var(--purple);
    transition: transform 0.3s;
    opacity: 0.6;
}
.promo-course-card:hover .promo-card-arrow {
    transform: translateX(4px);
    opacity: 1;
}

/* Dots */
.promo-dots {
    position: absolute;
    bottom: 18px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 8px;
    z-index: 10;
}
.promo-dot-btn {
    width: 9px; height: 9px;
    border-radius: 50%;
    border: 2px solid rgba(255,255,255,0.45);
    background: transparent;
    cursor: pointer;
    transition: all 0.3s;
    padding: 0;
}
.promo-dot-btn.active { background: white; border-color: white; width: 26px; border-radius: 100px; }

/* Arrows */
.promo-arrow {
    position: absolute;
    top: 50%; transform: translateY(-50%);
    background: rgba(255,255,255,0.1);
    border: 1.5px solid rgba(255,255,255,0.2);
    color: white;
    width: 40px; height: 40px;
    border-radius: 50%;
    font-size: 15px;
    cursor: pointer;
    z-index: 10;
    transition: all 0.2s;
    backdrop-filter: blur(10px);
    display: flex; align-items: center; justify-content: center;
    padding: 0;
    font-weight: bold;
}
.promo-arrow:hover { background: rgba(255,255,255,0.22); transform: translateY(-50%) scale(1.05); }
.promo-arrow-left { left: 20px; }
.promo-arrow-right { right: 20px; }

/* Promo banner status indicator */
.promo-status-toggle {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: var(--purple);
    color: white;
    border: none;
    padding: 10px 16px;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    z-index: 999;
    transition: all 0.2s;
    display: none;
}
.promo-status-toggle:hover {
    background: var(--purple-dark);
    transform: translateY(-2px);
}
.promo-status-toggle.show {
    display: inline-block;
}

/* Close */
.promo-close {
    position: absolute;
    top: 14px; right: 14px;
    background: rgba(255,255,255,0.1);
    border: none;
    color: rgba(255,255,255,0.65);
    width: 30px; height: 30px;
    border-radius: 50%;
    font-size: 17px;
    cursor: pointer;
    z-index: 20;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.2s;
    line-height: 1;
}
.promo-close:hover { background: rgba(255,255,255,0.22); color: white; }

@media (max-width: 768px) {
    .promo-bar { height: auto; }
    .promo-slide-content { grid-template-columns: 1fr; padding: 36px 20px 56px; gap: 20px; }
    .promo-slide-right { justify-content: center; }
    .promo-course-card { width: 160px; }
    .promo-card-thumb { aspect-ratio: 16/10; }
    .promo-card-body { padding: 10px 10px 12px; }
    .promo-card-title { font-size: 12px; }
    .promo-card-meta { gap: 6px; font-size: 9px; margin-bottom: 8px; padding-bottom: 8px; }
    .promo-card-price { font-size: 13px; }
    .promo-arrow-right { right: 20px; }
}
</style>
@endpush

@section('content')

{{-- ── PROMO BANNER SLIDER ─────────────────────────────── --}}
@php
    $displayCourses = [];
    $fallbacks = [
        [
            'slug' => '#',
            'title' => 'Fullstack Laravel & React',
            'thumbnail_url' => null,
            'category' => 'Technology',
            'instructor' => 'Coursify Team',
            'rating' => '4.9',
            'students' => '1.5K',
            'duration' => '40 jam',
            'price' => 'Rp 299.000',
            'is_free' => false,
            'badge' => 'Bestseller',
            'badge_type' => 'bestseller',
            'icon' => '💻'
        ],
        [
            'slug' => '#',
            'title' => 'Python for Data Science',
            'thumbnail_url' => null,
            'category' => 'Data Science',
            'instructor' => 'Coursify Team',
            'rating' => '4.9',
            'students' => '2.3K',
            'duration' => '20 jam',
            'price' => 'Free',
            'is_free' => true,
            'badge' => 'Sertifikat',
            'badge_type' => 'cert',
            'icon' => '📊'
        ],
        [
            'slug' => '#',
            'title' => 'UI/UX Design Fundamentals',
            'thumbnail_url' => null,
            'category' => 'Design',
            'instructor' => 'Sari Dewi · UX Lead',
            'rating' => '4.8',
            'students' => '980',
            'duration' => '25 jam',
            'price' => 'Rp 199.000',
            'is_free' => false,
            'badge' => 'Baru',
            'badge_type' => 'new',
            'icon' => '🎨'
        ],
        [
            'slug' => '#',
            'title' => 'Startup dari Nol',
            'thumbnail_url' => null,
            'category' => 'Business',
            'instructor' => 'Budi Hartono · Founder',
            'rating' => '4.8',
            'students' => '3.1K',
            'duration' => '18 jam',
            'price' => 'Free',
            'is_free' => true,
            'badge' => 'Gratis',
            'badge_type' => 'free',
            'icon' => '🚀'
        ],
        [
            'slug' => '#',
            'title' => 'Digital Marketing Mastery',
            'thumbnail_url' => null,
            'category' => 'Marketing',
            'instructor' => 'Maya Putri · CMO',
            'rating' => '4.7',
            'students' => '1.2K',
            'duration' => '30 jam',
            'price' => 'Rp 249.000',
            'is_free' => false,
            'badge' => 'Sertifikat Pro',
            'badge_type' => 'cert',
            'icon' => '📈'
        ],
        [
            'slug' => '#',
            'title' => 'Productivity Mastery',
            'thumbnail_url' => null,
            'category' => 'Self Dev',
            'instructor' => 'Linda Sari · Coach',
            'rating' => '4.9',
            'students' => '850',
            'duration' => '8 jam',
            'price' => 'Rp 149.000',
            'is_free' => false,
            'badge' => 'Bestseller',
            'badge_type' => 'bestseller',
            'icon' => '✏️'
        ]
    ];

    for ($i = 0; $i < 6; $i++) {
        if (isset($promoCourses[$i])) {
            $courseData = $promoCourses[$i];
            // Format duration
            $dur = $courseData['duration'];
            if (str_contains($dur, 'w')) {
                $weeks = intval(filter_var($dur, FILTER_SANITIZE_NUMBER_INT));
                $dur = ($weeks * 6) . ' jam';
            }
            $displayCourses[$i] = [
                'slug' => route('courses.show', $courseData['slug']),
                'title' => $courseData['title'],
                'thumbnail_url' => $courseData['thumbnail_url'],
                'category' => $courseData['category'],
                'instructor' => $courseData['instructor'],
                'rating' => $courseData['rating'],
                'students' => $courseData['students'],
                'duration' => $dur,
                'price' => $courseData['price'],
                'is_free' => $courseData['is_free'],
                'badge' => $courseData['is_free'] ? 'Gratis' : (($i % 3 === 0) ? 'Bestseller' : (($i % 3 === 1) ? 'Baru' : 'Sertifikat')),
                'badge_type' => $courseData['is_free'] ? 'free' : (($i % 3 === 0) ? 'bestseller' : (($i % 3 === 1) ? 'new' : 'cert')),
                'icon' => null
            ];
        } else {
            $displayCourses[$i] = $fallbacks[$i];
        }
    }
@endphp

<div id="promo-bar" class="promo-bar">
    <div class="promo-slides">

        {{-- Slide 1 --}}
        <div class="promo-slide active">
            <div class="promo-slide-bg" style="background:linear-gradient(135deg,#0f0c29,#302b63,#24243e);"></div>
            <div class="promo-slide-content">
                <div class="promo-slide-left">
                    <span class="promo-eyebrow">Penawaran Terbatas</span>
                    <h2 class="promo-slide-title">Hemat <em>30%</em> untuk semua kursus premium</h2>
                    <p class="promo-slide-desc">Gunakan kode <span class="promo-code">BELAJAR30</span> saat checkout. Berlaku hingga 31 Mei.</p>
                    <div class="promo-slide-actions">
                        <a href="{{ route('courses.index') }}" class="promo-btn-primary">Lihat Kursus →</a>
                        <a href="{{ route('courses.index') }}" class="promo-btn-outline">Jelajahi Kursus</a>
                    </div>
                </div>
                <div class="promo-slide-right">
                    @php
                        $c1 = $displayCourses[0];
                        $c2 = $displayCourses[1];
                    @endphp
                    <a href="{{ $c1['slug'] }}" class="hero-course-card" style="text-decoration:none;">
                        <div class="hero-card__thumb">
                            @if(!empty($c1['thumbnail_url']))
                                <img src="{{ $c1['thumbnail_url'] }}" alt="{{ $c1['title'] }}" style="width:100%;height:100%;object-fit:cover;display:block;">
                            @else
                                <div style="width:100%;height:100%;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;">
                                    <span style="font-size:28px;color:rgba(255,255,255,0.5);">{{ $c1['icon'] ?? '🎓' }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="hero-card__body">
                            @if(!empty($c1['category']))
                                <p class="hero-card__category">{{ strtoupper($c1['category']) }}</p>
                            @endif
                            <h4 class="hero-card__title">{{ $c1['title'] }}</h4>
                            @if(!empty($c1['instructor']))
                                <p class="hero-card__instructor">{{ $c1['instructor'] }}</p>
                            @endif
                            <div class="hero-card__meta">
                                @if(!empty($c1['rating']))
                                    <span><i class="fa-solid fa-star" style="color:#f59e0b;"></i> {{ $c1['rating'] }}</span>
                                @endif
                                @if(!empty($c1['duration']))
                                    <span><i class="fa-regular fa-clock"></i> {{ $c1['duration'] }}</span>
                                @endif
                            </div>
                        </div>
                    </a>

                    <a href="{{ $c2['slug'] }}" class="hero-course-card promo-card-offset" style="text-decoration:none;">
                        <div class="hero-card__thumb">
                            @if(!empty($c2['thumbnail_url']))
                                <img src="{{ $c2['thumbnail_url'] }}" alt="{{ $c2['title'] }}" style="width:100%;height:100%;object-fit:cover;display:block;">
                            @else
                                <div style="width:100%;height:100%;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;">
                                    <span style="font-size:28px;color:rgba(255,255,255,0.5);">{{ $c2['icon'] ?? '🎓' }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="hero-card__body">
                            @if(!empty($c2['category']))
                                <p class="hero-card__category">{{ strtoupper($c2['category']) }}</p>
                            @endif
                            <h4 class="hero-card__title">{{ $c2['title'] }}</h4>
                            @if(!empty($c2['instructor']))
                                <p class="hero-card__instructor">{{ $c2['instructor'] }}</p>
                            @endif
                            <div class="hero-card__meta">
                                @if(!empty($c2['rating']))
                                    <span><i class="fa-solid fa-star" style="color:#f59e0b;"></i> {{ $c2['rating'] }}</span>
                                @endif
                                @if(!empty($c2['duration']))
                                    <span><i class="fa-regular fa-clock"></i> {{ $c2['duration'] }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        {{-- Slide 2 --}}
        <div class="promo-slide">
            <div class="promo-slide-bg" style="background:linear-gradient(135deg,#1a1a2e,#16213e,#0f3460);"></div>
            <div class="promo-slide-content">
                <div class="promo-slide-left">
                    <span class="promo-eyebrow">Instruktur Baru</span>
                    <h2 class="promo-slide-title">Belajar langsung dari <em>para ahli industri</em></h2>
                    <p class="promo-slide-desc">Bergabung dengan 50.000+ pelajar yang sudah mengubah karir bersama Coursify.</p>
                    <div class="promo-slide-actions">
                        <a href="{{ route('register') }}" class="promo-btn-primary">Mulai Gratis →</a>
                        <a href="#instructors" class="promo-btn-outline">Lihat Instruktur</a>
                    </div>
                </div>
                <div class="promo-slide-right">
                    @php
                        $c3 = $displayCourses[2];
                        $c4 = $displayCourses[3];
                    @endphp
                    <a href="{{ $c3['slug'] }}" class="hero-course-card" style="text-decoration:none;">
                        <div class="hero-card__thumb">
                            @if(!empty($c3['thumbnail_url']))
                                <img src="{{ $c3['thumbnail_url'] }}" alt="{{ $c3['title'] }}" style="width:100%;height:100%;object-fit:cover;display:block;">
                            @else
                                <div style="width:100%;height:100%;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;">
                                    <span style="font-size:28px;color:rgba(255,255,255,0.5);">{{ $c3['icon'] ?? '🎓' }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="hero-card__body">
                            @if(!empty($c3['category']))
                                <p class="hero-card__category">{{ strtoupper($c3['category']) }}</p>
                            @endif
                            <h4 class="hero-card__title">{{ $c3['title'] }}</h4>
                            @if(!empty($c3['instructor']))
                                <p class="hero-card__instructor">{{ $c3['instructor'] }}</p>
                            @endif
                            <div class="hero-card__meta">
                                @if(!empty($c3['rating']))
                                    <span><i class="fa-solid fa-star" style="color:#f59e0b;"></i> {{ $c3['rating'] }}</span>
                                @endif
                                @if(!empty($c3['duration']))
                                    <span><i class="fa-regular fa-clock"></i> {{ $c3['duration'] }}</span>
                                @endif
                            </div>
                        </div>
                    </a>

                    <a href="{{ $c4['slug'] }}" class="hero-course-card promo-card-offset" style="text-decoration:none;">
                        <div class="hero-card__thumb">
                            @if(!empty($c4['thumbnail_url']))
                                <img src="{{ $c4['thumbnail_url'] }}" alt="{{ $c4['title'] }}" style="width:100%;height:100%;object-fit:cover;display:block;">
                            @else
                                <div style="width:100%;height:100%;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;">
                                    <span style="font-size:28px;color:rgba(255,255,255,0.5);">{{ $c4['icon'] ?? '🎓' }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="hero-card__body">
                            @if(!empty($c4['category']))
                                <p class="hero-card__category">{{ strtoupper($c4['category']) }}</p>
                            @endif
                            <h4 class="hero-card__title">{{ $c4['title'] }}</h4>
                            @if(!empty($c4['instructor']))
                                <p class="hero-card__instructor">{{ $c4['instructor'] }}</p>
                            @endif
                            <div class="hero-card__meta">
                                @if(!empty($c4['rating']))
                                    <span><i class="fa-solid fa-star" style="color:#f59e0b;"></i> {{ $c4['rating'] }}</span>
                                @endif
                                @if(!empty($c4['duration']))
                                    <span><i class="fa-regular fa-clock"></i> {{ $c4['duration'] }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        {{-- Slide 3 --}}
        <div class="promo-slide">
            <div class="promo-slide-bg" style="background:linear-gradient(135deg,#141e30,#243b55);"></div>
            <div class="promo-slide-content">
                <div class="promo-slide-left">
                    <span class="promo-eyebrow">Sertifikasi Resmi</span>
                    <h2 class="promo-slide-title">Raih sertifikat <em>diakui industri</em></h2>
                    <p class="promo-slide-desc">Sertifikat Coursify bisa langsung dibagikan ke LinkedIn dan diverifikasi perusahaan manapun.</p>
                    <div class="promo-slide-actions">
                        <a href="{{ route('courses.index') }}" class="promo-btn-primary">Mulai Belajar →</a>
                        <a href="{{ route('courses.index') }}" class="promo-btn-outline">Jelajahi Kursus</a>
                    </div>
                </div>
                <div class="promo-slide-right">
                    @php
                        $c5 = $displayCourses[4];
                        $c6 = $displayCourses[5];
                    @endphp
                    <a href="{{ $c5['slug'] }}" class="hero-course-card" style="text-decoration:none;">
                        <div class="hero-card__thumb">
                            @if(!empty($c5['thumbnail_url']))
                                <img src="{{ $c5['thumbnail_url'] }}" alt="{{ $c5['title'] }}" style="width:100%;height:100%;object-fit:cover;display:block;">
                            @else
                                <div style="width:100%;height:100%;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;">
                                    <span style="font-size:28px;color:rgba(255,255,255,0.5);">{{ $c5['icon'] ?? '🎓' }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="hero-card__body">
                            @if(!empty($c5['category']))
                                <p class="hero-card__category">{{ strtoupper($c5['category']) }}</p>
                            @endif
                            <h4 class="hero-card__title">{{ $c5['title'] }}</h4>
                            @if(!empty($c5['instructor']))
                                <p class="hero-card__instructor">{{ $c5['instructor'] }}</p>
                            @endif
                            <div class="hero-card__meta">
                                @if(!empty($c5['rating']))
                                    <span><i class="fa-solid fa-star" style="color:#f59e0b;"></i> {{ $c5['rating'] }}</span>
                                @endif
                                @if(!empty($c5['duration']))
                                    <span><i class="fa-regular fa-clock"></i> {{ $c5['duration'] }}</span>
                                @endif
                            </div>
                        </div>
                    </a>

                    <a href="{{ $c6['slug'] }}" class="hero-course-card promo-card-offset" style="text-decoration:none;">
                        <div class="hero-card__thumb">
                            @if(!empty($c6['thumbnail_url']))
                                <img src="{{ $c6['thumbnail_url'] }}" alt="{{ $c6['title'] }}" style="width:100%;height:100%;object-fit:cover;display:block;">
                            @else
                                <div style="width:100%;height:100%;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;">
                                    <span style="font-size:28px;color:rgba(255,255,255,0.5);">{{ $c6['icon'] ?? '🎓' }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="hero-card__body">
                            @if(!empty($c6['category']))
                                <p class="hero-card__category">{{ strtoupper($c6['category']) }}</p>
                            @endif
                            <h4 class="hero-card__title">{{ $c6['title'] }}</h4>
                            @if(!empty($c6['instructor']))
                                <p class="hero-card__instructor">{{ $c6['instructor'] }}</p>
                            @endif
                            <div class="hero-card__meta">
                                @if(!empty($c6['rating']))
                                    <span><i class="fa-solid fa-star" style="color:#f59e0b;"></i> {{ $c6['rating'] }}</span>
                                @endif
                                @if(!empty($c6['duration']))
                                    <span><i class="fa-regular fa-clock"></i> {{ $c6['duration'] }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- Dots --}}
    <div class="promo-dots">
        <button class="promo-dot-btn active" onclick="goToSlide(0)" aria-label="Slide 1"></button>
        <button class="promo-dot-btn" onclick="goToSlide(1)" aria-label="Slide 2"></button>
        <button class="promo-dot-btn" onclick="goToSlide(2)" aria-label="Slide 3"></button>
    </div>

    {{-- Arrows --}}
    <button class="promo-arrow promo-arrow-left" onclick="prevSlide()" aria-label="Sebelumnya">&#8592;</button>
    <button class="promo-arrow promo-arrow-right" onclick="nextSlide()" aria-label="Berikutnya">&#8594;</button>

    {{-- Close --}}
    <button class="promo-close" onclick="closePromoBanner()" aria-label="Tutup">×</button>
</div>

{{-- Tombol untuk membuka banner kembali --}}
<button id="promo-status-toggle" class="promo-status-toggle" onclick="togglePromoBanner('show')">
    ✓ Tampilkan Promo
</button>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- HERO                                                 --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="hero">
    <div class="hero-container">
        <div class="hero-content">
            <h1 class="hero-title select-none">
                <span class="hero-title-static">Learn</span>
                <span class="hero-title-dynamic-container">
                    <span class="hero-title-dynamic-word active">Anything,</span>
                    <span class="hero-title-dynamic-word">Anytime</span>
                    <span class="hero-title-dynamic-word">Anywhere</span>
                    <span class="hero-title-dynamic-word">Anyway</span>
                </span>
            </h1>
            <p class="hero-subtitle" style="margin-left: 0; margin-right: 0; max-width: 100%;">
                Master new skills with world-class instructors. Your personal learning journey starts here. free to begin, limitless to grow.
            </p>
            <div class="hero-cta" style="margin-left: 0; margin-right: 0; max-width: 100%; align-items: flex-start;">
                <form action="{{ route('courses.index') }}" method="GET" class="hero-selector-form" style="margin-left: 0;">
                    <div class="selector-container" style="background: rgba(255, 255, 255, 0.7);">
                        <div class="selector-group">
                            <label for="subject-select" class="selector-label">Subject</label>
                            <select name="category[]" id="subject-select" class="selector-dropdown">
                                <option value="">Select Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->slug }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="selector-divider"></div>
                        <div class="selector-group">
                            <label for="skill-select" class="selector-label">Skill</label>
                            <select name="search" id="skill-select" class="selector-dropdown">
                                <option value="">Select Skill</option>
                                @foreach($skills as $skill)
                                    <option value="{{ $skill }}">{{ $skill }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="selector-btn">
                            <span>Explore Courses</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="hero-visual">
            {{-- Phone Mockups --}}
            <div class="mockup-stage" style="margin: 0; transform: scale(0.95); transform-origin: center right;">
                {{-- Phone Left: Progress Tracker --}}
                <div class="phone phone-side phone-side-left">
                    <div class="phone-screen">
                        <div class="phone-status">9:41</div>
                        <div class="phone-label">Your Progress</div>
                        <div class="phone-card">
                            <div style="font-size:11px;font-weight:600;margin-bottom:4px;">Laravel Basics</div>
                            <div style="height:4px;background:#E8E1F3;border-radius:2px;margin-bottom:3px;">
                                <div style="height:100%;width:75%;background:var(--purple);border-radius:2px;"></div>
                            </div>
                            <div style="font-size:9px;color:var(--muted);">75% · 12/16 lessons</div>
                        </div>
                        <div class="phone-card">
                            <div style="font-size:11px;font-weight:600;margin-bottom:4px;">UI/UX Basics</div>
                            <div style="height:4px;background:#E8E1F3;border-radius:2px;margin-bottom:3px;">
                                <div style="height:100%;width:45%;background:var(--teal);border-radius:2px;"></div>
                            </div>
                            <div style="font-size:9px;color:var(--muted);">45% · 5/11 lessons</div>
                        </div>
                        <div class="phone-card">
                            <div style="font-size:11px;font-weight:600;margin-bottom:4px;">Python for Data</div>
                            <div style="height:4px;background:#E8E1F3;border-radius:2px;margin-bottom:3px;">
                                <div style="height:100%;width:90%;background:var(--orange);border-radius:2px;"></div>
                            </div>
                            <div style="font-size:9px;color:var(--muted);">90% · 18/20 lessons</div>
                        </div>
                    </div>
                </div>

                {{-- Phone Main: Instructor --}}
                <div class="phone phone-main">
                    <div class="phone-screen">
                        <div class="phone-status">9:41</div>
                        <div class="phone-label">Featured Instructor</div>
                        <div class="phone-card">
                            <div class="phone-avatar" style="border-radius:12px; overflow:hidden;">
                                <img src="{{ asset('images/landing.png') }}" alt="Andi" 
                                     style="width:100%;height:100%;object-fit:cover;object-position:top;border-radius:0;">
                            </div>
                            <div class="phone-name">Meet Andi</div>
                            <div style="font-size:10px;color:var(--muted);text-align:center;margin-top:2px;">Senior Developer · 12k students</div>
                            <div class="phone-skill-tags">
                                <span class="phone-skill-tag">Laravel</span>
                                <span class="phone-skill-tag">React</span>
                                <span class="phone-skill-tag">Node.js</span>
                            </div>
                        </div>
                        <div style="background:var(--purple);color:white;padding:8px 12px;border-radius:100px;font-size:11px;text-align:center;font-weight:600;">
                            Start Learning 
                        </div>
                    </div>
                </div>

                {{-- Phone Right: Video Lesson --}}
                <div class="phone phone-side phone-side-right">
                    <div class="phone-screen">
                        <div class="phone-status">9:41</div>
                        <div class="phone-label">Lesson 12</div>
                        <div class="phone-card">
                            <div style="aspect-ratio:16/10;background:linear-gradient(135deg,var(--navy),#2D4D7A);border-radius:8px;display:flex;align-items:center;justify-content:center;margin-bottom:6px;position:relative;">
                                <div style="width:30px;height:30px;background:white;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                    <span style="color:var(--navy);font-size:12px;">▶</span>
                                </div>
                            </div>
                            <div style="font-size:10px;font-weight:600;">Building Authentication</div>
                            <div style="font-size:9px;color:var(--muted);margin-top:2px;">⏱ 12:45 · Laravel Bootcamp</div>
                        </div>
                        <div class="phone-card" style="padding:8px;">
                            <div style="font-size:9px;color:var(--muted);margin-bottom:4px;">Up Next</div>
                            <div style="font-size:10px;font-weight:600;">Lesson 13: Middleware</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- STATS                                                --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="stats">
    <div class="container">
        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-value"><em>{{ $stats['students'] ?? '50K+' }}</em></div>
                <div class="stat-label">Active Learners</div>
            </div>
            <div class="stat-item">
                <div class="stat-value"><em>{{ $stats['courses'] ?? '500+' }}</em></div>
                <div class="stat-label">Courses</div>
            </div>
            <div class="stat-item">
                <div class="stat-value"><em>{{ $stats['instructors'] ?? '120+' }}</em></div>
                <div class="stat-label">Expert Instructors</div>
            </div>
            <div class="stat-item">
                <div class="stat-value"><em>{{ $stats['satisfaction'] ?? '98%' }}</em></div>
                <div class="stat-label">Satisfaction Rate</div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- TRUSTED PARTNERS                                     --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="section" id="partners">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">Trusted By</span>
            <h2 class="section-title">Top <em>Universities</em> &amp; Institutions</h2>
            <p class="section-subtitle">Trusted by learners from top universities &amp; institutions around the world.</p>
        </div>

        <div class="trust-marquee-wrapper">
            <div class="trust-marquee">
                @php $doubled = array_merge($partnerInstitutions, $partnerInstitutions); @endphp
                @foreach($doubled as $partner)
                    <a href="{{ route('universities.show', $partner['slug']) }}"
                       class="trust-partner-card"
                       title="{{ $partner['name'] }}">
                        <img src="{{ $partner['logo_url'] }}"
                             alt="{{ $partner['name'] }}"
                             class="trust-partner-logo"
                             loading="lazy"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                        <span class="trust-partner-fallback" style="display:none;">
                            {{ \Illuminate\Support\Str::limit($partner['name'], 20) }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- THE LATEST ON COURSIFY                               --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="section latest-section">
    <div class="container">
        <div class="latest-header">
            <div>
                <span class="latest-badge">NEW</span>
                <h2 class="latest-title">The latest on Coursify</h2>
            </div>
            <p class="latest-subtitle">Explore our newest offerings.</p>
        </div>

        <div class="latest-slider-wrapper">
            <button class="latest-nav prev" onclick="scrollLatest(-1)" aria-label="Previous">&#10094;</button>
            <div class="latest-slider" id="latestSlider">
                @foreach($latestCourses as $course)
                <a href="{{ route('courses.show', $course['slug']) }}" class="latest-card">
                    <div class="latest-card-header">
                        <span>Course</span>
                        {{-- <span class="latest-card-badge">NEW</span> --}}
                    </div>
                    <div class="latest-card-thumb">
                        <img src="{{ $course['thumbnail_url'] ?: 'https://placehold.co/600x400/153759/FFFFFF?text=Course' }}" alt="{{ $course['title'] }}">
                        <div class="latest-card-logo">
                            @if($course['institution_logo'])
                                <img src="{{ $course['institution_logo'] }}" alt="Logo">
                            @else
                                <span style="font-weight:bold;font-size:11px;color:#333;">{{ \Illuminate\Support\Str::limit($course['institution'], 10) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="latest-card-body">
                        <h3 class="latest-card-title">{{ $course['title'] }}</h3>
                        <p class="latest-card-inst">{{ $course['institution'] }}</p>
                        
                        <div class="latest-card-meta">
                            <div><i class="fa-regular fa-clock"></i> {{ $course['duration'] }}</div>
                            <div><i class="fa-solid fa-signal"></i> {{ $course['level'] }}</div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            <button class="latest-nav next" onclick="scrollLatest(1)" aria-label="Next">&#10095;</button>
        </div>
        
        <div class="latest-dots" id="latestDots">
            @php $pages = ceil(count($latestCourses) / 3); @endphp
            @for($i = 0; $i < $pages; $i++)
                <button class="latest-dot {{ $i === 0 ? 'active' : '' }}" onclick="scrollToLatestPage({{ $i }})" aria-label="Go to page {{ $i+1 }}"></button>
            @endfor
        </div>

        <div style="text-align: center; margin-top: 40px;">
            <a href="{{ route('courses.index', ['sort' => 'newest']) }}" class="latest-btn-browse">Browse additional courses</a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- FEATURED COURSES                                     --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="section" id="courses">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow"></span>
            <h2 class="section-title">Most Popular <em>Courses</em></h2>
            <p class="section-subtitle">Join thousands of learners mastering these in-demand skills.</p>
        </div>

        <div class="courses-grid">
            @php
                $defaultCourses = [
                    ['icon' => '💻', 'title' => 'Fullstack Web Development with Laravel', 'category' => 'Programming', 'instructor' => 'Andi Saputra · Senior Dev @ Gojek', 'rating' => '4.9', 'students' => '12.3k', 'duration' => '40h', 'price' => 'Rp 299k', 'badge' => 'bestseller', 'thumb' => 1],
                    ['icon' => '🎨', 'title' => 'UI/UX Design Fundamentals for Beginners', 'category' => 'Design', 'instructor' => 'Sari Dewi · UX Lead @ Traveloka', 'rating' => '4.8', 'students' => '8.1k', 'duration' => '25h', 'price' => 'Rp 199k', 'badge' => 'new', 'thumb' => 2],
                    ['icon' => '📊', 'title' => 'Introduction to Python for Data Analysis', 'category' => 'Data Science', 'instructor' => 'Rio Ahmad · Data Sci @ Shopee', 'rating' => '4.9', 'students' => '15.7k', 'duration' => '20h', 'price' => 'Free', 'badge' => 'free', 'thumb' => 3],
                    ['icon' => '📈', 'title' => 'Digital Marketing Mastery 2025', 'category' => 'Marketing', 'instructor' => 'Maya Putri · CMO @ Tokopedia', 'rating' => '4.7', 'students' => '9.8k', 'duration' => '30h', 'price' => 'Rp 249k', 'badge' => 'bestseller', 'thumb' => 4],
                    ['icon' => '🚀', 'title' => 'Startup Fundamentals: From Idea to Launch', 'category' => 'Business', 'instructor' => 'Budi Hartono · Founder @ Techstars', 'rating' => '4.8', 'students' => '5.2k', 'duration' => '18h', 'price' => 'Rp 349k', 'badge' => 'new', 'thumb' => 5],
                    ['icon' => '✏️', 'title' => 'Master Your Time: Productivity for Beginners', 'category' => 'Productivity', 'instructor' => 'Linda Sari · Coach @ YCombinator', 'rating' => '4.9', 'students' => '22k', 'duration' => '8h', 'price' => 'Free', 'badge' => 'free', 'thumb' => 6],
                ];
                $coursesData = $featuredCourses ?? $defaultCourses;
            @endphp

            @foreach($coursesData as $course)
                <a href="{{ isset($course['slug']) ? route('courses.show', $course['slug']) : route('courses.index') }}" 
                   class="course-card" 
                   style="display:block; text-decoration:none;">
                    
                    {{-- THUMBNAIL --}}
                    <div class="course-card__thumb" style="position:relative; aspect-ratio:16/9; overflow:hidden; border-radius:12px 12px 0 0; background:#1a1a2e;">
                        @if(!empty($course['thumbnail_url']))
                            <img src="{{ $course['thumbnail_url'] }}" 
                                 alt="{{ $course['title'] }}"
                                 style="width:100%;height:100%;object-fit:cover;display:block;">
                        @else
                            <div style="width:100%;height:100%;background:linear-gradient(135deg,#1e3a5f,#2d4d7a);display:flex;align-items:center;justify-content:center;">
                                {!! $course['icon'] ?? '<i class="fa-solid fa-graduation-cap" style="font-size:40px;color:rgba(255,255,255,0.3);"></i>' !!}
                            </div>
                        @endif

                        {{-- Badge dihilangkan sesuai permintaan --}}
                        {{-- 
                        @if(!empty($course['badge']))
                            <span style="position:absolute;top:10px;left:10px;background:#f59e0b;color:#fff;font-size:10px;font-weight:800;letter-spacing:0.08em;text-transform:uppercase;padding:3px 8px;border-radius:4px;">
                                {{ $course['badge'] === 'bestseller' ? 'Bestseller' : ucfirst($course['badge']) }}
                            </span>
                        @endif
                        --}}
                    </div>

                    {{-- BODY --}}
                    <div class="course-card__body" style="padding:14px 16px 16px;">
                        
                        {{-- Category --}}
                        @if(!empty($course['category']))
                            <p style="font-size:10px;font-weight:700;letter-spacing:0.09em;text-transform:uppercase;color:var(--purple, #6366f1);margin:0 0 6px;">
                                {{ $course['category'] }}
                            </p>
                        @endif

                        {{-- Judul --}}
                        <h3 style="font-size:15px;font-weight:700;line-height:1.4;margin:0 0 6px;color:var(--text);
                                   display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                            {{ $course['title'] }}
                        </h3>

                        {{-- Instructor --}}
                        @if(!empty($course['instructor']))
                            <p style="font-size:12px;color:var(--muted);margin:0 0 10px;
                                      white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $course['instructor'] }}
                            </p>
                        @endif

                        {{-- Meta row --}}
                        <div style="display:flex;align-items:center;gap:10px;font-size:12px;color:var(--muted);flex-wrap:wrap;">
                            @if(!empty($course['rating']))
                                <span>
                                    <i class="fa-solid fa-star" style="color:#f59e0b;font-size:11px;"></i>
                                    {{ $course['rating'] }}
                                </span>
                            @endif
                            @if(!empty($course['students']))
                                <span>
                                    <i class="fa-solid fa-users" style="font-size:11px;"></i>
                                    {{ $course['students'] }}
                                </span>
                            @endif
                            @if(!empty($course['duration']))
                                <span>
                                    <i class="fa-regular fa-clock" style="font-size:11px;"></i>
                                    {{ $course['duration'] }}
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div style="text-align:center;margin-top:32px;">
            <a href="{{ route('courses.index') }}" class="btn btn-light">View All Courses </a>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════════ --}}
{{-- Tambahan CSS untuk sisa section                     --}}
{{-- ═══════════════════════════════════════════════════ --}}
@push('styles')
<style>
    /* ═══ HOW IT WORKS ═══ */
    .how-section { padding: 60px 20px; }
    .how-wrapper {
        background: rgba(255,255,255,0.5);
        backdrop-filter: blur(30px);
        border: 1px solid rgba(255,255,255,0.8);
        border-radius: 32px;
        padding: 60px 40px;
        box-shadow: 0 10px 40px rgba(30,58,95,0.05);
    }
    .how-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        max-width: 960px;
        margin: 0 auto;
    }
    .how-card {
        background: white;
        border: 1px solid rgba(123,111,232,0.08);
        border-radius: 20px;
        padding: 28px 22px 24px;
        text-align: center;
        transition: all 0.3s;
        box-shadow: 0 4px 16px rgba(30,58,95,0.04);
    }
    .how-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 32px rgba(30,58,95,0.1);
        border-color: var(--purple);
    }
    .how-number {
        font-family: var(--font-serif);
        font-size: 48px;
        font-weight: 400;
        line-height: 1;
        margin-bottom: 18px;
        color: var(--text);
    }
    .how-visual {
        aspect-ratio: 3/2;
        background: linear-gradient(135deg, var(--lav-1), var(--lav-2));
        border-radius: 14px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        gap: 4px;
    }
    .avatar-stack { display: flex; }
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 3px solid white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        margin-left: -10px;
        transition: transform 0.3s;
    }
    .avatar-circle:first-child { margin-left: 0; }
    .how-card:hover .avatar-circle:nth-child(1) { transform: translateX(-4px); }
    .how-card:hover .avatar-circle:nth-child(3) { transform: translateX(4px); }
    .wave-viz { display: flex; align-items: center; gap: 3px; }
    .wave-bar {
        width: 4px;
        background: var(--purple);
        border-radius: 100px;
        animation: waveBar 1.2s ease-in-out infinite;
    }
    @keyframes waveBar {
        0%, 100% { transform: scaleY(0.4); }
        50% { transform: scaleY(1); }
    }
    .cert-viz {
        width: 80px;
        height: 60px;
        background: linear-gradient(135deg, white, var(--lav-1));
        border-radius: 8px;
        border: 2px solid var(--purple);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .cert-viz::after { content: '🏆'; font-size: 28px; }
    .how-title {
        font-family: var(--font-serif);
        font-size: 22px;
        font-weight: 400;
        margin-bottom: 8px;
        letter-spacing: -0.01em;
    }
    .how-desc { font-size: 12px; color: var(--muted); line-height: 1.6; }

    /* ═══ WHY US ═══ */
    .why-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-auto-rows: 1fr;
        gap: 16px;
        max-width: 960px;
        margin: 0 auto;
        align-items: stretch;
    }
    .why-card {
        background: rgba(255,255,255,0.65);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.9);
        border-radius: 24px;
        padding: 28px;
        box-shadow: 0 4px 20px rgba(30,58,95,0.04);
        transition: all 0.3s;
        display: flex;             /* ← Tambah ini */
        flex-direction: column;    /* ← Tambah ini: arrange vertical */
        min-width: 0;              /* ← Tambah ini: prevent overflow */
        overflow: hidden;
    }
    .why-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(30,58,95,0.08);
    }
    .why-visual {
        aspect-ratio: 16/10;
        background: linear-gradient(135deg, var(--lav-1), white);
        border-radius: 16px;
        margin-bottom: 20px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        justify-content: center;
        flex-shrink: 0; /* ← Tambah ini: prevent shrinking */
        overflow: hidden; /* ← Tambah ini: hide overflow */
    }
    .chat-bubble {
        background: white;
        padding: 8px 12px;
        border-radius: 14px;
        font-size: 11px;
        max-width: 75%;
        color: var(--text-soft);
        box-shadow: 0 2px 6px rgba(30,58,95,0.05);
        line-height: 1.4;
    }
    .chat-bubble-right {
        margin-left: auto;
        background: var(--purple);
        color: white;
    }
    .why-visual-center {
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 8px;
    }
    .why-viz-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--navy);
        color: white;
        padding: 8px 16px;
        border-radius: 100px;
        font-size: 11px;
        font-weight: 600;
    }
    .why-viz-title { font-family: var(--font-serif); font-size: 26px; letter-spacing: -0.01em; }
    .why-tags-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        justify-content: center;
        padding: 20px;
        align-items: center;
    }
    .why-tag {
        background: white;
        padding: 6px 12px;
        border-radius: 100px;
        font-size: 11px;
        color: var(--text-soft);
        font-weight: 500;
        box-shadow: 0 2px 6px rgba(30,58,95,0.05);
        transition: all 0.2s;
    }
    .why-tag:hover {
        background: var(--purple);
        color: white;
        transform: translateY(-2px);
    }
    .why-cert-visual {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }
    .cert-card {
        width: 140px;
        background: white;
        border: 2px solid var(--purple);
        border-radius: 10px;
        padding: 12px;
        text-align: center;
        transform: rotate(-3deg);
        box-shadow: 0 8px 20px rgba(30,58,95,0.1);
    }
    .cert-card::before {
        content: '🏆';
        font-size: 28px;
        display: block;
        margin-bottom: 6px;
    }
    .why-title {
        font-family: var(--font-serif);
        font-size: 24px;
        font-weight: 400;
        margin-bottom: 8px;
        letter-spacing: -0.01em;
    }
    .why-desc { font-size: 13px; color: var(--muted); line-height: 1.6; }

    /* ═══ TRUST / PARTNER MARQUEE ═══ */
.trust-section {
    margin-bottom: 40px;
}
.trust-label {
    font-size: 11px;
    color: var(--muted);
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    text-align: center;
    margin-bottom: 16px;
    display: block;
}
.trust-marquee-wrapper {
    overflow: hidden;
    position: relative;
    /* fade kiri-kanan */
    mask-image: linear-gradient(to right, transparent 0%, black 8%, black 92%, transparent 100%);
    -webkit-mask-image: linear-gradient(to right, transparent 0%, black 8%, black 92%, transparent 100%);
}
.trust-marquee {
    display: flex;
    gap: 12px;
    width: max-content;
    animation: marqueeScroll 28s linear infinite;
}
.trust-marquee:hover {
    animation-play-state: paused;
}
@keyframes marqueeScroll {
    from { transform: translateX(0); }
    to   { transform: translateX(-50%); }
}
.trust-partner-card {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: rgba(255,255,255,0.75);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 14px;
    padding: 10px 18px;
    white-space: nowrap;
    box-shadow: 0 4px 14px rgba(30,58,95,0.06);
    transition: all 0.3s;
    cursor: default;
}
.trust-partner-card:hover {
    background: rgba(255,255,255,0.95);
    border-color: rgba(123,111,232,0.3);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(30,58,95,0.1);
}
.trust-partner-icon {
    font-size: 22px;
    line-height: 1;
}
.trust-partner-name {
    font-family: var(--font-serif);
    font-size: 14px;
    font-weight: 500;
    color: var(--text);
    letter-spacing: -0.01em;
}
.trust-partner-full {
    font-size: 10px;
    color: var(--muted);
    font-weight: 500;
}

    /* ═══ INSTRUCTORS ═══ */
    .instructor-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        max-width: 960px;
        margin: 0 auto;
    }
    .instructor-card {
        background: rgba(255,255,255,0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.9);
        border-radius: 20px;
        padding: 24px;
        text-align: center;
        transition: all 0.3s;
    }
    .instructor-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(30,58,95,0.08);
    }
    .instructor-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--navy), #2D4D7A);
        margin: 0 auto 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        border: 3px solid white;
        box-shadow: 0 4px 14px rgba(30,58,95,0.15);
    }
    .instructor-name { font-family: var(--font-serif); font-size: 20px; margin-bottom: 4px; }
    .instructor-title { font-size: 11px; color: var(--muted); margin-bottom: 12px; }
    .instructor-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        justify-content: center;
        margin-bottom: 14px;
    }
    .instructor-tag {
        background: rgba(123,111,232,0.1);
        color: var(--purple-dark);
        padding: 3px 10px;
        border-radius: 100px;
        font-size: 10px;
        font-weight: 600;
    }
    .instructor-stats {
        display: flex;
        gap: 12px;
        justify-content: center;
        font-size: 11px;
        color: var(--muted);
        padding-top: 14px;
        border-top: 1px solid rgba(0,0,0,0.08);
    }

    /* ═══ TESTIMONIALS ═══ */
    .testimonial-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        max-width: 1000px;
        margin: 0 auto;
    }
    .testimonial-card {
        background: rgba(255,255,255,0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.9);
        border-radius: 20px;
        padding: 24px;
        transition: all 0.3s;
    }
    .testimonial-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(30,58,95,0.08);
    }
    .testimonial-stars {
        color: #FFC452;
        font-size: 16px;
        margin-bottom: 12px;
        letter-spacing: 2px;
    }
    .testimonial-quote {
        font-family: var(--font-serif);
        font-size: 16px;
        line-height: 1.5;
        color: var(--text);
        margin-bottom: 20px;
        letter-spacing: -0.01em;
    }
    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .testimonial-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--navy), #2D4D7A);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .testimonial-name { font-size: 13px; font-weight: 600; }
    .testimonial-role { font-size: 11px; color: var(--muted); }



    /* ═══ CATEGORY SECTION ═══ */
    .category-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        max-width: 860px;
        margin: 0 auto;
    }
    .category-card {
        background: rgba(255,255,255,0.94);
        border: 1px solid rgba(30,58,95,0.08);
        border-radius: 16px;
        padding: 26px 18px;
        text-align: center;
        color: var(--text);
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        min-height: 192px;
    }
    .category-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 22px 50px rgba(30,58,95,0.09);
        border-color: rgba(123,111,232,0.18);
    }
    .category-icon {
        width: 72px;
        height: 72px;
        border-radius: 24px;
        background: rgba(123,111,232,0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--purple);
        font-size: 28px;
        flex-shrink: 0;
    }
    .category-name {
        font-family: var(--font-serif);
        font-size: 18px;
        font-weight: 700;
        letter-spacing: -0.02em;
        line-height: 1.25;
        color: var(--text);
    }
    .category-count {
        font-size: 12px;
        color: var(--muted);
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    /* ═══ FAQ ═══ */
    .faq-wrapper { max-width: 720px; margin: 0 auto; }
    .faq-item {
        background: rgba(255,255,255,0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.9);
        border-radius: 16px;
        margin-bottom: 10px;
        overflow: hidden;
        transition: all 0.3s;
    }
    .faq-item:hover { border-color: var(--purple); }
    .faq-question {
        width: 100%;
        background: transparent;
        border: none;
        padding: 18px 22px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-family: var(--font-sans);
        font-size: 15px;
        font-weight: 500;
        text-align: left;
        cursor: pointer;
        color: var(--text);
        transition: all 0.2s;
    }
    .faq-question:hover { color: var(--purple); }
    .faq-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: rgba(123,111,232,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--purple);
        font-size: 14px;
        flex-shrink: 0;
        transition: transform 0.3s;
    }
    .faq-item.active .faq-icon {
        transform: rotate(45deg);
        background: var(--purple);
        color: white;
    }
    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease, padding 0.4s ease;
    }
    .faq-answer-inner {
        padding: 0 22px 20px;
        font-size: 14px;
        color: var(--muted);
        line-height: 1.7;
    }
    .faq-item.active .faq-answer { max-height: 300px; }

    /* ═══ CTA ═══ */
    .cta {
        text-align: center;
        padding: 100px 20px 40px;
    }
    .cta-title {
        font-family: var(--font-serif);
        font-size: clamp(36px, 5vw, 52px);
        font-weight: 400;
        line-height: 1.15;
        letter-spacing: -0.02em;
        margin-bottom: 28px;
        max-width: 640px;
        margin-left: auto;
        margin-right: auto;
    }
    .cta-title em { font-style: italic; color: var(--purple); }

    @media (max-width: 768px) {
        .how-grid, .why-grid, .instructor-grid,
        .testimonial-grid, .category-grid { grid-template-columns: 1fr; }
        .how-wrapper { padding: 40px 24px; }
    }

    /* ═══ TRUST / PARTNER MARQUEE ═══ */
    .trust-section {
        margin-bottom: 40px;
    }
    .trust-label {
        font-size: 11px;
        color: var(--muted);
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        text-align: center;
        margin-bottom: 16px;
        display: block;
    }
    .trust-marquee-wrapper {
        overflow: hidden;
        position: relative;
        /* Fade kiri–kanan */
        mask-image: linear-gradient(to right, transparent 0%, black 8%, black 92%, transparent 100%);
        -webkit-mask-image: linear-gradient(to right, transparent 0%, black 8%, black 92%, transparent 100%);
    }
    .trust-marquee {
        display: flex;
        align-items: center;
        gap: 12px;
        width: max-content;
        animation: marqueeScroll 32s linear infinite;
    }
    .trust-marquee:hover {
        animation-play-state: paused;
    }
    @keyframes marqueeScroll {
        from { transform: translateX(0); }
        to   { transform: translateX(-50%); }
    }
    .trust-partner-card {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.80);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.9);
        border-radius: 14px;
        padding: 10px 20px;
        min-width: 140px;
        height: 64px;
        white-space: nowrap;
        box-shadow: 0 4px 14px rgba(30,58,95,0.06);
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
        flex-shrink: 0;
    }
    .trust-partner-card:hover {
        background: rgba(255,255,255,0.97);
        border-color: rgba(123,111,232,0.35);
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(30,58,95,0.12);
    }
    .trust-partner-logo {
        max-height: 38px;
        max-width: 120px;
        width: auto;
        height: auto;
        object-fit: contain;
        filter: grayscale(30%);
        transition: filter 0.3s;
    }
    .trust-partner-card:hover .trust-partner-logo {
        filter: grayscale(0%);
    }
    .trust-partner-fallback {
        font-family: var(--font-serif);
        font-style: italic;
        font-size: 14px;
        color: var(--text-soft);
        font-weight: 500;
    }
</style>
@endpush

{{-- ═══════════════════════════════════════════════════ --}}
{{-- HOW IT WORKS                                         --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="how-section" id="how">
    <div class="container">
        <div class="how-wrapper">
            <div class="section-header">
                <span class="section-eyebrow"></span>
                <h2 class="section-title">How It <em>Works</em></h2>
                <p class="section-subtitle">Three simple steps to start your learning journey today.</p>
            </div>

            <div class="how-grid">
                {{-- Card 1: Choose Your Path --}}
                <div class="how-card">
                    <div class="how-number">1</div>
                    <div class="how-visual" style="padding:0;overflow:hidden;">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=600&q=80"
                             alt="Choose your path"
                             style="width:100%;height:100%;object-fit:cover;border-radius:14px;">
                    </div>
                    <div class="how-title">Choose Your<br>Path</div>
                    <p class="how-desc">Browse 500+ courses across programming, design, business, and more. Find the skill that matches your goals.</p>
                </div>

                {{-- Card 2: Learn at Your Pace - gambar + animasi wave di atas --}}
                <div class="how-card">
                    <div class="how-number">2</div>
                    <div class="how-visual" style="padding:0;overflow:hidden;position:relative;">
                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&q=80"
                             alt="Learn at your pace"
                             style="width:100%;height:100%;object-fit:cover;border-radius:14px;">
                        {{-- Wave overlay --}}
                        <div style="position:absolute;inset:0;background:rgba(30,58,95,0.45);border-radius:14px;display:flex;align-items:center;justify-content:center;">
                            <div class="wave-viz">
                                <div class="wave-bar" style="height:12px;animation-delay:0s;background:white;"></div>
                                <div class="wave-bar" style="height:24px;animation-delay:0.1s;background:white;"></div>
                                <div class="wave-bar" style="height:36px;animation-delay:0.2s;background:white;"></div>
                                <div class="wave-bar" style="height:48px;animation-delay:0.3s;background:white;"></div>
                                <div class="wave-bar" style="height:36px;animation-delay:0.4s;background:white;"></div>
                                <div class="wave-bar" style="height:24px;animation-delay:0.5s;background:white;"></div>
                                <div class="wave-bar" style="height:12px;animation-delay:0.6s;background:white;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="how-title">Learn at<br>Your Pace</div>
                    <p class="how-desc">Watch video lessons, complete exercises, and get instant feedback. Study anytime from any device.</p>
                </div>

                {{-- Card 3: Earn Your Certificate --}}
                <div class="how-card">
                    <div class="how-number">3</div>
                    <div class="how-visual" style="padding:0;overflow:hidden;">
                        <img src="https://images.unsplash.com/photo-1523289333742-be1143f6b766?w=600&q=80"
                             alt="Earn your certificate"
                             style="width:100%;height:100%;object-fit:cover;border-radius:14px;">
                    </div>
                    <div class="how-title">Earn Your<br>Certificate</div>
                    <p class="how-desc">Complete the course and receive a verified certificate you can showcase on LinkedIn and your CV.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- WHY COURSIFY                                         --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow"></span>
            <h2 class="section-title">Why <em>Coursify</em>&nbsp;?</h2>
            <p class="section-subtitle">Everything you need to master new skills in one beautifully designed platform.</p>
        </div>

        <div class="why-grid">
            <div class="why-card">
                <div class="why-visual">
                    <div class="chat-bubble">Can you explain how Laravel middleware works?</div>
                    <div class="chat-bubble chat-bubble-right">Great question! Middleware acts as a filter for HTTP requests...</div>
                    <div class="chat-bubble">Oh I get it now, thank you!</div>
                </div>
                <div class="why-title">Expert Instructors</div>
                <p class="why-desc">Learn from industry professionals with real-world experience. All instructors are verified and rated by students.</p>
            </div>

            {{-- Card 2: Learn Anytime --}}
<div class="why-card">
    <div class="why-visual" style="padding:0;overflow:hidden;position:relative;">
        <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=800&q=80"
             alt="Learn Anytime"
             style="width:100%;height:100%;object-fit:cover;border-radius:16px;">
    </div>
    <div class="why-title">Learn Anytime</div>
    <p class="why-desc">No deadlines, no pressure. Watch lessons, pause, rewind — study whenever it fits your schedule.</p>
</div>

            {{-- Card 3: Verified Certificates --}}
<div class="why-card">
    <div class="why-visual" style="padding:0;overflow:hidden;position:relative;">
        <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=800&q=80"
             alt="Verified Certificates"
             style="width:100%;height:100%;object-fit:cover;border-radius:16px;">
    </div>
    <div class="why-title">Verified Certificates</div>
    <p class="why-desc">Earn official digital certificates upon completion. Shareable on LinkedIn and verifiable by employers worldwide.</p>
</div>

           {{-- Card 4: Vibrant Community --}}
<div class="why-card">
    <div class="why-visual" style="padding:0;overflow:hidden;position:relative;">
        <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=800&q=80"
             alt="Vibrant Community"
             style="width:100%;height:100%;object-fit:cover;border-radius:16px;">
    </div>
    <div class="why-title">Vibrant Community</div>
    <p class="why-desc">Join 50,000+ learners. Ask questions, share projects, and grow together with peers worldwide.</p>
</div>
    
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- INSTRUCTORS                                          --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">Meet Our Experts</span>
            <h2 class="section-title">Learn from the <em>Best</em></h2>
            <p class="section-subtitle">Our instructors are industry veterans from top Indonesian tech companies.</p>
        </div>

        <div class="instructor-grid">
            @php
    $defaultInstructors = [
    ['avatar' => 'https://ui-avatars.com/api/?name=Budi+Santoso&background=1E3A5F&color=fff&size=150&bold=true', 'name' => 'Budi Santoso', 'title' => 'Senior Dev @ Tokopedia', 'tags' => ['Laravel', 'React', 'AWS'], 'courses' => '45', 'students' => '120K'],
    ['avatar' => 'https://ui-avatars.com/api/?name=Sari+Dewi&background=7B6FE8&color=fff&size=150&bold=true', 'name' => 'Sari Dewi', 'title' => 'UX Lead @ Traveloka', 'tags' => ['UI/UX', 'Figma', 'Research'], 'courses' => '12', 'students' => '38K'],
    ['avatar' => 'https://ui-avatars.com/api/?name=Rio+Ahmad&background=00C896&color=fff&size=150&bold=true', 'name' => 'Rio Ahmad', 'title' => 'Data Scientist @ Shopee', 'tags' => ['Python', 'ML', 'Analytics'], 'courses' => '28', 'students' => '67K'],
];
    $instructorsData = $instructors ?? $defaultInstructors;
@endphp

            @foreach($instructorsData as $inst)
                <div class="instructor-card">
                   <div class="instructor-avatar" style="overflow:hidden;padding:0;">
    <img src="https://ui-avatars.com/api/?name={{ urlencode($inst['name']) }}&background=1E3A5F&color=fff&size=150&bold=true"
         style="width:100%;height:100%;object-fit:cover;">
</div>
                    <div class="instructor-name">{{ $inst['name'] }}</div>
                    <div class="instructor-title">{{ $inst['title'] }}</div>
                    <div class="instructor-tags">
                        @foreach($inst['tags'] as $tag)
                            <span class="instructor-tag">{{ $tag }}</span>
                        @endforeach
                    </div>
                    <div class="instructor-stats">
    <span><i class="fa-solid fa-book"></i> {{ $inst['courses'] }} courses</span>
    <span><i class="fa-solid fa-users"></i> {{ $inst['students'] }} students</span>
</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- TESTIMONIALS                                         --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">Student Stories</span>
            <h2 class="section-title">Loved by <em>Learners</em></h2>
            <p class="section-subtitle">Real stories from people who transformed their careers with Coursify.</p>
        </div>

        <div class="testimonial-grid">
            <div class="testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-quote">"Coursify helped me transition from marketing to frontend development in 6 months. The certificates were a game-changer for my CV!"</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">
                        <img src="https://i.pravatar.cc/150?img=11" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                    </div>
                    <div>
                        <div class="testimonial-name">Andi Pratama</div>
                        <div class="testimonial-role">Frontend Dev @ Gojek</div>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-quote">"The instructors are world-class. I learned more in 3 months on Coursify than a year of college. Highly recommended!"</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">
                        <img src="https://i.pravatar.cc/150?img=45" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                    </div>
                    <div>
                        <div class="testimonial-name">Putri Rahma</div>
                        <div class="testimonial-role">Data Analyst @ Shopee</div>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-quote">"Love the flexibility. I can study during my commute, at night, anytime. Finally platform that respects my schedule."</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">
                        <img src="https://i.pravatar.cc/150?img=15" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                    </div>
                    <div>
                        <div class="testimonial-name">Dimas Wijaya</div>
                        <div class="testimonial-role">Product Manager</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



{{-- ═══════════════════════════════════════════════════ --}}
{{-- EXPLORE BY CATEGORY                                  --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">Top Categories</span>
            <h2 class="section-title">Explore by <em>Category</em></h2>
            <p class="section-subtitle">Jump directly into the category that fits your interests and browse matching courses.</p>
        </div>

        <div class="category-grid">
            @foreach($categories as $category)
                <a href="{{ route('courses.index', ['category' => $category['slug']]) }}" class="category-card">
                    <div class="category-icon">{!! $category['icon'] !!}</div>
                    <div class="category-name">{{ $category['name'] }}</div>
                    <div class="category-count">{{ $category['count'] }} course{{ $category['count'] !== 1 ? 's' : '' }}</div>
                </a>
            @endforeach
        </div>

        <div style="text-align: center; margin-top: 32px;">
            <a href="{{ route('courses.index') }}" class="btn btn-light">Browse all topics</a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- FAQ                                                  --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">FAQ</span>
            <h2 class="section-title">Frequently Asked<br><em>Questions</em></h2>
            <p class="section-subtitle">Can't find what you're looking for? Reach out to our support team.</p>
        </div>

        <div class="faq-wrapper" x-data="{ openFaq: null }">
            @php
                $faqs = [
                    ['q' => 'Are the certificates recognized by employers?', 'a' => 'Yes! Our certificates are issued by Coursify and our partner institutions. They include unique verification IDs that employers can verify online. Many of our alumni have landed jobs at top companies like Gojek, Tokopedia, and Shopee using these certificates.'],
                    ['q' => 'Can I access courses offline?', 'a' => 'Pro and Business plan subscribers can download lessons to our mobile app for offline viewing. This is perfect for learning during commutes or when you don\'t have internet access.'],
                    ['q' => 'What if I\'m not satisfied?', 'a' => 'We offer a 30-day money-back guarantee on all Pro subscriptions. If you\'re not happy for any reason, contact our support team for a full refund — no questions asked.'],
                    ['q' => 'Do you offer corporate packages?', 'a' => 'Absolutely. Our Business plan is designed for teams of up to 25 people. For larger enterprises, we offer custom packages with dedicated account managers, custom learning paths, and detailed analytics.'],
                    ['q' => 'Can I become an instructor?', 'a' => 'Yes! We\'re always looking for talented instructors. You need at least 3 years of industry experience and a portfolio of work. Apply through our instructor portal and our team will review your application within 7 days.'],
                ];
            @endphp

            @foreach($faqs as $index => $faq)
                <div class="faq-item" :class="{ 'active': openFaq === {{ $index }} }">
                    <button class="faq-question" @click="openFaq = openFaq === {{ $index }} ? null : {{ $index }}">
                        <span>{{ $faq['q'] }}</span>
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">{{ $faq['a'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- CTA BIG                                              --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="cta">
    <div class="container">
        <h2 class="cta-title">Everyone deserves to learn <br><em>anytime, anywhere.</em></h2>
        <div class="hero-cta">
            @guest
                <a href="{{ route('register') }}" class="btn btn-dark">Start Learning Free</a>
                <a href="{{ route('courses.index') }}" class="btn btn-light">▶ Browse Courses</a>
            @else
                <a href="{{ route('courses.index') }}" class="btn btn-dark">Explore Courses →</a>
            @endguest
        </div>
    </div>
</section>

@endsection

{{-- ═══════════════════════════════════════════════════ --}}
{{-- JAVASCRIPT                                           --}}
{{-- ═══════════════════════════════════════════════════ --}}
@push('scripts')
<script>
    // Scroll reveal animation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.section, .how-section, .stats').forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(20px)';
        section.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        observer.observe(section);
    });

    // Count-up animation for stats
    const countUp = (el, target) => {
        let current = 0;
        const duration = 2000;
        const startTime = performance.now();
        const isK = target.includes('K');
        const isPlus = target.includes('+');
        const isPercent = target.includes('%');
        const num = parseFloat(target.replace(/[^\d.]/g, ''));

        const update = (now) => {
            const elapsed = now - startTime;
            const progress = Math.min(elapsed / duration, 1);
            current = num * progress;

            let display = Math.floor(current);
            if (isK) display = display + 'K';
            if (isPlus) display = display + '+';
            if (isPercent) display = display + '%';

            el.textContent = display;

            if (progress < 1) requestAnimationFrame(update);
            else el.textContent = target;
        };
        requestAnimationFrame(update);
    };

    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.querySelectorAll('.stat-value em').forEach(el => {
                    if (!el.dataset.counted) {
                        el.dataset.counted = 'true';
                        countUp(el, el.textContent);
                    }
                });
                statsObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('.stats-bar').forEach(el => statsObserver.observe(el));

    // ── Promo Slider ──
let currentSlide = 0;
const slides = document.querySelectorAll('.promo-slide');
const dots = document.querySelectorAll('.promo-dot-btn');
let autoplayTimer;

function goToSlide(n) {
    if (slides.length === 0) return; // Safety check
    slides[currentSlide].classList.remove('active');
    dots[currentSlide].classList.remove('active');
    currentSlide = (n + slides.length) % slides.length;
    slides[currentSlide].classList.add('active');
    dots[currentSlide].classList.add('active');
    console.log('Slide berubah ke:', currentSlide + 1);
}
function nextSlide() { 
    goToSlide(currentSlide + 1); 
    resetAutoplay(); 
}
function prevSlide() { 
    goToSlide(currentSlide - 1); 
    resetAutoplay(); 
}
function resetAutoplay() {
    clearInterval(autoplayTimer);
    autoplayTimer = setInterval(() => goToSlide(currentSlide + 1), 5000);
}
function closePromoBanner() {
    togglePromoBanner('hide');
}

// Check if banner should be hidden
window.addEventListener('load', function() {
    const promoBanner = document.getElementById('promo-bar');
    const statusToggle = document.getElementById('promo-status-toggle');
    
    if (promoBanner && localStorage.getItem('coursify_promo_closed') === '1') {
        promoBanner.style.display = 'none';
        if (statusToggle) statusToggle.classList.add('show');
    } else if (promoBanner) {
        promoBanner.style.display = 'block';
        if (statusToggle) statusToggle.classList.remove('show');
        resetAutoplay();
    }
});

// Toggle banner visibility
function togglePromoBanner(action) {
    const promoBanner = document.getElementById('promo-bar');
    const statusToggle = document.getElementById('promo-status-toggle');
    
    if (!promoBanner) return;
    
    if (action === 'show') {
        promoBanner.style.display = 'block';
        localStorage.removeItem('coursify_promo_closed');
        if (statusToggle) statusToggle.classList.remove('show');
        resetAutoplay();
    } else if (action === 'hide') {
        promoBanner.style.display = 'none';
        localStorage.setItem('coursify_promo_closed', '1');
        if (statusToggle) statusToggle.classList.add('show');
    }
}
// Latest Slider Auto-scroll logic
const latestSlider = document.getElementById('latestSlider');
const latestDots = document.getElementById('latestDots') ? document.getElementById('latestDots').children : [];
let latestAutoScroll;

function updateLatestDots() {
    if(!latestSlider) return;
    const scrollLeft = latestSlider.scrollLeft;
    const pageWidth = latestSlider.clientWidth; 
    const index = Math.round(scrollLeft / pageWidth);
    
    Array.from(latestDots).forEach((dot, i) => {
        dot.classList.toggle('active', i === index);
    });
}

function scrollToLatestPage(index) {
    if(!latestSlider) return;
    const pageWidth = latestSlider.clientWidth;
    latestSlider.scrollTo({ left: pageWidth * index, behavior: 'smooth' });
    resetLatestAutoScroll();
}

function scrollLatest(direction) {
    if(!latestSlider) return;
    const pageWidth = latestSlider.clientWidth;
    
    let newScrollLeft = latestSlider.scrollLeft + (direction * pageWidth);
    
    // Loop back to start if at end
    if (newScrollLeft > latestSlider.scrollWidth - latestSlider.clientWidth + 10 && direction > 0) {
        newScrollLeft = 0;
    } else if (newScrollLeft < -10 && direction < 0) {
        newScrollLeft = latestSlider.scrollWidth - latestSlider.clientWidth;
    }
    
    latestSlider.scrollTo({ left: newScrollLeft, behavior: 'smooth' });
    resetLatestAutoScroll();
}

function startLatestAutoScroll() {
    latestAutoScroll = setInterval(() => {
        scrollLatest(1);
    }, 4000); // changes slide every 4 seconds
}

function resetLatestAutoScroll() {
    clearInterval(latestAutoScroll);
    startLatestAutoScroll();
}

if (latestSlider) {
    latestSlider.addEventListener('scroll', () => {
        requestAnimationFrame(updateLatestDots);
    });
    
    // Pause auto-scroll on hover
    latestSlider.addEventListener('mouseenter', () => clearInterval(latestAutoScroll));
    latestSlider.addEventListener('mouseleave', startLatestAutoScroll);
    
    // Start auto-scroll
    startLatestAutoScroll();
}

// Dynamic Hero Title Word Cycler
document.addEventListener("DOMContentLoaded", () => {
    const words = document.querySelectorAll(".hero-title-dynamic-word");
    if (words.length === 0) return;
    
    let currentIndex = 0;
    
    setInterval(() => {
        const currentWord = words[currentIndex];
        currentWord.classList.remove("active");
        currentWord.classList.add("exit");
        
        currentIndex = (currentIndex + 1) % words.length;
        
        const nextWord = words[currentIndex];
        nextWord.classList.remove("exit");
        nextWord.classList.add("active");
        
        // Clean up exit class after animation completes
        setTimeout(() => {
            words.forEach((w, idx) => {
                if (idx !== currentIndex) {
                    w.classList.remove("exit");
                }
            });
        }, 800);
    }, 4000);
});
</script>
@endpush
