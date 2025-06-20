

// ===================================  ADD TASK START  ===========================
const msOpenPopupBtn = document.getElementById('ms-openPopupBtn');
const msPopupOverlay = document.getElementById('ms-popup-overlay');
const msClosePopupBtn = document.getElementById('ms-closePopupBtn');
const msContent = document.getElementById('ms-content');
const msCancelBtn = document.getElementById('ms-cancelBtn');
const msPriorityLevels = document.querySelectorAll('.ms-priority-level');

function msOpenPopup() {
  msPopupOverlay.style.display = 'flex';   // Show popup overlay with flex display
  msContent.classList.add('ms-blur');      // Blur background
  msPopupOverlay.setAttribute('aria-hidden', 'false');
}

function msClosePopup() {
  msPopupOverlay.style.display = 'none';   // Hide popup overlay
  msContent.classList.remove('ms-blur');   // Remove blur
  msPopupOverlay.setAttribute('aria-hidden', 'true');
}

// Priority level toggle
msPriorityLevels.forEach(level => {
  level.addEventListener('click', () => {
    msPriorityLevels.forEach(l => l.classList.remove('selected'));
    level.classList.add('selected');
  });
});

// Event listeners
msOpenPopupBtn.addEventListener('click', msOpenPopup);
msClosePopupBtn.addEventListener('click', msClosePopup);
msCancelBtn.addEventListener('click', msClosePopup);

// Close popup if clicking outside popup box
msPopupOverlay.addEventListener('click', (e) => {
  if (e.target === msPopupOverlay) {
    msClosePopup();
  }
});



// ===================================  ADD TASK END ===========================




// ===================================  TASK OVERVIEW START ===========================


document.addEventListener('DOMContentLoaded', () => {
//   const openBtn = document.querySelector('.navBtn');
  const openBtn = document.querySelector('.taskOverview');
  const popupOverlay = document.getElementById('taskov-popup-overlay');
  const closeBtn = document.getElementById('taskov-closePopupBtn');

  openBtn.addEventListener('click', () => {
    popupOverlay.style.display = 'flex';
    popupOverlay.setAttribute('aria-hidden', 'false');
  });

  closeBtn.addEventListener('click', () => {
    popupOverlay.style.display = 'none';
    popupOverlay.setAttribute('aria-hidden', 'true');
  });
});

const progressRange = document.getElementById('progressRange');
const progressValue = document.getElementById('progressValue');

progressRange.addEventListener('input', () => {
  progressValue.textContent = `${progressRange.value}% Completed`;
});
// ===================================  TASK OVERVIEW END ===========================



