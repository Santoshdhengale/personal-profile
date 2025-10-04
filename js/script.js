const text = "AI Developer | Web Innovator | Creative Thinker";
let index = 0;
function typeEffect() {
  if (index < text.length) {
    document.querySelector(".typing").innerHTML += text.charAt(index);
    index++;
    setTimeout(typeEffect, 100);
  }
}
window.onload = typeEffect;

// Enhanced Navbar Functionality
document.addEventListener('DOMContentLoaded', function() {
  
  // Navbar scroll effect
  window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
      navbar.classList.add('navbar-scrolled');
    } else {
      navbar.classList.remove('navbar-scrolled');
    }
  });
  
  // Active navigation highlighting
  const sections = document.querySelectorAll('section[id]');
  const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
  
  function setActiveNav() {
    let current = '';
    
    sections.forEach(section => {
      const sectionTop = section.offsetTop;
      const sectionHeight = section.clientHeight;
      if (pageYOffset >= (sectionTop - 200)) {
        current = section.getAttribute('id');
      }
    });
    
    navLinks.forEach(link => {
      link.classList.remove('active');
      if (link.getAttribute('href') === `#${current}`) {
        link.classList.add('active');
      }
    });
  }
  
  window.addEventListener('scroll', setActiveNav);
  
  // Mobile menu auto-close on link click
  const navbarToggler = document.querySelector('.navbar-toggler');
  const navbarCollapse = document.querySelector('.navbar-collapse');
  
  navLinks.forEach(link => {
    link.addEventListener('click', () => {
      if (navbarCollapse.classList.contains('show')) {
        navbarToggler.click();
      }
    });
  });
  
  // Resume functionality
  window.openResumeModal = function() {
    const resumeModal = new bootstrap.Modal(document.getElementById('resumeModal'));
    resumeModal.show();
  };
  
  window.printResume = function() {
    const resumeImg = document.querySelector('#resume img');
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
      <html>
        <head>
          <title>Santosh Resume</title>
          <style>
            body { 
              margin: 0; 
              display: flex; 
              justify-content: center; 
              align-items: center; 
              min-height: 100vh; 
              background: #f8f9fa;
            }
            img { 
              max-width: 100%; 
              height: auto; 
              box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            }
            @media print {
              body { background: white; }
              img { box-shadow: none; }
            }
          </style>
        </head>
        <body>
          <img src="${resumeImg.src}" alt="Resume" onload="window.print(); window.close();" />
        </body>
      </html>
    `);
  };
  
  // Contact Form Handler
  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    const formMessage = document.getElementById('formMessage');
    const submitBtn = contactForm.querySelector('button[type="submit"]');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoading = submitBtn.querySelector('.btn-loading');

    contactForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Show loading state
      btnText.classList.add('d-none');
      btnLoading.classList.remove('d-none');
      submitBtn.disabled = true;
      
      // Get form data
      const formData = new FormData(contactForm);
      
      // Send AJAX request
      fetch('insert.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.text())
      .then(data => {
        // Hide loading state
        btnText.classList.remove('d-none');
        btnLoading.classList.add('d-none');
        submitBtn.disabled = false;
        
        // Show message
        formMessage.style.display = 'block';
        
        if (data.includes('✔️') || data.includes('successfully')) {
          formMessage.innerHTML = `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <i class="fas fa-check-circle me-2"></i>
              <strong>Success!</strong> Your message has been sent successfully. I'll get back to you soon!
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          `;
          contactForm.reset(); // Clear the form
        } else {
          formMessage.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="fas fa-exclamation-circle me-2"></i>
              <strong>Error!</strong> There was an issue sending your message. Please try again.
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          `;
        }
        
        // Auto-hide message after 5 seconds
        setTimeout(() => {
          formMessage.style.display = 'none';
        }, 5000);
      })
      .catch(error => {
        // Hide loading state
        btnText.classList.remove('d-none');
        btnLoading.classList.add('d-none');
        submitBtn.disabled = false;
        
        // Show error message
        formMessage.style.display = 'block';
        formMessage.innerHTML = `
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Error!</strong> Network error. Please check your connection and try again.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        `;
      });
    });
  }
  
  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });
  
  // Add some entrance animations
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  };
  
  const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
      }
    });
  }, observerOptions);
  
  // Observe sections for animations
  sections.forEach(section => {
    section.style.opacity = '0';
    section.style.transform = 'translateY(30px)';
    section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(section);
  });
  
  // Back to Top Button Functionality
  const backToTopBtn = document.getElementById('backToTop');
  
  function toggleBackToTop() {
    if (window.scrollY > 300) {
      backToTopBtn.parentElement.classList.add('show');
    } else {
      backToTopBtn.parentElement.classList.remove('show');
    }
  }
  
  window.addEventListener('scroll', toggleBackToTop);
  
  // Smooth scroll for back to top
  backToTopBtn.addEventListener('click', function(e) {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
  
  // Social Media Links Analytics (Optional)
  const socialLinks = document.querySelectorAll('.social-link');
  socialLinks.forEach(link => {
    link.addEventListener('click', function() {
      const platform = this.classList[1]; // instagram, linkedin, etc.
      console.log(`Social link clicked: ${platform}`);
      // You can add analytics tracking here
    });
  });
  
  // Footer Links Smooth Scroll
  const footerLinks = document.querySelectorAll('.footer-links a[href^="#"]');
  footerLinks.forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });
  
  // Add subtle animation to footer elements on scroll
  const footerSections = document.querySelectorAll('.footer-section');
  const footerObserver = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
      }
    });
  }, { threshold: 0.2 });
  
  footerSections.forEach(section => {
    section.style.opacity = '0';
    section.style.transform = 'translateY(20px)';
    section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    footerObserver.observe(section);
  });
});
