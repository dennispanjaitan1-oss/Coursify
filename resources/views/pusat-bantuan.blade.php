@extends('layouts.app') {{-- Sesuaikan dengan nama file layout kamu --}}

@section('title', 'Pusat Panduan — Coursify')

@push('styles')
<style>
/* ══════════════════ TOKENS ══════════════════ */
:root {
  --navy:         #1E3A5F;
  --purple:       #7B6FE8;
  --purple-dark:  #5A4FD4;
  --purple-light: #9F94F2;
  --teal:         #0CB898;
  --orange:       #FF6B35;
  --gold:         #F4B942;
  --text:         #1A2540;
  --text-soft:    #4A5568;
  --muted:        #8896A8;
  --lav-1:        #F4F3FD;
  --lav-2:        #EAE8FA;
  --lav-3:        #D4D0F5;
  --bg:           #F7F8FC;
  --white:        #FFFFFF;
  --font-serif:   'Lora', Georgia, serif;
  --font-sans:    'DM Sans', sans-serif;
  --radius-sm:    10px;
  --radius-md:    16px;
  --radius-lg:    24px;
  --shadow-sm:    0 2px 12px rgba(30,58,95,0.07);
  --shadow-md:    0 6px 24px rgba(30,58,95,0.1);
  --shadow-lg:    0 12px 40px rgba(30,58,95,0.12);
}

/* ══════════════════ RESET ══════════════════ */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{font-family:var(--font-sans);background:var(--bg);color:var(--text);min-height:100vh;overflow-x:hidden}

/* ══════════════════ BG DECORATION ══════════════════ */
body::before{
  content:'';position:fixed;inset:0;
  background:
    radial-gradient(ellipse 80% 60% at 10% -10%, rgba(123,111,232,0.1) 0%, transparent 60%),
    radial-gradient(ellipse 60% 50% at 90% 110%, rgba(12,184,152,0.08) 0%, transparent 55%),
    radial-gradient(ellipse 50% 40% at 50% 50%, rgba(244,185,66,0.04) 0%, transparent 70%);
  pointer-events:none;z-index:0;
}

/* ══════════════════ HERO ══════════════════ */
.hero{
  position:relative;z-index:1;
  text-align:center;
  padding:64px 24px 52px;
}
.hero-eyebrow{
  display:inline-flex;align-items:center;gap:7px;
  background:rgba(123,111,232,0.1);border:1px solid rgba(123,111,232,0.2);
  color:var(--purple-dark);font-size:11px;font-weight:700;
  letter-spacing:.1em;text-transform:uppercase;
  padding:6px 16px;border-radius:100px;margin-bottom:22px;
}
.hero-title{
  font-family:var(--font-serif);
  font-size:clamp(38px,6vw,68px);font-weight:400;
  line-height:1.08;letter-spacing:-0.025em;
  margin-bottom:18px;color:var(--text);
}
.hero-title em{
  font-style:italic;
  background:linear-gradient(135deg,#9F94F2,#7B6FE8,#5A4FD4);
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.hero-sub{
  font-size:16px;color:var(--text-soft);line-height:1.65;
  max-width:500px;margin:0 auto 40px;
}

/* Search */
.search-wrap{max-width:580px;margin:0 auto;position:relative}
.search-icon{
  position:absolute;left:20px;top:50%;transform:translateY(-50%);
  color:var(--muted);font-size:16px;pointer-events:none;z-index:1;
}
.search-input{
  width:100%;padding:17px 130px 17px 52px;
  background:rgba(255,255,255,0.92);backdrop-filter:blur(20px);
  border:2px solid rgba(255,255,255,0.95);border-radius:100px;
  font-family:var(--font-sans);font-size:15px;color:var(--text);
  outline:none;transition:all .25s;
  box-shadow:0 8px 30px rgba(30,58,95,0.1),0 2px 8px rgba(30,58,95,0.05);
}
.search-input::placeholder{color:var(--muted)}
.search-input:focus{
  background:white;border-color:var(--purple);
  box-shadow:0 0 0 5px rgba(123,111,232,0.12),0 8px 30px rgba(30,58,95,0.1);
}
.search-btn{
  position:absolute;right:6px;top:50%;transform:translateY(-50%);
  padding:11px 22px;border-radius:100px;
  background:var(--navy);color:white;border:none;cursor:pointer;
  font-family:var(--font-sans);font-size:13px;font-weight:600;
  transition:all .2s;display:flex;align-items:center;gap:7px;
  box-shadow:0 3px 10px rgba(30,58,95,0.25);
}
.search-btn:hover{background:#2D4D7A}
.search-clear{
  position:absolute;right:104px;top:50%;transform:translateY(-50%);
  width:28px;height:28px;border-radius:50%;
  background:var(--lav-2);border:none;cursor:pointer;
  color:var(--muted);font-size:12px;
  display:none;align-items:center;justify-content:center;
  transition:all .2s;z-index:2;
}
.search-clear.visible{display:flex}
.search-clear:hover{background:var(--lav-3);color:var(--text)}
.search-suggestions{
  position:absolute;top:calc(100% + 8px);left:0;right:0;
  background:white;border:1px solid rgba(123,111,232,0.15);
  border-radius:var(--radius-md);box-shadow:var(--shadow-lg);
  overflow:hidden;z-index:50;display:none;
}
.search-suggestions.visible{display:block}
.suggestion-item{
  display:flex;align-items:center;gap:12px;
  padding:12px 18px;cursor:pointer;transition:background .15s;
  font-size:14px;color:var(--text-soft);border-bottom:1px solid rgba(30,58,95,0.05);
}
.suggestion-item:last-child{border-bottom:none}
.suggestion-item:hover{background:var(--lav-1);color:var(--text)}
.suggestion-item i{color:var(--purple);font-size:13px;width:16px;text-align:center}

/* Stats bar */
.hero-stats{
  display:flex;justify-content:center;gap:32px;flex-wrap:wrap;
  margin-top:36px;
}
.stat-chip{
  display:flex;align-items:center;gap:8px;
  font-size:13px;color:var(--text-soft);
  background:rgba(255,255,255,0.6);border:1px solid rgba(255,255,255,0.9);
  padding:8px 16px;border-radius:100px;
  backdrop-filter:blur(12px);
}
.stat-chip strong{color:var(--text);font-weight:700}
.stat-chip i{color:var(--purple);font-size:12px}

/* ══════════════════ TOPIC GRID ══════════════════ */
.section{position:relative;z-index:1;padding:0 24px 60px}
.section-inner{max-width:1100px;margin:0 auto}
.section-header{
  display:flex;align-items:baseline;justify-content:space-between;
  gap:16px;margin-bottom:20px;flex-wrap:wrap;
}
.section-label{
  font-size:11px;font-weight:700;letter-spacing:.1em;
  text-transform:uppercase;color:var(--muted);
}
.section-title{
  font-family:var(--font-serif);font-size:clamp(22px,3vw,30px);
  font-weight:400;letter-spacing:-0.015em;color:var(--text);
  margin-top:4px;
}
.see-all{
  font-size:13px;font-weight:600;color:var(--purple);
  text-decoration:none;display:flex;align-items:center;gap:5px;
  transition:gap .2s;white-space:nowrap;
}
.see-all:hover{gap:8px}

/* Topic cards */
.topics-grid{
  display:grid;
  grid-template-columns:repeat(auto-fill,minmax(200px,1fr));
  gap:14px;
}
.topic-card{
  background:rgba(255,255,255,0.75);backdrop-filter:blur(20px);
  border:1px solid rgba(255,255,255,0.92);border-radius:var(--radius-md);
  padding:22px 18px;cursor:pointer;
  transition:all .25s;text-decoration:none;display:block;
  box-shadow:var(--shadow-sm);position:relative;overflow:hidden;
}
.topic-card::before{
  content:'';position:absolute;inset:0;
  background:linear-gradient(135deg,var(--card-from,rgba(123,111,232,0.05)),var(--card-to,transparent));
  opacity:0;transition:opacity .25s;
}
.topic-card:hover{
  transform:translateY(-3px);border-color:var(--card-border,rgba(123,111,232,0.3));
  box-shadow:var(--shadow-md);
}
.topic-card:hover::before{opacity:1}
.topic-icon{
  width:44px;height:44px;border-radius:12px;
  display:flex;align-items:center;justify-content:center;
  font-size:18px;margin-bottom:14px;
  background:var(--icon-bg);color:var(--icon-color);
  transition:transform .25s;
}
.topic-card:hover .topic-icon{transform:scale(1.1) rotate(-3deg)}
.topic-name{
  font-size:14px;font-weight:600;color:var(--text);
  margin-bottom:4px;
}
.topic-count{font-size:12px;color:var(--muted)}
.topic-arrow{
  position:absolute;right:16px;top:50%;transform:translateY(-50%);
  font-size:12px;color:var(--muted);opacity:0;transition:all .2s;
}
.topic-card:hover .topic-arrow{opacity:1;right:13px}

/* ══════════════════ FEATURED ARTICLES ══════════════════ */
.articles-grid{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:14px;
}
.article-card{
  background:rgba(255,255,255,0.75);backdrop-filter:blur(20px);
  border:1px solid rgba(255,255,255,0.92);border-radius:var(--radius-md);
  padding:22px 24px;cursor:pointer;transition:all .25s;
  text-decoration:none;display:block;box-shadow:var(--shadow-sm);
  position:relative;overflow:hidden;
}
.article-card:hover{
  transform:translateY(-2px);border-color:rgba(123,111,232,0.25);
  box-shadow:var(--shadow-md);
}
.article-meta{
  display:flex;align-items:center;gap:10px;margin-bottom:12px;flex-wrap:wrap;
}
.article-cat{
  font-size:10px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;
  padding:3px 10px;border-radius:100px;
}
.article-readtime{font-size:12px;color:var(--muted)}
.article-title{
  font-size:15px;font-weight:600;color:var(--text);
  line-height:1.4;margin-bottom:8px;
}
.article-card:hover .article-title{color:var(--purple-dark)}
.article-excerpt{font-size:13px;color:var(--text-soft);line-height:1.65;margin-bottom:14px}
.article-footer{
  display:flex;align-items:center;justify-content:space-between;
  gap:8px;
}
.article-views{font-size:11px;color:var(--muted);display:flex;align-items:center;gap:5px}
.article-link{
  font-size:12px;font-weight:600;color:var(--purple);
  display:flex;align-items:center;gap:5px;transition:gap .2s;
}
.article-card:hover .article-link{gap:8px}

/* ══════════════════ POPULAR SEARCHES ══════════════════ */
.popular-wrap{margin-top:18px;display:flex;flex-wrap:wrap;gap:8px}
.popular-tag{
  display:inline-flex;align-items:center;gap:6px;
  padding:7px 16px;border-radius:100px;
  background:rgba(255,255,255,0.72);border:1px solid rgba(255,255,255,0.9);
  font-size:13px;color:var(--text-soft);cursor:pointer;
  transition:all .2s;backdrop-filter:blur(12px);
  box-shadow:var(--shadow-sm);text-decoration:none;
}
.popular-tag:hover{
  background:rgba(123,111,232,0.1);border-color:rgba(123,111,232,0.25);
  color:var(--purple-dark);transform:translateY(-1px);
}
.popular-tag i{font-size:11px;color:var(--muted)}

/* ══════════════════ STEP ARTICLES (tutorial format) ══════════════════ */
.step-section{
  background:rgba(255,255,255,0.55);backdrop-filter:blur(20px);
  border:1px solid rgba(255,255,255,0.9);border-radius:var(--radius-lg);
  padding:32px 36px;box-shadow:var(--shadow-sm);
}
.steps-list{display:flex;flex-direction:column;gap:0}
.step-item{
  display:flex;gap:20px;padding:18px 0;
  border-bottom:1px solid rgba(30,58,95,0.06);cursor:pointer;
  text-decoration:none;transition:all .2s;position:relative;
}
.step-item:last-child{border-bottom:none}
.step-item:hover{padding-left:6px}
.step-num{
  width:32px;height:32px;border-radius:50%;flex-shrink:0;
  background:linear-gradient(135deg,var(--purple),var(--purple-dark));
  color:white;font-size:13px;font-weight:700;
  display:flex;align-items:center;justify-content:center;
  box-shadow:0 3px 10px rgba(123,111,232,0.3);margin-top:2px;
}
.step-body{flex:1}
.step-title{font-size:14.5px;font-weight:600;color:var(--text);margin-bottom:4px}
.step-item:hover .step-title{color:var(--purple-dark)}
.step-desc{font-size:13px;color:var(--text-soft);line-height:1.6}
.step-badge{
  margin-left:8px;font-size:10px;font-weight:700;
  letter-spacing:.05em;text-transform:uppercase;
  padding:2px 8px;border-radius:100px;
  background:rgba(12,184,152,0.12);color:#009970;vertical-align:middle;
}

/* ══════════════════ VIDEO TUTORIALS ══════════════════ */
.video-grid{
  display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));
  gap:14px;
}
.video-card{
  background:rgba(255,255,255,0.75);backdrop-filter:blur(20px);
  border:1px solid rgba(255,255,255,0.92);border-radius:var(--radius-md);
  overflow:hidden;cursor:pointer;transition:all .25s;
  box-shadow:var(--shadow-sm);text-decoration:none;display:block;
}
.video-card:hover{transform:translateY(-3px);box-shadow:var(--shadow-md)}
.video-thumb{
  height:148px;position:relative;overflow:hidden;
  display:flex;align-items:center;justify-content:center;
}
.video-thumb-bg{
  position:absolute;inset:0;
  display:flex;align-items:center;justify-content:center;font-size:48px;
}
.video-play{
  width:48px;height:48px;border-radius:50%;
  background:rgba(255,255,255,0.92);backdrop-filter:blur(8px);
  display:flex;align-items:center;justify-content:center;
  font-size:16px;color:var(--navy);z-index:1;
  box-shadow:0 4px 16px rgba(0,0,0,0.15);transition:transform .2s;
}
.video-card:hover .video-play{transform:scale(1.1)}
.video-duration{
  position:absolute;bottom:10px;right:10px;z-index:1;
  background:rgba(0,0,0,0.65);color:white;font-size:11px;font-weight:600;
  padding:3px 8px;border-radius:6px;
}
.video-body{padding:16px}
.video-cat{
  font-size:10px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;
  color:var(--purple);margin-bottom:6px;
}
.video-title{font-size:14px;font-weight:600;color:var(--text);line-height:1.4}
.video-card:hover .video-title{color:var(--purple-dark)}

/* ══════════════════ CONTACT SECTION ══════════════════ */
.contact-section{
  position:relative;z-index:1;padding:0 24px 80px;
}
.contact-grid{
  max-width:1100px;margin:0 auto;
  display:grid;grid-template-columns:repeat(3,1fr);gap:14px;
}
.contact-card{
  background:rgba(255,255,255,0.72);backdrop-filter:blur(20px);
  border:1px solid rgba(255,255,255,0.9);border-radius:var(--radius-md);
  padding:28px 24px;text-align:center;
  box-shadow:var(--shadow-sm);transition:all .25s;
  cursor:pointer;text-decoration:none;display:block;
}
.contact-card:hover{transform:translateY(-3px);box-shadow:var(--shadow-md)}
.contact-icon{
  width:56px;height:56px;border-radius:16px;
  display:flex;align-items:center;justify-content:center;
  font-size:22px;margin:0 auto 16px;
}
.contact-title{font-size:16px;font-weight:700;color:var(--text);margin-bottom:6px}
.contact-desc{font-size:13px;color:var(--text-soft);line-height:1.6;margin-bottom:16px}
.contact-meta{
  font-size:12px;font-weight:600;color:var(--purple);
  display:flex;align-items:center;justify-content:center;gap:5px;
}

/* ══════════════════ SEARCH RESULTS ══════════════════ */
.search-results-panel{
  display:none;position:relative;z-index:1;
  padding:0 24px 60px;
}
.search-results-panel.visible{display:block}
.search-result-header{
  max-width:1100px;margin:0 auto 20px;
  display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;
}
.search-result-title{font-size:15px;color:var(--text-soft)}
.search-result-title strong{color:var(--text)}
.search-result-back{
  font-size:13px;font-weight:600;color:var(--purple);
  background:none;border:none;cursor:pointer;
  display:flex;align-items:center;gap:6px;transition:gap .2s;
}
.search-result-back:hover{gap:9px}
.search-results-list{max-width:1100px;margin:0 auto;display:flex;flex-direction:column;gap:10px}
.result-item{
  background:rgba(255,255,255,0.75);backdrop-filter:blur(20px);
  border:1px solid rgba(255,255,255,0.92);border-radius:var(--radius-md);
  padding:20px 24px;cursor:pointer;transition:all .25s;
  text-decoration:none;display:block;box-shadow:var(--shadow-sm);
}
.result-item:hover{
  border-color:rgba(123,111,232,0.3);transform:translateX(4px);
  box-shadow:var(--shadow-md);
}
.result-item-top{display:flex;align-items:flex-start;gap:14px}
.result-item-icon{
  width:38px;height:38px;border-radius:10px;flex-shrink:0;
  display:flex;align-items:center;justify-content:center;font-size:15px;
}
.result-item-body{flex:1}
.result-item-title{font-size:15px;font-weight:600;color:var(--text);margin-bottom:4px}
.result-item:hover .result-item-title{color:var(--purple-dark)}
.result-item-desc{font-size:13px;color:var(--text-soft);line-height:1.6}
.result-item-foot{
  display:flex;align-items:center;gap:8px;margin-top:10px;
  font-size:11px;color:var(--muted);
}
.result-highlight{background:rgba(123,111,232,0.15);color:var(--purple-dark);
  padding:1px 4px;border-radius:4px;font-weight:600}
.no-results-block{
  max-width:1100px;margin:0 auto;text-align:center;padding:60px 24px;
  background:rgba(255,255,255,0.5);border:1px solid rgba(255,255,255,0.8);
  border-radius:var(--radius-lg);
}
.no-results-icon{font-size:48px;color:var(--lav-3);margin-bottom:16px}
.no-results-title{
  font-family:var(--font-serif);font-size:24px;font-weight:400;
  color:var(--text);margin-bottom:8px;
}
.no-results-desc{font-size:14px;color:var(--muted)}

/* ══════════════════ ANNOUNCEMENT BAR ══════════════════ */
.announcement{
  background:linear-gradient(90deg,var(--purple-dark),var(--purple));
  color:white;text-align:center;padding:10px 24px;
  font-size:13px;font-weight:500;position:relative;z-index:200;
}
.announcement strong{font-weight:700}
.announcement a{color:rgba(255,255,255,0.85);text-decoration:underline;margin-left:6px}
.announcement-close{
  position:absolute;right:16px;top:50%;transform:translateY(-50%);
  background:none;border:none;color:white;cursor:pointer;opacity:.7;font-size:16px;
}
.announcement-close:hover{opacity:1}

/* ══════════════════ ARTICLE MODAL ══════════════════ */
.modal-overlay{
  position:fixed;inset:0;background:rgba(20,30,60,0.55);
  backdrop-filter:blur(6px);z-index:1000;
  display:flex;align-items:center;justify-content:center;padding:20px;
  opacity:0;pointer-events:none;transition:opacity .3s;
}
.modal-overlay.open{opacity:1;pointer-events:all}
.modal{
  background:white;border-radius:var(--radius-lg);
  width:100%;max-width:680px;max-height:85vh;overflow-y:auto;
  box-shadow:0 24px 80px rgba(30,58,95,0.2);
  transform:translateY(20px) scale(0.98);
  transition:transform .3s;
}
.modal-overlay.open .modal{transform:translateY(0) scale(1)}
.modal-header{
  padding:28px 32px 20px;
  border-bottom:1px solid rgba(30,58,95,0.07);
  position:sticky;top:0;background:white;z-index:1;
  display:flex;align-items:flex-start;gap:16px;
}
.modal-icon{
  width:48px;height:48px;border-radius:14px;
  display:flex;align-items:center;justify-content:center;
  font-size:20px;flex-shrink:0;
}
.modal-title-block{flex:1}
.modal-cat{
  font-size:10px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;
  margin-bottom:6px;display:block;
}
.modal-title{font-family:var(--font-serif);font-size:22px;font-weight:500;color:var(--text);line-height:1.3}
.modal-close{
  width:36px;height:36px;border-radius:50%;background:var(--lav-1);border:none;
  cursor:pointer;font-size:16px;color:var(--muted);flex-shrink:0;
  display:flex;align-items:center;justify-content:center;transition:all .2s;
}
.modal-close:hover{background:var(--lav-2);color:var(--text)}
.modal-body{padding:24px 32px 32px}
.modal-body p{font-size:14.5px;line-height:1.8;color:var(--text-soft);margin-bottom:16px}
.modal-body h3{
  font-family:var(--font-serif);font-size:18px;font-weight:500;color:var(--text);
  margin:24px 0 10px;
}
.modal-steps{list-style:none;display:flex;flex-direction:column;gap:12px;margin-bottom:20px}
.modal-steps li{
  display:flex;gap:14px;align-items:flex-start;
  padding:14px 16px;background:var(--lav-1);border-radius:var(--radius-sm);
}
.modal-step-n{
  width:24px;height:24px;border-radius:50%;
  background:linear-gradient(135deg,var(--purple),var(--purple-dark));
  color:white;font-size:12px;font-weight:700;
  display:flex;align-items:center;justify-content:center;flex-shrink:0;
}
.modal-steps li p{font-size:13.5px;line-height:1.6;color:var(--text-soft);margin:0}
.modal-steps li strong{color:var(--text)}
.modal-tip{
  background:rgba(12,184,152,0.08);border:1px solid rgba(12,184,152,0.2);
  border-radius:var(--radius-sm);padding:14px 16px;
  display:flex;gap:10px;align-items:flex-start;margin-top:8px;
}
.modal-tip i{color:var(--teal);margin-top:2px;font-size:14px}
.modal-tip p{font-size:13px;line-height:1.6;color:var(--text-soft);margin:0}
.modal-footer{
  padding:16px 32px 28px;
  border-top:1px solid rgba(30,58,95,0.07);
  display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;
}
.modal-helpful{font-size:13px;color:var(--text-soft);display:flex;align-items:center;gap:10px}
.helpful-btn{
  display:inline-flex;align-items:center;gap:6px;
  padding:7px 14px;border-radius:100px;
  background:var(--lav-1);border:1px solid rgba(123,111,232,0.15);
  font-size:12px;font-weight:600;color:var(--text-soft);cursor:pointer;
  transition:all .2s;
}
.helpful-btn:hover{background:rgba(123,111,232,0.1);color:var(--purple-dark)}
.helpful-btn.voted{background:rgba(12,184,152,0.1);color:#009970;border-color:rgba(12,184,152,0.2)}

/* ══════════════════ RESPONSIVE ══════════════════ */
@media(max-width:860px){
  .articles-grid{grid-template-columns:1fr}
  .contact-grid{grid-template-columns:1fr 1fr}
  .modal-header,.modal-body,.modal-footer{padding-left:20px;padding-right:20px}
}
@media(max-width:600px){
  .nav-breadcrumb{display:none}
  .topics-grid{grid-template-columns:repeat(2,1fr)}
  .contact-grid{grid-template-columns:1fr}
  .hero{padding:44px 20px 40px}
  .step-section{padding:20px}
  .video-grid{grid-template-columns:1fr 1fr}
}
@media(max-width:420px){
  .video-grid{grid-template-columns:1fr}
  .topics-grid{grid-template-columns:repeat(2,1fr)}
}

/* ══════════════════ UTILS ══════════════════ */
.d-none{display:none!important}
.main-content{transition:opacity .2s}
</style>
</head>
<body>

<!-- Announcement -->
<div class="announcement" id="announcement">
  <i class="fa-solid fa-sparkles" style="margin-right:6px"></i>
  <strong>Baru!</strong> Panduan fitur AI Learning Assistant sudah tersedia.
  <a href="#" onclick="openArticle('ai-assistant'); return false">Baca sekarang →</a>
  <button class="announcement-close" onclick="this.parentElement.style.display='none'" aria-label="Tutup">×</button>
</div>


<!-- Hero -->
<section class="hero">
  <div class="hero-eyebrow">
    <i class="fa-solid fa-book-open-reader"></i>
    Pusat Panduan
  </div>
  <h1 class="hero-title">
    Bagaimana kami<br>bisa <em>membantu?</em>
  </h1>
  <p class="hero-sub">Temukan tutorial, panduan langkah-demi-langkah, dan jawaban untuk semua pertanyaanmu tentang Coursify.</p>

  <div class="search-wrap">
    <i class="fa-solid fa-magnifying-glass search-icon"></i>
    <input type="text" class="search-input" id="mainSearch"
      placeholder="Cari panduan... (mis: cara reset password)"
      oninput="handleSearch(this.value)"
      onkeydown="if(event.key==='Enter')doSearch()"
      autocomplete="off">
    <button class="search-clear" id="searchClear" onclick="clearSearch()"><i class="fa-solid fa-xmark"></i></button>
    <button class="search-btn" onclick="doSearch()"><i class="fa-solid fa-magnifying-glass"></i> Cari</button>
    <div class="search-suggestions" id="searchSuggestions"></div>
  </div>

  <div class="hero-stats">
    <div class="stat-chip"><i class="fa-solid fa-file-lines"></i> <strong>48</strong> Artikel panduan</div>
    <div class="stat-chip"><i class="fa-solid fa-circle-play"></i> <strong>12</strong> Video tutorial</div>
    <div class="stat-chip"><i class="fa-solid fa-clock-rotate-left"></i> Diperbarui minggu ini</div>
    <div class="stat-chip"><i class="fa-solid fa-headset"></i> Support <strong>&lt; 2 jam</strong></div>
  </div>
</section>

<!-- ── Search Results Panel ── -->
<div class="search-results-panel" id="searchPanel">
  <div class="search-result-header">
    <div class="search-result-title" id="searchResultTitle">Hasil untuk <strong>""</strong></div>
    <button class="search-result-back" onclick="clearSearch()"><i class="fa-solid fa-arrow-left"></i> Kembali ke semua panduan</button>
  </div>
  <div id="searchResultsList" class="search-results-list"></div>
</div>

<!-- ── Main Content ── -->
<div class="main-content" id="mainContent">

  <!-- Topics -->
  <section class="section">
    <div class="section-inner">
      <div class="section-header">
        <div>
          <div class="section-label">Jelajahi Topik</div>
          <div class="section-title">Pilih kategori panduan</div>
        </div>
      </div>
      <div class="topics-grid">
        <a class="topic-card" href="#" onclick="filterByTopic('akun'); return false"
           style="--card-from:rgba(123,111,232,0.07);--card-to:rgba(123,111,232,0.01);--card-border:rgba(123,111,232,0.3);--icon-bg:rgba(123,111,232,0.12);--icon-color:#7B6FE8">
          <div class="topic-icon"><i class="fa-solid fa-user-shield"></i></div>
          <div class="topic-name">Akun & Keamanan</div>
          <div class="topic-count">8 artikel</div>
          <i class="fa-solid fa-arrow-right topic-arrow"></i>
        </a>
        <a class="topic-card" href="#" onclick="filterByTopic('kursus'); return false"
           style="--card-from:rgba(12,184,152,0.07);--card-to:rgba(12,184,152,0.01);--card-border:rgba(12,184,152,0.3);--icon-bg:rgba(12,184,152,0.12);--icon-color:#0CB898">
          <div class="topic-icon"><i class="fa-solid fa-graduation-cap"></i></div>
          <div class="topic-name">Kursus & Belajar</div>
          <div class="topic-count">10 artikel</div>
          <i class="fa-solid fa-arrow-right topic-arrow"></i>
        </a>
        <a class="topic-card" href="#" onclick="filterByTopic('pembayaran'); return false"
           style="--card-from:rgba(255,107,53,0.07);--card-to:rgba(255,107,53,0.01);--card-border:rgba(255,107,53,0.3);--icon-bg:rgba(255,107,53,0.12);--icon-color:#FF6B35">
          <div class="topic-icon"><i class="fa-solid fa-credit-card"></i></div>
          <div class="topic-name">Pembayaran & Langganan</div>
          <div class="topic-count">9 artikel</div>
          <i class="fa-solid fa-arrow-right topic-arrow"></i>
        </a>
        <a class="topic-card" href="#" onclick="filterByTopic('sertifikat'); return false"
           style="--card-from:rgba(244,185,66,0.1);--card-to:rgba(244,185,66,0.01);--card-border:rgba(244,185,66,0.4);--icon-bg:rgba(244,185,66,0.15);--icon-color:#C88500">
          <div class="topic-icon"><i class="fa-solid fa-certificate"></i></div>
          <div class="topic-name">Sertifikat & Nilai</div>
          <div class="topic-count">6 artikel</div>
          <i class="fa-solid fa-arrow-right topic-arrow"></i>
        </a>
        <a class="topic-card" href="#" onclick="filterByTopic('instruktur'); return false"
           style="--card-from:rgba(30,58,95,0.06);--card-to:rgba(30,58,95,0.01);--card-border:rgba(30,58,95,0.2);--icon-bg:rgba(30,58,95,0.1);--icon-color:#1E3A5F">
          <div class="topic-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
          <div class="topic-name">Instruktur & Konten</div>
          <div class="topic-count">8 artikel</div>
          <i class="fa-solid fa-arrow-right topic-arrow"></i>
        </a>
        <a class="topic-card" href="#" onclick="filterByTopic('teknis'); return false"
           style="--card-from:rgba(123,111,232,0.05);--card-to:rgba(12,184,152,0.04);--card-border:rgba(123,111,232,0.25);--icon-bg:rgba(123,111,232,0.1);--icon-color:#5A4FD4">
          <div class="topic-icon"><i class="fa-solid fa-wrench"></i></div>
          <div class="topic-name">Teknis & Troubleshoot</div>
          <div class="topic-count">7 artikel</div>
          <i class="fa-solid fa-arrow-right topic-arrow"></i>
        </a>
      </div>
    </div>
  </section>

  <!-- Popular Searches -->
  <section class="section" style="padding-top:0;padding-bottom:40px">
    <div class="section-inner">
      <div style="font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);margin-bottom:12px">
        <i class="fa-solid fa-fire" style="color:#FF6B35;margin-right:5px"></i>Pencarian Populer
      </div>
      <div class="popular-wrap">
        <a class="popular-tag" href="#" onclick="setSearch('cara daftar kursus'); return false"><i class="fa-solid fa-magnifying-glass"></i> Cara daftar kursus</a>
        <a class="popular-tag" href="#" onclick="setSearch('reset password'); return false"><i class="fa-solid fa-magnifying-glass"></i> Reset password</a>
        <a class="popular-tag" href="#" onclick="setSearch('download sertifikat'); return false"><i class="fa-solid fa-magnifying-glass"></i> Download sertifikat</a>
        <a class="popular-tag" href="#" onclick="setSearch('refund langganan'); return false"><i class="fa-solid fa-magnifying-glass"></i> Refund langganan</a>
        <a class="popular-tag" href="#" onclick="setSearch('akses offline'); return false"><i class="fa-solid fa-magnifying-glass"></i> Akses offline</a>
        <a class="popular-tag" href="#" onclick="setSearch('jadi instruktur'); return false"><i class="fa-solid fa-magnifying-glass"></i> Jadi instruktur</a>
        <a class="popular-tag" href="#" onclick="setSearch('metode pembayaran'); return false"><i class="fa-solid fa-magnifying-glass"></i> Metode pembayaran</a>
        <a class="popular-tag" href="#" onclick="setSearch('linkedin sertifikat'); return false"><i class="fa-solid fa-magnifying-glass"></i> LinkedIn sertifikat</a>
      </div>
    </div>
  </section>

  <!-- Featured Articles -->
  <section class="section" style="padding-top:0">
    <div class="section-inner">
      <div class="section-header">
        <div>
          <div class="section-label">Panduan Unggulan</div>
          <div class="section-title">Artikel yang sering dibaca</div>
        </div>
        <a class="see-all" href="#">Lihat semua <i class="fa-solid fa-arrow-right"></i></a>
      </div>
      <div class="articles-grid">

        <a class="article-card" href="#" onclick="openArticle('daftar-kursus'); return false">
          <div class="article-meta">
            <span class="article-cat" style="background:rgba(12,184,152,0.12);color:#009970">Kursus</span>
            <span class="article-readtime"><i class="fa-regular fa-clock" style="margin-right:4px"></i>3 menit baca</span>
          </div>
          <div class="article-title">Cara Mendaftar dan Mulai Kursus Pertamamu di Coursify</div>
          <div class="article-excerpt">Panduan lengkap langkah-demi-langkah untuk menemukan kursus yang tepat, melakukan enrollment, dan langsung memulai belajar dalam hitungan menit.</div>
          <div class="article-footer">
            <span class="article-views"><i class="fa-solid fa-eye"></i> 12.4k dilihat</span>
            <span class="article-link">Baca panduan <i class="fa-solid fa-arrow-right"></i></span>
          </div>
        </a>

        <a class="article-card" href="#" onclick="openArticle('reset-password'); return false">
          <div class="article-meta">
            <span class="article-cat" style="background:rgba(123,111,232,0.12);color:var(--purple-dark)">Akun</span>
            <span class="article-readtime"><i class="fa-regular fa-clock" style="margin-right:4px"></i>2 menit baca</span>
          </div>
          <div class="article-title">Cara Reset Password dan Masuk Kembali ke Akun</div>
          <div class="article-excerpt">Lupa password? Tidak perlu khawatir. Ikuti langkah mudah ini untuk memulihkan akses akun Coursify kamu dalam waktu kurang dari 5 menit.</div>
          <div class="article-footer">
            <span class="article-views"><i class="fa-solid fa-eye"></i> 9.1k dilihat</span>
            <span class="article-link">Baca panduan <i class="fa-solid fa-arrow-right"></i></span>
          </div>
        </a>

        <a class="article-card" href="#" onclick="openArticle('sertifikat'); return false">
          <div class="article-meta">
            <span class="article-cat" style="background:rgba(244,185,66,0.15);color:#C88500">Sertifikat</span>
            <span class="article-readtime"><i class="fa-regular fa-clock" style="margin-right:4px"></i>4 menit baca</span>
          </div>
          <div class="article-title">Cara Mendapatkan, Mengunduh, dan Membagikan Sertifikat ke LinkedIn</div>
          <div class="article-excerpt">Semua yang perlu kamu tahu tentang sertifikat Coursify — mulai cara mendapatkannya, format file, hingga cara menambahkan ke profil LinkedIn dengan satu klik.</div>
          <div class="article-footer">
            <span class="article-views"><i class="fa-solid fa-eye"></i> 7.8k dilihat</span>
            <span class="article-link">Baca panduan <i class="fa-solid fa-arrow-right"></i></span>
          </div>
        </a>

        <a class="article-card" href="#" onclick="openArticle('refund'); return false">
          <div class="article-meta">
            <span class="article-cat" style="background:rgba(255,107,53,0.12);color:#D04010">Pembayaran</span>
            <span class="article-readtime"><i class="fa-regular fa-clock" style="margin-right:4px"></i>3 menit baca</span>
          </div>
          <div class="article-title">Kebijakan Refund dan Cara Mengajukan Pengembalian Dana</div>
          <div class="article-excerpt">Garansi uang kembali 30 hari berlaku untuk semua langganan Pro. Pelajari syarat-syarat refund dan proses pengajuannya yang mudah dan tanpa ribet.</div>
          <div class="article-footer">
            <span class="article-views"><i class="fa-solid fa-eye"></i> 5.2k dilihat</span>
            <span class="article-link">Baca panduan <i class="fa-solid fa-arrow-right"></i></span>
          </div>
        </a>

      </div>
    </div>
  </section>

  <!-- Step-by-step guide -->
  <section class="section" style="padding-top:0">
    <div class="section-inner">
      <div class="section-header">
        <div>
          <div class="section-label">Panduan Cepat</div>
          <div class="section-title">Mulai dari mana?</div>
        </div>
      </div>
      <div class="step-section">
        <a class="step-item" href="#" onclick="openArticle('buat-akun'); return false">
          <div class="step-num">1</div>
          <div class="step-body">
            <div class="step-title">Buat akun Coursify <span class="step-badge">Gratis</span></div>
            <div class="step-desc">Daftar hanya butuh 30 detik dengan email atau akun Google. Tidak perlu kartu kredit.</div>
          </div>
          <i class="fa-solid fa-chevron-right" style="color:var(--muted);margin-top:4px;font-size:12px"></i>
        </a>
        <a class="step-item" href="#" onclick="openArticle('jelajah-kursus'); return false">
          <div class="step-num">2</div>
          <div class="step-body">
            <div class="step-title">Jelajahi dan pilih kursus</div>
            <div class="step-desc">Browse lebih dari 500 kursus dari instruktur berpengalaman. Filter berdasarkan level, topik, dan durasi.</div>
          </div>
          <i class="fa-solid fa-chevron-right" style="color:var(--muted);margin-top:4px;font-size:12px"></i>
        </a>
        <a class="step-item" href="#" onclick="openArticle('daftar-kursus'); return false">
          <div class="step-num">3</div>
          <div class="step-body">
            <div class="step-title">Daftar ke kursus dan mulai belajar</div>
            <div class="step-desc">Klik Enroll Now dan langsung akses semua materi. Kursus gratis bisa langsung dimulai tanpa pembayaran.</div>
          </div>
          <i class="fa-solid fa-chevron-right" style="color:var(--muted);margin-top:4px;font-size:12px"></i>
        </a>
        <a class="step-item" href="#" onclick="openArticle('sertifikat'); return false">
          <div class="step-num">4</div>
          <div class="step-body">
            <div class="step-title">Selesaikan kursus dan dapatkan sertifikat</div>
            <div class="step-desc">Tonton semua video, kerjakan kuis, dan raih sertifikat yang bisa dibagikan ke LinkedIn dan CV-mu.</div>
          </div>
          <i class="fa-solid fa-chevron-right" style="color:var(--muted);margin-top:4px;font-size:12px"></i>
        </a>
      </div>
    </div>
  </section>

  <!-- Video tutorials -->
  <section class="section" style="padding-top:0">
    <div class="section-inner">
      <div class="section-header">
        <div>
          <div class="section-label">Tutorial Video</div>
          <div class="section-title">Lebih mudah dengan visual</div>
        </div>
        <a class="see-all" href="#">Lihat semua <i class="fa-solid fa-arrow-right"></i></a>
      </div>
      <div class="video-grid">
        <a class="video-card" href="#" onclick="openArticle('daftar-kursus'); return false">
          <div class="video-thumb" style="background:linear-gradient(135deg,#E8F5FE,#C8E8FF)">
            <div class="video-thumb-bg" style="color:#5BA3D9">🎓</div>
            <div class="video-play"><i class="fa-solid fa-play"></i></div>
            <span class="video-duration">3:42</span>
          </div>
          <div class="video-body">
            <div class="video-cat">Memulai</div>
            <div class="video-title">Cara daftar dan mulai kursus pertamamu</div>
          </div>
        </a>
        <a class="video-card" href="#" onclick="openArticle('upgrade-pro'); return false">
          <div class="video-thumb" style="background:linear-gradient(135deg,#F3F0FF,#E0DAFF)">
            <div class="video-thumb-bg" style="color:#8B7FD4">💳</div>
            <div class="video-play"><i class="fa-solid fa-play"></i></div>
            <span class="video-duration">2:18</span>
          </div>
          <div class="video-body">
            <div class="video-cat">Pembayaran</div>
            <div class="video-title">Upgrade ke Pro: langkah demi langkah</div>
          </div>
        </a>
        <a class="video-card" href="#" onclick="openArticle('sertifikat'); return false">
          <div class="video-thumb" style="background:linear-gradient(135deg,#FFFBEC,#FFF3C4)">
            <div class="video-thumb-bg" style="color:#C88500">🏆</div>
            <div class="video-play"><i class="fa-solid fa-play"></i></div>
            <span class="video-duration">1:55</span>
          </div>
          <div class="video-body">
            <div class="video-cat">Sertifikat</div>
            <div class="video-title">Download dan share sertifikat ke LinkedIn</div>
          </div>
        </a>
        <a class="video-card" href="#" onclick="openArticle('instruktur'); return false">
          <div class="video-thumb" style="background:linear-gradient(135deg,#EBF7F4,#C5EDE7)">
            <div class="video-thumb-bg" style="color:#0CB898">📹</div>
            <div class="video-play"><i class="fa-solid fa-play"></i></div>
            <span class="video-duration">5:10</span>
          </div>
          <div class="video-body">
            <div class="video-cat">Instruktur</div>
            <div class="video-title">Panduan lengkap daftar jadi instruktur</div>
          </div>
        </a>
      </div>
    </div>
  </section>

</div><!-- /.main-content -->

<!-- Contact section -->
<section class="contact-section">
  <div class="contact-grid">
    <a class="contact-card" href="mailto:support@coursify.id">
      <div class="contact-icon" style="background:rgba(123,111,232,0.12);color:var(--purple)">
        <i class="fa-solid fa-envelope"></i>
      </div>
      <div class="contact-title">Email Support</div>
      <div class="contact-desc">Kirim pesan ke tim kami. Kami biasanya membalas dalam kurang dari 2 jam pada hari kerja.</div>
      <div class="contact-meta"><i class="fa-solid fa-clock"></i> Respons &lt; 2 jam</div>
    </a>
    <a class="contact-card" href="#">
      <div class="contact-icon" style="background:rgba(12,184,152,0.12);color:var(--teal)">
        <i class="fa-brands fa-whatsapp"></i>
      </div>
      <div class="contact-title">Chat WhatsApp</div>
      <div class="contact-desc">Hubungi kami melalui WhatsApp untuk bantuan cepat dan langsung dari tim support Coursify.</div>
      <div class="contact-meta"><i class="fa-solid fa-circle" style="font-size:8px;color:#0CB898"></i> Tersedia 08.00–22.00</div>
    </a>
    <a class="contact-card" href="#">
      <div class="contact-icon" style="background:rgba(244,185,66,0.15);color:#C88500">
        <i class="fa-solid fa-comments"></i>
      </div>
      <div class="contact-title">Live Chat</div>
      <div class="contact-desc">Chat langsung di platform untuk pertanyaan singkat dan bantuan real-time dari agen kami.</div>
      <div class="contact-meta"><i class="fa-solid fa-circle" style="font-size:8px;color:#0CB898"></i> Tersedia sekarang</div>
    </a>
  </div>
</section>

<!-- ══════ ARTICLE MODAL ══════ -->
<div class="modal-overlay" id="modalOverlay" onclick="if(event.target===this)closeModal()">
  <div class="modal" id="modal">
    <div class="modal-header">
      <div class="modal-icon" id="modalIcon"></div>
      <div class="modal-title-block">
        <span class="modal-cat" id="modalCat"></span>
        <div class="modal-title" id="modalTitle"></div>
      </div>
      <button class="modal-close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="modal-body" id="modalBody"></div>
    <div class="modal-footer">
      <div class="modal-helpful">
        <span>Artikel ini membantu?</span>
        <button class="helpful-btn" onclick="vote(this, true)"><i class="fa-solid fa-thumbs-up"></i> Ya</button>
        <button class="helpful-btn" onclick="vote(this, false)"><i class="fa-solid fa-thumbs-down"></i> Tidak</button>
      </div>
      <a href="#" style="font-size:13px;font-weight:600;color:var(--purple);text-decoration:none;display:flex;align-items:center;gap:5px">
        <i class="fa-solid fa-share-nodes"></i> Bagikan
      </a>
    </div>
  </div>
</div>

<script>
/* ══════════════════ ARTICLE DATA ══════════════════ */
const articles = {
  'daftar-kursus': {
    icon: '🎓', iconBg: 'rgba(12,184,152,0.12)', iconColor: '#009970',
    cat: 'Kursus', catColor: '#009970', catBg: 'rgba(12,184,152,0.12)',
    title: 'Cara Mendaftar dan Mulai Kursus Pertamamu',
    tags: ['kursus','daftar','enroll','mulai belajar','akses kursus'],
    body: `
      <p>Mendaftar ke kursus di Coursify sangat mudah — prosesnya hanya membutuhkan beberapa klik. Panduan ini akan membimbingmu dari awal hingga bisa langsung menonton materi pertama.</p>
      <h3>Langkah-langkah</h3>
      <ul class="modal-steps">
        <li><div class="modal-step-n">1</div><p><strong>Temukan kursus</strong> yang kamu inginkan lewat halaman Browse atau gunakan fitur pencarian di menu utama.</p></li>
        <li><div class="modal-step-n">2</div><p>Buka halaman detail kursus dan <strong>klik tombol "Enroll Now"</strong> yang ada di panel sebelah kanan.</p></li>
        <li><div class="modal-step-n">3</div><p>Untuk kursus <strong>gratis</strong>, kamu langsung diarahkan ke halaman belajar. Untuk kursus <strong>berbayar</strong>, kamu akan diarahkan ke halaman pembayaran.</p></li>
        <li><div class="modal-step-n">4</div><p>Setelah terdaftar, kursus muncul di <strong>dashboard "My Learning"</strong> milikmu dan bisa diakses kapan saja.</p></li>
        <li><div class="modal-step-n">5</div><p>Klik <strong>"Continue Learning"</strong> untuk melanjutkan dari materi terakhir yang kamu tonton.</p></li>
      </ul>
      <div class="modal-tip">
        <i class="fa-solid fa-lightbulb"></i>
        <p><strong>Tips:</strong> Gunakan fitur <em>Wishlist</em> untuk menyimpan kursus yang ingin kamu ambil nanti. Klik ikon hati di halaman detail kursus.</p>
      </div>
    `
  },
  'reset-password': {
    icon: '🔐', iconBg: 'rgba(123,111,232,0.12)', iconColor: 'var(--purple)',
    cat: 'Akun', catColor: 'var(--purple-dark)', catBg: 'rgba(123,111,232,0.12)',
    title: 'Cara Reset Password Akun Coursify',
    tags: ['password','reset','lupa password','login','akun','masuk'],
    body: `
      <p>Lupa password adalah hal yang wajar. Proses reset password di Coursify dirancang cepat dan aman — selesai dalam kurang dari 5 menit.</p>
      <h3>Langkah Reset Password</h3>
      <ul class="modal-steps">
        <li><div class="modal-step-n">1</div><p>Buka halaman login Coursify dan klik tautan <strong>"Lupa Password?"</strong> di bawah form login.</p></li>
        <li><div class="modal-step-n">2</div><p>Masukkan <strong>alamat email</strong> yang terdaftar di akunmu, lalu klik <strong>"Kirim Link Reset"</strong>.</p></li>
        <li><div class="modal-step-n">3</div><p>Cek <strong>inbox email</strong>-mu (dan folder spam jika tidak muncul). Kamu akan menerima email dari noreply@coursify.id.</p></li>
        <li><div class="modal-step-n">4</div><p>Klik tombol <strong>"Reset Password"</strong> di email tersebut. Link berlaku selama <strong>60 menit</strong>.</p></li>
        <li><div class="modal-step-n">5</div><p>Masukkan <strong>password baru</strong> dua kali dan klik <strong>"Simpan Password Baru"</strong>. Kamu langsung bisa login.</p></li>
      </ul>
      <div class="modal-tip">
        <i class="fa-solid fa-shield-halved"></i>
        <p><strong>Keamanan:</strong> Gunakan password minimal 8 karakter yang mengandung huruf besar, angka, dan simbol agar akunmu lebih aman.</p>
      </div>
    `
  },
  'sertifikat': {
    icon: '🏆', iconBg: 'rgba(244,185,66,0.15)', iconColor: '#C88500',
    cat: 'Sertifikat', catColor: '#C88500', catBg: 'rgba(244,185,66,0.15)',
    title: 'Cara Mendapatkan dan Membagikan Sertifikat',
    tags: ['sertifikat','download','linkedin','cetak','pdf','bagikan'],
    body: `
      <p>Sertifikat Coursify adalah bukti nyata kompetensimu yang bisa dibagikan ke LinkedIn, CV, atau dicetak untuk keperluan profesional.</p>
      <h3>Cara Mendapatkan Sertifikat</h3>
      <ul class="modal-steps">
        <li><div class="modal-step-n">1</div><p>Selesaikan <strong>semua materi video</strong> dalam kursus (progress bar harus mencapai 100%).</p></li>
        <li><div class="modal-step-n">2</div><p>Kerjakan dan lulus <strong>kuis akhir</strong> dengan nilai minimal 70%. Kamu boleh mengulang kuis sebanyak yang diperlukan.</p></li>
        <li><div class="modal-step-n">3</div><p>Sertifikat akan <strong>otomatis muncul</strong> di dashboard-mu dalam tab "Sertifikat Saya".</p></li>
      </ul>
      <h3>Cara Download dan Share</h3>
      <ul class="modal-steps">
        <li><div class="modal-step-n">1</div><p>Buka <strong>"Sertifikat Saya"</strong> di menu profil, lalu klik sertifikat yang ingin diunduh.</p></li>
        <li><div class="modal-step-n">2</div><p>Klik <strong>"Download PDF"</strong> untuk mendapatkan file resolusi tinggi (siap cetak A4).</p></li>
        <li><div class="modal-step-n">3</div><p>Klik tombol <strong>"Tambah ke LinkedIn"</strong> — data kursus dan ID verifikasi akan terisi otomatis.</p></li>
      </ul>
      <div class="modal-tip">
        <i class="fa-solid fa-check-circle"></i>
        <p>Setiap sertifikat punya <strong>ID verifikasi unik</strong> yang bisa dicek di verify.coursify.id oleh siapapun — termasuk rekruter perusahaanmu.</p>
      </div>
    `
  },
  'refund': {
    icon: '💳', iconBg: 'rgba(255,107,53,0.12)', iconColor: '#D04010',
    cat: 'Pembayaran', catColor: '#D04010', catBg: 'rgba(255,107,53,0.12)',
    title: 'Kebijakan Refund dan Pengembalian Dana',
    tags: ['refund','uang kembali','pembayaran','batal','garansi','langganan'],
    body: `
      <p>Kami percaya pada kualitas platform kami. Oleh karena itu, kami menawarkan <strong>garansi uang kembali 30 hari</strong> untuk semua langganan Pro — tanpa pertanyaan tambahan.</p>
      <h3>Syarat Refund</h3>
      <ul class="modal-steps">
        <li><div class="modal-step-n">1</div><p>Refund berlaku dalam <strong>30 hari pertama</strong> setelah tanggal pembelian langganan Pro.</p></li>
        <li><div class="modal-step-n">2</div><p>Pembelian kursus individual (<strong>non-langganan</strong>) tidak bisa direfund setelah 48 jam akses pertama.</p></li>
        <li><div class="modal-step-n">3</div><p>Dana dikembalikan ke <strong>metode pembayaran asal</strong> dalam 3–7 hari kerja.</p></li>
      </ul>
      <h3>Cara Mengajukan Refund</h3>
      <ul class="modal-steps">
        <li><div class="modal-step-n">1</div><p>Buka <strong>Pengaturan Akun → Langganan</strong> dan klik "Ajukan Refund".</p></li>
        <li><div class="modal-step-n">2</div><p>Pilih alasan refund (opsional) dan konfirmasi permintaan.</p></li>
        <li><div class="modal-step-n">3</div><p>Tim kami akan memproses dalam <strong>1×24 jam</strong> dan mengirim konfirmasi via email.</p></li>
      </ul>
      <div class="modal-tip">
        <i class="fa-solid fa-headset"></i>
        <p>Butuh bantuan? Hubungi support@coursify.id atau WhatsApp kami. Tim kami siap membantu proses refundmu.</p>
      </div>
    `
  },
  'buat-akun': {
    icon: '👤', iconBg: 'rgba(123,111,232,0.12)', iconColor: 'var(--purple)',
    cat: 'Akun', catColor: 'var(--purple-dark)', catBg: 'rgba(123,111,232,0.12)',
    title: 'Cara Membuat Akun Coursify',
    tags: ['akun','daftar','register','buat akun','signup'],
    body: `
      <p>Membuat akun Coursify hanya butuh waktu 30 detik dan sepenuhnya gratis. Kamu tidak perlu kartu kredit untuk mendaftar.</p>
      <h3>Pilih Cara Daftar</h3>
      <ul class="modal-steps">
        <li><div class="modal-step-n">1</div><p><strong>Via Google:</strong> Klik "Daftar dengan Google" di halaman registrasi. Ini cara tercepat — tidak perlu isi form.</p></li>
        <li><div class="modal-step-n">2</div><p><strong>Via Email:</strong> Isi nama lengkap, alamat email aktif, dan buat password minimal 8 karakter.</p></li>
        <li><div class="modal-step-n">3</div><p>Klik <strong>"Buat Akun"</strong>. Kamu langsung masuk ke dashboard tanpa perlu verifikasi email.</p></li>
        <li><div class="modal-step-n">4</div><p>Opsional: Lengkapi <strong>profil</strong>mu dengan foto dan bidang minat untuk rekomendasi kursus yang lebih relevan.</p></li>
      </ul>
      <div class="modal-tip">
        <i class="fa-solid fa-gift"></i>
        <p>Setelah daftar, kamu langsung mendapat akses ke <strong>100+ kursus gratis</strong> tanpa batas waktu.</p>
      </div>
    `
  },
  'jelajah-kursus': {
    icon: '🔍', iconBg: 'rgba(12,184,152,0.12)', iconColor: 'var(--teal)',
    cat: 'Kursus', catColor: '#009970', catBg: 'rgba(12,184,152,0.12)',
    title: 'Cara Mencari dan Menemukan Kursus yang Tepat',
    tags: ['kursus','cari','browse','filter','rekomendasi'],
    body: `
      <p>Dengan lebih dari 500 kursus tersedia, fitur pencarian dan filter Coursify membantu kamu menemukan kursus yang paling sesuai dengan tujuan dan level belajarmu.</p>
      <h3>Cara Mencari Kursus</h3>
      <ul class="modal-steps">
        <li><div class="modal-step-n">1</div><p>Gunakan <strong>kotak pencarian</strong> di bagian atas halaman untuk mencari berdasarkan topik, instruktur, atau kata kunci.</p></li>
        <li><div class="modal-step-n">2</div><p>Gunakan <strong>filter</strong> di sidebar untuk menyaring berdasarkan level (Pemula/Menengah/Lanjutan), durasi, harga, dan rating.</p></li>
        <li><div class="modal-step-n">3</div><p>Klik <strong>"Lihat Preview"</strong> untuk melihat silabus lengkap dan beberapa video gratis sebelum memutuskan enroll.</p></li>
        <li><div class="modal-step-n">4</div><p>Baca <strong>ulasan peserta</strong> sebelumnya untuk mendapat gambaran kualitas kursus secara nyata.</p></li>
      </ul>
      <div class="modal-tip">
        <i class="fa-solid fa-star"></i>
        <p>Halaman <strong>"Trending"</strong> menampilkan kursus paling populer minggu ini — cocok jika kamu belum tahu harus mulai dari mana.</p>
      </div>
    `
  },
  'upgrade-pro': {
    icon: '⚡', iconBg: 'rgba(244,185,66,0.15)', iconColor: '#C88500',
    cat: 'Pembayaran', catColor: '#D04010', catBg: 'rgba(255,107,53,0.12)',
    title: 'Cara Upgrade ke Langganan Pro',
    tags: ['pro','upgrade','langganan','berbayar','premium'],
    body: `
      <p>Upgrade ke Pro membuka akses penuh ke semua kursus, fitur offline, dan sertifikat premium. Berikut cara mudah upgrade akunmu.</p>
      <h3>Langkah Upgrade</h3>
      <ul class="modal-steps">
        <li><div class="modal-step-n">1</div><p>Klik <strong>"Upgrade to Pro"</strong> di banner dashboard atau buka menu <strong>Profil → Langganan</strong>.</p></li>
        <li><div class="modal-step-n">2</div><p>Pilih paket: <strong>Bulanan</strong> (lebih fleksibel) atau <strong>Tahunan</strong> (hemat 40%).</p></li>
        <li><div class="modal-step-n">3</div><p>Pilih metode pembayaran: kartu kredit/debit, transfer bank, e-wallet (GoPay, OVO, DANA), atau QRIS.</p></li>
        <li><div class="modal-step-n">4</div><p>Konfirmasi pembayaran. Akses Pro <strong>aktif instan</strong> setelah pembayaran berhasil.</p></li>
      </ul>
      <div class="modal-tip">
        <i class="fa-solid fa-shield"></i>
        <p>Dilindungi <strong>garansi 30 hari</strong>. Tidak puas? Kami kembalikan dana penuh, tidak ada pertanyaan.</p>
      </div>
    `
  },
  'instruktur': {
    icon: '📹', iconBg: 'rgba(30,58,95,0.1)', iconColor: 'var(--navy)',
    cat: 'Instruktur', catColor: 'var(--navy)', catBg: 'rgba(30,58,95,0.1)',
    title: 'Cara Mendaftar Menjadi Instruktur Coursify',
    tags: ['instruktur','mengajar','buat kursus','jadi instruktur','pendapatan'],
    body: `
      <p>Bagikan keahlianmu dan dapatkan pendapatan dari ribuan pelajar. Coursify menerima instruktur baru setiap bulan melalui proses seleksi yang transparan.</p>
      <h3>Persyaratan</h3>
      <ul class="modal-steps">
        <li><div class="modal-step-n">1</div><p>Minimal <strong>3 tahun pengalaman industri</strong> yang relevan dengan topik kursus yang akan diajarkan.</p></li>
        <li><div class="modal-step-n">2</div><p>Portofolio pekerjaan, LinkedIn profesional, atau <strong>bukti keahlian</strong> lainnya.</p></li>
      </ul>
      <h3>Proses Pendaftaran</h3>
      <ul class="modal-steps">
        <li><div class="modal-step-n">1</div><p>Daftar melalui <strong>portal instruktur</strong> di coursify.id/teach dan isi formulir aplikasi.</p></li>
        <li><div class="modal-step-n">2</div><p>Tim kami meninjau aplikasi dalam <strong>7 hari kerja</strong> dan memberi feedback via email.</p></li>
        <li><div class="modal-step-n">3</div><p>Jika diterima, ikuti <strong>onboarding session</strong> dan mulai buat kursus pertamamu dengan bantuan tim kami.</p></li>
        <li><div class="modal-step-n">4</div><p>Kursus melewati <strong>review kualitas</strong> (5–10 hari) sebelum dipublikasikan ke semua pengguna.</p></li>
      </ul>
      <div class="modal-tip">
        <i class="fa-solid fa-coins"></i>
        <p>Instruktur mendapat <strong>70% dari setiap penjualan</strong>. Tidak ada biaya pendaftaran — cukup fokus pada konten berkualitas.</p>
      </div>
    `
  },
  'ai-assistant': {
    icon: '🤖', iconBg: 'rgba(123,111,232,0.12)', iconColor: 'var(--purple)',
    cat: 'Fitur Baru', catColor: 'var(--purple-dark)', catBg: 'rgba(123,111,232,0.12)',
    title: 'Panduan Fitur AI Learning Assistant',
    tags: ['ai','asisten','learning assistant','fitur baru','rekomendasi'],
    body: `
      <p>AI Learning Assistant adalah fitur baru Coursify yang membantu kamu belajar lebih efektif dengan rekomendasi personal, ringkasan materi otomatis, dan jawaban pertanyaan real-time.</p>
      <h3>Cara Menggunakan AI Assistant</h3>
      <ul class="modal-steps">
        <li><div class="modal-step-n">1</div><p>Klik ikon <strong>bintang/AI</strong> yang muncul di pojok kanan bawah saat menonton video kursus.</p></li>
        <li><div class="modal-step-n">2</div><p>Tanyakan apapun tentang materi yang sedang dipelajari — AI akan menjawab berdasarkan konteks kursusmu.</p></li>
        <li><div class="modal-step-n">3</div><p>Minta <strong>ringkasan otomatis</strong> setiap video dengan mengetik "Ringkaskan video ini".</p></li>
        <li><div class="modal-step-n">4</div><p>Aktifkan <strong>rekomendasi learning path</strong> di menu Profil → AI Settings untuk panduan belajar yang dipersonalisasi.</p></li>
      </ul>
      <div class="modal-tip">
        <i class="fa-solid fa-sparkles"></i>
        <p>AI Assistant tersedia untuk semua pengguna <strong>Pro dan Business</strong>. Upgrade sekarang untuk mencoba fitur ini.</p>
      </div>
    `
  }
};

/* ══════════════════ SEARCH DATA ══════════════════ */
const allSearchData = Object.entries(articles).map(([id, art]) => ({
  id, ...art
}));

/* ══════════════════ OPEN / CLOSE MODAL ══════════════════ */
function openArticle(id) {
  const art = articles[id];
  if (!art) return;
  const overlay = document.getElementById('modalOverlay');
  const icon = document.getElementById('modalIcon');
  const cat = document.getElementById('modalCat');
  const title = document.getElementById('modalTitle');
  const body = document.getElementById('modalBody');

  icon.textContent = art.icon;
  icon.style.background = art.iconBg;
  icon.style.fontSize = '22px';
  cat.textContent = art.cat;
  cat.style.color = art.catColor;
  title.textContent = art.title;
  body.innerHTML = art.body;

  // Reset helpful buttons
  document.querySelectorAll('.helpful-btn').forEach(b => b.classList.remove('voted'));

  overlay.classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeModal() {
  document.getElementById('modalOverlay').classList.remove('open');
  document.body.style.overflow = '';
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

function vote(btn, positive) {
  document.querySelectorAll('.helpful-btn').forEach(b => b.classList.remove('voted'));
  btn.classList.add('voted');
  btn.innerHTML = positive
    ? '<i class="fa-solid fa-check"></i> Terima kasih!'
    : '<i class="fa-solid fa-check"></i> Sudah dicatat';
}

/* ══════════════════ SEARCH ══════════════════ */
const suggestions = [
  'Cara daftar kursus','Reset password','Download sertifikat',
  'Refund langganan','Akses offline','Jadi instruktur',
  'Metode pembayaran','Upgrade ke Pro','AI Learning Assistant'
];

function handleSearch(val) {
  const clearBtn = document.getElementById('searchClear');
  const suggBox = document.getElementById('searchSuggestions');
  clearBtn.classList.toggle('visible', val.length > 0);

  if (val.length >= 2) {
    const filtered = suggestions.filter(s => s.toLowerCase().includes(val.toLowerCase())).slice(0, 5);
    if (filtered.length > 0) {
      suggBox.innerHTML = filtered.map(s =>
        `<div class="suggestion-item" onclick="setSearch('${s}')">
          <i class="fa-solid fa-magnifying-glass"></i>${s}
        </div>`
      ).join('');
      suggBox.classList.add('visible');
    } else {
      suggBox.classList.remove('visible');
    }
  } else {
    suggBox.classList.remove('visible');
    if (val.length === 0) clearSearch();
  }
}

function setSearch(text) {
  document.getElementById('mainSearch').value = text;
  document.getElementById('searchSuggestions').classList.remove('visible');
  document.getElementById('searchClear').classList.add('visible');
  doSearch();
}

function doSearch() {
  const q = document.getElementById('mainSearch').value.trim().toLowerCase();
  document.getElementById('searchSuggestions').classList.remove('visible');
  if (!q) { clearSearch(); return; }

  const results = allSearchData.filter(art =>
    art.title.toLowerCase().includes(q) ||
    (art.tags && art.tags.some(t => t.includes(q))) ||
    (art.cat && art.cat.toLowerCase().includes(q))
  );

  document.getElementById('mainContent').style.display = 'none';
  const panel = document.getElementById('searchPanel');
  panel.classList.add('visible');

  const titleEl = document.getElementById('searchResultTitle');
  titleEl.innerHTML = `${results.length} hasil untuk <strong>"${q}"</strong>`;

  const list = document.getElementById('searchResultsList');
  if (results.length === 0) {
    list.innerHTML = `
      <div class="no-results-block">
        <div class="no-results-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
        <div class="no-results-title">Tidak ada hasil ditemukan</div>
        <p class="no-results-desc">Coba kata kunci lain atau <a href="mailto:support@coursify.id" style="color:var(--purple)">hubungi support kami</a>.</p>
      </div>`;
    return;
  }

  list.innerHTML = results.map(art => `
    <a class="result-item" href="#" onclick="openArticle('${art.id}'); return false">
      <div class="result-item-top">
        <div class="result-item-icon" style="background:${art.iconBg}">${art.icon}</div>
        <div class="result-item-body">
          <div class="result-item-title">${highlight(art.title, q)}</div>
          <div class="result-item-desc">Panduan lengkap tentang ${art.title.toLowerCase()}.</div>
        </div>
      </div>
      <div class="result-item-foot">
        <span class="article-cat" style="background:${art.catBg};color:${art.catColor};font-size:10px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;padding:2px 8px;border-radius:100px">${art.cat}</span>
        <span>•</span>
        <span>Panduan lengkap</span>
      </div>
    </a>
  `).join('');
}

function highlight(text, q) {
  const re = new RegExp(`(${q})`, 'gi');
  return text.replace(re, '<span class="result-highlight">$1</span>');
}

function clearSearch() {
  document.getElementById('mainSearch').value = '';
  document.getElementById('searchClear').classList.remove('visible');
  document.getElementById('searchSuggestions').classList.remove('visible');
  document.getElementById('searchPanel').classList.remove('visible');
  document.getElementById('mainContent').style.display = '';
}

/* ══════════════════ TOPIC FILTER ══════════════════ */
function filterByTopic(topic) {
  const topicMap = {
    akun: 'reset password',
    kursus: 'kursus',
    pembayaran: 'pembayaran',
    sertifikat: 'sertifikat',
    instruktur: 'instruktur',
    teknis: 'troubleshoot'
  };
  setSearch(topicMap[topic] || topic);
}
</script>
</body>
</html>