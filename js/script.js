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