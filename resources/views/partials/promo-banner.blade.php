<style>
    .promo-bar {
        background: var(--navy);
        color: white;
        padding: 10px 50px 10px 20px;
        text-align: center;
        position: relative;
        font-size: 13px;
        font-weight: 500;
        line-height: 1.5;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        transition: all 0.3s ease;
    }
    .promo-bar.hidden {
        display: none;
    }
    .promo-bar-dot {
        display: inline-block;
        width: 6px;
        height: 6px;
        background: #B8AFEB;
        border-radius: 50%;
        margin-right: 8px;
        vertical-align: middle;
        animation: pulse 2s infinite;
    }
    .promo-bar a {
        color: #B8AFEB;
        font-weight: 700;
        text-decoration: underline;
        margin-left: 6px;
    }
    .promo-bar a:hover { color: white; }
    .promo-code {
        display: inline-block;
        background: rgba(184,175,235,0.25);
        border: 1px solid rgba(184,175,235,0.4);
        color: #D4CCFF;
        padding: 1px 8px;
        border-radius: 4px;
        font-family: monospace;
        font-size: 13px;
        font-weight: 700;
        margin: 0 2px;
        letter-spacing: 0.05em;
    }
    .promo-close {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: rgba(255,255,255,0.5);
        cursor: pointer;
        font-size: 20px;
        line-height: 1;
        padding: 4px 6px;
        border-radius: 4px;
        transition: all 0.2s;
    }
    .promo-close:hover {
        color: white;
        background: rgba(255,255,255,0.1);
    }
</style>

<div id="promo-bar" class="promo-bar">
    <span class="promo-bar-dot"></span>
    Mulai belajar hari ini! Dapatkan <strong>30% off</strong> untuk semua kursus premium hingga 31 Mei 2025.
    Gunakan kode <span class="promo-code">BELAJAR30</span>.
    <a href="#pricing">Pelajari lebih lanjut →</a>
    <button class="promo-close" onclick="closePromoBanner()" aria-label="Tutup notifikasi">×</button>
</div>

<script>
    (function () {
        if (localStorage.getItem('coursify_promo_closed') === '1') {
            var bar = document.getElementById('promo-bar');
            if (bar) bar.style.display = 'none';
        }
    })();

    function closePromoBanner() {
        var bar = document.getElementById('promo-bar');
        if (bar) {
            bar.style.opacity = '0';
            bar.style.maxHeight = '0';
            bar.style.padding = '0';
            bar.style.overflow = 'hidden';
            setTimeout(function () { bar.style.display = 'none'; }, 300);
        }
        localStorage.setItem('coursify_promo_closed', '1');
    }
</script>