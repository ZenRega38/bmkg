document.addEventListener('DOMContentLoaded', function() {
    console.log('nav.js is running!');

    const dropdownBtn = document.querySelectorAll(".dropdown-btn2");
    const dropdown = document.querySelectorAll(".dropdown2");
    const hamburgerBtn = document.querySelector(".hamburger1");
    const navMenu = document.querySelector(".menu2");
    const links = document.querySelectorAll(".dropdown2 a");
    const body = document.body;

    console.log('Hamburger button found:', hamburgerBtn);
    console.log('Nav Menu found:', navMenu);

    // Create close button
    const closeBtn = document.createElement('span');
    closeBtn.classList.add('close-btn');
    closeBtn.innerHTML = 'x';
    closeBtn.setAttribute('aria-label', 'Close menu');
    navMenu.appendChild(closeBtn); // Append to navMenu

    console.log('Close Button created:', closeBtn); // Tambahkan ini

    closeBtn.style.display = 'none'; // Initially hide the close button

    function toggleMenu() {
        console.log('Toggle Menu function called');
        navMenu.classList.toggle('show');
        body.classList.toggle('no-scroll');
        closeBtn.style.display = navMenu.classList.contains('show') ? 'block' : 'none';
        console.log('Close button display:', closeBtn.style.display); // Tambahkan ini
    
        // Tambahkan ini untuk memastikan menu ditampilkan atau disembunyikan
        if (navMenu.classList.contains('show')) {
            navMenu.style.display = 'block'; // Atau 'flex', tergantung layoutmu
        } else {
            navMenu.style.display = 'none';
        }
    }

    // Function to set aria-expanded to false for all dropdown buttons
    function setAriaExpandedFalse() {
        dropdownBtn.forEach((btn) => btn.setAttribute("aria-expanded", "false"));
    }

    // Function to close all dropdown menus
    function closeDropdownMenu() {
        dropdown.forEach((drop) => {
            drop.classList.remove("active");
            drop.removeEventListener("click", (e) => e.stopPropagation());
        });
    }

    // Dropdown button click event
    dropdownBtn.forEach((btn) => {
        btn.addEventListener("click", function (e) {
            e.stopPropagation(); // Prevent event from bubbling up to the document
            const dropdownIndex = e.currentTarget.dataset.dropdown;
            const dropdownElement = document.getElementById(dropdownIndex);

            dropdownElement.classList.toggle("active");
            dropdown.forEach((drop) => {
                if (drop.id !== btn.dataset["dropdown"]) {
                    drop.classList.remove("active");
                }
            });
            btn.setAttribute(
                "aria-expanded",
                btn.getAttribute("aria-expanded") === "false" ? "true" : "false"
            );
        });
    });

    // Close dropdown menu when the dropdown links are clicked
    links.forEach((link) =>
        link.addEventListener("click", () => {
            closeDropdownMenu();
            setAriaExpandedFalse();
            toggleMenu();
        })
    );

    // Close dropdown menu when you click on the document body
    document.documentElement.addEventListener("click", () => {
        closeDropdownMenu();
        setAriaExpandedFalse();
    });

    // Close dropdown when the escape key is pressed
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            closeDropdownMenu();
            setAriaExpandedFalse();
        }
    });

  // Hamburger click event
  closeBtn.addEventListener('click', function(e) {
    e.preventDefault();
    toggleMenu();
    this.style.display = 'none'; // Hide when menu closes
});

  // Create close button
  const closeBtn = document.createElement('span');
  closeBtn.classList.add('close-btn');
  closeBtn.innerHTML = 'x';
  closeBtn.setAttribute('aria-label', 'Close menu');
  document.body.appendChild(closeBtn); // Append to body instead of navMenu

    // Close button click event
    closeBtn.addEventListener('click', function(e) {
        e.preventDefault();
        toggleMenu();
    });

    // Prevent scrolling when the menu is open
    document.addEventListener('click', function(event) {
        if (navMenu.classList.contains('show') && !navMenu.contains(event.target) && event.target !== hamburgerBtn && !event.target.closest('.dropdown')) {
            toggleMenu();
        }
    });
});