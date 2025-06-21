
const podcastData = {
  mindset: [
    { title: "Positive Thinking Daily", desc: "Uplift your day with powerful affirmations.", url: "https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3", duration: "10:35" },
    { title: "Power Habits", desc: "Habits that changed lives.", url: "https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3", duration: "12:48" },
    { title: "Mindful Mornings", desc: "Peaceful start to the day.", url: "https://www.soundhelix.com/examples/mp3/SoundHelix-Song-3.mp3", duration: "9:21" },
    { title: "Gratitude Practice", desc: "Reflect with purpose.", url: "https://www.soundhelix.com/examples/mp3/SoundHelix-Song-4.mp3", duration: "11:10" },
    { title: "Resilience Talk", desc: "Mental strength tips.", url: "https://www.soundhelix.com/examples/mp3/SoundHelix-Song-5.mp3", duration: "13:44" }
  ],
  tech: [
    { title: "Tech Trends 2025", desc: "What’s coming in AI and software.", url: "https://www.soundhelix.com/examples/mp3/SoundHelix-Song-6.mp3", duration: "15:22" },
    { title: "Cloud Simplified", desc: "All about the cloud!", url: "https://www.soundhelix.com/examples/mp3/SoundHelix-Song-7.mp3", duration: "12:55" },
    { title: "Developer Life", desc: "Behind the screen.", url: "https://www.soundhelix.com/examples/mp3/SoundHelix-Song-8.mp3", duration: "14:10" }
  ],
  interviews: [
    { title: "Startup Journey", desc: "CEO of a rising tech firm shares insight.", url: "https://www.soundhelix.com/examples/mp3/SoundHelix-Song-9.mp3", duration: "17:45" },
    { title: "Women in Tech", desc: "Breaking barriers in the industry.", url: "https://www.soundhelix.com/examples/mp3/SoundHelix-Song-10.mp3", duration: "16:20" }
  ]
};

let currentCategory = 'mindset';
let currentIndex = 0;
const batchSize = 4;

function showCategory(cat) {
  document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
  document.querySelector(`[onclick="showCategory('${cat}')"]`).classList.add('active');
  currentCategory = cat;
  currentIndex = 0;
  document.getElementById('podcastGrid').innerHTML = '';
  loadMore();
}

function loadMore() {
  const list = podcastData[currentCategory];
  const grid = document.getElementById('podcastGrid');
  const next = list.slice(currentIndex, currentIndex + batchSize);

  next.forEach(p => {
    const card = document.createElement('div');
    card.className = 'podcast-card';
    card.innerHTML = `
      <h3>${p.title}</h3>
      <p>${p.desc}</p>
      <audio controls>
        <source src="${p.url}" type="audio/mpeg">
        Your browser does not support the audio tag.
      </audio>
      <p><strong>Duration:</strong> ${p.duration}</p>
    `;
    grid.appendChild(card);
  });

  currentIndex += batchSize;
  document.getElementById('loadMoreBtn').style.display = currentIndex < list.length ? 'block' : 'none';
}

document.addEventListener('DOMContentLoaded', () => showCategory(currentCategory));
