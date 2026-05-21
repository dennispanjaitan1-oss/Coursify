// If we are on Google Search
if (window.location.href.includes('google.com/search')) {
  setTimeout(() => {
    let resultUrl = null;
    const links = document.querySelectorAll('div#search a');
    for (let i = 0; i < links.length; i++) {
      if (links[i].href && links[i].href.includes('edx.org')) {
        let rawHref = links[i].href;
        // Clean Google Redirects if any
        if (rawHref.includes('/url?q=')) {
          rawHref = decodeURIComponent(rawHref.split('/url?q=')[1].split('&')[0]);
        }
        resultUrl = rawHref;
        break;
      }
    }
    
    if (resultUrl) {
      window.location.href = resultUrl; // Navigate directly to edX
    } else {
      chrome.runtime.sendMessage({ action: 'not_found_on_search' });
    }
  }, 1500); // 1.5s delay to simulate human
}

// If we are on edX
if (window.location.href.includes('edx.org')) {
  setTimeout(() => {
    // 1. Extract Description
    let desc = "";
    const descNodes = [
      document.querySelector('.about-this-course'),
      document.querySelector('#about-this-course'),
      document.querySelector('[data-testid="about-this-course"]')
    ];
    
    for (let node of descNodes) {
      if (node && node.innerText) {
        desc = node.innerText.trim();
        break;
      }
    }

    // 2. Extract Syllabus
    let syllabus = [];
    const syllabusNodes = document.querySelectorAll('.what-you-will-learn li, [data-testid="what-you-will-learn"] li, .learning-outcomes li');
    if (syllabusNodes.length > 0) {
      syllabusNodes.forEach(li => {
        let txt = li.innerText.trim();
        if (txt) syllabus.push(txt);
      });
    } else {
      // Fallback: look for a heading containing "learn" and get next UL
      const h2s = document.querySelectorAll('h2, h3');
      for (let h2 of h2s) {
        if (h2.innerText.toLowerCase().includes("what you'll learn") || h2.innerText.toLowerCase().includes("what you will learn")) {
          let nextEl = h2.nextElementSibling;
          while(nextEl && nextEl.tagName !== 'UL') {
            nextEl = nextEl.nextElementSibling;
          }
          if (nextEl && nextEl.tagName === 'UL') {
            nextEl.querySelectorAll('li').forEach(li => {
              if (li.innerText.trim()) syllabus.push(li.innerText.trim());
            });
          }
          break;
        }
      }
    }

    // 3. Extract Curriculum (Sections & Lessons)
    let rawCurriculumText = "";
    const currNodes = [
      document.querySelector('#syllabus'),
      document.querySelector('.course-syllabus'),
      document.querySelector('[data-testid="syllabus"]')
    ];
    for (let node of currNodes) {
      if (node && node.innerText) {
        rawCurriculumText = node.innerText;
        break;
      }
    }

    let parsedCurriculum = [];
    if (rawCurriculumText && rawCurriculumText.trim()) {
       parsedCurriculum = parseCurriculum(rawCurriculumText);
    }

    try {
      chrome.runtime.sendMessage({
        action: 'scraped_data',
        data: {
          description: desc,
          syllabus: syllabus,
          curriculum: parsedCurriculum
        }
      });
    } catch(e) {
      console.log("Error sending message to background:", e);
    }

  }, 3000); // Wait 3 seconds for edX React rendering
}

function parseCurriculum(text) {
    if (!text || !text.trim) return [];
    if (!text.trim()) return [];
    const lines = text.split('\n');
    const sections = [];
    let currentSection = null;
    let sectionOrder = 1;
    let lessonOrder = 1;

    function isMetadata(line) {
        line = line.trim().toLowerCase();
        if (!line) return true;
        const skips = [
            'video', 'reading', 'quiz', 'practice', 'graded', 'estimated', 'duration',
            'expand', 'collapse', 'expand all', 'collapse all', 'topics', 'lessons', 
            'minutes', 'hours', 'mins', 'hrs', 'free preview', 'core topic', 'survey',
            'video lecture', 'ungraded'
        ];
        if (skips.includes(line)) return true;
        if (/^\d+\s+(topics?|lessons?|minutes?|hours?|mins?|hrs?|videos?|readings?|quizzes?)$/i.test(line)) return true;
        if (/^\d+\s*(m|h|min|mins|hour|hours|sec|secs)$/i.test(line)) return true;
        return false;
    }

    lines.forEach(line => {
        const cleanLine = line.trim();
        if (!cleanLine) return;
        let isSection = false;
        let sectionTitle = cleanLine;

        const secRegex = /^(section|module|week|bagian|bab|unit|chapter|\d+)\s*(?:\d+)?\s*[:\-\.\s]\s*(.*)$/i;
        const secRegex2 = /^(section|module|week|bagian|bab|unit|chapter)\s*(\d+)$/i;

        if (secRegex.test(cleanLine)) {
            const matches = cleanLine.match(secRegex);
            isSection = true;
            sectionTitle = matches[2] ? matches[2].trim() : cleanLine;
        } else if (secRegex2.test(cleanLine)) {
            isSection = true;
            sectionTitle = cleanLine;
        } else if (/^\d+\.\s+.*$/.test(cleanLine)) { // Like "1. Getting Started"
            isSection = true;
            sectionTitle = cleanLine;
        }

        if (isSection) {
            currentSection = { title: sectionTitle, order_index: sectionOrder++, lessons: [] };
            sections.push(currentSection);
            lessonOrder = 1;
        } else {
            if (!isMetadata(cleanLine)) {
                if (!currentSection) {
                    currentSection = { title: "Bagian 1: Pendahuluan", order_index: sectionOrder++, lessons: [] };
                    sections.push(currentSection);
                }
                const cleanLesson = cleanLine.replace(/^(lesson|materi)?\s*(?:\d+\.\d+|\d+)\s*[:\-\.\s]\s*/i, '');
                currentSection.lessons.push({ title: cleanLesson, order_index: lessonOrder++ });
            }
        }
    });
    return sections;
}
