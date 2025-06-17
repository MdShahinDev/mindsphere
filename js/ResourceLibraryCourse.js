const videoData = {
  personal: [
    { title: "Public Speaking Mastery", url: "https://www.youtube.com/embed/Iwpi1Lm6dFo", rating: 4.8 },
    { title: "Body Language Tips", url: "https://www.youtube.com/embed/8F0NYBBKczM", rating: 4.5 },
    { title: "Leadership Skills", url: "https://www.youtube.com/embed/2wPeVtq_3bw", rating: 4.7 },
    { title: "Presentation Techniques", url: "https://www.youtube.com/embed/R4V0Xg6T2MM", rating: 4.6 },
    { title: "Overcoming Fear", url: "https://www.youtube.com/embed/tShavGuo0_E", rating: 4.4 },
    { title: "Confident Speech", url: "https://www.youtube.com/embed/bk0F5GS1Drc", rating: 4.3 },
    { title: "Storytelling in Talks", url: "https://www.youtube.com/embed/Ivv3z0zsRsM", rating: 4.6 },
    { title: "Articulate Delivery", url: "https://www.youtube.com/embed/EJxSb3W5V8s", rating: 4.5 }
  ],
  skill: [
    { title: "Clean Code in JS", url: "https://www.youtube.com/embed/7EmboKQH8lM", rating: 5 },
    { title: "System Design 101", url: "https://www.youtube.com/embed/UzLMhqg3_Wc", rating: 4.8 },
    { title: "Python Data Science", url: "https://www.youtube.com/embed/rfscVS0vtbw", rating: 4.6 },
    { title: "Frontend Development", url: "https://www.youtube.com/embed/3PHXvlpOkf4", rating: 4.7 },
    { title: "Backend Basics", url: "https://www.youtube.com/embed/2eebptXfEvw", rating: 4.5 },
    { title: "DevOps in Practice", url: "https://www.youtube.com/embed/sdgg9ByyUdU", rating: 4.6 },
    { title: "DSA for Beginners", url: "https://www.youtube.com/embed/8hly31xKli0", rating: 4.3 },
    { title: "React.js Crash Course", url: "https://www.youtube.com/embed/Dorf8i6lCuk", rating: 4.9 }
  ],
  study: [
    { title: "Quantum Physics Intro", url: "https://www.youtube.com/embed/p7bzE1E5PMY", rating: 4.9 },
    { title: "Math: Algebra Basics", url: "https://www.youtube.com/embed/Q1vA2UjXX-4", rating: 4.5 },
    { title: "Chemistry Reactions", url: "https://www.youtube.com/embed/JkLk5XWvZrg", rating: 4.7 },
    { title: "Astronomy 101", url: "https://www.youtube.com/embed/wf73xqZvk6k", rating: 4.8 },
    { title: "Biology Cell Division", url: "https://www.youtube.com/embed/L0k-enzoeOM", rating: 4.4 },
    { title: "Statistics Concepts", url: "https://www.youtube.com/embed/OA5aXgZO0Y8", rating: 4.6 },
    { title: "Geography Patterns", url: "https://www.youtube.com/embed/u1dVd9h6iHk", rating: 4.2 },
    { title: "Historical Timeline", url: "https://www.youtube.com/embed/n5C2Y5J6S7U", rating: 4.3 }
  ]
};

let currentCategory = 'personal';
let currentIndex = 0;
const batchSize = 4;

function showCategory(category) {
  document.querySelectorAll('.tab').forEach(btn => btn.classList.remove('active'));
  document.querySelector(`[onclick="showCategory('${category}')"]`).classList.add('active');
  currentCategory = category;
  currentIndex = 0;
  document.getElementById('videoGrid').innerHTML = '';
  loadMore();
}

function loadMore() {
  const videos = videoData[currentCategory];
  const grid = document.getElementById('videoGrid');
  const nextBatch = videos.slice(currentIndex, currentIndex + batchSize);

  nextBatch.forEach(video => {
    const card = document.createElement('div');
    card.className = 'video-card';
    card.innerHTML = `
      <iframe src="${video.url}" frameborder="0" allowfullscreen></iframe>
      <div class="content">
        <h3>Title: ${video.title}</h3>
        <p>Rating: <span class="stars">${'★'.repeat(Math.floor(video.rating))}${'☆'.repeat(5 - Math.floor(video.rating))}</span> (${video.rating})</p>
      </div>
    `;
    grid.appendChild(card);
  });

  currentIndex += batchSize;
  const loadMoreBtn = document.getElementById('loadMoreBtn');
  loadMoreBtn.style.display = currentIndex < videos.length ? 'inline-block' : 'none';
}

document.addEventListener('DOMContentLoaded', () => showCategory('personal'));
