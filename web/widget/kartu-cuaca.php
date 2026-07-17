<?php
/**
 * BMKG Tarakan - Sub-District Weather Widget Container
 * Placeholder section populated dynamically by modern-bmkg.js.
 */
?>
<section class="cuaca" id="kartu-cuaca" style="margin-bottom: 20px;">
    <!-- Populated dynamically via AJAX in assets/script/modern-bmkg.js -->
</section>

<!-- METAR TAF Widget for Juwata Tarakan (WAQQ) -->
<section class="UMKM" style="margin-bottom: 50px;">
    <h1>Data Cuaca Bandara</h1>
    <p>Cuaca Penerbangan (METAR) Bandara Juwata Tarakan (WAQQ)</p>
    <div class="content" style="margin-top: 25px; display: flex; justify-content: center;">
        <div class="weather-info" style="width: 100%; max-width: 800px; padding: 20px; background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            <a href="https://metar-taf.com/WAQQ" id="metartaf-lNcdCBQc" class="metar">METAR Juwata</a>
            <script async defer crossorigin="anonymous" src="https://metar-taf.com/embed-js/WAQQ?layout=landscape&qnh=hPa&rh=rh&target=lNcdCBQc"></script>
        </div>
    </div>
</section>