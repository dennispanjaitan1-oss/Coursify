@extends('layouts.app')

@section('title', 'Blog & Berita')

@push('styles')
<style>
    .blog-hero {
        text-align: center;
        padding: 56px 20px 48px;
    }

    .blog-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 16px;
        border-radius: 999px;
        background: rgba(123,111,232,0.1);
        border: 1px solid rgba(123,111,232,0.18);
        color: #5B4FD4;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        margin-bottom: 20px;
    }

    .blog-title {
        font-family: 'Instrument Serif', serif;
        font-size: clamp(42px, 6vw, 72px);
        line-height: 1.08;
        font-weight: 400;
        letter-spacing: -0.03em;
        color: #1A1825;
        margin-bottom: 18px;
    }

    .blog-title em {
        font-style: italic;
        background: linear-gradient(135deg, #9F94F2 0%, #7B6FE8 50%, #5B4FD4 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .blog-sub {
        max-width: 640px;
        margin: 0 auto;
        font-size: 16px;
        line-height: 1.7;
        color: #4A4660;
    }

    .blog-wrap {
        max-width: 1180px;
        margin: 0 auto;
        padding: 0 20px 90px;
    }

    .blog-featured {
        display: grid;
        grid-template-columns: 1.2fr .8fr;
        gap: 24px;
        margin-bottom: 32px;
    }

    .featured-card,
    .blog-card {
        background: rgba(255,255,255,0.72);
        backdrop-filter: blur(24px);
        border: 1px solid rgba(255,255,255,0.92);
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(30,58,95,0.06);
        text-decoration: none;
        color: inherit;
        transition: .3s ease;
    }

    .featured-card:hover,
    .blog-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(30,58,95,0.12);
    }

    .featured-image {
        height: 320px;
        background: linear-gradient(135deg, #1E3A5F 0%, #5B4FD4 100%);
        position: relative;
    }

    .featured-tag,
    .blog-tag {
        position: absolute;
        top: 18px;
        left: 18px;
        padding: 6px 14px;
        border-radius: 999px;
        background: rgba(255,255,255,0.16);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.18);
        color: white;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .featured-content,
    .blog-content {
        padding: 28px;
    }

    .blog-meta {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
        font-size: 12px;
        color: #8B87A8;
        margin-bottom: 14px;
    }

    .featured-heading,
    .blog-heading {
        font-family: 'Instrument Serif', serif;
        font-size: 34px;
        line-height: 1.15;
        letter-spacing: -.02em;
        color: #1A1825;
        margin-bottom: 14px;
        font-weight: 400;
    }

    .blog-heading {
        font-size: 24px;
    }

    .featured-desc,
    .blog-desc {
        font-size: 14px;
        line-height: 1.8;
        color: #5D5875;
    }

    .blog-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 22px;
    }

    .blog-image {
        height: 180px;
        background: linear-gradient(135deg, #1E3A5F 0%, #2D5F9E 100%);
        position: relative;
    }

    .blog-card:nth-child(2) .blog-image {
        background: linear-gradient(135deg, #7B6FE8 0%, #1E3A5F 100%);
    }

    .blog-card:nth-child(3) .blog-image {
        background: linear-gradient(135deg, #0F766E 0%, #1E3A5F 100%);
    }

    .read-btn {
        margin-top: 18px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #5B4FD4;
        font-size: 13px;
        font-weight: 700;
    }

    @media (max-width: 920px) {
        .blog-featured,
        .blog-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')

<section class="blog-hero">
    <div class="container">
        <div class="blog-eyebrow">
            <i class="fa-solid fa-newspaper"></i>
            Blog & News
        </div>

        <h1 class="blog-title">
            Insight, berita, dan<br><em>inspirasi pendidikan</em>
        </h1>

        <p class="blog-sub">
            Temukan artikel terbaru seputar teknologi, pendidikan, universitas partner, karier, dan perkembangan dunia digital bersama Coursify.
        </p>
    </div>
</section>

<section class="blog-wrap">

    <div class="blog-featured">
        <a href="#" class="featured-card">
            <div class="featured-image">
                <span class="featured-tag">Featured Article</span>
            </div>

            <div class="featured-content">
                <div class="blog-meta">
                    <span><i class="fa-solid fa-calendar"></i> 12 Mei 2026</span>
                    <span><i class="fa-solid fa-user"></i> Tim Coursify</span>
                </div>

                <h2 class="featured-heading">
                    Transformasi pembelajaran digital di era AI dan teknologi modern
                </h2>

                <p class="featured-desc">
                    Bagaimana artificial intelligence mengubah cara mahasiswa belajar, berinteraksi, dan mengembangkan skill di era digital.
                </p>

                <div class="read-btn">
                    Baca Selengkapnya
                    <i class="fa-solid fa-arrow-right"></i>
                </div>
            </div>
        </a>

        <div class="featured-card" style="padding:28px; display:flex; flex-direction:column; justify-content:center; background:linear-gradient(135deg,#1E3A5F 0%,#10243D 100%); color:white;">
            <div style="font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#B8AFEB;margin-bottom:14px;">
                Newsletter
            </div>

            <h3 style="font-family:'Instrument Serif',serif;font-size:34px;line-height:1.15;font-weight:400;margin-bottom:14px;">
                Dapatkan update artikel terbaru
            </h3>

            <p style="font-size:14px;line-height:1.8;color:rgba(255,255,255,.7);margin-bottom:22px;">
                Subscribe newsletter Coursify dan dapatkan insight pendidikan terbaru langsung ke email Anda.
            </p>

            <div style="display:flex;gap:10px;flex-wrap:wrap;">
                <input type="email" placeholder="Masukkan email" style="flex:1;padding:14px 18px;border:none;border-radius:999px;font-family:'Inter',sans-serif;outline:none;min-width:180px;">

                <button style="padding:14px 22px;border:none;border-radius:999px;background:white;color:#1E3A5F;font-weight:700;cursor:pointer;">
                    Subscribe
                </button>
            </div>
        </div>
    </div>

    <div class="blog-grid">

        <a href="#" class="blog-card">
            <div class="blog-image">
                <span class="blog-tag">Technology</span>
            </div>

            <div class="blog-content">
                <div class="blog-meta">
                    <span>10 Mei 2026</span>
                    <span>5 min read</span>
                </div>

                <h3 class="blog-heading">
                    Skill teknologi paling dicari perusahaan tahun 2026
                </h3>

                <p class="blog-desc">
                    Pelajari skill digital dan teknologi yang paling dibutuhkan industri modern.
                </p>

                <div class="read-btn">
                    Baca Artikel
                    <i class="fa-solid fa-arrow-right"></i>
                </div>
            </div>
        </a>

        <a href="#" class="blog-card">
            <div class="blog-image">
                <span class="blog-tag">University</span>
            </div>

            <div class="blog-content">
                <div class="blog-meta">
                    <span>08 Mei 2026</span>
                    <span>7 min read</span>
                </div>

                <h3 class="blog-heading">
                    Universitas partner baru bergabung dengan Coursify
                </h3>

                <p class="blog-desc">
                    Coursify resmi menjalin kerja sama dengan universitas ternama di Indonesia.
                </p>

                <div class="read-btn">
                    Baca Artikel
                    <i class="fa-solid fa-arrow-right"></i>
                </div>
            </div>
        </a>

        <a href="#" class="blog-card">
            <div class="blog-image">
                <span class="blog-tag">Career</span>
            </div>

            <div class="blog-content">
                <div class="blog-meta">
                    <span>05 Mei 2026</span>
                    <span>6 min read</span>
                </div>

                <h3 class="blog-heading">
                    Tips membangun portofolio mahasiswa yang menarik recruiter
                </h3>

                <p class="blog-desc">
                    Strategi membangun CV dan portofolio digital untuk meningkatkan peluang karier.
                </p>

                <div class="read-btn">
                    Baca Artikel
                    <i class="fa-solid fa-arrow-right"></i>
                </div>
            </div>
        </a>

    </div>
</section>

@endsection