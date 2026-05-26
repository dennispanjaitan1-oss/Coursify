// ============================================================
// Coursify Auto Scraper - content.js (FULL UPDATED)
// ============================================================

if (window.location.href.includes('google.com/search')) {
  setTimeout(() => {
    let resultUrl = null;
    const links = document.querySelectorAll('div#search a');
    for (let i = 0; i < links.length; i++) {
      const href = links[i].href;
      if (href && href.includes('edx.org') &&
          (href.includes('/learn/') || href.includes('/course/'))) {
        let rawHref = href;
        if (rawHref.includes('/url?q=')) {
          rawHref = decodeURIComponent(rawHref.split('/url?q=')[1].split('&')[0]);
        }
        resultUrl = rawHref;
        break;
      }
    }
    if (resultUrl) {
      window.location.href = resultUrl;
    } else {
      try {
        const port = chrome.runtime.connect({ name: 'scraper' });
        port.postMessage({ action: 'not_found_on_search' });
      } catch (e) {
        console.log('[Coursify] Error sending not_found:', e);
      }
    }
  }, 1500);
}

if (window.location.href.includes('edx.org') && !window.location.href.includes('learning.edx.org')) {
  setTimeout(() => {

    // ── 0. edX URL — simpan URL halaman yang sedang dibuka ────────
    const edxUrl = window.location.href.split('?')[0].replace(/\/$/, '');

    // ── 1. Description ────────────────────────────────────────────
    let desc = "";
    const descParagraphs = [];

    const descEls = document.querySelectorAll('p.text-base.md\\:text-lg.text-gray-800.font-sans');
    descEls.forEach(el => {
      const text = el.innerText.trim();
      if (text.length > 30) descParagraphs.push(text);
    });

    if (descParagraphs.length === 0) {
      const containers = document.querySelectorAll('div.text-gray-800, div[class*="description"], div[class*="about"]');
      for (let container of containers) {
        const paras = container.querySelectorAll('p');
        paras.forEach(p => {
          const text = p.innerText.trim();
          if (text.length > 50) descParagraphs.push(text);
        });
        if (descParagraphs.length > 0) break;
      }
    }

    if (descParagraphs.length === 0) {
      document.querySelectorAll('main p, article p, section p').forEach(p => {
        const text = p.innerText.trim();
        if (text.length > 100) descParagraphs.push(text);
      });
    }

    desc = descParagraphs.join('\n\n');
    console.log("[Coursify] description paragraphs:", descParagraphs.length, "| total length:", desc.length);

    // ── 2. Short Description ──────────────────────────────────────
    let shortDesc = "";

    const shortDescSelectors = [
      'div.line-clamp-2 p', 'div.line-clamp-3 p',
      'p[class*="subtitle"]', 'h2 + p',
      'div[class*="hero"] p', 'div[class*="banner"] p',
      'meta[name="description"]',
    ];

    for (let selector of shortDescSelectors) {
      if (selector === 'meta[name="description"]') {
        const meta = document.querySelector(selector);
        if (meta && meta.getAttribute('content')?.trim().length > 30) {
          shortDesc = meta.getAttribute('content').trim();
          break;
        }
      } else {
        const el = document.querySelector(selector);
        if (el && el.innerText?.trim().length > 30) {
          shortDesc = el.innerText.trim();
          break;
        }
      }
    }

    if (!shortDesc && desc.length > 0) {
      const firstSentences = desc.split(/\. /);
      shortDesc = firstSentences.slice(0, 2).join('. ').trim();
      if (shortDesc.length > 300) shortDesc = shortDesc.substring(0, 297) + '...';
    }

    console.log("[Coursify] short_description length:", shortDesc.length);

    // ── 3. Syllabus ───────────────────────────────────────────────
    let syllabus = [];
    document.querySelectorAll('div.md\\:columns-2 li').forEach(li => {
      if (li.innerText.trim()) syllabus.push(li.innerText.trim());
    });
    if (syllabus.length === 0) {
      document.querySelectorAll('ul[class*="syllabus"] li, div[class*="what-you"] li, section[class*="learn"] li').forEach(li => {
        if (li.innerText.trim().length > 5) syllabus.push(li.innerText.trim());
      });
    }
    console.log("[Coursify] syllabus items:", syllabus.length);

    // ── 4. Curriculum ─────────────────────────────────────────────
    let parsedCurriculum = [];
    let rawCurriculumText = "";
    document.querySelectorAll('div.prose p, div.prose h2, div.prose h3').forEach(el => {
      rawCurriculumText += el.innerText + "\n";
    });
    if (rawCurriculumText.trim()) {
      parsedCurriculum = parseCurriculum(rawCurriculumText);
    }
    console.log("[Coursify] curriculum sections:", parsedCurriculum.length);

    // ── 5. Language, Transcripts, Content Translation, Prerequisites ──
    let language = "";
    let transcripts = [];
    let contentTranslation = [];
    let prerequisites = "";

    const labelEls = document.querySelectorAll('p.text-primary');
    const knownLabels = ['language', 'transcripts', 'content translation', 'prerequisites'];

    labelEls.forEach(el => {
      const label = el.innerText.trim().toLowerCase();
      if (!knownLabels.includes(label)) return;
      let values = [];
      let sibling = el.nextElementSibling;
      while (sibling) {
        const sibText = sibling.innerText.trim();
        if (sibling.tagName === 'P' && sibling.classList.contains('text-primary')) break;
        if (sibText) values.push(sibText);
        sibling = sibling.nextElementSibling;
      }
      if (label === 'language')            language = values[0] || "";
      if (label === 'transcripts')         transcripts = values;
      if (label === 'content translation') contentTranslation = values;
      if (label === 'prerequisites')       prerequisites = values.join(', ');
    });

    console.log("[Coursify] language:", language);

    // ── 6. Difficulty, Pace, Effort ───────────────────────────────
    let difficulty  = "";
    let isSelfPaced = false;
    let effort      = "";

    const infoBlocks = document.querySelectorAll('div.md\\:pr-12.\\!pr-0');
    const seen = new Set();

    infoBlocks.forEach(block => {
      const text = block.innerText.trim();
      if (seen.has(text)) return;
      seen.add(text);
      const lower = text.toLowerCase();

      if (!difficulty) {
        if (lower.includes('introductory') || lower.includes('no prior experience')) {
          difficulty = 'beginner';
        } else if (lower.includes('intermediate')) {
          difficulty = 'intermediate';
        } else if (lower.includes('advanced')) {
          difficulty = 'advanced';
        }
      }

      if (lower.includes('self-paced') || lower.includes('self paced')) isSelfPaced = true;

      if (!effort && /\d+\s*weeks?/i.test(text) && /hours?\s*per\s*week/i.test(text)) {
        effort = text.replace(/\n/g, ', ').trim();
      } else if (!effort && /\d+\s*weeks?/i.test(text) && !lower.includes('earn') && !lower.includes('certificate')) {
        effort = text.replace(/\n/g, ', ').trim();
      }
    });

    if (!effort) {
      const bodyText = document.body.innerText;
      const patterns = [
        /(\d+)\s*weeks?,\s*([\d]+[-–][\d]+|\d+)\s*hours?\s*per\s*week/i,
        /(\d+[-–]\d+)\s*weeks?,\s*([\d]+[-–][\d]+|\d+)\s*hours?\s*per\s*week/i,
        /(\d+)\s*weeks?\s*\|\s*([\d]+[-–][\d]+|\d+)\s*hours?\s*per\s*week/i,
        /([\d]+[-–][\d]+|\d+)\s*hours?\s*per\s*week,\s*(\d+)\s*weeks?/i,
      ];
      for (let pattern of patterns) {
        const match = bodyText.match(pattern);
        if (match) { effort = match[0].trim(); break; }
      }
      if (!effort) {
        const matchWeeks = bodyText.match(/(\d+[-–]\d+|\d+)\s*weeks?\s+to\s+complete/i)
                        || bodyText.match(/(\d+[-–]\d+|\d+)\s*weeks?\s+duration/i);
        if (matchWeeks) effort = matchWeeks[0].trim();
      }
    }

    console.log("[Coursify] difficulty:", difficulty, "| self_paced:", isSelfPaced, "| effort:", effort);

    // ── 7. Start Date & End Date ──────────────────────────────────
    let startDate = "";
    let endDate   = "";

    const dateBlock = document.querySelector('div.text-center.md\\:text-left');
    if (dateBlock) {
      const dateText = dateBlock.innerText.trim();
      const startMatch = dateText.match(/Starts?\s+([A-Za-z]+\s+\d{1,2},?\s*\d{4}|[A-Za-z]+\s+\d{1,2})/i);
      const endMatch   = dateText.match(/Ends?\s+([A-Za-z]+\s+\d{1,2},?\s*\d{4})/i);
      if (startMatch) startDate = startMatch[1].trim();
      if (endMatch)   endDate   = endMatch[1].trim();
    }

    console.log("[Coursify] startDate:", startDate, "| endDate:", endDate);

    // ── 8. Price ──────────────────────────────────────────────────
    let price = "";
    const priceEls = document.querySelectorAll('.font-bold.text-lg.break-all, .font-bold.break-all.text-lg');
    for (let el of priceEls) {
      if (/\$[\d,]+/.test(el.innerText.trim())) { price = el.innerText.trim(); break; }
    }
    if (!price) {
      const bodyText = document.body.innerText;
      if (bodyText.match(/audit this course for free/i)) price = "Free";
      else { const m = bodyText.match(/\$[\d,]+(\.\d{2})?/); if (m) price = m[0]; }
    }
    console.log("[Coursify] price:", price);

    // ── 9. Instructors ────────────────────────────────────────────
    // DIUPDATE: pakai selector a[class*="min-w-[200px]"] yang sudah dikonfirmasi
    let instructors = [];

    // Selector utama — sudah dikonfirmasi via DevTools
    const instructorCards = document.querySelectorAll('a[class*="min-w-[200px]"]');

    if (instructorCards.length > 0) {
      instructorCards.forEach(card => {
        const nameEl  = card.querySelector('p.text-lg.font-bold');
        const titleEl = card.querySelector('p.text-base, p.text-sm');
        const name    = nameEl?.innerText?.trim();
        if (!name) return;

        const allImgs = card.querySelectorAll('img');
        let photoUrl = null;
        let logoUrl  = null;

        allImgs.forEach(imgEl => {
            const src = imgEl.src || '';
            const alt = (imgEl.alt || '').toLowerCase();
            const cls = (imgEl.className || '').toLowerCase();

            const isLikelyLogo =
                alt.match(/^[0-9a-f-]{36}$/) ||   // UUID alt (pola lama edX)
                cls.includes('logo') ||
                alt.includes('logo') ||
                alt.includes('university') ||
                alt.includes('institute') ||
                alt.includes('college') ||
                src.includes('logo') ||
                src.includes('institution');

            if (isLikelyLogo && !logoUrl) logoUrl = src;
            else if (!isLikelyLogo && !photoUrl) photoUrl = src;
        });

        instructors.push({
          name,
          title:                titleEl?.innerText?.trim() || "",
          photo_url:            photoUrl,
          institution_logo_url: logoUrl,
        });
      });
    }

    // Fallback 1 — div card dengan class instructor/staff/educator
    if (instructors.length === 0) {
      const divCards = document.querySelectorAll(
        'div[class*="instructor"], div[class*="staff"], div[class*="educator"]'
      );
      divCards.forEach(card => {
        const nameEl  = card.querySelector('p.text-lg.font-bold, h3, h4');
        const titleEl = card.querySelector('p.text-base, p.text-sm');
        const name    = nameEl?.innerText?.trim();
        if (!name) return;

        let photoUrl = null;
        let logoUrl  = null;
        card.querySelectorAll('img').forEach(img => {
          const src = img.src || '';
          if (!src) return;
          const alt = (img.alt || '').toLowerCase();
          const cls = (img.className || '').toLowerCase();
          const isLogo = cls.includes('logo') || alt.includes('logo') ||
                         alt.includes('university') || alt.includes('institute');
          if (isLogo && !logoUrl) logoUrl = src;
          else if (!isLogo && !photoUrl) photoUrl = src;
        });

        instructors.push({
          name,
          title:                titleEl?.innerText?.trim() || "",
          photo_url:            photoUrl,
          institution_logo_url: logoUrl,
        });
      });
    }

    // Fallback 2 — selector lama berdasarkan class spesifik edX
    if (instructors.length === 0) {
      const nameEls  = document.querySelectorAll('p.text-lg.font-bold.lg\\:text-base.m-0.text-secondary-500');
      const titleEls = document.querySelectorAll('p.text-base.font-bold.md\\:font-normal.lg\\:text-sm.m-0.text-gray-800');

      nameEls.forEach((nameEl, i) => {
        const name = nameEl.innerText.trim();
        if (!name) return;
        const card = nameEl.closest('div[class*="flex"], div[class*="grid"], li, article')
                  || nameEl.parentElement?.parentElement;
        let photoUrl = null;
        let logoUrl  = null;
        if (card) {
          card.querySelectorAll('img').forEach(img => {
            const src = img.src || '';
            if (!src) return;
            const alt = (img.alt || '').toLowerCase();
            const cls = (img.className || '').toLowerCase();
            const isLogo = cls.includes('logo') || alt.includes('logo') ||
                           alt.includes('university') || alt.includes('mit') ||
                           alt.includes('harvard') || alt.includes('stanford');
            if (isLogo && !logoUrl) logoUrl = src;
            else if (!isLogo && !photoUrl) photoUrl = src;
          });
        }
        instructors.push({
          name,
          title:                titleEls[i]?.innerText?.trim() || "",
          photo_url:            photoUrl,
          institution_logo_url: logoUrl,
        });
      });
    }

    console.log("[Coursify] instructors:", instructors.length, "| edx_url:", edxUrl);

    // ── Kirim ke background.js via Port ───────────────────────────
    const payload = {
      edx_url:             edxUrl,
      description:         desc,
      short_description:   shortDesc,
      syllabus,
      curriculum:          parsedCurriculum,
      language,
      transcripts,
      content_translation: contentTranslation,
      prerequisites,
      difficulty,
      is_self_paced:       isSelfPaced,
      start_date:          startDate,
      end_date:            endDate,
      effort,
      price,
      instructors,
    };

    function sendWithRetry(attempt) {
      attempt = attempt || 1;
      try {
        const port = chrome.runtime.connect({ name: 'scraper' });
        port.postMessage({ action: 'scraped_data', data: payload });
        console.log('[Coursify] Data sent via port, attempt:', attempt);
        port.onDisconnect.addListener(() => {
          if (chrome.runtime.lastError) {
            console.log('[Coursify] Port disconnect:', chrome.runtime.lastError.message);
          }
        });
      } catch (e) {
        console.log('[Coursify] Send error attempt ' + attempt + ':', e);
        if (attempt < 3) setTimeout(() => sendWithRetry(attempt + 1), 2000);
      }
    }

    sendWithRetry(1);

  }, 4500);
}

// ── Parser Kurikulum ──────────────────────────────────────────
function parseCurriculum(text) {
  if (!text || !text.trim()) return [];
  const lines = text.split('\n');
  const sections = [];
  let currentSection = null;
  let sectionOrder = 1;
  let lessonOrder  = 1;

  function isMetadata(line) {
    line = line.trim().toLowerCase();
    if (!line) return true;
    const skips = ['video','reading','quiz','practice','graded','estimated','duration',
      'expand','collapse','expand all','collapse all','topics','lessons','minutes',
      'hours','mins','hrs','free preview','core topic','survey','video lecture','ungraded'];
    if (skips.includes(line)) return true;
    if (/^\d+\s+(topics?|lessons?|minutes?|hours?|mins?|hrs?|videos?|readings?|quizzes?)$/i.test(line)) return true;
    if (/^\d+\s*(m|h|min|mins|hour|hours|sec|secs)$/i.test(line)) return true;
    return false;
  }

  lines.forEach(line => {
    const cleanLine = line.trim();
    if (!cleanLine) return;
    let isSection    = false;
    let sectionTitle = cleanLine;
    const secRegex  = /^(section|module|week|bagian|bab|unit|chapter|\d+)\s*(?:\d+)?\s*[:\-\.\s]\s*(.*)$/i;
    const secRegex2 = /^(section|module|week|bagian|bab|unit|chapter)\s*(\d+)$/i;
    if (secRegex.test(cleanLine)) {
      const m = cleanLine.match(secRegex);
      isSection    = true;
      sectionTitle = m[2] ? m[2].trim() : cleanLine;
    } else if (secRegex2.test(cleanLine)) {
      isSection = true;
    } else if (/^\d+\.\s+.*$/.test(cleanLine)) {
      isSection = true;
    }
    if (isSection) {
      currentSection = { title: sectionTitle, order_index: sectionOrder++, lessons: [] };
      sections.push(currentSection);
      lessonOrder = 1;
    } else if (!isMetadata(cleanLine)) {
      if (!currentSection) {
        currentSection = { title: "Bagian 1: Pendahuluan", order_index: sectionOrder++, lessons: [] };
        sections.push(currentSection);
      }
      const cleanLesson = cleanLine.replace(/^(lesson|materi)?\s*(?:\d+\.\d+|\d+)\s*[:\-\.\s]\s*/i, '');
      currentSection.lessons.push({ title: cleanLesson, order_index: lessonOrder++ });
    }
  });
  return sections;
}