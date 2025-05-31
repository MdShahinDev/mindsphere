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




const openBtn = document.getElementById('openPopup');
const closeBtn = document.getElementById('closePopup');
const overlay = document.getElementById('popupOverlay');
const timerDisplay = document.getElementById('timer');
const tabButtons = document.querySelectorAll('.tab');
const startBtn = document.getElementById('startBtn');

let selectedTime = 1500; // default 25 mins in seconds
let timerInterval = null;
let timeRemaining = selectedTime;

openBtn.addEventListener('click', () => {
  overlay.style.display = 'flex';
  resetTimer();
});

closeBtn.addEventListener('click', () => {
  overlay.style.display = 'none';
  stopTimer();
});

tabButtons.forEach(btn => {
  btn.addEventListener('click', () => {
    // Remove active class from all tabs
    tabButtons.forEach(b => b.classList.remove('active'));
    // Add active class to clicked tab
    btn.classList.add('active');

    // Update selected time and reset timer
    selectedTime = parseInt(btn.dataset.time);
    resetTimer();
  });
});

startBtn.addEventListener('click', () => {
  if (timerInterval) {
    stopTimer();
    startBtn.textContent = 'Start';
  } else {
    startTimer();
    startBtn.textContent = 'Pause';
  }
});

function updateTimerDisplay(seconds) {
  const mins = String(Math.floor(seconds / 60)).padStart(2, '0');
  const secs = String(seconds % 60).padStart(2, '0');
  timerDisplay.textContent = `${mins}:${secs}:00`;
}

function startTimer() {
  if (timerInterval) return; // prevent multiple intervals

  timerInterval = setInterval(() => {
    if (timeRemaining <= 0) {
      stopTimer();
      alert('Time is up!');
      return;
    }
    timeRemaining--;
    updateTimerDisplay(timeRemaining);
  }, 1000);
}

function stopTimer() {
  clearInterval(timerInterval);
  timerInterval = null;
}

function resetTimer() {
  stopTimer();
  timeRemaining = selectedTime;
  updateTimerDisplay(timeRemaining);
  startBtn.textContent = 'Start';
}

// Initialize timer display
updateTimerDisplay(selectedTime);



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