/*=================================
    JS Index Here
=================================*/
/*
01. On Load Function
02. Preloader
03. Mobile Menu
04. Sticky fix
05. Scroll To Top
06. Set Background Image Color & Mask
07. Global Slider
08. Ajax Contact Form
09. Search Box Popup
10. Popup Sidemenu
11. Magnific Popup
12. Section Position
13. Filter
14. Counter Up
15. Shape Mockup
16. Progress Bar Animation
17. Countdown
18. Image to SVG Code
00. Woocommerce Toggle
00. Color Scheme
00. Right Click Disable
*/
/*=================================
    JS Index End
=================================*/


/*---------- 01. On Load Function ----------*/
document.addEventListener("DOMContentLoaded", function () {
 

  /*=================================
      Additional Global Init Calls
  ==================================*/
  // Add your custom initializations here, for example:
  // initStickyHeader();
  // initScrollTop();
  // initSliders();
  // etc.

}); // âœ… End DOMContentLoaded

/*Popup*/
document.addEventListener("DOMContentLoaded", function () {
  const popup = document.getElementById("admissionPopup");
  const closeBtn = popup.querySelector(".admission-close");

  setTimeout(() => {
    popup.classList.add("active");
  }, 300);

  closeBtn.addEventListener("click", () => {
    popup.classList.remove("active");
  });

  popup.addEventListener("click", (e) => {
    if (e.target === popup) {
      popup.classList.remove("active");
    }
  });
  

});
 

/*==========Announcement============*/
document.addEventListener("DOMContentLoaded", function () { 
 
    const carousels = [ 
      { id: '#newsCarousel' }
    ];

    carousels.forEach(({ id }) => {
      const el = document.querySelector(id);
      const carousel = new bootstrap.Carousel(el, {
        interval: 2000,
        ride: 'carousel',
        wrap: true
      });

      const indicators = document.querySelectorAll(`[data-bs-target="${id}"]`);
      indicators.forEach((btn, idx) => {
        btn.addEventListener('click', () => carousel.to(idx));
      });

      el.addEventListener('slide.bs.carousel', (e) => {
        indicators.forEach(b => b.classList.remove('active'));
        indicators[e.to].classList.add('active');
      });
    });
});
 
  

/*==========Announcement Slider==========*/
 
document.addEventListener("DOMContentLoaded", function () {
  const el = document.querySelector('#announcementCarousel');
  if (!el) return;

  const items = el.querySelectorAll('.carousel-item');

  const carousel = new bootstrap.Carousel(el, {
    interval: 4000,
    ride: 'carousel',
    wrap: true
  });

  const currentEl = document.querySelector('.carousel-fraction .current');
  const totalEl = document.querySelector('.carousel-fraction .total');
  const prevBtn = document.querySelector('.carousel-fraction .prevBtn');
  const nextBtn = document.querySelector('.carousel-fraction .nextBtn');

  // 🔹 Set total slides
  totalEl.textContent = String(items.length).padStart(2, '0');

  // 🔹 Initial value
  currentEl.textContent = "01";

  // 🔹 Button controls
  prevBtn.addEventListener('click', () => carousel.prev());
  nextBtn.addEventListener('click', () => carousel.next());

  // 🔹 Update fraction on slide
  el.addEventListener('slid.bs.carousel', (e) => {
    currentEl.textContent = String(e.to + 1).padStart(2, '0');
  });

});

 
 
/*==============Events==============*/
 document.addEventListener("DOMContentLoaded", () => {
  const track = document.querySelector(".events-track");
  const cards = Array.from(document.querySelectorAll(".event-card"));
  const dotsContainer = document.querySelector(".carousel-dots");
  const visibleCount = 3;
  const total = cards.length;

  let currentIndex = 0;
  let cardWidth;

  function updateCardWidth() {
    cardWidth = cards[0].offsetWidth + 24;
  }

  // Clone slides for seamless looping
  cards.forEach((card) => {
    const clone = card.cloneNode(true);
    track.appendChild(clone);
  });

  // Show limited dots (3â€“4 only)
  const visibleDots = Math.min(total - visibleCount + 1, 4);

  for (let i = 0; i < visibleDots; i++) {
    const dot = document.createElement("button");
    if (i === 0) dot.classList.add("active");
    dotsContainer.appendChild(dot);
  }
  const dots = dotsContainer.querySelectorAll("button");

  function updateDots() {
    dots.forEach((dot, i) => {
      const dotIndex = (currentIndex % total) % visibleDots;
      dot.classList.toggle("active", i === dotIndex);
    });
  }

  function slideNext() {
    updateCardWidth();
    currentIndex++;
    track.style.transition = "transform 1s ease";
    track.style.transform = `translateX(-${currentIndex * cardWidth}px)`;

    updateDots();

    if (currentIndex >= total) {
      setTimeout(() => {
        track.style.transition = "none";
        track.style.transform = "translateX(0)";
        currentIndex = 0;
        updateDots();
      }, 1000);
    }
  }

  // Dot navigation
  dots.forEach((dot, index) => {
    dot.addEventListener("click", () => {
      currentIndex = index;
      track.style.transition = "transform 1s ease";
      track.style.transform = `translateX(-${index * cardWidth}px)`;
      updateDots();
    });
  });

  // Auto-slide
  setInterval(slideNext, 4000);

  window.addEventListener("resize", updateCardWidth);
  updateCardWidth();
 
});
/*===================Story Card======================*/
document.addEventListener("DOMContentLoaded", () => {
 
  const slider = document.querySelector(".story-slider");
  const cards = Array.from(document.querySelectorAll(".story-card"));
  const prevBtn = document.querySelector(".story-prev");
  const nextBtn = document.querySelector(".story-next");

  // Clone first and last few cards for seamless infinite loop
  const clonesBefore = cards.slice(-5).map(card => card.cloneNode(true));
  const clonesAfter = cards.slice(0, 5).map(card => card.cloneNode(true));

  clonesBefore.forEach(clone => slider.insertBefore(clone, slider.firstChild));
  clonesAfter.forEach(clone => slider.appendChild(clone));

  let allCards = document.querySelectorAll(".story-card");
  let index = 5; // start after initial clones
  let cardWidth = allCards[0].offsetWidth + 20; // includes gap

  function updateSlider(animate = true) {
    slider.style.transition = animate ? "transform 0.7s ease-in-out" : "none";
    slider.style.transform = `translateX(-${index * cardWidth}px)`;
  }

  function nextSlide() {
    index++;
    updateSlider();

    if (index >= allCards.length - 5) {
      setTimeout(() => {
        index = 5;
        updateSlider(false);
      }, 700);
    }
  }

  function prevSlide() {
    index--;
    updateSlider();

    if (index < 5) {
      setTimeout(() => {
        index = allCards.length - 10;
        updateSlider(false);
      }, 700);
    }
  }

  nextBtn.addEventListener("click", nextSlide);
  prevBtn.addEventListener("click", prevSlide);

  // Auto-slide
  setInterval(nextSlide, 4000);

  window.addEventListener("resize", () => {
    cardWidth = allCards[0].offsetWidth + 20;
    updateSlider(false);
  });

  updateSlider(false);
}); 

/*================Gallery Lightbox==================== */
 
(() => {
  const items = document.querySelectorAll('.gallery-item');
  const modalEl = document.getElementById('lightboxModal');
  const lightboxImage = document.getElementById('lightboxImage');

  if (!items.length || !modalEl || !lightboxImage) return;

  const modal = new bootstrap.Modal(modalEl);
  const prev = modalEl.querySelector('.lightbox-prev');
  const next = modalEl.querySelector('.lightbox-next');
  const imgs = [...items].map(i => i.dataset.full).filter(Boolean);

  let i = 0;

  const show = n => {
    i = (n + imgs.length) % imgs.length;
    lightboxImage.src = imgs[i];
    modal.show();
  };

  items.forEach((el, idx) =>
    el.addEventListener('click', () => show(idx))
  );

  [prev, next].forEach((btn, j) => {
    if (!btn) return;
    btn.addEventListener('click', e => {
      e.stopPropagation();
      show(i + (j ? 1 : -1));
    });
  });

  document.addEventListener('keydown', e => {
    if (!modalEl.classList.contains('show')) return;
    if (e.key === 'ArrowLeft') show(i - 1);
    if (e.key === 'ArrowRight') show(i + 1);
  });
})();
 



/*=====================Counter===========================*/
document.addEventListener("DOMContentLoaded", () => {
  const counters = document.querySelectorAll(".counter");

  const animateCounter = counter => {
    const target = +counter.getAttribute("data-target");
    const update = () => {
      const current = +counter.innerText;
      const increment = target / 100;
      if (current < target) {
        counter.innerText = Math.ceil(current + increment);
        setTimeout(update, 30);
      } else counter.innerText = target;
    };
    update();
  };

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animateCounter(entry.target);
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.5 });

  counters.forEach(c => observer.observe(c));
 
});
/*======================Floating Social========================*/

const toggle = document.querySelector('.social-toggle');
const floatingSocial = document.querySelector('.floating-social');

toggle.addEventListener('click', () => {
  floatingSocial.classList.toggle('active');
});

/*======================Sticky Header====================*/

 document.addEventListener("DOMContentLoaded", function () {

  const stickyHeader = document.getElementById("stickyHeader");
  const mainHeader = document.querySelector(".sju-header");
  const navbarCollapse = document.getElementById("stickyNavbar");
  const navbarToggler = document.querySelector(".navbar-toggler");

  if (!stickyHeader || !mainHeader) return;

  function handleSticky() {
    const headerBottom = mainHeader.getBoundingClientRect().bottom;
    // If header bottom is above viewport top → user has scrolled
    if (headerBottom <= 0) {
      stickyHeader.classList.add("is-visible");
    } else {
      stickyHeader.classList.remove("is-visible");
      navbarCollapse?.classList.remove("show");
    }
  }

  // Run on everything that can change layout
  window.addEventListener("scroll", handleSticky, { passive: true });
  window.addEventListener("resize", handleSticky);
  window.addEventListener("load", handleSticky);

  // Initial check
  handleSticky();

  // Mobile menu positioning
  if (navbarToggler && navbarCollapse) {
    navbarToggler.addEventListener("click", () => {
      navbarCollapse.style.top = stickyHeader.offsetHeight + "px";
    });
  }
});
 


/*=============Courses===================== */

document.addEventListener("DOMContentLoaded", function () { 

  const filter = document.getElementById("programFilter");
  const items = document.querySelectorAll(".data-item");

  if (!filter || !items.length) return;

  function applyFilter(value) {

    items.forEach(function(item) {

      // If "all" option exists AND selected
      if (value === "all") {
        item.classList.remove("d-none");
      } 
      // Normal filtering
      else if (item.getAttribute("data-category") === value) {
        item.classList.remove("d-none");
      } 
      else {
        item.classList.add("d-none");
      }

    });
  }

  // Automatically apply current selected value on load
  applyFilter(filter.value);

  filter.addEventListener("change", function () {
    applyFilter(this.value);
  });
 
});
/*==============DEPARTMENT PAGES===================*/

 document.addEventListener("DOMContentLoaded", function () {

  const sections = document.querySelectorAll(".department_tab");
  const navLinks = document.querySelectorAll(".dept-sticky-nav a");
  const mobileSelect = document.getElementById("deptMobileNav");

  let isClickScrolling = false;

  function activateNav(id) {
    navLinks.forEach(link => {
      link.classList.toggle(
        "active",
        link.getAttribute("href") === `#${id}`
      );
    });

    if (mobileSelect) {
      mobileSelect.value = `#${id}`;
    }
  }

  function scrollToSection(target) {
    target.scrollIntoView({
      behavior: "smooth",
      block: "start"
    });
  }

  /* =============================
     CLICK HANDLERS
  ============================= */

  navLinks.forEach(link => {
    link.addEventListener("click", e => {
      e.preventDefault();

      const target = document.querySelector(link.getAttribute("href"));
      if (!target) return;

      isClickScrolling = true;
      activateNav(target.id);
      scrollToSection(target);

      setTimeout(() => {
        isClickScrolling = false;
      }, 700);
    });
  });

  if (mobileSelect) {
    mobileSelect.addEventListener("change", function () {
      const target = document.querySelector(this.value);
      if (!target) return;

      isClickScrolling = true;
      activateNav(target.id);
      scrollToSection(target);

      setTimeout(() => {
        isClickScrolling = false;
      }, 700);
    });
  }

  /* =============================
     INTERSECTION OBSERVER
  ============================= */

  const observer = new IntersectionObserver(
    entries => {
      if (isClickScrolling) return;

      entries.forEach(entry => {
        if (entry.isIntersecting) {
          activateNav(entry.target.id);
        }
      });
    },
    {
      root: null,
      rootMargin: "-35% 0px -45% 0px",
      threshold: 0
    }
  );

  sections.forEach(section => observer.observe(section));
});


 
/*===================PROGRAM DETAILS====================*/

 
document.addEventListener("DOMContentLoaded", function () {
  const sections = document.querySelectorAll(".programme-detail-content");
  const mobileSelect = document.getElementById("deptMobileNav");

  function showSection(id) {
    sections.forEach(section => {
      section.classList.toggle("active", section.id === id);
    });

    navLinks.forEach(link => {
      link.classList.toggle(
        "active",
        link.getAttribute("href") === `#${id}`
      );
    });

    if (mobileSelect) {
      mobileSelect.value = `#${id}`;
    }
  }

  /* =============================
     DESKTOP TAB CLICK
  ============================== */
  navLinks.forEach(link => {
    link.addEventListener("click", e => {
      e.preventDefault();
      const id = link.getAttribute("href").substring(1);
      showSection(id);
    });
  });

  /* =============================
     MOBILE DROPDOWN
  ============================== */
  if (mobileSelect) {
    mobileSelect.addEventListener("change", function () {
      const id = this.value.substring(1);
      showSection(id);
    });
  }

  /* =============================
     DEFAULT TAB (FIRST)
  ============================== */
  if (sections.length) {
    showSection(sections[0].id);
  }
  
});
 

/****************DEPARTMENT RESEARCH **********************/
 
 
document.addEventListener("DOMContentLoaded", function () {
let tableBody = document.getElementById("tableBody");
let rows = tableBody.querySelectorAll("tr");

let perPage = 20;
let totalRows = rows.length;
let totalPages = Math.ceil(totalRows / perPage);

let pagination = document.getElementById("pagination");
let tableTop = document.getElementById("publicationTable");

function showPage(page){

    let start = (page-1) * perPage;
    let end = start + perPage;

    rows.forEach((row,index)=>{
        row.style.display = (index >= start && index < end) ? "" : "none";
    });

    document.querySelectorAll("#pagination li").forEach(li=>{
        li.classList.remove("active");
    });

    document.querySelector(`#pagination li[data-page="${page}"]`).classList.add("active");

    /* Scroll to table top */
    window.scrollTo({
        top: tableTop.offsetTop - 80,
        behavior: "smooth"
    });
}

/* Create pagination buttons */

for(let i=1;i<=totalPages;i++){

    let li=document.createElement("li");
    li.className="page-item";
    li.dataset.page=i;

    let a=document.createElement("a");
    a.className="page-link";
    a.href="#";
    a.innerText=i;

    a.addEventListener("click",function(e){
        e.preventDefault();
        showPage(i);
    });

    li.appendChild(a);
    pagination.appendChild(li);
}

showPage(1);

});

/*=========================TESTIMONIAL======================*/
 
document.addEventListener("DOMContentLoaded", function () {
  const slider = document.querySelector('#testimonialSlider');
  if (!slider) return;

  const track = slider.querySelector('.testimonial-track');
  let items = slider.querySelectorAll('.testimonial-item');
  const nextBtn = slider.querySelector('.nextBtn');
  const prevBtn = slider.querySelector('.prevBtn');
  const currentEl = slider.querySelector('.current');
  const totalEl = slider.querySelector('.total');

  let index = 0;
  let isTransitioning = false;
  let auto;

  // ======================
  // CONFIG HELPERS
  // ======================
  function getVisibleItems() {
    return window.innerWidth <= 768 ? 1 : 2;
  }

  function getItemWidth() {
    return items[0].offsetWidth;
  }

  // ======================
  // CORE UPDATE
  // ======================
  function updateSlider(animate = true) {
    track.style.transition = animate ? 'transform 0.5s ease' : 'none';
    track.style.transform = `translateX(-${index * getItemWidth()}px)`;
    updateFraction();
  }

  function updateFraction() {
    const visible = getVisibleItems();
    const realTotal = items.length - (visible * 2);

    let realIndex = index - visible;

    if (realIndex < 0) realIndex = realTotal - 1;
    if (realIndex >= realTotal) realIndex = 0;

    currentEl.textContent = String(realIndex + 1).padStart(2, '0');
    totalEl.textContent = String(realTotal).padStart(2, '0');
  }

  // ======================
  // CLONE SETUP (INFINITE LOOP)
  // ======================
  function setupClones() {
    const visible = getVisibleItems();

    items = slider.querySelectorAll('.testimonial-item');

    for (let i = 0; i < visible; i++) {
      const firstClone = items[i].cloneNode(true);
      const lastClone = items[items.length - 1 - i].cloneNode(true);

      track.appendChild(firstClone);
      track.insertBefore(lastClone, track.firstChild);
    }

    items = slider.querySelectorAll('.testimonial-item');
    index = visible;

    updateSlider(false);
  }

  // ======================
  // NAVIGATION
  // ======================
  function goNext() {
    if (isTransitioning) return;
    isTransitioning = true;
    index++;
    updateSlider(true);
  }

  function goPrev() {
    if (isTransitioning) return;
    isTransitioning = true;
    index--;
    updateSlider(true);
  }

  nextBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    goNext();
  });

  prevBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    goPrev();
  });

  // ======================
  // LOOP FIX AFTER TRANSITION
  // ======================
  track.addEventListener('transitionend', () => {
    const visible = getVisibleItems();
    const total = items.length;

    if (index >= total - visible) {
      index = visible;
      updateSlider(false);
    }

    if (index < visible) {
      index = total - (visible * 2);
      updateSlider(false);
    }

    isTransitioning = false;
  });

  // ======================
  // AUTOPLAY (NO CLICK TRIGGERS)
  // ======================
  function startAutoPlay() {
    auto = setInterval(() => {
      if (isTransitioning) return;
      goNext();
    }, 4000);
  }

  function stopAutoPlay() {
    clearInterval(auto);
  }

  // ======================
  // INTERACTION CONTROLS
  // ======================

  // Pause on slider hover
  slider.addEventListener('mouseenter', stopAutoPlay);
  slider.addEventListener('mouseleave', startAutoPlay);

  // Prevent bubbling issues
  slider.addEventListener('click', function (e) {
    e.stopPropagation();
  });

  // Pause when interacting with navbar/menu
  const nav = document.querySelector('header, .navbar');
  if (nav) {
    nav.addEventListener('mouseenter', stopAutoPlay);
    nav.addEventListener('mouseleave', startAutoPlay);
  }

  // Pause when tab inactive
  document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
      stopAutoPlay();
    } else {
      startAutoPlay();
    }
  });

  // Bootstrap dropdown support (if used)
  document.addEventListener('shown.bs.dropdown', stopAutoPlay);
  document.addEventListener('hidden.bs.dropdown', startAutoPlay);

  // ======================
  // INIT
  // ======================
  setupClones();
  startAutoPlay();

});


 
