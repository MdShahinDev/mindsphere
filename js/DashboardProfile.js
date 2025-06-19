let currentSection = '';

// Open modal and set section type
function openModal(section) {
    currentSection = section;
    document.getElementById('skill-type').value = section;
    document.getElementById('skill-modal').style.display = 'flex';
}

// Close modal and reset form
function closeModal() {
    document.getElementById('skill-modal').style.display = 'none';
    document.getElementById('skill-name').value = '';
    document.getElementById('skill-grade').value = '';
    document.getElementById('skill-assessed').checked = false;
}
