document.getElementById('startBtn').addEventListener('click', () => {
  chrome.runtime.sendMessage({ action: 'start' });
  document.getElementById('startBtn').style.display = 'none';
  document.getElementById('stopBtn').style.display = 'block';
  document.getElementById('status').innerText = 'Scraping started...';
});

document.getElementById('stopBtn').addEventListener('click', () => {
  chrome.runtime.sendMessage({ action: 'stop' });
  document.getElementById('startBtn').style.display = 'block';
  document.getElementById('stopBtn').style.display = 'none';
  document.getElementById('status').innerText = 'Stopped.';
});

// Check initial status
chrome.storage.local.get(['isScraping'], (result) => {
  if (result.isScraping) {
    document.getElementById('startBtn').style.display = 'none';
    document.getElementById('stopBtn').style.display = 'block';
    document.getElementById('status').innerText = 'Scraping in progress...';
  }
});
