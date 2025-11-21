// Function to handle ScrollReveal animations and initialize skill bar animation
function initScrollReveal() {
    const sr = ScrollReveal({
        reset: false,
        distance: '30px', // Reduced distance for subtle float effect
        duration: 1200, // Reduced duration for faster, snappier animations
        easing: 'cubic-bezier(0.5, 0, 0.2, 1)',
        mobile: true
    });

    // Hero Section
    sr.reveal('.hero-content', { origin: 'left', delay: 200 });
    sr.reveal('.hero-photo-container', { origin: 'right', delay: 400 });
    sr.reveal('.navbar', { origin: 'top', distance: '10px', duration: 800, delay: 100 });
    
    // Sections
    sr.reveal('.section-title', { origin: 'bottom', interval: 100 });
    sr.reveal('.about-content', { origin: 'left', delay: 200 });
    sr.reveal('.about-img img', { origin: 'right', delay: 400 });
    
    // Fresher Summary Animation (Glass Cards)
    sr.reveal('.fresher-summary h3', { origin: 'bottom', delay: 200 });
    sr.reveal('.fresher-card', { interval: 150, origin: 'bottom', delay: 300 });

    // Glass Cards & Projects
    sr.reveal('.service-card', { interval: 150, origin: 'bottom' });
    sr.reveal('.project-card', { interval: 150, origin: 'bottom' });
    
    // Contact & Footer
    sr.reveal('.contact-form', { origin: 'bottom', delay: 200 });
    sr.reveal('.footer', { origin: 'bottom', distance: '10px', duration: 800, delay: 50 });

    // Skill Bar Animation Trigger
    sr.reveal('.skill-item', { 
        interval: 100, // Slightly faster interval for skills
        origin: 'bottom',
        afterReveal: (el) => {
            const level = el.getAttribute('data-level');
            const skillLevelBar = el.querySelector('.skill-level');
            if (skillLevelBar) {
                // Animate the width from 0 to the specified percentage
                skillLevelBar.style.width = level;
            }
        }
    });
}

// Function to send WhatsApp message
function sendWhatsApp() {
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const message = document.getElementById("message").value.trim();

    // URL encoding for clean parameters
    const text = `Name: ${encodeURIComponent(name)}\nEmail: ${encodeURIComponent(email)}\nMessage: ${encodeURIComponent(message)}`;
    const phone = "918608144068"; 
    const link = `https://wa.me/${phone}?text=${text}`;

    window.open(link, "_blank");
}

// Event listener to attach sendWhatsApp function to the button and initialize ScrollReveal
document.addEventListener('DOMContentLoaded', () => {
    const whatsappBtn = document.querySelector('.whatsapp-btn');
    if (whatsappBtn) {
        whatsappBtn.addEventListener('click', sendWhatsApp);
    }
    initScrollReveal();
});