// Smooth scroll
document.querySelectorAll(".nav-links a").forEach((link) => {
  link.addEventListener("click", function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute("href"));
    target.scrollIntoView({ behavior: "smooth" });
  });
});

// Animaciones al hacer scroll
const faders = document.querySelectorAll(".fade-in");
const slidersLeft = document.querySelectorAll(".slide-left");
const slidersRight = document.querySelectorAll(".slide-right");

const appearOptions = { threshold: 0.2, rootMargin: "0px 0px -50px 0px" };

const appearOnScroll = new IntersectionObserver(function (entries, observer) {
  entries.forEach((entry) => {
    if (!entry.isIntersecting) return;
    entry.target.classList.add("show");
    observer.unobserve(entry.target);
  });
}, appearOptions);

faders.forEach((fader) => appearOnScroll.observe(fader));
slidersLeft.forEach((slider) => appearOnScroll.observe(slider));
slidersRight.forEach((slider) => appearOnScroll.observe(slider));
