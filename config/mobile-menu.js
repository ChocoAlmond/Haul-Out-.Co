// Mobile Menu Toggle Functionality
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.querySelector('.navbar .toggle');
    const navMenu = document.querySelector('.navbar ul');
    
    if (toggleBtn && navMenu) {
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            toggleBtn.classList.toggle('active');
            navMenu.classList.toggle('active');
        });

        // Close menu when a link is clicked
        const navLinks = navMenu.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                toggleBtn.classList.remove('active');
                navMenu.classList.remove('active');
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.navbar')) {
                toggleBtn.classList.remove('active');
                navMenu.classList.remove('active');
            }
        });
    }
});
