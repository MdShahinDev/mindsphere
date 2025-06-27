// Features Carousel Functionality
let currentSlide = 0;
const featuresPerView = 4;
const totalFeatures = 5;
const maxSlides = Math.max(0, totalFeatures - featuresPerView);

function updateCarousel() {
    const featureCards = document.querySelector('.feature-cards');
    const cardWidth = 280 + 16; // card width + gap
    featureCards.style.transform = `translateX(-${currentSlide * cardWidth}px)`;
    
    // Update dots
    document.querySelectorAll('.dot').forEach((dot, index) => {
        dot.classList.toggle('active', index === currentSlide);
    });
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % (maxSlides + 1);
    updateCarousel();
}

function prevSlide() {
    currentSlide = currentSlide === 0 ? maxSlides : currentSlide - 1;
    updateCarousel();
}

// Reviews Carousel Functionality
 let currentReviewIndex = 0;

        function updateReviews() {
            const currentReviews = reviewsData[currentReviewIndex].reviews;
            const reviewCards = document.querySelectorAll('.review-card');
            
            reviewCards.forEach((card, index) => {
                if (currentReviews[index]) {
                    const review = currentReviews[index];
                    const img = card.querySelector('.user-avatar');
                    const name = card.querySelector('.user-name');
                    const location = card.querySelector('.user-location');
                    const text = card.querySelector('.review-text');
                    
                    img.src = review.photo;
                    img.alt = review.name;
                    name.textContent = review.name;
                    location.textContent = review.location;
                    text.textContent = review.text;
                }
            });
        }

        function previousReview() {
            currentReviewIndex = (currentReviewIndex - 1 + reviewsData.length) % reviewsData.length;
            updateReviews();
        }

        function nextReview() {
            currentReviewIndex = (currentReviewIndex + 1) % reviewsData.length;
            updateReviews();
        }

        // Optional: Auto-advance reviews every 10 seconds
        // setInterval(nextReview, 10000);

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Features carousel controls
    document.getElementById('nextBtn').addEventListener('click', nextSlide);
    document.getElementById('prevBtn').addEventListener('click', prevSlide);
    
    // Dot navigation
    document.querySelectorAll('.dot').forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentSlide = index;
            updateCarousel();
        });
    });
    
    // Reviews carousel controls
    document.getElementById('reviewNext').addEventListener('click', nextReview);
    document.getElementById('reviewPrev').addEventListener('click', prevReview);
    
    // Auto-slide for features (optional)
    setInterval(nextSlide, 5000);
    
    // Auto-slide for reviews (optional)
    setInterval(nextReview, 7000);
    
    // Initialize carousels
    updateCarousel();
    updateReviewCarousel();
});

// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});




// ===================================  Pomodoro Timer START ===========================



document.addEventListener('DOMContentLoaded', () => {
  const popupOverlay = document.getElementById('pomodoro-overlay');
  const openBtn = document.querySelector('.pomodoro-open-btn');
  const closeBtn = document.getElementById('pomodoro-close');
  const settingsBtn = document.getElementById('pomodoro-settings');
  const timerSettings = document.getElementById('timer-settings');
  const timerArea = document.getElementById('timer-area');
  const settingsIcon = document.getElementById('settings-icon');
  const startBtn = document.getElementById('start-timer');
  const timerDisplay = document.getElementById('timer-display');
  const tabs = document.querySelectorAll('.tab');
  const alarm = document.getElementById('alarm-audio');
  let timer;
  let currentMode = 'pomodoro';
  let remainingTime = 0;

  const getTimeForMode = () => {
    const pomodoro = parseInt(document.getElementById('pomodoro-time').value, 10);
    const short = parseInt(document.getElementById('short-time').value, 10);
    const long = parseInt(document.getElementById('long-time').value, 10);
    return currentMode === 'pomodoro' ? pomodoro : currentMode === 'short' ? short : long;
  };

  const updateDisplay = (seconds) => {
    const mins = String(Math.floor(seconds / 60)).padStart(2, '0');
    const secs = String(seconds % 60).padStart(2, '0');
    timerDisplay.textContent = `${mins}:${secs}`;
  };

  const startCountdown = () => {
    clearInterval(timer);
    remainingTime = getTimeForMode() * 60;
    updateDisplay(remainingTime);
    timer = setInterval(() => {
      remainingTime--;
      updateDisplay(remainingTime);
      if (remainingTime <= 0) {
        clearInterval(timer);
        alarm.play();
      }
    }, 1000);
  };

  openBtn.addEventListener('click', () => {
    popupOverlay.classList.remove('hidden');
    popupOverlay.style.display = 'flex';
    currentMode = 'pomodoro';
    updateDisplay(getTimeForMode() * 60);
    tabs.forEach(tab => tab.classList.remove('active'));
    tabs[0].classList.add('active');
  });

  closeBtn.addEventListener('click', () => {
    popupOverlay.classList.add('hidden');
    popupOverlay.style.display = 'none';
    clearInterval(timer);
  });

  settingsBtn.addEventListener('click', () => {
    const isSettingsVisible = timerSettings.classList.toggle('hidden') === false;
    timerArea.classList.toggle('hidden');
    startBtn.style.display = isSettingsVisible ? 'none' : 'inline-block';
    settingsIcon.classList.toggle('fa-ellipsis-vertical', !isSettingsVisible);
    settingsIcon.classList.toggle('fa-check', isSettingsVisible);
  });

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      currentMode = tab.dataset.mode;
      updateDisplay(getTimeForMode() * 60);
      clearInterval(timer);
    });
  });

  startBtn.addEventListener('click', () => {
    startCountdown();
  });
});



// ===================================  Pomodoro Timer END ===========================










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