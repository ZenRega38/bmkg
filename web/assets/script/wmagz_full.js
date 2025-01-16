document.addEventListener('DOMContentLoaded', function() {
    const prevYearBtn = document.getElementById('prevYearBtn');
    const nextYearBtn = document.getElementById('nextYearBtn');
    const currentYearDisplay = document.getElementById('currentYearDisplay');
    const currentMonthDisplay = document.getElementById('currentMonthDisplay');
    const imageGrid = document.querySelector('.image-grid');
    let currentYear = new Date().getFullYear();
    let currentMonth = new Date().getMonth();


    function updateGrid(year) {
        currentYearDisplay.textContent = year;
        currentMonthDisplay.textContent = month;
        imageGrid.innerHTML = ''; // Clear previous content

        // Example: dynamically add images
        for (let i = 1; i <= 15; i++) {
            const imagePath = `magazine_${month}_${year}/pages/1.jpg`;
            const link = document.createElement('a');
            link.href = `magazine_january_${year}/viewer.html`;
            const img = document.createElement('img');
            img.src = imagePath;
            img.alt = `Image ${i}`;
            link.appendChild(img);
            if (i === 1){
             link.classList.add('featured');
            }
            imageGrid.appendChild(link);

        }
    }

    updateGrid(currentYear);
    // Disable next button on first load
    nextYearBtn.disabled = true;


    prevYearBtn.addEventListener('click', function() {
        currentYear--;
        updateGrid(currentYear);
         // Enable next button if we have moved back from the future
         nextYearBtn.disabled = false;
    });
    
     nextYearBtn.addEventListener('click', function() {
        currentYear++;
        updateGrid(currentYear);
         // disable next button if next year is the current year
        if (currentYear == new Date().getFullYear()){
            nextYearBtn.disabled = true;
         }
    });
});