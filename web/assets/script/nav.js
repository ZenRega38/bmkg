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
            if (hamburgerBtn) hamburgerBtn.style.setProperty('display', 'none', 'important');
        } else {
            body.style.overflow = '';
            if (hamburgerBtn) hamburgerBtn.style.removeProperty('display');
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

    // Global Loading Mechanism
    const loadingContainer = document.getElementById("global-loading-container");
    const loadingGif = document.getElementById("global-loading-gif");
    const progressBar = document.getElementById("global-progress-bar");
    const gifPaths = [
        "assets/gif/load_1.gif",
        "assets/gif/load_2.gif",
        "assets/gif/load_3.gif",
        "assets/gif/load_4.gif",
        "assets/gif/load_5.gif",
        "assets/gif/load_6.gif",
    ];
    let gifInterval;

    if (loadingContainer && loadingGif && progressBar) {
        document.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                // Only intercept internal links that actually navigate
                if (href && !href.startsWith('#') && !href.startsWith('http') && !href.startsWith('mailto:') && !href.startsWith('javascript:')) {
                    e.preventDefault();
                    
                    // Show Loading Overlay
                    loadingContainer.classList.add('active');
                    
                    // Reset and start animations
                    progressBar.style.width = '0%';
                    let progress = 0;
                    let gifIndex = 0;

                    loadingGif.src = gifPaths[gifIndex];
                    
                    clearInterval(gifInterval);
                    gifInterval = setInterval(() => {
                        gifIndex = (gifIndex + 1) % gifPaths.length;
                        loadingGif.src = gifPaths[gifIndex];
                    }, 500); // Faster GIF cycle for global loader

                    const simulateProgress = () => {
                        if (progress < 100) {
                            progress += Math.random() * 8 + 2; // Slower progress (takes ~1.3s)
                            if (progress >= 100) {
                                progress = 100;
                                progressBar.style.width = `${progress}%`;
                                // Navigate only after reaching 100%
                                setTimeout(() => {
                                    window.location.href = href;
                                }, 100); 
                                return;
                            }
                            progressBar.style.width = `${progress}%`;
                            setTimeout(simulateProgress, 80);
                        }
                    };
                    simulateProgress();
                }
            });
        });
    }
});

// CRITICAL: Handle Back-Forward Cache (bfcache)
// If the user presses the "Back" button, this hides the stuck loading screen
window.addEventListener('pageshow', function(event) {
    if (typeof window.BMKGFinishLoading === 'function') {
        window.BMKGFinishLoading();
    }
});

// Function to globally hide the loading screen
window.BMKGFinishLoading = function() {
    const loadingContainer = document.getElementById("global-loading-container");
    if (loadingContainer) {
        // Reset loading screen instantly
        loadingContainer.classList.remove('active');
        const progressBar = document.getElementById("global-progress-bar");
        if (progressBar) {
            progressBar.style.width = '0%';
        }
    }
};

// Handle initial page load
window.addEventListener('load', function() {
    // If a script hasn't explicitly asked to defer hiding, hide it now.
    if (!window.deferLoadingHide) {
        window.BMKGFinishLoading();
    }
});