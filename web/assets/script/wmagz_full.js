 console.log("javascript loaded");
 document.addEventListener('DOMContentLoaded', function() {
   console.log("DOMContentLoaded event triggered");
    const prevYearBtn = document.getElementById('prevYearBtn');
    const nextYearBtn = document.getElementById('nextYearBtn');
    const currentYearDisplay = document.getElementById('currentYearDisplay');
    const imageGrid = document.querySelector('.image-grid');
    let currentYear = new Date().getFullYear();

   console.log(prevYearBtn);
   console.log(nextYearBtn);


    function updateGrid(year) {
        currentYearDisplay.textContent = year;
        imageGrid.innerHTML = ''; // Clear previous content

        // Example: dynamically add images
        for (let i = 1; i <= 15; i++) {
            const imagePath = `magazine_january_${year}/pages/1.jpg`;
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
    nextYearBtn.disabled = true;
  
    prevYearBtn.addEventListener('click', function() {
        currentYear--;
        updateGrid(currentYear);
         nextYearBtn.disabled = false;
       console.log("prevYearBtn clicked");
    });

     console.log("Click listener added to prevYearBtn");
    
     nextYearBtn.addEventListener('click', function() {
        currentYear++;
        updateGrid(currentYear);
        if (currentYear == new Date().getFullYear()){
            nextYearBtn.disabled = true;
         }
          console.log("nextYearBtn clicked");
    });
   console.log("Click listener added to nextYearBtn");
});