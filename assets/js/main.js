// BoutonFlareX — shared site behavior
document.addEventListener('DOMContentLoaded', function () {

  // Mobile nav toggle
  var toggle = document.querySelector('.nav-toggle');
  var links = document.querySelector('.nav-links');
  if (toggle && links) {
    toggle.addEventListener('click', function () {
      links.classList.toggle('open');
      var expanded = links.classList.contains('open');
      toggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');
    });
  }

  // Newsletter / contact form friendly inline feedback (static demo forms)
  document.querySelectorAll('form[data-inline-feedback]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      var note = form.querySelector('.form-note');
      if (form.getAttribute('data-static') === 'true') {
        e.preventDefault();
        if (note) {
          note.textContent = "You're on the list — welcome to the atelier.";
          note.style.color = form.classList.contains('contact-form') ? '#7c8a6a' : '#f7f2e9';
        }
        form.reset();
      }
    });
  });

  // Footer year
  document.querySelectorAll('[data-year]').forEach(function (el) {
    el.textContent = new Date().getFullYear();
  });
});
