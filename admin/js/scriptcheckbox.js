const checkboxes = document.querySelectorAll('input[type="checkbox"]');
const availItem = document.querySelectorAll('.avail');

for (let i = 0; i < checkboxes.length; i++) {
  const checkbox = checkboxes[i];
  const avail = availItem[i];

  checkbox.addEventListener('click', () => {
    if (checkbox.checked) {
      avail.textContent = 'Unavailable';
    } else {
      avail.textContent = 'Available';
    }
  });
}
