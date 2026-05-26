// background.js - Coursify Auto Scraper

let isScraping = false;
let currentCourse = null;
let currentTabId = null;
let waitingForVerification = false;
let verificationCheckInterval = null;

const API_URL = "http://localhost:8000/api/scrape";

// ── Port listener — keeps SW alive saat content.js kirim data ─
chrome.runtime.onConnect.addListener((port) => {
  if (port.name !== 'scraper') return;
  port.onMessage.addListener((request) => {
    const sender = port.sender;
    if (request.action === 'scraped_data') {
      if (waitingForVerification) {
        console.log('[Coursify] Masih menunggu verifikasi, data diabaikan.');
        return;
      }
      if (isScraping && currentCourse && sender?.tab?.id === currentTabId) {
        saveDataToLaravel(request.data);
      }
    } else if (request.action === 'not_found_on_search') {
      if (waitingForVerification) return;
      if (isScraping && currentCourse && sender?.tab?.id === currentTabId) {
        if (currentTabId) {
          try { chrome.tabs.remove(currentTabId); } catch(e) {}
        }
        saveDataToLaravel({
          edx_url: "", description: null, short_description: "",
          syllabus: [], curriculum: [],
          language: "", effort: "", price: "", instructors: []
        });
      }
    }
  });
});

// ── Listener Messages dari popup ─────────────────────────────
chrome.runtime.onMessage.addListener((request, sender, sendResponse) => {
  if (request.action === 'start') {
    isScraping = true;
    waitingForVerification = false;
    chrome.storage.local.set({ isScraping: true });
    processNextCourse();

  } else if (request.action === 'stop') {
    isScraping = false;
    waitingForVerification = false;
    clearVerificationCheck();
    chrome.storage.local.set({ isScraping: false });
  }
});

// ── Pantau perubahan URL tab ──────────────────────────────────
chrome.tabs.onUpdated.addListener((tabId, changeInfo, tab) => {
  if (tabId !== currentTabId) return;
  if (changeInfo.status !== 'complete') return;

  const url = tab.url || '';

  const isVerifPage =
    url.includes('challenges.cloudflare.com') ||
    url.includes('/cdn-cgi/challenge') ||
    url.includes('edx.org/verify') ||
    (url.includes('edx.org') &&
      !url.includes('/learn/') &&
      !url.includes('/course/') &&
      !url.includes('learning.edx.org') &&
      !url.includes('google.com'));

  const isEdxCoursePage =
    url.includes('edx.org') &&
    (url.includes('/learn/') || url.includes('/course/'));

  if (isVerifPage && !waitingForVerification) {
    waitingForVerification = true;
    clearVerificationCheck();
    console.log('[Coursify] ⚠️ Halaman verifikasi terdeteksi! Menunggu user...');
    chrome.tabs.update(currentTabId, { active: true });
    startVerificationCheck();
  }

  if (waitingForVerification && isEdxCoursePage) {
    console.log('[Coursify] ✅ Verifikasi selesai, halaman course dimuat.');
    waitingForVerification = false;
    clearVerificationCheck();
  }
});

// ── Tab ditutup paksa saat scraping ──────────────────────────
chrome.tabs.onRemoved.addListener((tabId) => {
  if (tabId !== currentTabId) return;
  if (waitingForVerification) {
    console.log('[Coursify] Tab verifikasi ditutup user, skip course ini.');
    waitingForVerification = false;
    clearVerificationCheck();
    currentTabId = null;
    if (currentCourse) {
      fetch(`${API_URL}/save`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify({
          course_id: currentCourse.id,
          edx_url: "", description: "", short_description: "",
          syllabus: [], curriculum: [],
          language: "", effort: "", price: "", instructors: []
        })
      }).catch(() => {});
      currentCourse = null;
    }
    setTimeout(processNextCourse, Math.floor(Math.random() * 4000) + 3000);
  }
});

// ── Cek berkala apakah verifikasi sudah selesai ───────────────
function startVerificationCheck() {
  verificationCheckInterval = setInterval(() => {
    if (!waitingForVerification || !currentTabId) {
      clearVerificationCheck();
      return;
    }
    chrome.tabs.get(currentTabId, (tab) => {
      if (chrome.runtime.lastError || !tab) {
        clearVerificationCheck();
        return;
      }
      const url = tab.url || '';
      const isEdxCoursePage =
        url.includes('edx.org') &&
        (url.includes('/learn/') || url.includes('/course/'));
      if (isEdxCoursePage) {
        console.log('[Coursify] ✅ Verifikasi terdeteksi selesai via interval check.');
        waitingForVerification = false;
        clearVerificationCheck();
      }
    });
  }, 2000);
}

function clearVerificationCheck() {
  if (verificationCheckInterval) {
    clearInterval(verificationCheckInterval);
    verificationCheckInterval = null;
  }
}

// ── Ambil course berikutnya ───────────────────────────────────
async function processNextCourse() {
  if (!isScraping || waitingForVerification) return;

  currentCourse = null;
  currentTabId = null;

  try {
    const res = await fetch(`${API_URL}/next`);
    const data = await res.json();

    if (data.status === 'done' || !data.course) {
      isScraping = false;
      chrome.storage.local.set({ isScraping: false });
      console.log('[Coursify] 🎉 Semua course selesai diproses!');
      return;
    }

    currentCourse = data.course;
    console.log(`[Coursify] ▶ Processing: ${currentCourse.title} (id: ${currentCourse.id})`);

    const query = encodeURIComponent(`site:edx.org ${currentCourse.title}`);
    const searchUrl = `https://www.google.com/search?q=${query}`;

    chrome.tabs.create({ url: searchUrl, active: false }, (tab) => {
      currentTabId = tab.id;
      console.log(`[Coursify] Tab dibuat: ${currentTabId}`);
    });

  } catch (e) {
    console.error('[Coursify] Error fetching next course:', e);
    setTimeout(processNextCourse, 5000);
  }
}

// ── Simpan data ke Laravel ────────────────────────────────────
async function saveDataToLaravel(scrapedData) {
  if (waitingForVerification) return;

  const courseToSave = currentCourse;
  const tabToClose   = currentTabId;

  currentCourse = null;
  currentTabId  = null;

  if (tabToClose) {
    try { chrome.tabs.remove(tabToClose); } catch(e) {}
  }

  if (!courseToSave) {
    console.error('[Coursify] currentCourse null, skip.');
    setTimeout(processNextCourse, Math.floor(Math.random() * 4000) + 3000);
    return;
  }

  try {
    console.log(`[Coursify] 💾 Menyimpan: ${courseToSave.title}`);
    const response = await fetch(`${API_URL}/save`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        course_id:           courseToSave.id,
        edx_url:             scrapedData.edx_url             || "",  // ← DITAMBAHKAN
        description:         scrapedData.description         || "",
        short_description:   scrapedData.short_description   || "",
        syllabus:            scrapedData.syllabus             || [],
        curriculum:          scrapedData.curriculum           || [],
        language:            scrapedData.language             || "",
        transcripts:         scrapedData.transcripts          || [],
        content_translation: scrapedData.content_translation || [],
        prerequisites:       scrapedData.prerequisites        || "",
        difficulty:          scrapedData.difficulty           || "",
        is_self_paced:       scrapedData.is_self_paced        || false,
        start_date:          scrapedData.start_date           || "",
        end_date:            scrapedData.end_date             || "",
        effort:              scrapedData.effort               || "",
        price:               scrapedData.price                || "",
        instructors:         scrapedData.instructors          || [],
      })
    });

    if (response.ok) {
      console.log(`[Coursify] ✅ Tersimpan! Lanjut ke berikutnya...`);
    } else {
      console.warn(`[Coursify] ⚠️ Server error ${response.status}, tetap lanjut.`);
    }
  } catch (e) {
    console.error('[Coursify] Error menyimpan:', e);
  }

  setTimeout(processNextCourse, Math.floor(Math.random() * 4000) + 3000);
}