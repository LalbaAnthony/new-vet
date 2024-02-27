// * Automatically save all html fields to local storage

// Add event listener to all input fields
window.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('input').forEach(function (input) {
    input.addEventListener('input', function () {
      localStorage.setItem(`saved_input_${input.id}`, input.value);
    });
  });
});

// Restore all input fields
window.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('input').forEach(function (input) {
    input.value = localStorage.getItem(`saved_input_${input.id}`);
  });
});
