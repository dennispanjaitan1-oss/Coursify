@extends('layouts.app')

@section('title', 'Coursify - Learn Anything, Anytime')

@push('styles')
<style>
    /* ═══ HERO ═══ */
    .hero {
        padding: 70px 20px 40px;
        text-align: center;
        animation: fadeInUp 0.8s ease-out 0.2s both;
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
        line-height: 1.2;
        letter-spacing: -0.03em;
        margin-bottom: 18px;
        color: var(--text);
    }
    .hero-title em {
        font-style: italic;
        background: linear-gradient(135deg, #9F94F2, #7B6FE8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: block;
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
        gap: 14px;
        justify-content: center;
        flex-wrap: wrap;
        margin-bottom: 36px;
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

    /* ═══ COURSES ═══ */
    .courses-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        max-width: 1000px;
        margin: 0 auto;
    }
    .course-card {
        background: rgba(255,255,255,0.85);
        backdrop-filter: blur(30px);
        border: 1px solid rgba(123,111,232,0.08);
        border-radius: 20px;
        overflow: hidden;
        text-decoration: none;
        color: var(--text);
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }
    .course-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(30,58,95,0.14), 0 8px 20px rgba(123,111,232,0.08);
        border-color: rgba(123,111,232,0.2);
    }
    .course-thumb {
        aspect-ratio: 16/10;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 60px;
    }
    .course-thumb-1 { background: linear-gradient(135deg, #667EEA, #764BA2); }
    .course-thumb-2 { background: linear-gradient(135deg, #F093FB, #F5576C); }
    .course-thumb-3 { background: linear-gradient(135deg, #4FACFE, #00F2FE); }
    .course-thumb-4 { background: linear-gradient(135deg, #FA709A, #FEE140); }
    .course-thumb-5 { background: linear-gradient(135deg, #30CFD0, #330867); }
    .course-thumb-6 { background: linear-gradient(135deg, #A8EDEA, #FED6E3); }

    .course-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 4px 10px;
        border-radius: 100px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        backdrop-filter: blur(10px);
    }
    .badge-new { background: rgba(255,138,91,0.9); color: white; }
    .badge-bestseller { background: rgba(255,200,50,0.95); color: #5A3A00; }
    .badge-free { background: rgba(0,200,150,0.9); color: white; }

    .course-body { padding: 18px; }
    .course-category {
        font-size: 10px;
        color: var(--muted);
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    .course-title {
        font-family: var(--font-serif);
        font-size: 18px;
        line-height: 1.2;
        margin-bottom: 8px;
        letter-spacing: -0.01em;
    }
    .course-instructor {
        font-size: 12px;
        color: var(--text-soft);
        margin-bottom: 12px;
    }
    .course-meta {
        display: flex;
        gap: 12px;
        font-size: 12px;
        color: var(--muted);
        margin-bottom: 14px;
        padding-bottom: 14px;
        border-bottom: 1px solid rgba(0,0,0,0.06);
    }
    .course-footer { display: flex; justify-content: space-between; align-items: center; }
    .course-price {
        font-family: var(--font-serif);
        font-size: 18px;
        font-weight: 400;
        letter-spacing: -0.01em;
        color: var(--text);
    }
    .course-price-free { color: var(--teal); font-weight: 600; }
    .course-arrow { font-size: 18px; color: var(--purple); transition: transform 0.3s; }
    .course-card:hover .course-arrow { transform: translateX(6px); color: var(--purple-dark); }

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
    background: #0f0c29;
}
.promo-slides { position: relative; width: 100%; height: 100%; }
.promo-slide {
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity 0.7s ease;
    pointer-events: none;
}
.promo-slide.active { opacity: 1; pointer-events: all; }
.promo-slide-bg { position: absolute; inset: 0; z-index: 0; }
.promo-slide-content {
    position: relative;
    z-index: 1;
    max-width: 1100px;
    margin: 0 auto;
    padding: 50px 40px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: center;
    height: 100%;
}
.promo-slide-left { color: white; }
.promo-eyebrow {
    display: inline-block;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.55);
    margin-bottom: 12px;
}
.promo-slide-title {
    font-family: var(--font-serif);
    font-size: clamp(26px, 3vw, 40px);
    font-weight: 400;
    line-height: 1.15;
    letter-spacing: -0.02em;
    margin-bottom: 12px;
    color: white;
}
.promo-slide-title em { font-style: italic; color: #b8aef7; }
.promo-slide-desc {
    font-size: 14px;
    color: rgba(255,255,255,0.72);
    line-height: 1.6;
    margin-bottom: 24px;
    max-width: 400px;
}
.promo-code {
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.28);
    padding: 2px 9px;
    border-radius: 6px;
    font-family: monospace;
    font-size: 13px;
    font-weight: 700;
    color: #ffd700;
    letter-spacing: 0.05em;
}
.promo-slide-actions { display: flex; gap: 10px; flex-wrap: wrap; }
.promo-btn-primary {
    background: white;
    color: #1a1a2e;
    padding: 10px 22px;
    border-radius: 100px;
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
    border-radius: 100px;
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
.promo-course-card {
    background: rgba(255,255,255,0.97);
    border-radius: 18px;
    overflow: hidden;
    width: 220px;
    flex-shrink: 0;
    box-shadow: 0 20px 50px rgba(0,0,0,0.25), 0 0 0 1px rgba(123,111,232,0.06);
    position: relative;
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    color: var(--text);
    display: block;
}
.promo-course-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 28px 60px rgba(0,0,0,0.35), 0 0 0 1px rgba(123,111,232,0.15);
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
}
.promo-card-badge.badge-free { background: rgba(0,200,150,0.9); color: white; }
.promo-card-badge.badge-new { background: rgba(123,111,232,0.92); color: white; }
.promo-card-badge.badge-bestseller { background: rgba(255,200,50,0.95); color: #5A3A00; }
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
}
.promo-arrow:hover { background: rgba(255,255,255,0.22); transform: translateY(-50%) scale(1.05); }
.promo-arrow-left { left: 20px; }
.promo-arrow-right { right: 56px; }

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
                        <a href="#pricing" class="promo-btn-primary">Lihat Paket →</a>
                        <a href="{{ route('courses.index') }}" class="promo-btn-outline">Jelajahi Kursus</a>
                    </div>
                </div>
                <div class="promo-slide-right">
                    @php
                        $c1 = $displayCourses[0];
                        $c2 = $displayCourses[1];
                    @endphp
                    <a href="{{ $c1['slug'] }}" class="promo-course-card">
                        <div class="promo-card-badge badge-{{ $c1['badge_type'] }}">{{ $c1['badge'] }}</div>
                        <div class="promo-card-thumb" style="@if(!$c1['thumbnail_url']) background: linear-gradient(135deg, #667eea, #764ba2); font-size: 32px; @endif">
                            @if(!empty($c1['thumbnail_url']))
                                <img src="{{ $c1['thumbnail_url'] }}" alt="{{ $c1['title'] }}">
                            @else
                                <span>{{ $c1['icon'] ?? '🎓' }}</span>
                            @endif
                        </div>
                        <div class="promo-card-body">
                            <div class="promo-card-category">{{ $c1['category'] }}</div>
                            <div class="promo-card-title" title="{{ $c1['title'] }}">{{ $c1['title'] }}</div>
                            <div class="promo-card-instructor">{{ $c1['instructor'] }}</div>
                            <div class="promo-card-meta">
                                <span>⭐ {{ $c1['rating'] }}</span>
                                <span>⏱ {{ $c1['duration'] }}</span>
                            </div>
                            <div class="promo-card-footer">
                                <div class="promo-card-price {{ $c1['is_free'] ? 'promo-price-free' : '' }}">
                                    {{ $c1['price'] }}
                                </div>
                                <div class="promo-card-arrow">→</div>
                            </div>
                        </div>
                    </a>

                    <a href="{{ $c2['slug'] }}" class="promo-course-card promo-card-offset">
                        <div class="promo-card-badge badge-{{ $c2['badge_type'] }}">{{ $c2['badge'] }}</div>
                        <div class="promo-card-thumb" style="@if(!$c2['thumbnail_url']) background: linear-gradient(135deg, #4facfe, #00f2fe); font-size: 32px; @endif">
                            @if(!empty($c2['thumbnail_url']))
                                <img src="{{ $c2['thumbnail_url'] }}" alt="{{ $c2['title'] }}">
                            @else
                                <span>{{ $c2['icon'] ?? '🎓' }}</span>
                            @endif
                        </div>
                        <div class="promo-card-body">
                            <div class="promo-card-category">{{ $c2['category'] }}</div>
                            <div class="promo-card-title" title="{{ $c2['title'] }}">{{ $c2['title'] }}</div>
                            <div class="promo-card-instructor">{{ $c2['instructor'] }}</div>
                            <div class="promo-card-meta">
                                <span>⭐ {{ $c2['rating'] }}</span>
                                <span>⏱ {{ $c2['duration'] }}</span>
                            </div>
                            <div class="promo-card-footer">
                                <div class="promo-card-price {{ $c2['is_free'] ? 'promo-price-free' : '' }}">
                                    {{ $c2['price'] }}
                                </div>
                                <div class="promo-card-arrow">→</div>
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
                    <a href="{{ $c3['slug'] }}" class="promo-course-card">
                        <div class="promo-card-badge badge-{{ $c3['badge_type'] }}">{{ $c3['badge'] }}</div>
                        <div class="promo-card-thumb" style="@if(!$c3['thumbnail_url']) background: linear-gradient(135deg, #FA709A, #FEE140); font-size: 32px; @endif">
                            @if(!empty($c3['thumbnail_url']))
                                <img src="{{ $c3['thumbnail_url'] }}" alt="{{ $c3['title'] }}">
                            @else
                                <span>{{ $c3['icon'] ?? '🎓' }}</span>
                            @endif
                        </div>
                        <div class="promo-card-body">
                            <div class="promo-card-category">{{ $c3['category'] }}</div>
                            <div class="promo-card-title" title="{{ $c3['title'] }}">{{ $c3['title'] }}</div>
                            <div class="promo-card-instructor">{{ $c3['instructor'] }}</div>
                            <div class="promo-card-meta">
                                <span>⭐ {{ $c3['rating'] }}</span>
                                <span>⏱ {{ $c3['duration'] }}</span>
                            </div>
                            <div class="promo-card-footer">
                                <div class="promo-card-price {{ $c3['is_free'] ? 'promo-price-free' : '' }}">
                                    {{ $c3['price'] }}
                                </div>
                                <div class="promo-card-arrow">→</div>
                            </div>
                        </div>
                    </a>

                    <a href="{{ $c4['slug'] }}" class="promo-course-card promo-card-offset">
                        <div class="promo-card-badge badge-{{ $c4['badge_type'] }}">{{ $c4['badge'] }}</div>
                        <div class="promo-card-thumb" style="@if(!$c4['thumbnail_url']) background: linear-gradient(135deg, #30CFD0, #330867); font-size: 32px; @endif">
                            @if(!empty($c4['thumbnail_url']))
                                <img src="{{ $c4['thumbnail_url'] }}" alt="{{ $c4['title'] }}">
                            @else
                                <span>{{ $c4['icon'] ?? '🎓' }}</span>
                            @endif
                        </div>
                        <div class="promo-card-body">
                            <div class="promo-card-category">{{ $c4['category'] }}</div>
                            <div class="promo-card-title" title="{{ $c4['title'] }}">{{ $c4['title'] }}</div>
                            <div class="promo-card-instructor">{{ $c4['instructor'] }}</div>
                            <div class="promo-card-meta">
                                <span>⭐ {{ $c4['rating'] }}</span>
                                <span>⏱ {{ $c4['duration'] }}</span>
                            </div>
                            <div class="promo-card-footer">
                                <div class="promo-card-price {{ $c4['is_free'] ? 'promo-price-free' : '' }}">
                                    {{ $c4['price'] }}
                                </div>
                                <div class="promo-card-arrow">→</div>
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
                        <a href="#pricing" class="promo-btn-outline">Lihat Harga</a>
                    </div>
                </div>
                <div class="promo-slide-right">
                    @php
                        $c5 = $displayCourses[4];
                        $c6 = $displayCourses[5];
                    @endphp
                    <a href="{{ $c5['slug'] }}" class="promo-course-card">
                        <div class="promo-card-badge badge-{{ $c5['badge_type'] }}">{{ $c5['badge'] }}</div>
                        <div class="promo-card-thumb" style="@if(!$c5['thumbnail_url']) background: linear-gradient(135deg, #f7971e, #ffd200); font-size: 32px; @endif">
                            @if(!empty($c5['thumbnail_url']))
                                <img src="{{ $c5['thumbnail_url'] }}" alt="{{ $c5['title'] }}">
                            @else
                                <span>{{ $c5['icon'] ?? '🎓' }}</span>
                            @endif
                        </div>
                        <div class="promo-card-body">
                            <div class="promo-card-category">{{ $c5['category'] }}</div>
                            <div class="promo-card-title" title="{{ $c5['title'] }}">{{ $c5['title'] }}</div>
                            <div class="promo-card-instructor">{{ $c5['instructor'] }}</div>
                            <div class="promo-card-meta">
                                <span>⭐ {{ $c5['rating'] }}</span>
                                <span>⏱ {{ $c5['duration'] }}</span>
                            </div>
                            <div class="promo-card-footer">
                                <div class="promo-card-price {{ $c5['is_free'] ? 'promo-price-free' : '' }}">
                                    {{ $c5['price'] }}
                                </div>
                                <div class="promo-card-arrow">→</div>
                            </div>
                        </div>
                    </a>

                    <a href="{{ $c6['slug'] }}" class="promo-course-card promo-card-offset">
                        <div class="promo-card-badge badge-{{ $c6['badge_type'] }}">{{ $c6['badge'] }}</div>
                        <div class="promo-card-thumb" style="@if(!$c6['thumbnail_url']) background: linear-gradient(135deg, #a8edea, #fed6e3); font-size: 32px; @endif">
                            @if(!empty($c6['thumbnail_url']))
                                <img src="{{ $c6['thumbnail_url'] }}" alt="{{ $c6['title'] }}">
                            @else
                                <span>{{ $c6['icon'] ?? '🎓' }}</span>
                            @endif
                        </div>
                        <div class="promo-card-body">
                            <div class="promo-card-category">{{ $c6['category'] }}</div>
                            <div class="promo-card-title" title="{{ $c6['title'] }}">{{ $c6['title'] }}</div>
                            <div class="promo-card-instructor">{{ $c6['instructor'] }}</div>
                            <div class="promo-card-meta">
                                <span>⭐ {{ $c6['rating'] }}</span>
                                <span>⏱ {{ $c6['duration'] }}</span>
                            </div>
                            <div class="promo-card-footer">
                                <div class="promo-card-price {{ $c6['is_free'] ? 'promo-price-free' : '' }}">
                                    {{ $c6['price'] }}
                                </div>
                                <div class="promo-card-arrow">→</div>
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

{{-- ═══════════════════════════════════════════════════ --}}
{{-- HERO                                                 --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="hero">

        <h1 class="hero-title">
            Learn Anything,
            <em>Anytime</em>
        </h1>
        <p class="hero-subtitle">
            Master new skills with world-class instructors. Your personal learning journey starts here. free to begin, limitless to grow.
        </p>
        <div class="hero-cta">
            @guest
                <a href="{{ route('register') }}" class="btn btn-dark">Start Learning Free</a>
                <a href="{{ route('courses.index') }}" class="btn btn-light">▶ Browse Courses</a>
            @else
                <a href="{{ route('student.index') }}" class="btn btn-dark">Continue Learning </a>
                <a href="{{ route('courses.index') }}" class="btn btn-light">▶ Browse Courses</a>
            @endguest
        </div>

       

        {{-- Phone Mockups --}}
        <div class="mockup-stage">
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
                <a href="{{ isset($course['slug']) ? route('courses.show', $course['slug']) : route('courses.index') }}" class="course-card">
                    <div class="course-thumb course-thumb-{{ $course['thumb'] ?? 1 }}">
                        @if(!empty($course['badge']))
                            <span class="course-badge badge-{{ $course['badge'] }}">
                                {{ $course['badge'] === 'bestseller' ? 'Bestseller' : ucfirst($course['badge']) }}
                            </span>
                        @endif
                        @if(!empty($course['thumbnail_url']))
    <img src="{{ $course['thumbnail_url'] }}" alt="{{ $course['title'] }}"
        style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0.85;">
@else
    {!! $course['icon'] ?? '<i class="fa-solid fa-book-open"></i>' !!}
@endif
                    </div>
                    <div class="course-body">
                        <div class="course-category">{{ $course['category'] }}</div>
                        <div class="course-title">{{ $course['title'] }}</div>
                        <div class="course-instructor">{{ $course['instructor'] }}</div>
                        <div class="course-meta">
                            <span><i class="fa-solid fa-star"></i> {{ $course['rating'] }}</span>
<span><i class="fa-solid fa-users"></i> {{ $course['students'] }}</span>
<span><i class="fa-solid fa-clock"></i> {{ $course['duration'] }}</span>
                        </div>
                        <div class="course-footer">
                            <div class="course-price {{ $course['price'] === 'Free' ? 'course-price-free' : '' }}">
                                {{ $course['price'] }}
                            </div>
                            <div class="course-arrow">→</div>
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

    /* ═══ PRICING ═══ */
    .pricing-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        max-width: 900px;
        margin: 0 auto;
    }
    .pricing-card {
        background: rgba(255,255,255,0.75);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.95);
        border-radius: 24px;
        padding: 28px 22px;
        position: relative;
        transition: all 0.3s;
        box-shadow: 0 4px 16px rgba(30,58,95,0.04);
    }
    .pricing-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 36px rgba(30,58,95,0.1);
    }
    .pricing-featured {
        background: linear-gradient(180deg, #9A8EE8, #7B6FE8);
        color: white;
        border: 1px solid rgba(255,255,255,0.3);
        box-shadow: 0 16px 40px rgba(123,111,232,0.35);
        transform: scale(1.03);
    }
    .pricing-featured:hover {
        transform: scale(1.03) translateY(-4px);
    }
    .pricing-badge {
        position: absolute;
        top: -10px;
        right: 20px;
        background: white;
        color: var(--text);
        padding: 5px 14px;
        border-radius: 100px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.05em;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .pricing-plan {
        font-family: var(--font-serif);
        font-size: 22px;
        font-weight: 400;
        margin-bottom: 4px;
    }
    .pricing-price {
        font-family: var(--font-serif);
        font-size: 44px;
        font-weight: 400;
        line-height: 1;
        letter-spacing: -0.02em;
        margin: 10px 0 4px;
    }
    .pricing-price-sub {
        font-size: 12px;
        color: var(--muted);
        font-weight: 500;
        margin-left: 2px;
    }
    .pricing-featured .pricing-price-sub { color: rgba(255,255,255,0.8); }
    .pricing-desc {
        font-size: 12px;
        color: var(--muted);
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(0,0,0,0.08);
        line-height: 1.5;
        min-height: 40px;
    }
    .pricing-featured .pricing-desc {
        color: rgba(255,255,255,0.85);
        border-bottom-color: rgba(255,255,255,0.2);
    }
    .pricing-features {
        list-style: none;
        margin-bottom: 20px;
        min-height: 150px;
    }
    .pricing-features li {
        font-size: 12px;
        padding: 4px 0;
        color: var(--text-soft);
        display: flex;
        align-items: flex-start;
        gap: 8px;
        line-height: 1.5;
    }
    .pricing-featured .pricing-features li { color: rgba(255,255,255,0.95); }
    .pricing-features li::before {
        content: '✓';
        color: var(--purple);
        font-weight: 700;
        flex-shrink: 0;
    }
    .pricing-featured .pricing-features li::before { color: white; }
    .pricing-btn {
        width: 100%;
        background: rgba(0,0,0,0.06);
        color: var(--text);
        border: none;
        padding: 11px;
        border-radius: 100px;
        font-weight: 500;
        font-size: 13px;
        cursor: pointer;
        font-family: var(--font-sans);
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }
    .pricing-btn:hover {
        background: rgba(0,0,0,0.1);
        transform: translateY(-1px);
    }
    .pricing-featured .pricing-btn {
        background: white;
        color: var(--purple-dark);
        font-weight: 600;
    }
    .pricing-featured .pricing-btn:hover {
        background: rgba(255,255,255,0.9);
    }

    /* ═══ SDG ═══ */
    .sdg-wrapper {
        background: linear-gradient(135deg, var(--navy), #2D4D7A);
        border-radius: 32px;
        padding: 60px 40px;
        color: white;
        position: relative;
        overflow: hidden;
        max-width: 1100px;
        margin: 0 auto;
    }
    .sdg-wrapper::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(184,175,235,0.3), transparent 70%);
    }
    .sdg-content { position: relative; z-index: 1; }
    .sdg-eyebrow {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: var(--lav-4);
        margin-bottom: 12px;
        text-align: center;
    }
    .sdg-title {
        font-family: var(--font-serif);
        font-size: clamp(32px, 4vw, 42px);
        font-weight: 400;
        text-align: center;
        line-height: 1.2;
        letter-spacing: -0.02em;
        margin-bottom: 14px;
    }
    .sdg-subtitle {
        text-align: center;
        color: rgba(255,255,255,0.8);
        font-size: 14px;
        max-width: 540px;
        margin: 0 auto 40px;
        line-height: 1.6;
    }
    .sdg-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }
    .sdg-card {
        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 20px;
        padding: 28px 24px;
        transition: all 0.3s;
    }
    .sdg-card:hover {
        background: rgba(255,255,255,0.15);
        transform: translateY(-4px);
    }
    .sdg-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.95);
        color: var(--navy);
        font-family: var(--font-serif);
        font-size: 28px;
        border-radius: 14px;
        margin-bottom: 16px;
    }
    .sdg-name {
        font-family: var(--font-serif);
        font-size: 20px;
        margin-bottom: 6px;
        letter-spacing: -0.01em;
    }
    .sdg-code {
        display: inline-block;
        font-size: 10px;
        color: var(--lav-4);
        font-weight: 700;
        letter-spacing: 0.1em;
        margin-bottom: 12px;
    }
    .sdg-desc {
        font-size: 13px;
        color: rgba(255,255,255,0.8);
        line-height: 1.6;
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
        .testimonial-grid, .pricing-grid, .sdg-grid { grid-template-columns: 1fr; }
        .pricing-featured { transform: none; }
        .how-wrapper, .sdg-wrapper { padding: 40px 24px; }
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
{{-- PRICING                                              --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="section" id="pricing">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">Pricing</span>
            <h2 class="section-title">Start free.<br>Upgrade when <em>ready</em>.</h2>
            <p class="section-subtitle">Flexible plans that grow with you. Cancel anytime, no questions asked.</p>
        </div>

        <div class="pricing-grid">
            <div class="pricing-card">
                <div class="pricing-plan">Starter</div>
                <div class="pricing-price">Free</div>
                <div class="pricing-desc">Perfect for exploring and trying out the platform.</div>
                <ul class="pricing-features">
                    <li>Access to 100+ free courses</li>
                    <li>Basic progress tracking</li>
                    <li>Community forum access</li>
                    <li>Audit mode certificates</li>
                </ul>
                <a href="{{ route('register') }}" class="pricing-btn">Get Started</a>
            </div>

            <div class="pricing-card pricing-featured">
                <div class="pricing-badge">Most Popular</div>
                <div class="pricing-plan">Pro</div>
                <div class="pricing-price">Rp 99k<span class="pricing-price-sub">/month</span></div>
                <div class="pricing-desc">Full access to all premium courses and features.</div>
                <ul class="pricing-features">
                    <li>All 500+ premium courses</li>
                    <li>Verified certificates</li>
                    <li>Offline downloads</li>
                    <li>Priority support 24/7</li>
                    <li>1-on-1 mentoring sessions</li>
                </ul>
                <a href="{{ route('payment.index') }}?plan=pro" class="pricing-btn">Start Free Trial</a>
            </div>

            <div class="pricing-card">
                <div class="pricing-plan">Business</div>
                <div class="pricing-price">Rp 499k<span class="pricing-price-sub">/month</span></div>
                <div class="pricing-desc">For teams and companies investing in their people.</div>
                <ul class="pricing-features">
                    <li>Everything in Pro plan</li>
                    <li>Up to 25 team members</li>
                    <li>Admin dashboard</li>
                    <li>Analytics & reporting</li>
                    <li>Custom learning paths</li>
                </ul>
                <a href="{{ route('payment.index') }}?plan=business" class="pricing-btn">Contact Sales</a>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- SDG COMMITMENT                                       --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="section">
    <div class="container">
        <div class="sdg-wrapper">
            <div class="sdg-content">
                <div class="sdg-eyebrow">Sustainable Development Goals</div>
                <h2 class="sdg-title">Education for <em style="font-style:italic;">everyone</em>.<br>Growth for the <em style="font-style:italic;">future</em>.</h2>
                <p class="sdg-subtitle">Coursify is committed to supporting the United Nations Sustainable Development Goals through accessible, quality education.</p>

                <div class="sdg-grid">
                    <div class="sdg-card">
                        <div class="sdg-number">4</div>
                        <div class="sdg-code">SDG 4</div>
                        <div class="sdg-name">Quality Education</div>
                        <p class="sdg-desc">Providing free courses and scholarships for underserved communities. Lifelong learning for all.</p>
                    </div>

                    <div class="sdg-card">
                        <div class="sdg-number">8</div>
                        <div class="sdg-code">SDG 8</div>
                        <div class="sdg-name">Decent Work</div>
                        <p class="sdg-desc">Equipping 50K+ learners with industry-ready skills for better career opportunities.</p>
                    </div>

                    <div class="sdg-card">
                        <div class="sdg-number">10</div>
                        <div class="sdg-code">SDG 10</div>
                        <div class="sdg-name">Reduced Inequalities</div>
                        <p class="sdg-desc">Breaking educational barriers through accessible technology for everyone, everywhere.</p>
                    </div>
                </div>
            </div>
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
    slides[currentSlide].classList.remove('active');
    dots[currentSlide].classList.remove('active');
    currentSlide = (n + slides.length) % slides.length;
    slides[currentSlide].classList.add('active');
    dots[currentSlide].classList.add('active');
}
function nextSlide() { goToSlide(currentSlide + 1); resetAutoplay(); }
function prevSlide() { goToSlide(currentSlide - 1); resetAutoplay(); }
function resetAutoplay() {
    clearInterval(autoplayTimer);
    autoplayTimer = setInterval(() => goToSlide(currentSlide + 1), 5000);
}
function closePromoBanner() {
    document.getElementById('promo-bar').style.display = 'none';
}
resetAutoplay();
</script>
@endpush