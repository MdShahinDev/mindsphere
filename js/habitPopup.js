// Get DOM elements
const modal = document.getElementById("suggestionModal");
const btn = document.getElementById("openSuggestionModal");
const span = document.querySelector(".close");
const closeBtn = document.querySelector(".modal-close-btn");

// Show modal
btn.onclick = function () {
  modal.style.display = "block";
};

// Hide modal (X)
span.onclick = function () {
  modal.style.display = "none";
};

// Hide modal (Close button)
closeBtn.onclick = function () {
  modal.style.display = "none";
};

// Hide modal (outside click)
window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};
