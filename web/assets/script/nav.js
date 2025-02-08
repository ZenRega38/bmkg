// nav.js (renamed to avoid confusion with other scripts)

document.addEventListener('DOMContentLoaded', function() {
  const dropdownBtn = document.querySelectorAll(".dropdown-btn2"); // Updated class
  const dropdown = document.querySelectorAll(".dropdown2"); // Updated class
  const hamburgerBtn = document.querySelector(".hamburger1"); // Updated class
  const navMenu = document.querySelector(".menu2"); // Updated class
  const links = document.querySelectorAll(".dropdown2 a"); // Updated class
  const body = document.body; // Get the body element

  // Function to toggle the menu and body overflow
  function toggleMenu() {
      navMenu.classList.toggle('show');
      body.classList.toggle('no-scroll'); // Toggle the class on the body
  }

  // Function to set aria-expanded to false for all dropdown buttons
  function setAriaExpandedFalse() {
      dropdownBtn.forEach((btn) => btn.setAttribute("aria-expanded", "false"));
  }

  // Function to close all dropdown menus
  function closeDropdownMenu() {
      dropdown.forEach((drop) => {
          drop.classList.remove("active");
          drop.removeEventListener("click", (e) => e.stopPropagation()); // Remove the event listener to avoid memory leaks
      });
  }

  // Dropdown button click event
  dropdownBtn.forEach((btn) => {
      btn.addEventListener("click", function (e) {
          const dropdownIndex = e.currentTarget.dataset.dropdown;
          const dropdownElement = document.getElementById(dropdownIndex);

          dropdownElement.classList.toggle("active");
          dropdown.forEach((drop) => {
              if (drop.id !== btn.dataset["dropdown"]) {
                  drop.classList.remove("active");
              }
          });
          e.stopPropagation();
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
  hamburgerBtn.addEventListener("click", function(e) {
      e.preventDefault();
      toggleMenu();
  });

  // Create close button
  const closeBtn = document.createElement('span');
  closeBtn.classList.add('close-btn');
  closeBtn.innerHTML = '×'; // 'X' symbol
  navMenu.appendChild(closeBtn);

  // Close button click event
  closeBtn.addEventListener('click', function(e) {
      e.preventDefault();
      toggleMenu();
  });

  // Prevent scrolling when the menu is open
  document.addEventListener('click', function(event) {
      if (navMenu.classList.contains('show') && !navMenu.contains(event.target) && event.target !== hamburgerBtn) {
          toggleMenu();
      }
  });
});