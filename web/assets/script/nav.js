document.addEventListener('DOMContentLoaded', function() {
    const dropdownBtns = document.querySelectorAll(".dropdown-btn");
    const dropdowns = document.querySelectorAll(".dropdown");
    const hamburgerBtn = document.getElementById("hamburger");
    const navMenu = document.querySelector(".menu");
    const body = document.body;

    // Create close button for mobile menu
    const closeBtn = document.createElement('button');
    closeBtn.classList.add('close-btn');
    closeBtn.innerHTML = '<i class="bx bx-x"></i>';
    closeBtn.setAttribute('aria-label', 'Close menu');
    if (navMenu) {
        navMenu.appendChild(closeBtn);
    }

    function toggleMenu() {
        if (!navMenu) return;
        navMenu.classList.toggle('show');
        if (navMenu.classList.contains('show')) {
            body.style.overflow = 'hidden'; // prevent background scrolling
        } else {
            body.style.overflow = '';
        }
    }

    // Toggle Mobile Menu
    if (hamburgerBtn) {
        hamburgerBtn.addEventListener('click', toggleMenu);
    }
    
    // Close Mobile Menu
    if (closeBtn) {
        closeBtn.addEventListener('click', toggleMenu);
    }

    function closeAllDropdowns() {
        dropdowns.forEach(drop => drop.classList.remove("active"));
        dropdownBtns.forEach(btn => btn.setAttribute("aria-expanded", "false"));
    }

    // Dropdown Logic
    dropdownBtns.forEach((btn) => {
        btn.addEventListener("click", function (e) {
            e.stopPropagation(); 
            const dropdownId = this.getAttribute("data-dropdown");
            const dropdownElement = document.getElementById(dropdownId);
            
            if (dropdownElement) {
                const isActive = dropdownElement.classList.contains("active");
                closeAllDropdowns();
                
                if (!isActive) {
                    dropdownElement.classList.add("active");
                    this.setAttribute("aria-expanded", "true");
                }
            }
        });
    });

    // Close dropdowns on outside click
    document.documentElement.addEventListener("click", () => {
        closeAllDropdowns();
    });

    // Prevent closing when clicking inside dropdown
    dropdowns.forEach(drop => {
        drop.addEventListener('click', (e) => e.stopPropagation());
    });
});