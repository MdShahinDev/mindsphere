let currentSection = '';


function openModal(section) {
  currentSection = section;
  document.getElementById('skill-modal').style.display = 'flex';
}

function closeModal() {
  document.getElementById('skill-modal').style.display = 'none';
  document.getElementById('skill-name').value = '';
  document.getElementById('skill-grade').value = '';
  document.getElementById('skill-assessed').checked = false;
}

