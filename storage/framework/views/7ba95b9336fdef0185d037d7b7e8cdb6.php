

<?php $__env->startSection('title', 'Tentang Kami'); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* ═══════════════════════════════════════════════════════
   ABOUT PAGE — COURSIFY
   resources/views/about.blade.php
   Tambahkan route di web.php:
   Route::view('/about', 'about')->name('about');
═══════════════════════════════════════════════════════ */

/* ── Shared helpers ── */
.about-eyebrow {
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
    margin-bottom: 18px;
}
.about-eyebrow i { font-size: 11px; }

.glass-card {
    background: rgba(255,255,255,0.68);
    backdrop-filter: blur(28px);
    -webkit-backdrop-filter: blur(28px);
    border: 1px solid rgba(255,255,255,0.92);
    border-radius: 24px;
    box-shadow: 0 4px 20px rgba(30,58,95,0.05);
}

/* ══════════════════════════════════════════
   1. HERO
══════════════════════════════════════════ */
.about-hero {
    text-align: center;
    padding: 60px 20px 52px;
    position: relative;
    z-index: 1;
}
.about-hero-title {
    font-family: var(--font-serif);
    font-size: clamp(48px, 7vw, 88px);
    font-weight: 400;
    line-height: 1.06;
    letter-spacing: -0.03em;
    margin-bottom: 20px;
    color: var(--text);
    overflow: visible;
}
.about-hero-title em {
    font-style: italic;
    background: linear-gradient(135deg, #9F94F2, #7B6FE8, #5B4FD4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    padding-right: 0.08em;
}
.about-hero-sub {
    font-size: 17px;
    line-height: 1.65;
    color: var(--text-soft);
    max-width: 600px;
    margin: 0 auto 40px;
}
.about-hero-actions {
    display: flex;
    gap: 12px;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 52px;
}
.btn-about-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 13px 28px;
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
    box-shadow: 0 4px 14px rgba(30,58,95,0.3);
}
.btn-about-primary:hover {
    background: #2D4D7A;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(30,58,95,0.4);
}
.btn-about-ghost {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 13px 28px;
    background: rgba(255,255,255,0.7);
    color: var(--text);
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    border: 1.5px solid rgba(255,255,255,0.9);
    backdrop-filter: blur(10px);
}
.btn-about-ghost:hover {
    background: rgba(255,255,255,0.95);
    transform: translateY(-2px);
}

/* Hero mission card */
.hero-mission-card {
    max-width: 820px;
    margin: 0 auto;
    padding: 36px 44px;
    text-align: left;
    position: relative;
    overflow: hidden;
}
.hero-mission-card::before {
    content: '"';
    font-family: var(--font-serif);
    font-size: 220px;
    line-height: 1;
    color: var(--purple);
    opacity: 0.06;
    position: absolute;
    top: -20px;
    left: 20px;
    pointer-events: none;
    font-style: italic;
}
.hero-mission-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--purple);
    margin-bottom: 14px;
}
.hero-mission-text {
    font-family: var(--font-serif);
    font-size: clamp(20px, 2.5vw, 28px);
    font-weight: 400;
    line-height: 1.55;
    letter-spacing: -0.015em;
    color: var(--text);
    font-style: italic;
    position: relative;
    z-index: 1;
}
.hero-mission-text strong {
    font-style: normal;
    color: var(--purple-dark);
}
.hero-mission-author {
    margin-top: 22px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.mission-author-avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--navy), #2D4D7A);
    color: white;
    font-size: 15px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.mission-author-info { display: flex; flex-direction: column; gap: 2px; }
.mission-author-name { font-size: 14px; font-weight: 700; color: var(--text); }
.mission-author-role { font-size: 12px; color: var(--muted); }

/* ══════════════════════════════════════════
   2. IMPACT STATS
══════════════════════════════════════════ */
.about-stats-section { padding: 20px 20px 0; }
.about-stats-bar {
    max-width: 1000px;
    margin: 0 auto;
    padding: 32px 48px;
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 20px;
}
.about-stat-item {
    text-align: center;
    position: relative;
}
.about-stat-item + .about-stat-item::before {
    content: '';
    position: absolute;
    left: 0; top: 15%; bottom: 15%;
    width: 1px;
    background: rgba(30,58,95,0.08);
}
.about-stat-val {
    font-family: var(--font-serif);
    font-size: 38px;
    font-weight: 400;
    letter-spacing: -0.025em;
    line-height: 1;
    margin-bottom: 6px;
    color: var(--text);
}
.about-stat-val em { font-style: italic; color: var(--purple); }
.about-stat-label {
    font-size: 11px;
    font-weight: 600;
    color: var(--muted);
    letter-spacing: 0.06em;
    text-transform: uppercase;
    line-height: 1.4;
}

/* ══════════════════════════════════════════
   3. OUR STORY
══════════════════════════════════════════ */
.about-section { padding: 72px 20px; }
.about-section-inner {
    max-width: 1120px;
    margin: 0 auto;
}
.story-grid {
    display: grid;
    grid-template-columns: 1fr 480px;
    gap: 36px;
    align-items: center;
}
.story-text-col { min-width: 0; }
.story-section-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--purple);
    margin-bottom: 12px;
}
.story-title {
    font-family: var(--font-serif);
    font-size: clamp(36px, 4vw, 50px);
    font-weight: 400;
    line-height: 1.1;
    letter-spacing: -0.025em;
    margin-bottom: 20px;
    color: var(--text);
}
.story-title em {
    font-style: italic;
    color: var(--purple);
    padding-bottom: 0.05em;
    display: inline-block;
}
.story-body {
    font-size: 15px;
    line-height: 1.75;
    color: var(--text-soft);
    margin-bottom: 14px;
}
.story-body strong { color: var(--text); font-weight: 600; }

/* Timeline */
.story-timeline {
    display: flex;
    flex-direction: column;
    gap: 0;
    padding: 32px;
    position: relative;
}
.story-timeline::before {
    content: '';
    position: absolute;
    left: 52px;
    top: 44px;
    bottom: 44px;
    width: 2px;
    background: linear-gradient(180deg, var(--purple) 0%, var(--teal) 50%, var(--orange) 100%);
    opacity: 0.25;
    border-radius: 2px;
}
.timeline-item {
    display: flex;
    gap: 20px;
    align-items: flex-start;
    padding: 16px 0;
    position: relative;
}
.timeline-year-badge {
    flex-shrink: 0;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--purple), var(--purple-dark));
    color: white;
    font-size: 11px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(123,111,232,0.3);
    z-index: 1;
    text-align: center;
    line-height: 1.2;
}
.timeline-year-badge.badge-teal { background: linear-gradient(135deg, var(--teal), #00A075); box-shadow: 0 4px 12px rgba(0,200,150,0.3); }
.timeline-year-badge.badge-orange { background: linear-gradient(135deg, var(--orange), #E06040); box-shadow: 0 4px 12px rgba(255,138,91,0.3); }
.timeline-year-badge.badge-navy { background: linear-gradient(135deg, var(--navy), #2D4D7A); box-shadow: 0 4px 12px rgba(30,58,95,0.3); }
.timeline-content { flex: 1; min-width: 0; padding-top: 8px; }
.timeline-year-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 4px;
}
.timeline-event-title {
    font-family: var(--font-serif);
    font-size: 17px;
    font-weight: 400;
    color: var(--text);
    letter-spacing: -0.01em;
    margin-bottom: 4px;
}
.timeline-event-desc {
    font-size: 13px;
    color: var(--text-soft);
    line-height: 1.55;
}

/* ══════════════════════════════════════════
   4. VALUES
══════════════════════════════════════════ */
.values-section {
    padding: 0 20px 72px;
}
.values-header {
    text-align: center;
    max-width: 600px;
    margin: 0 auto 44px;
}
.values-title {
    font-family: var(--font-serif);
    font-size: clamp(34px, 4.5vw, 52px);
    font-weight: 400;
    line-height: 1.1;
    letter-spacing: -0.025em;
    margin-bottom: 14px;
    color: var(--text);
}
.values-title em { font-style: italic; color: var(--purple); }
.values-sub { font-size: 15px; color: var(--muted); line-height: 1.6; }
.values-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    max-width: 1120px;
    margin: 0 auto;
}
.value-card {
    padding: 32px 26px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}
.value-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, transparent 60%, rgba(123,111,232,0.03));
    pointer-events: none;
}
.value-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(30,58,95,0.1);
    border-color: rgba(123,111,232,0.3);
}
.value-icon-wrap {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    transition: transform 0.3s;
}
.value-card:hover .value-icon-wrap { transform: scale(1.08) rotate(-4deg); }
.icon-purple { background: linear-gradient(135deg, rgba(123,111,232,0.15), rgba(91,79,212,0.1)); color: var(--purple); }
.icon-teal   { background: linear-gradient(135deg, rgba(0,200,150,0.15), rgba(0,160,117,0.1)); color: #009970; }
.icon-orange { background: linear-gradient(135deg, rgba(255,138,91,0.15), rgba(230,100,60,0.1)); color: #D05020; }
.icon-navy   { background: linear-gradient(135deg, rgba(30,58,95,0.12), rgba(45,77,122,0.08)); color: var(--navy); }
.value-name {
    font-family: var(--font-serif);
    font-size: 21px;
    font-weight: 400;
    letter-spacing: -0.01em;
    margin-bottom: 10px;
    color: var(--text);
}
.value-desc { font-size: 13.5px; color: var(--text-soft); line-height: 1.65; }

/* ══════════════════════════════════════════
   5. TEAM
══════════════════════════════════════════ */
.team-section { padding: 0 20px 72px; }
.team-header {
    text-align: center;
    max-width: 560px;
    margin: 0 auto 44px;
}
.team-title {
    font-family: var(--font-serif);
    font-size: clamp(34px, 4.5vw, 52px);
    font-weight: 400;
    line-height: 1.1;
    letter-spacing: -0.025em;
    margin-bottom: 12px;
    color: var(--text);
}
.team-title em { font-style: italic; color: var(--purple); }
.team-sub { font-size: 15px; color: var(--muted); line-height: 1.6; }
.team-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 18px;
    max-width: 1120px;
    margin: 0 auto;
}
.team-card {
    padding: 28px 22px 24px;
    text-align: center;
    transition: all 0.3s;
}
.team-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 36px rgba(30,58,95,0.1);
    border-color: rgba(123,111,232,0.25);
}
.team-avatar {
    width: 84px;
    height: 84px;
    border-radius: 50%;
    margin: 0 auto 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    font-weight: 700;
    color: white;
    font-family: var(--font-serif);
    box-shadow: 0 8px 24px rgba(30,58,95,0.18);
    transition: transform 0.3s;
    position: relative;
}
.team-card:hover .team-avatar { transform: scale(1.05); }
.team-avatar-a { background: linear-gradient(135deg, #667EEA, #764BA2); }
.team-avatar-b { background: linear-gradient(135deg, var(--navy), #2D4D7A); }
.team-avatar-c { background: linear-gradient(135deg, var(--teal), #009970); }
.team-avatar-d { background: linear-gradient(135deg, var(--orange), #D05020); }
.team-name {
    font-family: var(--font-serif);
    font-size: 19px;
    font-weight: 400;
    letter-spacing: -0.01em;
    margin-bottom: 4px;
    color: var(--text);
}
.team-role {
    font-size: 12px;
    color: var(--purple-dark);
    font-weight: 700;
    letter-spacing: 0.04em;
    margin-bottom: 10px;
    text-transform: uppercase;
    font-size: 10px;
}
.team-bio {
    font-size: 12.5px;
    color: var(--text-soft);
    line-height: 1.6;
    margin-bottom: 16px;
}
.team-socials {
    display: flex;
    justify-content: center;
    gap: 8px;
}
.team-social-btn {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: var(--lav-1);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-soft);
    font-size: 12px;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
}
.team-social-btn:hover {
    background: var(--navy);
    color: white;
    transform: translateY(-2px);
}

/* ══════════════════════════════════════════
   6. SDG / IMPACT
══════════════════════════════════════════ */
.impact-section { padding: 0 20px 72px; }
.impact-wrapper {
    max-width: 1120px;
    margin: 0 auto;
    background: linear-gradient(135deg, var(--navy) 0%, #1A3A6E 60%, #2D4D7A 100%);
    border-radius: 32px;
    padding: 64px 56px;
    position: relative;
    overflow: hidden;
    color: white;
}
.impact-wrapper::before {
    content: '';
    position: absolute;
    top: -80px; right: -80px;
    width: 380px; height: 380px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(184,175,235,0.2), transparent 70%);
    pointer-events: none;
}
.impact-wrapper::after {
    content: '';
    position: absolute;
    bottom: -60px; left: 10%;
    width: 280px; height: 280px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(0,200,150,0.12), transparent 70%);
    pointer-events: none;
}
.impact-content { position: relative; z-index: 1; }
.impact-header {
    text-align: center;
    max-width: 640px;
    margin: 0 auto 48px;
}
.impact-eyebrow {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--lav-4);
    margin-bottom: 14px;
}
.impact-title {
    font-family: var(--font-serif);
    font-size: clamp(32px, 4vw, 46px);
    font-weight: 400;
    line-height: 1.15;
    letter-spacing: -0.02em;
    color: white;
    margin-bottom: 14px;
}
.impact-title em { font-style: italic; color: var(--lav-4); }
.impact-sub { font-size: 15px; color: rgba(255,255,255,0.7); line-height: 1.6; }
.sdg-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
}
.sdg-card {
    background: rgba(255,255,255,0.07);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.14);
    border-radius: 20px;
    padding: 28px 24px;
    transition: all 0.3s;
}
.sdg-card:hover {
    background: rgba(255,255,255,0.13);
    transform: translateY(-4px);
}
.sdg-number-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 56px;
    height: 56px;
    background: rgba(255,255,255,0.95);
    color: var(--navy);
    font-family: var(--font-serif);
    font-size: 26px;
    border-radius: 14px;
    margin-bottom: 16px;
    font-weight: 400;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
.sdg-code {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.1em;
    color: var(--lav-4);
    margin-bottom: 8px;
    text-transform: uppercase;
}
.sdg-card-title {
    font-family: var(--font-serif);
    font-size: 20px;
    color: white;
    margin-bottom: 8px;
    letter-spacing: -0.01em;
}
.sdg-card-desc { font-size: 13px; color: rgba(255,255,255,0.75); line-height: 1.6; }
.sdg-progress {
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid rgba(255,255,255,0.12);
}
.sdg-progress-label {
    display: flex;
    justify-content: space-between;
    font-size: 11px;
    color: rgba(255,255,255,0.6);
    font-weight: 500;
    margin-bottom: 6px;
}
.sdg-progress-bar {
    height: 5px;
    background: rgba(255,255,255,0.12);
    border-radius: 3px;
    overflow: hidden;
}
.sdg-progress-fill {
    height: 100%;
    border-radius: 3px;
    background: linear-gradient(90deg, var(--lav-4), #9F94F2);
}

/* ══════════════════════════════════════════
   7. RECOGNITION / PRESS
══════════════════════════════════════════ */
.recognition-section { padding: 0 20px 72px; }
.recog-grid {
    max-width: 1120px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}
.recog-left { display: flex; flex-direction: column; gap: 18px; }
.recog-right { display: flex; flex-direction: column; justify-content: center; padding: 40px; }
.award-item {
    display: flex;
    gap: 18px;
    align-items: flex-start;
    padding: 20px;
    transition: all 0.25s;
}
.award-item:hover {
    transform: translateX(4px);
    border-color: rgba(123,111,232,0.3);
}
.award-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}
.ai-gold   { background: linear-gradient(135deg, rgba(255,196,82,0.2), rgba(255,196,82,0.1)); }
.ai-purple { background: rgba(123,111,232,0.1); }
.ai-teal   { background: rgba(0,200,150,0.1); }
.award-year {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--purple);
    margin-bottom: 4px;
}
.award-name {
    font-family: var(--font-serif);
    font-size: 17px;
    font-weight: 400;
    color: var(--text);
    letter-spacing: -0.01em;
    margin-bottom: 4px;
}
.award-org { font-size: 12px; color: var(--muted); font-weight: 500; }
.recog-right-eyebrow {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--purple);
    margin-bottom: 14px;
}
.recog-big-title {
    font-family: var(--font-serif);
    font-size: clamp(30px, 3.5vw, 42px);
    font-weight: 400;
    line-height: 1.15;
    letter-spacing: -0.02em;
    margin-bottom: 14px;
    color: var(--text);
}
.recog-big-title em { font-style: italic; color: var(--purple); }
.recog-desc { font-size: 14px; color: var(--text-soft); line-height: 1.65; margin-bottom: 24px; }
.press-logos {
    display: flex;
    gap: 18px;
    align-items: center;
    flex-wrap: wrap;
}
.press-logo {
    font-family: var(--font-serif);
    font-style: italic;
    font-size: 19px;
    color: var(--text-soft);
    opacity: 0.55;
    transition: opacity 0.2s;
}
.press-logo:hover { opacity: 1; }

/* ══════════════════════════════════════════
   8. JOIN US CTA
══════════════════════════════════════════ */
.join-section { padding: 0 20px 80px; }
.join-banner {
    max-width: 1120px;
    margin: 0 auto;
    padding: 64px 56px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.join-banner::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, var(--lav-1) 0%, rgba(255,255,255,0.3) 50%, var(--lav-2) 100%);
    pointer-events: none;
}
.join-content { position: relative; z-index: 1; }
.join-title {
    font-family: var(--font-serif);
    font-size: clamp(36px, 5vw, 56px);
    font-weight: 400;
    line-height: 1.1;
    letter-spacing: -0.025em;
    margin-bottom: 16px;
    color: var(--text);
}
.join-title em { font-style: italic; color: var(--purple); }
.join-sub {
    font-size: 16px;
    color: var(--text-soft);
    line-height: 1.6;
    max-width: 520px;
    margin: 0 auto 36px;
}
.join-cards {
    display: flex;
    gap: 16px;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 36px;
}
.join-card {
    padding: 22px 28px;
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 20px;
    text-decoration: none;
    color: var(--text);
    min-width: 200px;
    text-align: center;
    transition: all 0.3s;
    box-shadow: 0 4px 16px rgba(30,58,95,0.04);
}
.join-card:hover {
    background: white;
    transform: translateY(-5px);
    box-shadow: 0 16px 36px rgba(30,58,95,0.1);
    border-color: var(--purple);
}
.join-card-icon { font-size: 32px; margin-bottom: 12px; }
.join-card-title {
    font-family: var(--font-serif);
    font-size: 18px;
    font-weight: 400;
    letter-spacing: -0.01em;
    margin-bottom: 6px;
    color: var(--text);
}
.join-card-desc { font-size: 12px; color: var(--muted); line-height: 1.5; }
.join-trust {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 24px;
    flex-wrap: wrap;
    font-size: 12px;
    color: var(--muted);
    font-weight: 500;
}
.join-trust-item {
    display: flex;
    align-items: center;
    gap: 6px;
}
.join-trust-item i { color: var(--teal); font-size: 13px; }

/* ══════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════ */
@media (max-width: 1280px) {
    .about-stats-bar { grid-template-columns: repeat(3, 1fr); }
    .about-stat-item:nth-child(3)::before { display: none; }
    .values-grid { grid-template-columns: repeat(2, 1fr); }
    .team-grid { grid-template-columns: repeat(2, 1fr); }
    .sdg-cards { grid-template-columns: 1fr; }
    .recog-grid { grid-template-columns: 1fr; }
    .story-grid { grid-template-columns: 1fr; }
}
@media (max-width: 700px) {
    .about-stats-bar { grid-template-columns: repeat(2, 1fr); padding: 20px; }
    .about-stat-item:nth-child(2)::before { display: none; }
    .values-grid { grid-template-columns: 1fr; }
    .team-grid { grid-template-columns: 1fr; }
    .hero-mission-card { padding: 24px; }
    .impact-wrapper { padding: 40px 28px; }
    .join-banner { padding: 40px 24px; }
    .join-cards { flex-direction: column; align-items: center; }
    .join-card { width: 100%; max-width: 320px; }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


<section class="about-hero">
    <div class="container">

        <div class="about-eyebrow">
            <i class="fa-solid fa-circle-info"></i>
            Tentang Kami
        </div>

        <h1 class="about-hero-title">
            Pendidikan berkualitas<br>untuk <em>semua orang</em>
        </h1>
        <p class="about-hero-sub">
            Coursify lahir dari satu keyakinan sederhana: setiap orang berhak mendapatkan akses ke pendidikan terbaik, tanpa batasan geografis maupun finansial.
        </p>

        <div class="about-hero-actions">
            <a href="<?php echo e(route('courses.index')); ?>" class="btn-about-primary">
                <i class="fa-solid fa-graduation-cap"></i>
                Jelajahi Kursus
            </a>
            <a href="#team" class="btn-about-ghost">
                <i class="fa-solid fa-users"></i>
                Kenali Tim Kami
            </a>
        </div>

        
        <div class="glass-card hero-mission-card">
            <div class="hero-mission-label">
                <i class="fa-solid fa-quote-left" style="margin-right:6px;opacity:0.5;"></i>
                Pernyataan Misi
            </div>
            <p class="hero-mission-text">
                "Kami percaya bahwa <strong>akses ke pendidikan berkualitas adalah hak dasar</strong>, bukan hak istimewa. Coursify hadir untuk menghapus batas, memperluas kesempatan, dan membantu setiap pelajar di Indonesia meraih potensi terbaik mereka."
            </p>
            <div class="hero-mission-author">
                <div class="mission-author-avatar">A</div>
                <div class="mission-author-info">
                    <div class="mission-author-name">Andi Nugroho</div>
                    <div class="mission-author-role">Co-founder & CEO, Coursify</div>
                </div>
            </div>
        </div>

    </div>
</section>


<section class="about-stats-section">
    <div class="container">
        <div class="glass-card about-stats-bar">
            <div class="about-stat-item">
                <div class="about-stat-val"><em>50K+</em></div>
                <div class="about-stat-label">Pelajar Aktif</div>
            </div>
            <div class="about-stat-item">
                <div class="about-stat-val"><em>500+</em></div>
                <div class="about-stat-label">Kursus</div>
            </div>
            <div class="about-stat-item">
                <div class="about-stat-val"><em>9</em></div>
                <div class="about-stat-label">Univ. Partner</div>
            </div>
            <div class="about-stat-item">
                <div class="about-stat-val"><em>120+</em></div>
                <div class="about-stat-label">Instruktur</div>
            </div>
            <div class="about-stat-item">
                <div class="about-stat-val"><em>34</em></div>
                <div class="about-stat-label">Kota di Indonesia</div>
            </div>
        </div>
    </div>
</section>


<section class="about-section">
    <div class="about-section-inner container">
        <div class="story-grid">

            
            <div class="story-text-col">
                <div class="story-section-label">
                    <i class="fa-solid fa-book-open" style="margin-right:6px;"></i>
                    Cerita Kami
                </div>
                <h2 class="story-title">
                    Dari sebuah<br><em>kamar kos</em> di Bandung
                </h2>
                <p class="story-body">
                    Coursify dimulai pada 2022 ketika <strong>Andi Nugroho</strong>, seorang mahasiswa tingkat akhir di ITB, frustasi melihat teman-temannya kesulitan mengakses materi kuliah berkualitas hanya karena keterbatasan biaya dan lokasi.
                </p>
                <p class="story-body">
                    Bersama tiga sahabatnya, Andi membangun prototipe pertama Coursify di laptop yang sama yang dipakai untuk mengerjakan tugas akhir. Dalam 3 bulan, platform ini sudah diakses oleh lebih dari 500 mahasiswa dari Sabang sampai Merauke.
                </p>
                <p class="story-body">
                    Hari ini, Coursify telah berkembang menjadi platform e-learning terpercaya dengan <strong>9 universitas partner</strong>, <strong>500+ kursus</strong>, dan ribuan alumni yang telah mengubah karier mereka.
                </p>
            </div>

            
            <div class="glass-card story-timeline">
                <?php
                    $milestones = [
                        ['year' => '2022', 'badge' => '', 'title' => 'Coursify Didirikan', 'desc' => 'Prototipe pertama diluncurkan di Bandung oleh 4 co-founder.'],
                        ['year' => '2023', 'badge' => 'badge-teal', 'title' => 'Kemitraan Pertama', 'desc' => 'UI dan ITB bergabung sebagai universitas partner pertama.'],
                        ['year' => '2023', 'badge' => 'badge-orange', 'title' => '10.000 Pelajar', 'desc' => 'Milestone 10 ribu pelajar aktif tercapai dalam 8 bulan.'],
                        ['year' => '2024', 'badge' => 'badge-navy', 'title' => 'Ekspansi Nasional', 'desc' => '9 universitas, 34 kota, dan 500+ kursus tersedia.'],
                        ['year' => '2025', 'badge' => '', 'title' => '50K+ Pelajar', 'desc' => 'Coursify kini melayani lebih dari 50.000 pelajar aktif.'],
                    ];
                ?>

                <?php $__currentLoopData = $milestones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="timeline-item">
                        <div class="timeline-year-badge <?php echo e($m['badge']); ?>">
                            <?php echo e(substr($m['year'], 2)); ?>

                        </div>
                        <div class="timeline-content">
                            <div class="timeline-year-label"><?php echo e($m['year']); ?></div>
                            <div class="timeline-event-title"><?php echo e($m['title']); ?></div>
                            <div class="timeline-event-desc"><?php echo e($m['desc']); ?></div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

        </div>
    </div>
</section>


<section class="values-section">
    <div class="container">
        <div class="values-header">
            <div class="about-eyebrow">
                <i class="fa-solid fa-heart"></i>
                Nilai-nilai Kami
            </div>
            <h2 class="values-title">Prinsip yang <em>memandu</em> kami</h2>
            <p class="values-sub">Empat pilar yang menjadi fondasi setiap keputusan yang kami buat.</p>
        </div>

        <div class="values-grid">
            <?php
                $values = [
                    [
                        'icon' => 'fa-medal',
                        'icon_class' => 'icon-purple',
                        'name' => 'Kualitas Tanpa Kompromi',
                        'desc' => 'Setiap kursus melalui proses kurasi ketat. Kami hanya bermitra dengan instruktur dan institusi terbaik yang telah terbukti di industri.',
                    ],
                    [
                        'icon' => 'fa-door-open',
                        'icon_class' => 'icon-teal',
                        'name' => 'Aksesibilitas untuk Semua',
                        'desc' => 'Pendidikan bukan untuk segelintir orang. Kami menawarkan ratusan kursus gratis dan program beasiswa untuk pelajar yang membutuhkan.',
                    ],
                    [
                        'icon' => 'fa-people-group',
                        'icon_class' => 'icon-orange',
                        'name' => 'Kekuatan Komunitas',
                        'desc' => 'Belajar bersama lebih powerful dari belajar sendiri. Kami membangun ekosistem di mana pelajar saling mendukung dan tumbuh bersama.',
                    ],
                    [
                        'icon' => 'fa-lightbulb',
                        'icon_class' => 'icon-navy',
                        'name' => 'Inovasi Berkelanjutan',
                        'desc' => 'Dunia terus berubah, begitu pula konten kami. Kami secara aktif memperbarui kurikulum agar selalu relevan dengan kebutuhan industri.',
                    ],
                ];
            ?>

            <?php $__currentLoopData = $values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="glass-card value-card">
                    <div class="value-icon-wrap <?php echo e($v['icon_class']); ?>">
                        <i class="fa-solid <?php echo e($v['icon']); ?>"></i>
                    </div>
                    <div class="value-name"><?php echo e($v['name']); ?></div>
                    <p class="value-desc"><?php echo e($v['desc']); ?></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>


<section class="team-section" id="team">
    <div class="container">
        <div class="team-header">
            <div class="about-eyebrow">
                <i class="fa-solid fa-users"></i>
                Tim Kami
            </div>
            <h2 class="team-title">Orang-orang di balik <em>Coursify</em></h2>
            <p class="team-sub">Tim kecil dengan mimpi besar — berdedikasi untuk merevolusi pendidikan Indonesia.</p>
        </div>

        <div class="team-grid">
    <?php
        $team = [
    [
        'initial' => 'A',
        'color'   => 'team-avatar-a',
        'photo'   => '',
        'name'    => 'Dennis Panjaitan',
        'role'    => 'Frontend Developer',
        'bio'     => 'Alumni ITB. Sebelumnya product lead di Gojek. Obsesi: membuat belajar menjadi hal yang menyenangkan.',
        'socials' => [
            ['icon' => 'fa-linkedin-in', 'url' => 'https://linkedin.com/in/username'],
            ['icon' => 'fa-github',      'url' => 'https://github.com/username'],
            ['icon' => 'fa-instagram',   'url' => 'https://instagram.com/username'],
        ],
    ],
    [
        'initial' => 'D',
        'color'   => 'team-avatar-b',
        'photo'   => 'jupar.jpg',
        'name'    => 'Abdullah Jufar',
        'role'    => 'Backend Developer',
        'bio'     => 'Engineer backend berpengalaman 8 tahun. Arsitek infrastruktur platform Coursify dari hari pertama.',
        'socials' => [
            ['icon' => 'fa-linkedin-in', 'url' => 'https://linkedin.com/in/username'],
            ['icon' => 'fa-github',      'url' => 'https://github.com/username'],
            ['icon' => 'fa-instagram',   'url' => 'https://instagram.com/username'],
        ],
    ],
    [
        'initial' => 'R',
        'color'   => 'team-avatar-c',
        'photo'   => 'agi.jpg',
        'name'    => 'Agi Aginta',
        'role'    => 'Lead Designer',
        'bio'     => 'Designer dan product thinker. Bertanggung jawab atas setiap piksel yang ada di Coursify.',
        'socials' => [
            ['icon' => 'fa-linkedin-in', 'url' => 'https://linkedin.com/in/username'],
            ['icon' => 'fa-github',      'url' => 'https://github.com/username'],
            ['icon' => 'fa-instagram',   'url' => 'https://instagram.com/username'],
        ],
    ],
    [
        'initial' => 'M',
        'color'   => 'team-avatar-d',
        'photo'   => '',
        'name'    => 'Randi Abdiansyah',
        'role'    => 'UI/UX Designer',
        'bio'     => 'Membangun jembatan antara Coursify dan universitas-universitas partner terbaik Indonesia.',
        'socials' => [
            ['icon' => 'fa-linkedin-in', 'url' => 'https://linkedin.com/in/username'],
            ['icon' => 'fa-github',      'url' => 'https://github.com/username'],
            ['icon' => 'fa-instagram',   'url' => 'https://instagram.com/username'],
        ],
    ],
    [
        'initial' => 'B',
        'color'   => 'team-avatar-e',
        'photo'   => 'renald.png',
        'name'    => 'Reynald Alvaro',
        'role'    => 'Frontend Developer',
        'bio'     => 'Mantan mahasiswa di UNIMED.',
        'socials' => [
            ['icon' => 'fa-linkedin-in', 'url' => 'https://linkedin.com/in/username'],
            ['icon' => 'fa-github',      'url' => 'https://github.com/username'],
            ['icon' => 'fa-instagram',   'url' => 'https://instagram.com/username'],
        ],
    ],
];
    ?>

    <?php $__currentLoopData = $team; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="glass-card team-card">
            <div class="team-avatar <?php echo e($member['color']); ?>">
                <?php if(!empty($member['photo'])): ?>
                    <img src="<?php echo e(asset('images/team/' . $member['photo'])); ?>"
                         alt="<?php echo e($member['name']); ?>"
                         style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                <?php else: ?>
                    <?php echo e($member['initial']); ?>

                <?php endif; ?>
            </div>
                    <div class="team-name"><?php echo e($member['name']); ?></div>
                    <div class="team-role"><?php echo e($member['role']); ?></div>
                    <p class="team-bio"><?php echo e($member['bio']); ?></p>
                    <div class="team-socials">
                        <?php $__currentLoopData = $member['socials']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <a href="<?php echo e($social['url']); ?>" class="team-social-btn"
       aria-label="<?php echo e($social['icon']); ?>"
       target="_blank" rel="noopener noreferrer">
        <i class="fa-brands <?php echo e($social['icon']); ?>"></i>
    </a>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>


<section class="impact-section">
    <div class="container">
        <div class="impact-wrapper">
            <div class="impact-content">
                <div class="impact-header">
                    <div class="impact-eyebrow">
                        <i class="fa-solid fa-earth-asia" style="margin-right:6px;"></i>
                        Sustainable Development Goals
                    </div>
                    <h2 class="impact-title">
                        Dampak nyata untuk<br><em>Sekitar</em>
                    </h2>
                    <p class="impact-sub">
                        Coursify berkomitmen mendukung Tujuan Pembangunan Berkelanjutan melalui platform kami.
                    </p>
                </div>

                <div class="sdg-cards">
                    <?php
                        $sdgs = [
                            [
                                'number' => '4',
                                'code' => 'SDG 4',
                                'title' => 'Pendidikan Berkualitas',
                                'desc' => 'Menjamin pendidikan yang inklusif dan setara, serta mendorong kesempatan belajar sepanjang hayat bagi semua.',
                                'progress' => 72,
                                'target' => '100K pelajar gratis pada 2026',
                            ],
                            [
                                'number' => '8',
                                'code' => 'SDG 8',
                                'title' => 'Pekerjaan Layak',
                                'desc' => 'Membekali 50K+ pelajar dengan keterampilan yang dibutuhkan industri untuk mendapatkan pekerjaan yang layak.',
                                'progress' => 55,
                                'target' => '10K alumni bekerja pada 2026',
                            ],
                            [
                                'number' => '10',
                                'code' => 'SDG 10',
                                'title' => 'Mengurangi Kesenjangan',
                                'desc' => 'Menghapus kesenjangan akses pendidikan antara kota besar dan daerah terpencil di seluruh Indonesia.',
                                'progress' => 40,
                                'target' => '100 kota tercover pada 2027',
                            ],
                        ];
                    ?>

                    <?php $__currentLoopData = $sdgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sdg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="sdg-card">
                            <div class="sdg-number-badge"><?php echo e($sdg['number']); ?></div>
                            <div class="sdg-code"><?php echo e($sdg['code']); ?></div>
                            <div class="sdg-card-title"><?php echo e($sdg['title']); ?></div>
                            <p class="sdg-card-desc"><?php echo e($sdg['desc']); ?></p>
                            <div class="sdg-progress">
                                <div class="sdg-progress-label">
                                    <span>Progres</span>
                                    <span><?php echo e($sdg['progress']); ?>% — <?php echo e($sdg['target']); ?></span>
                                </div>
                                <div class="sdg-progress-bar">
                                    <div class="sdg-progress-fill" style="width: <?php echo e($sdg['progress']); ?>%;"></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="recognition-section">
    <div class="container">
        <div class="recog-grid">

            
            <div class="recog-left">
                <?php
                    $awards = [
                        [
                            'icon' => '🏆', 'icon_class' => 'ai-gold',
                            'year' => 'Kemendikbud 2024',
                            'name' => 'Platform EdTech Terbaik',
                            'org' => 'Penghargaan Inovasi Pendidikan Indonesia',
                        ],
                        [
                            'icon' => '⭐', 'icon_class' => 'ai-purple',
                            'year' => 'Google for Startups 2023',
                            'name' => 'Top 10 Startup Pendidikan',
                            'org' => 'Google for Startups Southeast Asia',
                        ],
                        [
                            'icon' => '🌱', 'icon_class' => 'ai-teal',
                            'year' => 'UNDP Indonesia 2024',
                            'name' => 'SDG Innovation Award',
                            'org' => 'United Nations Development Programme',
                        ],
                    ];
                ?>

                <?php $__currentLoopData = $awards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $award): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="glass-card award-item">
                        <div class="award-icon <?php echo e($award['icon_class']); ?>">
                            <?php echo e($award['icon']); ?>

                        </div>
                        <div>
                            <div class="award-year"><?php echo e($award['year']); ?></div>
                            <div class="award-name"><?php echo e($award['name']); ?></div>
                            <div class="award-org"><?php echo e($award['org']); ?></div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <div class="glass-card recog-right">
                <div class="recog-right-eyebrow">
                    <i class="fa-solid fa-newspaper" style="margin-right:5px;"></i>
                    Media & Pengakuan
                </div>
                <h3 class="recog-big-title">
                    Dipercaya oleh<br><em>media nasional</em>
                </h3>
                <p class="recog-desc">
                    Perjalanan Coursify telah diliput oleh berbagai media teknologi dan pendidikan terkemuka di Indonesia. Komitmen kami terhadap kualitas dan aksesibilitas mendapat pengakuan luas.
                </p>
                <div class="press-logos">
                    <span class="press-logo">Kompas</span>
                    <span class="press-logo">Tempo</span>
                    <span class="press-logo">Detik</span>
                    <span class="press-logo">IDN Times</span>
                    <span class="press-logo">Katadata</span>
                </div>
            </div>

        </div>
    </div>
</section>


<section class="join-section">
    <div class="container">
        <div class="glass-card join-banner">
            <div class="join-content">
                <div class="about-eyebrow" style="margin-bottom:20px;">
                    <i class="fa-solid fa-rocket"></i>
                    Bergabung Bersama Kami
                </div>
                <h2 class="join-title">
                    Jadilah bagian dari<br><em>misi kami</em>
                </h2>
                <p class="join-sub">
                    Ada banyak cara untuk berkontribusi dalam revolusi pendidikan Indonesia. Pilih peranmu.
                </p>

                <div class="join-cards">
                    <a href="<?php echo e(route('register')); ?>" class="join-card">
                        <div class="join-card-icon">🎓</div>
                        <div class="join-card-title">Mulai Belajar</div>
                        <p class="join-card-desc">Akses ratusan kursus gratis dan mulai perjalananmu hari ini.</p>
                    </a>
                    <a href="<?php echo e(route('register')); ?>" class="join-card">
                        <div class="join-card-icon">🧑‍🏫</div>
                        <div class="join-card-title">Jadi Instruktur</div>
                        <p class="join-card-desc">Bagikan keahlianmu dan monetisasi pengetahuanmu.</p>
                    </a>
                    <a href="<?php echo e(route('universities')); ?>" class="join-card">
                        <div class="join-card-icon">🤝</div>
                        <div class="join-card-title">Partner Universitas</div>
                        <p class="join-card-desc">Bawa universitas Anda bergabung dalam ekosistem Coursify.</p>
                    </a>
                    <a href="#" class="join-card">
                        <div class="join-card-icon">💼</div>
                        <div class="join-card-title">Karir di Coursify</div>
                        <p class="join-card-desc">Kami sedang mencari talenta terbaik untuk bergabung di tim kami.</p>
                    </a>
                </div>

                <div class="join-trust">
                    <div class="join-trust-item">
                        <i class="fa-solid fa-shield-halved"></i>
                        Gratis untuk memulai
                    </div>
                    <div class="join-trust-item">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        Belajar kapan saja
                    </div>
                    <div class="join-trust-item">
                        <i class="fa-solid fa-certificate"></i>
                        Sertifikat terverifikasi
                    </div>
                    <div class="join-trust-item">
                        <i class="fa-solid fa-earth-asia"></i>
                        50K+ komunitas aktif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
/* ── Scroll reveal ── */
(function () {
    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    var targets = document.querySelectorAll(
        '.value-card, .team-card, .sdg-card, .award-item, .timeline-item, .join-card'
    );
    targets.forEach(function (el, i) {
        el.style.opacity = '0';
        el.style.transform = 'translateY(22px)';
        el.style.transition = 'opacity 0.6s ease ' + (i * 0.06) + 's, transform 0.6s ease ' + (i * 0.06) + 's';
        observer.observe(el);
    });
})();

/* ── SDG progress bar animate on scroll ── */
(function () {
    var animated = false;
    var section = document.querySelector('.impact-section');
    if (!section) return;

    var progObserver = new IntersectionObserver(function (entries) {
        if (entries[0].isIntersecting && !animated) {
            animated = true;
            document.querySelectorAll('.sdg-progress-fill').forEach(function (bar) {
                var width = bar.style.width;
                bar.style.width = '0';
                setTimeout(function () {
                    bar.style.transition = 'width 1.2s cubic-bezier(0.4, 0, 0.2, 1)';
                    bar.style.width = width;
                }, 200);
            });
        }
    }, { threshold: 0.3 });
    progObserver.observe(section);
})();

/* ── Count-up for stats ── */
(function () {
    var counted = false;
    var statsSection = document.querySelector('.about-stats-section');
    if (!statsSection) return;

    var statObserver = new IntersectionObserver(function (entries) {
        if (entries[0].isIntersecting && !counted) {
            counted = true;
            statsSection.querySelectorAll('.about-stat-val em').forEach(function (el) {
                var raw = el.textContent.trim();
                var num = parseFloat(raw.replace(/[^0-9.]/g, ''));
                var suffix = raw.replace(/[0-9.]/g, '');
                var start = 0;
                var duration = 1800;
                var startTime = performance.now();

                function update(now) {
                    var progress = Math.min((now - startTime) / duration, 1);
                    var ease = 1 - Math.pow(1 - progress, 3);
                    var current = Math.floor(num * ease);
                    el.textContent = current + suffix;
                    if (progress < 1) requestAnimationFrame(update);
                    else el.textContent = raw;
                }
                requestAnimationFrame(update);
            });
        }
    }, { threshold: 0.5 });
    statObserver.observe(statsSection);
})();
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\coursify\resources\views/about.blade.php ENDPATH**/ ?>