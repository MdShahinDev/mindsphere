
const bookData = {
  selfhelp: [
    { title: "Atomic Habits", author: "James Clear", file: "sample-1.pdf"},
    { title: "Think and Grow Rich", author: "Napoleon Hill", file: "sample-2.pdf" },
    { title: "Atomic Habits", author: "James Clear", file: "sample-3.pdf" }
    
   
    
  ],
  technology: [
    { title: "Clean Code", author: "Robert C. Martin", file: "clean-code.pdf", thumbnail: "./img/tech1.jpg" },
    { title: "Clean Code", author: "Robert C. Martin", file: "clean-code.pdf", thumbnail: "./img/tech1.jpg" },
    { title: "Clean Code", author: "Robert C. Martin", file: "clean-code.pdf", thumbnail: "./img/tech1.jpg" }
  ],
  education: [
    { title: "Physics for Scientists", author: "Giancoli", file: "physics-for-scientists.pdf", thumbnail: "./img/edu1.jpg" },
    { title: "Physics for Scientists", author: "Giancoli", file: "physics-for-scientists.pdf", thumbnail: "./img/edu1.jpg" },
    { title: "Physics for Scientists", author: "Giancoli", file: "physics-for-scientists.pdf", thumbnail: "./img/edu1.jpg" }
  ]
};

let currentCategory = 'selfhelp';
let currentIndex = 0;
const batchSize = 2;

function showCategory(cat) {
  document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
  document.querySelector(`[onclick="showCategory('${cat}')"]`).classList.add('active');
  currentCategory = cat;
  currentIndex = 0;
  document.getElementById('bookGrid').innerHTML = '';
  loadMore();
}

function loadMore() {
  const list = bookData[currentCategory];
  const grid = document.getElementById('bookGrid');
  const next = list.slice(currentIndex, currentIndex + batchSize);

  next.forEach(book => {
    const card = document.createElement('div');
    card.className = 'book-card';
    card.innerHTML = `
      <img src="${book.thumbnail}" class="thumbnail" />
      <h3>${book.title}</h3>
      <p><strong>Author:</strong> ${book.author}</p>
      <a href="./books/${book.file}" download target="_blank"><i class="fa-solid fa-download"></i> Download</a>
      <button class="btn" style="background-color: red" onclick="openViewer('./books/${book.file}')"> View</button>
    `;
    grid.appendChild(card);
  });

  currentIndex += batchSize;
  document.getElementById('loadMoreBtn').style.display = currentIndex < list.length ? 'block' : 'none';
}

function openViewer(path) {
  const viewer = document.getElementById('pdfViewer');
  viewer.querySelector('iframe').src = path;
  viewer.style.display = 'block';
  window.scrollTo(0, document.body.scrollHeight);
}

function closeViewer() {
  const viewer = document.getElementById('pdfViewer');
  viewer.style.display = 'none';
  viewer.querySelector('iframe').src = '';
}

document.addEventListener('DOMContentLoaded', () => showCategory(currentCategory));
