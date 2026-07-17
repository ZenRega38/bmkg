document.addEventListener('DOMContentLoaded', function() {
    const prevYearBtn = document.getElementById('prevYearBtn');
    const nextYearBtn = document.getElementById('nextYearBtn');
    const currentYearDisplay = document.getElementById('currentYearDisplay');
    const imageGrid = document.querySelector('.image-grid');
    
    let currentYear = new Date().getFullYear();
    let magazinesData = {};

    function updateGrid(year) {
        currentYearDisplay.textContent = year;
        imageGrid.innerHTML = ''; // Clear previous content

        const yearData = magazinesData[year];

        if (yearData && Object.keys(yearData).length > 0) {
            let isFirst = true;
            for (const [month, data] of Object.entries(yearData)) {
                const link = document.createElement('a');
                link.href = data.link;
                const img = document.createElement('img');
                img.src = data.coverImage;
                img.alt = data.title;
                link.appendChild(img);
                
                if (isFirst) {
                    link.classList.add('featured');
                    isFirst = false;
                }
                imageGrid.appendChild(link);
            }
        } else {
            imageGrid.innerHTML = '<p style="text-align:center; grid-column: 1 / -1; font-size: 1.2rem; color: #666; margin-top: 50px;">Tidak ada edisi majalah untuk tahun ' + year + '.</p>';
        }
    }

    // Fetch the JSON data
    fetch('assets/json/data-wmagz.json')
        .then(response => response.json())
        .then(data => {
            if (data && data.magazines) {
                magazinesData = data.magazines;
                // Determine latest year available if current year doesn't exist
                const availableYears = Object.keys(magazinesData).map(Number).sort((a,b) => b-a);
                if (availableYears.length > 0 && !magazinesData[currentYear]) {
                    currentYear = availableYears[0];
                }
            }
            updateGrid(currentYear);
            updateButtons();
        })
        .catch(error => {
            console.error('Error fetching magazines:', error);
            imageGrid.innerHTML = '<p style="text-align:center; grid-column: 1 / -1; color: red;">Gagal memuat data majalah.</p>';
        });

    function updateButtons() {
        const availableYears = Object.keys(magazinesData).map(Number).sort((a,b) => b-a);
        if (availableYears.length > 0) {
            const maxYear = Math.max(...availableYears, new Date().getFullYear());
            const minYear = Math.min(...availableYears);
            
            nextYearBtn.style.opacity = currentYear >= maxYear ? '0.3' : '1';
            nextYearBtn.style.cursor = currentYear >= maxYear ? 'not-allowed' : 'pointer';
            
            prevYearBtn.style.opacity = currentYear <= minYear ? '0.3' : '1';
            prevYearBtn.style.cursor = currentYear <= minYear ? 'not-allowed' : 'pointer';
        }
    }

    prevYearBtn.addEventListener('click', function() {
        currentYear--;
        updateGrid(currentYear);
        updateButtons();
    });

    nextYearBtn.addEventListener('click', function() {
        currentYear++;
        updateGrid(currentYear);
        updateButtons();
    });
});