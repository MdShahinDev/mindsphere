const tabsData = {
  health: [
    { name: "Drink Water", options: ["100ml", "250ml", "500ml", "1L"] },
    { name: "Exercise", options: ["10 mins", "30 mins", "1 hour"] },
    { name: "Sound Sleep", options: ["<6 hrs", "6-8 hrs", ">8 hrs"] },
    { name: "Blood Pressure", options: ["Normal", "Elevated", "High"] },
    { name: "Meal", options: ["Skipped", "1 meal", "2 meals", "3 meals"] }
  ],
  wellness: [
    { name: "Meditation", options: ["5 mins", "15 mins", "30 mins"] },
    { name: "Journaling", options: ["Yes", "No"] },
    { name: "Gratitude", options: ["Noted", "Skipped"] },
    { name: "Mood Checkin", options: ["Happy", "Stressed", "Anxious"] },
    { name: "Calm Breathing", options: ["3 mins", "5 mins", "Not Done"] }
  ],
  productivity: [
    { name: "Work Hours", options: ["<4", "4-6", "6-8", "8+"] },
    { name: "Social Media Usage", options: ["0 Min", "15 min", "1 hr", "Overused+"] },
    { name: "Tasks Done", options: ["1", "2", "3", "4+"] },
    { name: "Pomodoro Session", options: ["0","1","2", "3", "4", "5", "6", "7", "8", "9", "10"] },
    { name: "Break Time", options: ["Short", "Medium", "Long"] }
  ],
  learning: [
    { name: "Reading", options: ["None", "15 mins", "30 mins"] },
    { name: "Course", options: ["Not Started", "In Progress", "Completed"] },
    { name: "Smart Recall", options: ["Anki Done", "Quiz", "10 flashcards"] },
    { name: "New Skill", options: ["Watched", "Practiced", "Mastered"] },
    { name: "Learn & Log", options: ["Notes Taken", "Logged", "Skipped"] }
  ]
};

function showTab(event, tabName) {
  document.querySelectorAll('.tab').forEach(btn => btn.classList.remove('active'));
  event.target.classList.add('active');
  const data = tabsData[tabName];
  const checklist = document.getElementById("checklist");
  checklist.innerHTML = "";
  data.forEach(item => {
    const row = document.createElement("div");
    row.className = "check-row";
    row.innerHTML = `
      <label><input type="checkbox"> ${item.name}</label>
      <select>${item.options.map(opt => `<option>${opt}</option>`).join('')}</select>
    `;
    checklist.appendChild(row);
  });
}

// Flatpickr setup
flatpickr("#calendar", {
  inline: true,
  defaultDate: "today",
  onChange: function(selectedDates, dateStr) {
    updateDateDisplay(selectedDates[0]);
  }
});

flatpickr("#calendar-picker", {
  defaultDate: "today",
  onChange: function(selectedDates) {
    updateDateDisplay(selectedDates[0]);
  }
});

function updateDateDisplay(date) {
  document.getElementById("dayName").textContent = date.toLocaleDateString(undefined, { weekday: 'long' });
  document.getElementById("fullDate").textContent =
    date.toLocaleDateString(undefined, { month: 'long', day: 'numeric', year: 'numeric' }) + " | 10:00 AM";
}

// Load default
document.addEventListener("DOMContentLoaded", () => {
  showTab({ target: document.querySelector(".tab.active") }, "health");
});
