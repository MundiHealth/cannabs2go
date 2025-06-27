// Main App
// scripts gerais
// --------------------------------------------------

window.addEventListener('load', function() {
  // loading
  document.querySelector(".se-pre-con").style.display = "none";

  // menu mobile
  document.querySelector('.toggle-nav').addEventListener('click', function(event) {
    document.body.classList.add('open-nav');
    document.querySelector('.overlay').classList.add('active');
    event.stopPropagation();
  });

  document.querySelector('html').addEventListener('click', function() {
    document.body.classList.remove('open-nav');
    document.querySelector('.overlay').classList.remove('active');
  });

  // fixed header
  var headerHeight = document.querySelector(".header").offsetHeight;

  window.addEventListener('scroll', function() {
    if (window.scrollY > headerHeight) {
      document.querySelector('.header').classList.add("fixed");
    } else {
      document.querySelector('.header').classList.remove("fixed");
    }
  });
});
