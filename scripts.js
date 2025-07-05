// Set current year in footer
document.getElementById('current-year').textContent = new Date().getFullYear();

// Form validation for signup
const signupForm = document.getElementById('signupForm');
if (signupForm) {
    signupForm.addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        
        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Passwords do not match!');
            document.getElementById('confirm_password').focus();
        }
        
        // Additional validation can be added here
    });
}

// Profile page functionality
const updateProfileBtn = document.getElementById('updateProfileBtn');
const deleteProfileBtn = document.getElementById('deleteProfileBtn');
const updateModal = document.getElementById('updateModal');
const closeBtn = document.querySelector('.close-btn');

if (updateProfileBtn && updateModal) {
    updateProfileBtn.addEventListener('click', function() {
        updateModal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    });
    
    closeBtn.addEventListener('click', function() {
        updateModal.style.display = 'none';
        document.body.style.overflow = 'auto';
    });
    
    window.addEventListener('click', function(e) {
        if (e.target === updateModal) {
            updateModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });
}

if (deleteProfileBtn) {
    deleteProfileBtn.addEventListener('click', function() {
        if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
            // In a real application, this would make an AJAX call to delete the account
            alert('Account deletion functionality would be implemented here.');
        }
    });
}

// Update form submission
const updateForm = document.getElementById('updateForm');
if (updateForm) {
    updateForm.addEventListener('submit', function(e) {
        e.preventDefault();
        // In a real application, this would make an AJAX call to update the profile
        alert('Profile update functionality would be implemented here.');
        updateModal.style.display = 'none';
        document.body.style.overflow = 'auto';
    });
}

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Animation on scroll
const animateOnScroll = function() {
    const elements = document.querySelectorAll('.features article, .hero, aside');
    
    elements.forEach(element => {
        const elementPosition = element.getBoundingClientRect().top;
        const screenPosition = window.innerHeight / 1.3;
        
        if (elementPosition < screenPosition) {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }
    });
};

// Set initial state for animated elements
window.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.features article, .hero, aside');
    elements.forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        element.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    });
    
    // Trigger initial animation
    setTimeout(animateOnScroll, 100);
});

window.addEventListener('scroll', animateOnScroll);