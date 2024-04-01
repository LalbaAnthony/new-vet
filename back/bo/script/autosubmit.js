// * Auto submit search form on change (with a delay)

const delay = 1000;

window.addEventListener('DOMContentLoaded', function () {
  var searchInput = document.getElementById('search');
  var searchForm = document.querySelector('form');
  var timeout = null;
  searchInput.addEventListener('input', function () {
    clearTimeout(timeout);
    timeout = setTimeout(function () {
      searchForm.submit();
    }, delay);
  });
});
