let isScraping = false;
let currentCourse = null;
let currentTabId = null;

const API_URL = "http://localhost:8000/api/scrape"; 
// Adjust this to http://coursify.test/api/scrape if the user uses custom domain

chrome.runtime.onMessage.addListener((request, sender, sendResponse) => {
  if (request.action === 'start') {
    isScraping = true;
    chrome.storage.local.set({ isScraping: true });
    processNextCourse();
  } else if (request.action === 'stop') {
    isScraping = false;
    chrome.storage.local.set({ isScraping: false });
  } else if (request.action === 'scraped_data') {
    if (isScraping && currentCourse) {
      saveDataToLaravel(request.data);
    }
  } else if (request.action === 'not_found_on_search') {
    if (isScraping && currentCourse) {
      // close tab, send empty data
      if (currentTabId) chrome.tabs.remove(currentTabId);
      saveDataToLaravel({ description: null, syllabus: [] });
    }
  }
});

async function processNextCourse() {
  if (!isScraping) return;

  try {
    const res = await fetch(`${API_URL}/next`);
    const data = await res.json();

    if (data.status === 'done' || !data.course) {
      isScraping = false;
      chrome.storage.local.set({ isScraping: false });
      console.log("All courses processed!");
      return;
    }

    currentCourse = data.course;
    
    // Search on Google
    const query = encodeURIComponent(`site:edx.org ${currentCourse.title}`);
    const searchUrl = `https://www.google.com/search?q=${query}`;
    
    chrome.tabs.create({ url: searchUrl, active: false }, (tab) => {
      currentTabId = tab.id;
    });

  } catch (e) {
    console.error("Error fetching next course", e);
    // Try again in 5 seconds
    setTimeout(processNextCourse, 5000);
  }
}

async function saveDataToLaravel(scrapedData) {
  if (currentTabId) {
    try {
      chrome.tabs.remove(currentTabId);
    } catch(e) {}
  }
  
  try {
    await fetch(`${API_URL}/save`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        course_id: currentCourse.id,
        description: scrapedData.description,
        syllabus: scrapedData.syllabus,
        curriculum: scrapedData.curriculum
      })
    });
  } catch (e) {
    console.error("Error saving data", e);
  }

  // Wait 3 seconds before next course to avoid heavy spam
  setTimeout(processNextCourse, 3000);
}
