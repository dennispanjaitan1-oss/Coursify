"""
edX Scraper — dengan Session Cookie (Login)
============================================
Scraping: deskripsi, bahasa, sub-bab, kurikulum, durasi
Pakai session cookie dari browser agar bisa akses semua kursus.

CARA AMBIL SESSION COOKIE (Chrome/Firefox):
  1. Buka https://courses.edx.org dan LOGIN
  2. F12 → Application → Cookies → courses.edx.org
  3. Salin nilai cookie: sessionid, csrftoken, edxloggedin, edx-user-info
  4. Paste di bagian COOKIE_CONFIG di bawah

Cara pakai:
    pip install requests beautifulsoup4
    python edx_scraper.py

Output:
    edx_courses.csv   - flat (1 baris per kursus)
    edx_courses.json  - nested dengan syllabus & kurikulum lengkap
"""

import requests
import json
import csv
import time
import re
from bs4 import BeautifulSoup

# ─── ✏️  KONFIGURASI UTAMA ────────────────────────────────────────────────────

# 1. Paste cookie dari browser kamu di sini:
COOKIE_CONFIG = {
    "sessionid":    "PASTE_SESSION_ID_KAMU_DI_SINI",
    "csrftoken":    "PASTE_CSRF_TOKEN_KAMU_DI_SINI",
    "edxloggedin":  "true",
    # Opsional tapi membantu:
    # "edx-user-info": '{"username":"namakamu",...}',
}

# 2. Ubah sesuai kebutuhan pencarian:
KEYWORD   = "python"    # topik, atau "" untuk semua
ORG       = ""          # "HarvardX", "MITx", atau "" untuk semua
MAX_PAGES = 2           # 1 halaman ≈ 100 kursus

# 3. Output:
OUTPUT_CSV  = "edx_courses.csv"
OUTPUT_JSON = "edx_courses.json"
DELAY_SEC   = 1.2       # jeda antar request (jangan terlalu cepat)

# ─── ENDPOINT ────────────────────────────────────────────────────────────────

BASE_URL        = "https://courses.edx.org"
COURSE_API      = f"{BASE_URL}/api/courses/v1/courses/"
COURSE_DETAIL   = f"{BASE_URL}/api/courses/v1/courses/{{course_id}}/"
BLOCKS_API      = f"{BASE_URL}/api/courses/v1/blocks/"
COURSEWARE_URL  = f"{BASE_URL}/courses/{{course_id}}/courseware"

HEADERS = {
    "User-Agent":      "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36",
    "Accept":          "application/json, text/html, */*",
    "Accept-Language": "en-US,en;q=0.9",
    "Referer":         "https://www.edx.org/",
    "X-Requested-With": "XMLHttpRequest",
}


# ─── SESSION SETUP ───────────────────────────────────────────────────────────

def build_session() -> requests.Session:
    """Buat session dengan cookie login."""
    s = requests.Session()
    s.headers.update(HEADERS)
    # Set cookie
    for k, v in COOKIE_CONFIG.items():
        s.cookies.set(k, v, domain=".edx.org")
        s.cookies.set(k, v, domain="courses.edx.org")
    # Set CSRF header
    s.headers["X-CSRFToken"] = COOKIE_CONFIG.get("csrftoken", "")
    return s


SESSION = build_session()


def is_logged_in() -> bool:
    """Cek apakah session/cookie valid."""
    r = SESSION.get(f"{BASE_URL}/api/user/v1/me", timeout=10)
    if r.status_code == 200:
        data = r.json()
        username = data.get("username", "")
        if username and username != "":
            print(f"✅ Login sebagai: {username}")
            return True
    print("⚠️  Cookie tidak valid / belum login — mode anonymous (syllabus terbatas)")
    return False


# ─── HELPER ──────────────────────────────────────────────────────────────────

def clean_html(text: str) -> str:
    if not text:
        return ""
    text = re.sub(r"<[^>]+>", " ", text)
    return re.sub(r"\s+", " ", text).strip()


def get_json(url: str, params: dict = None) -> dict | None:
    try:
        r = SESSION.get(url, params=params, timeout=20)
        if r.status_code == 200:
            return r.json()
        print(f"  ⚠ {r.status_code} → {url[:70]}")
    except Exception as e:
        print(f"  ⚠ Error: {e}")
    return None


def get_html(url: str) -> str:
    try:
        r = SESSION.get(url, timeout=20)
        if r.status_code == 200:
            return r.text
    except Exception as e:
        print(f"  ⚠ HTML error: {e}")
    return ""


# ─── 1. LIST KURSUS ──────────────────────────────────────────────────────────

def fetch_courses(keyword: str, org: str, max_pages: int) -> list[dict]:
    """
    GET /api/courses/v1/courses/
    Tersedia tanpa login, tapi dengan login dapat lebih banyak field.
    """
    courses = []
    params  = {"page_size": 100}
    if org:
        params["org"] = org
    if keyword:
        params["search_term"] = keyword

    url  = COURSE_API
    page = 1

    while url and page <= max_pages:
        print(f"  📄 Halaman {page} — terkumpul {len(courses)} kursus")
        data = get_json(url, params if page == 1 else None)
        if not data:
            break
        for c in data.get("results", []):
            courses.append({
                "course_id":  c.get("id", ""),
                "title":      c.get("name", ""),
                "org":        c.get("org", ""),
                "short_desc": clean_html(c.get("short_description", "")),
                "start":      c.get("start", ""),
                "end":        c.get("end", ""),
            })
        url = (data.get("pagination") or {}).get("next") or data.get("next")
        page += 1
        time.sleep(DELAY_SEC)

    return courses


# ─── 2. DETAIL KURSUS ────────────────────────────────────────────────────────

def fetch_detail(course_id: str) -> dict:
    """
    GET /api/courses/v1/courses/{course_id}/
    Dapat: language, effort, overview, pacing, blocks_url
    """
    url  = COURSE_DETAIL.format(course_id=course_id)
    data = get_json(url) or {}
    return {
        "language":   data.get("language", ""),
        "effort":     data.get("effort", ""),
        "overview":   clean_html(data.get("overview", "")),
        "pacing":     data.get("pacing", ""),
        "blocks_url": data.get("blocks_url", ""),
        "course_url": data.get("course_url") or f"https://www.edx.org/course/{course_id}",
    }


# ─── 3. SYLLABUS + KURIKULUM via Blocks API ──────────────────────────────────

def fetch_curriculum(blocks_url: str, course_id: str) -> dict:
    """
    Ambil FULL struktur kurikulum:
      course
        └─ chapter  (Bab / Week)
             └─ sequential  (Sub-bab / Lesson)
                  └─ vertical  (Unit)
                       └─ html/video/problem  (Konten)

    Dengan cookie login, bisa akses semua kursus yang sudah di-enroll.
    Tanpa login, hanya kursus publik.
    """
    if not blocks_url:
        return {"syllabus": [], "total_bab": 0, "total_sub_bab": 0,
                "total_unit": 0, "block_types": {}}

    params = {
        "depth":            "all",
        "requested_fields": "display_name,type,children,student_view_url,due,graded,format",
        "username":         "",   # kosong = pakai session aktif
        "block_counts":     "video,problem,html",
    }

    data = get_json(blocks_url, params)
    if not data or "blocks" not in data:
        return {"syllabus": [], "total_bab": 0, "total_sub_bab": 0,
                "total_unit": 0, "block_types": {}}

    blocks  = data["blocks"]
    root_id = data.get("root", "")

    # Hitung semua tipe blok
    block_types = {}
    for b in blocks.values():
        t = b.get("type", "unknown")
        block_types[t] = block_types.get(t, 0) + 1

    # Bangun tree syllabus
    syllabus    = []
    total_sub   = 0
    total_unit  = 0

    root_block = blocks.get(root_id, {})
    for ch_id in root_block.get("children", []):
        chapter = blocks.get(ch_id, {})
        if chapter.get("type") != "chapter":
            continue

        bab = {
            "bab":     chapter.get("display_name", ""),
            "sub_bab": []
        }

        for seq_id in chapter.get("children", []):
            seq = blocks.get(seq_id, {})
            if seq.get("type") != "sequential":
                continue

            sub = {
                "nama":    seq.get("display_name", ""),
                "graded":  seq.get("graded", False),
                "format":  seq.get("format", ""),  # "Homework", "Exam", dll
                "unit":    []
            }

            for vert_id in seq.get("children", []):
                vert = blocks.get(vert_id, {})
                if vert.get("type") != "vertical":
                    continue

                unit = {
                    "nama":   vert.get("display_name", ""),
                    "konten": []
                }

                for leaf_id in vert.get("children", []):
                    leaf = blocks.get(leaf_id, {})
                    ltype = leaf.get("type", "")
                    if ltype in ("html", "video", "problem", "discussion"):
                        unit["konten"].append({
                            "type": ltype,
                            "nama": leaf.get("display_name", ""),
                        })
                total_unit += 1
                sub["unit"].append(unit)

            bab["sub_bab"].append(sub)
            total_sub += 1

        syllabus.append(bab)

    return {
        "syllabus":      syllabus,
        "total_bab":     len(syllabus),
        "total_sub_bab": total_sub,
        "total_unit":    total_unit,
        "block_types":   block_types,    # jumlah video, problem, html, dsb
    }


# ─── 4. SCRAPE HALAMAN KURSUS (fallback syllabus via HTML) ───────────────────

def fetch_syllabus_html(course_id: str) -> list[str]:
    """
    Fallback: scrape halaman about course di edx.org
    untuk ambil syllabus dari HTML (tanpa login, publik).
    """
    url  = f"https://www.edx.org/course/{course_id.split('/')[-1]}"
    html = get_html(url)
    if not html:
        return []

    soup  = BeautifulSoup(html, "html.parser")
    items = []

    # Cari section syllabus
    for tag in soup.find_all(["h2", "h3", "li"]):
        text = tag.get_text(strip=True)
        if text and len(text) > 5:
            items.append(text)

    # Ambil yang relevan (biasanya dalam section "syllabus" atau "curriculum")
    return items[:50]  # max 50 item


# ─── 5. MAIN ─────────────────────────────────────────────────────────────────

def scrape() -> list[dict]:
    print("\n" + "=" * 65)
    print("  edX Scraper — Session Cookie Mode")
    print("=" * 65)

    logged_in = is_logged_in()
    print()

    # Step 1: List kursus
    print(f"🔍 Mencari kursus: keyword='{KEYWORD}', org='{ORG}'")
    courses = fetch_courses(KEYWORD, ORG, MAX_PAGES)
    print(f"\n✅ {len(courses)} kursus ditemukan\n")

    results = []

    for i, c in enumerate(courses, 1):
        cid   = c["course_id"]
        title = c["title"]
        print(f"\n[{i:03d}/{len(courses)}] {title[:58]}")
        print(f"   ID: {cid}")

        # Step 2: Detail
        detail = fetch_detail(cid)
        time.sleep(DELAY_SEC)

        # Step 3: Kurikulum via Blocks API
        curriculum = fetch_curriculum(detail.get("blocks_url", ""), cid)
        time.sleep(DELAY_SEC)

        # Step 4: Fallback syllabus HTML jika blocks kosong & tidak login
        syllabus_fallback = []
        if not logged_in and curriculum["total_bab"] == 0:
            syllabus_fallback = fetch_syllabus_html(cid)
            time.sleep(DELAY_SEC)

        # Summary print
        vid_count  = curriculum["block_types"].get("video", 0)
        prob_count = curriculum["block_types"].get("problem", 0)
        html_count = curriculum["block_types"].get("html", 0)

        print(f"   ✓ lang={detail['language'] or '-'} | "
              f"effort={detail['effort'] or '-'} | "
              f"pacing={detail['pacing'] or '-'}")
        print(f"   ✓ Bab={curriculum['total_bab']} | "
              f"Sub-bab={curriculum['total_sub_bab']} | "
              f"Unit={curriculum['total_unit']} | "
              f"Video={vid_count} | Soal={prob_count}")

        row = {
            # Identitas
            "course_id":        cid,
            "title":            title,
            "org":              c["org"],
            "course_url":       detail.get("course_url", ""),
            # Waktu
            "start":            c["start"],
            "end":              c["end"],
            "pacing":           detail.get("pacing", ""),
            # Bahasa & durasi
            "language":         detail.get("language", ""),
            "effort":           detail.get("effort", ""),
            # Deskripsi
            "short_desc":       c["short_desc"],
            "overview":         detail.get("overview", "")[:600],
            # Statistik kurikulum
            "total_bab":        curriculum["total_bab"],
            "total_sub_bab":    curriculum["total_sub_bab"],
            "total_unit":       curriculum["total_unit"],
            "total_video":      vid_count,
            "total_problem":    prob_count,
            "total_html":       html_count,
            # Data kurikulum lengkap (JSON string untuk CSV)
            "curriculum_json":  json.dumps(curriculum["syllabus"], ensure_ascii=False),
            # Fallback syllabus
            "syllabus_fallback": " | ".join(syllabus_fallback) if syllabus_fallback else "",
        }
        results.append(row)

    return results


# ─── 6. SIMPAN OUTPUT ────────────────────────────────────────────────────────

def save(data: list[dict]):
    if not data:
        print("\n❌ Tidak ada data.")
        return

    # CSV (flat)
    with open(OUTPUT_CSV, "w", newline="", encoding="utf-8-sig") as f:
        w = csv.DictWriter(f, fieldnames=data[0].keys())
        w.writeheader()
        w.writerows(data)
    print(f"\n💾 CSV  → {OUTPUT_CSV}  ({len(data)} baris)")

    # JSON (nested, curriculum_json di-parse jadi list)
    clean = []
    for row in data:
        r = dict(row)
        try:
            r["curriculum"] = json.loads(r.pop("curriculum_json", "[]"))
        except Exception:
            r["curriculum"] = []
        clean.append(r)

    with open(OUTPUT_JSON, "w", encoding="utf-8") as f:
        json.dump(clean, f, ensure_ascii=False, indent=2)
    print(f"💾 JSON → {OUTPUT_JSON}")


# ─── PREVIEW ─────────────────────────────────────────────────────────────────

def preview(data: list[dict], n: int = 2):
    print("\n" + "=" * 65)
    print(f"  PREVIEW {n} KURSUS PERTAMA")
    print("=" * 65)
    for row in data[:n]:
        print(f"\n📚 {row['title']}")
        print(f"   Org      : {row['org']}")
        print(f"   Bahasa   : {row['language'] or '(tidak tersedia)'}")
        print(f"   Durasi   : {row['effort'] or '(tidak tersedia)'}")
        print(f"   Pacing   : {row['pacing']}")
        print(f"   Video    : {row['total_video']} | Soal: {row['total_problem']}")
        print(f"   Deskripsi: {row['short_desc'][:100]}...")

        kurikulum = json.loads(row.get("curriculum_json", "[]"))
        if kurikulum:
            print(f"   Kurikulum ({len(kurikulum)} Bab):")
            for bab in kurikulum[:3]:
                print(f"     📁 {bab['bab']}")
                for sub in bab["sub_bab"][:3]:
                    nama_sub = sub["nama"] if isinstance(sub, dict) else sub
                    print(f"        └─ {nama_sub}")
                if len(bab["sub_bab"]) > 3:
                    print(f"        └─ ... (+{len(bab['sub_bab'])-3} sub-bab)")
        elif row.get("syllabus_fallback"):
            print(f"   Syllabus (fallback HTML):")
            items = row["syllabus_fallback"].split(" | ")[:5]
            for item in items:
                print(f"     • {item}")


# ─── JALANKAN ────────────────────────────────────────────────────────────────

if __name__ == "__main__":
    hasil = scrape()
    save(hasil)
    if hasil:
        preview(hasil)

