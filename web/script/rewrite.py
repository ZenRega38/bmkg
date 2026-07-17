import re

with open('cuaca.php', 'r', encoding='utf-8') as f:
    content = f.read()

start_idx = content.find('<section>')
end_idx = content.find('</section>') + len('</section>')

if start_idx == -1 or end_idx == -1:
    print("Could not find <section>")
    exit(1)

head_part = content[:start_idx]
tail_part = content[end_idx:]

new_section = """<section>
    <div class="swiper-container master-city-swiper" style="width: 100%; overflow: hidden;">
        <div class="swiper-wrapper">
            <?php foreach ($citiesData as $cityName => $selectedCityData): ?>
            <div class="swiper-slide master-city-slide">
                <h2 class="forecast-title">
                    Prakiraan Cuaca <?= $cityName . ', ' . $selectedCityData['provinsi'] ?>
                </h2>
                
                <div style="display: flex; justify-content: center; align-items: center; width: 100%; margin-bottom: 20px;">
                      <a href="#" class="master-prev-btn" style="text-decoration: none; color: #000; font-size: 20px; display: flex; align-items: center;">
                          <img style="width:16px;height:22px;margin-right: 16px;" src="assets/image/prev_btn.png"/>
                      </a>
                      <div style="text-decoration: none; color: #000; font-size: 20px; display: flex; align-items: center; justify-content: center; height: 100%;">
                          <?= $cityName ?>
                      </div>
                      <a href="#" class="master-next-btn" style="text-decoration: none; color: #000; font-size: 20px; display: flex; align-items: center;">
                          <img style="width:16px;height:22px;margin-left: 16px;" src="assets/image/next_btn.png"/>
                      </a>
                </div>

                <!-- Current Weather Info -->
                <div class="current-weather-container">
                    <?php
                    $icon_mapping = [
                        'Cerah' => '<span class="weather-icon">☀️</span>',
                        'Berawan' => '<span class="weather-icon">☁️</span>',
                        'Hujan Ringan' => '<span class="weather-icon">🌦️</span>',
                        'Hujan Sedang' => '<span class="weather-icon">🌧️</span>',
                        'Hujan Lebat' => '<span class="weather-icon">⛈️</span>',
                        'Hujan Petir' => '<span class="weather-icon">⛈️</span>',
                        'Cerah Berawan' => '<span class="weather-icon">🌤️</span>',
                        'Awan Tebal' => '<span class="weather-icon">🌥️</span>',
                        'Udara Kabur' => '<span class="weather-icon">🌫️</span>',
                        'Angin Kencang' => '<span class="weather-icon">🌪️</span>',
                        'Kabut' => '<span class="weather-icon">🌫️</span>',
                        'Asap' => '<span class="weather-icon">🌫️</span>',
                        'Berawan Tebal' => '<span class="weather-icon">🌥️</span>',
                        'Kabut Asap' => '<span class="weather-icon">🌫️</span>',
                        'Cloudy' => '<span class="weather-icon">☁️</span>',
                        'Light Rain' => '<span class="weather-icon">🌦️</span>',
                        'Moderate Rain' => '<span class="weather-icon">🌧️</span>',
                        'Heavy Rain' => '<span class="weather-icon">⛈️</span>',
                        'Clear' => '<span class="weather-icon">☀️</span>',
                        'Partly Cloudy' => '<span class="weather-icon">🌤️</span>',
                        'Fog' => '<span class="weather-icon">🌫️</span>',
                        'Smoke' => '<span class="weather-icon">🌫️</span>',
                        'Overcast' => '<span class="weather-icon">🌥️</span>',
                        'Haze' => '<span class="weather-icon">🌫️</span>',
                        'Light Snow' => '<span class="weather-icon">🌨️</span>',
                        'Moderate Snow' => '<span class="weather-icon">🌨️</span>',
                        'Heavy Snow' => '<span class="weather-icon">🌨️</span>',
                        'Snow' => '<span class="weather-icon">🌨️</span>',
                        'Sleet' => '<span class="weather-icon">🌧️</span>',
                        'Freezing Rain' => '<span class="weather-icon">🌦️</span>',
                        'Drizzle' => '<span class="weather-icon">🌦️</span>',
                        'Rain' => '<span class="weather-icon">🌧️</span>',
                        'Thunder' => '<span class="weather-icon">⛈️</span>',
                        'Windy' => '<span class="weather-icon">🌪️</span>',
                        'Clear Sky' => '<span class="weather-icon">☀️</span>',
                        'Few Clouds' => '<span class="weather-icon">🌤️</span>',
                        'Scattered Clouds' => '<span class="weather-icon">☁️</span>',
                        'Broken Clouds' => '<span class="weather-icon">🌥️</span>',
                        'Shower Rain' => '<span class="weather-icon">🌦️</span>',
                        'Rain Shower' => '<span class="weather-icon">🌦️</span>',
                        'Snow Shower' => '<span class="weather-icon">🌨️</span>',
                        'Ice Pellets' => '<span class="weather-icon">🌧️</span>',
                        'Mist' => '<span class="weather-icon">🌫️</span>',
                        'Sand' => '<span class="weather-icon">🏜️</span>',
                        'Dust' => '<span class="weather-icon">🌫️</span>',
                        'Squall' => '<span class="weather-icon">🌪️</span>',
                        'Tornado' => '<span class="weather-icon">🌋</span>',
                        'Sandstorm' => '<span class="weather-icon">🏜️</span>',
                        'Duststorm' => '<span class="weather-icon">🌫️</span>',
                        'Funnel Cloud' => '<span class="weather-icon">🌪️</span>',
                        'Hail' => '<span class="weather-icon">🌧️</span>',
                        'Small Hail' => '<span class="weather-icon">🌧️</span>',
                        'Unknown' => ''
                    ];
                    $timezone = $selectedCityData['timezone'] ?? 'Asia/Jakarta';
                    $now = new DateTime('now', new DateTimeZone($timezone));
                    $currentForecast = null;
                    $minDiff = PHP_INT_MAX;
                    if (isset($selectedCityData['cuaca'])) {
                        foreach ($selectedCityData['cuaca'] as $forecast_set) {
                            foreach ($forecast_set as $forecast) {
                                if (isset($forecast['local_datetime'])) {
                                    $forecastTime = new DateTime($forecast['local_datetime'], new DateTimeZone($timezone));
                                    $diff = abs($now->getTimestamp() - $forecastTime->getTimestamp());
                                    if ($diff < $minDiff) {
                                        $minDiff = $diff;
                                        $currentForecast = $forecast;
                                    }
                                }
                            }
                        }
                    }
                    if ($currentForecast) {
                        $weather_desc = isset($currentForecast['weather_desc']) ? $currentForecast['weather_desc'] : 'Unknown';
                        $icon_html = isset($icon_mapping[$weather_desc]) ? $icon_mapping[$weather_desc] : '';
                        $formatted_time = $now->format('H:i');
                        echo '<div class="current-weather">';
                        echo '<div class="current-weather-time realtime-clock" data-timezone="'.$timezone.'" style="font-size: 24px; font-weight: 600; text-align: center;">' . $formatted_time . ' WITA</div>';
                        echo '<div class="current-weather-temp" style="display: flex; justify-content: center; align-items: center; font-size: 40px; font-weight: 700;">' . (isset($currentForecast['t']) ? $currentForecast['t'] : 'N/A') . '°C</div>';
                        echo '<div class="current-weather-icon" style="display: flex; justify-content: center; align-items: center; font-size: 24px; font-weight: 600; flex-direction: row;">';
                        echo '<span style="margin-right: 18px; margin-top: -24px">' . $icon_html . '</span>';
                        echo '<span>' . $weather_desc . '</span>';
                        echo '</div>';
                        echo '<div class="current-weather-humidity" style="display: flex; justify-content: center; align-items: center; font-size: 22px; font-weight: 500; margin-top: 15px;">💧 ' . (isset($currentForecast['hu']) ? $currentForecast['hu'] : 'N/A') . ' %</div>';
                        echo '</div>';
                    }
                    ?>
                </div>

                <!-- Filter Dropdown -->
                <div class="filter-container">
                   <select onchange="filterTable(this)">
                        <option value="all">Tiga Hari Kedepan</option>
                        <option value="today">Hari Ini</option>
                        <option value="tomorrow">Besok</option>
                        <option value="today-tomorrow">Hari Ini & Besok</option>
                    </select>
                </div>

                <!-- Desktop Table Forecast -->
                <div class="weather-table-container">
                    <table class="weather-table">
                        <thead>
                            <tr>
                                <th>Suhu</th>
                                <th>Tutupan Awan</th>
                                <th>Deskripsi Cuaca</th>
                                <th>Kecepatan Angin</th>
                                <th>Kelembapan Udara</th>
                                <th>Jarak Pandang</th>
                                <th>Waktu Setempat</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($selectedCityData['cuaca'])) {
                               $dayCount = 0;
                               $displayedDates = [];
                                foreach ($selectedCityData['cuaca'] as $forecast_set) {
                                    foreach ($forecast_set as $forecast) {
                                        $weather_desc = isset($forecast['weather_desc']) ? $forecast['weather_desc'] : 'Unknown';
                                        $icon_html = isset($icon_mapping[$weather_desc]) ? $icon_mapping[$weather_desc] : '';
                                        $local_datetime = isset($forecast['local_datetime']) ? $forecast['local_datetime'] : null;
                                        $formatted_time = 'N/A';
                                        $formatted_date = 'N/A';
                                        $dayName = 'N/A';
                                        if ($local_datetime) {
                                            try {
                                               $date = new DateTime($local_datetime, new DateTimeZone($timezone));
                                               $formatted_time = $date->format('H:i');
                                               $formatted_date = $date->format('Y-m-d');
                                               $dayName = $date->format('D');
                                               $dayName = match ($dayName) {
                                                   'Mon' => 'Senin',
                                                   'Tue' => 'Selasa',
                                                   'Wed' => 'Rabu',
                                                   'Thu' => 'Kamis',
                                                   'Fri' => 'Jumat',
                                                   'Sat' => 'Sabtu',
                                                   'Sun' => 'Minggu',
                                                   default => 'Unknown',
                                               };
                                               $today = new DateTime('now', new DateTimeZone($selectedCityData['timezone']));
                                               $tomorrow = (new DateTime('now', new DateTimeZone($selectedCityData['timezone'])))->modify('+1 day');
                                              if ($date->format('Y-m-d') == $today->format('Y-m-d')) {
                                                   $dayName = 'Hari Ini';
                                               } elseif ($date->format('Y-m-d') == $tomorrow->format('Y-m-d')) {
                                                   $dayName = 'Besok';
                                               }
                                            } catch (Exception $e) { }
                                       }
                                      if (!in_array($formatted_date, $displayedDates)) {
                                          if ($dayCount >= 3) {
                                              break 2;
                                          }
                                          $displayedDates[] = $formatted_date;
                                          $dayCount++;
                                      }
                                        echo '<tr data-date="' . $formatted_date . '">';
                                       echo '<td>' . (isset($forecast['t']) ? $forecast['t'] : 'N/A') . ' °C</td>';
                                       echo '<td>' . (isset($forecast['tcc']) ? $forecast['tcc'] : 'N/A') . ' %</td>';
                                       echo '<td>' . $icon_html . ' ' . $weather_desc . '</td>';
                                       echo '<td>' . (isset($forecast['ws']) ? $forecast['ws'] : 'N/A') . ' km/jam</td>';
                                       echo '<td>' . (isset($forecast['hu']) ? $forecast['hu'] : 'N/A') . ' %</td>';
                                       echo '<td>' . (isset($forecast['vs_text']) ? $forecast['vs_text'] : 'N/A') . '</td>';
                                       echo '<td>' . $formatted_time . '</td>';
                                       echo '<td>' . $dayName . '</td>';
                                       echo '</tr>';
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <?php
                // Group forecasts by day for mobile cards
                if (isset($selectedCityData['cuaca'])) {
                    $dailyForecasts = [];
                    $today = new DateTime('now', new DateTimeZone($timezone));
                    $today_date = $today->format('Y-m-d');
                    $tomorrow = (new DateTime('now', new DateTimeZone($timezone)))->modify('+1 day');
                    $tomorrow_date = $tomorrow->format('Y-m-d');
                    $after_tomorrow = (new DateTime('now', new DateTimeZone($timezone)))->modify('+2 days');
                    $after_tomorrow_date = $after_tomorrow->format('Y-m-d');
                    $dayAfterTomorrowName = $after_tomorrow->format('D');
                    $dayAfterTomorrowName = match ($dayAfterTomorrowName) {
                        'Mon' => 'Senin',
                        'Tue' => 'Selasa',
                        'Wed' => 'Rabu',
                        'Thu' => 'Kamis',
                        'Fri' => 'Jumat',
                        'Sat' => 'Sabtu',
                        'Sun' => 'Minggu',
                        default => 'Unknown',
                    };

                    $dailyForecasts['Hari Ini'] = [];
                    $dailyForecasts['Besok'] = [];
                    $dailyForecasts[$dayAfterTomorrowName] = [];

                    foreach ($selectedCityData['cuaca'] as $forecast_set) {
                        foreach ($forecast_set as $forecast) {
                            $local_datetime = isset($forecast['local_datetime']) ? $forecast['local_datetime'] : null;
                            if ($local_datetime) {
                                try {
                                    $date = new DateTime($local_datetime, new DateTimeZone($timezone));
                                    $date_string = $date->format('Y-m-d');
                                    if ($date_string == $today_date) {
                                        $dailyForecasts['Hari Ini'][] = $forecast;
                                    } elseif ($date_string == $tomorrow_date) {
                                        $dailyForecasts['Besok'][] = $forecast;
                                    } elseif ($date_string == $after_tomorrow_date) {
                                        $dailyForecasts[$dayAfterTomorrowName][] = $forecast;
                                    }
                                } catch (Exception $e) { }
                            }
                        }
                    }
                }
                $dayOrder = ['Hari Ini', 'Besok', $dayAfterTomorrowName];
                ?>

                <?php foreach ($dayOrder as $dayName): ?>
                    <div class="day-container">
                        <div class="day-heading"><?= $dayName ?></div>
                        <div class="mobile-swiper-container swiper-mobile">
                            <div class="swiper-wrapper">
                                <?php if (isset($dailyForecasts[$dayName]) && !empty($dailyForecasts[$dayName])): ?>
                                    <?php foreach ($dailyForecasts[$dayName] as $forecast):
                                        $weather_desc = isset($forecast['weather_desc']) ? $forecast['weather_desc'] : 'Unknown';
                                        $icon_html = isset($icon_mapping[$weather_desc]) ? $icon_mapping[$weather_desc] : '';
                                        $local_datetime = isset($forecast['local_datetime']) ? $forecast['local_datetime'] : null;
                                        $formatted_time = 'N/A';
                                        if ($local_datetime) {
                                            try {
                                                $date = new DateTime($local_datetime, new DateTimeZone($timezone));
                                                $formatted_time = $date->format('H:i');
                                            } catch (Exception $e) { }
                                        }
                                        ?>
                                        <div class="swiper-slide mobile-swiper-slide">
                                            <div class="weather-card">
                                                <div class="weather-card-title"><?= $formatted_time ?></div>
                                                <div style="text-align: center; color:white; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);"><?=$icon_html?></div>
                                                <div class="weather-card-detail">
                                                    Suhu: <?= (isset($forecast['t']) ? $forecast['t'] : 'N/A') ?> °C
                                                </div>
                                                <div class="weather-card-detail">
                                                     <?= $weather_desc ?>
                                                </div>
                                                <div class="weather-card-detail">
                                                       Kecepatan Angin: <?= (isset($forecast['ws']) ? $forecast['ws'] : 'N/A') ?> km/jam
                                                </div>
                                                <div class="weather-card-detail">
                                                      Kelembapan: <?= (isset($forecast['hu']) ? $forecast['hu'] : 'N/A') ?>%
                                                 </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="swiper-slide mobile-swiper-slide">
                                        <div class="weather-card">
                                            <div class="weather-card-title">No Data Available</div>
                                            <div class="weather-card-detail">
                                                No forecast data for <?= $dayName ?>.
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div> <!-- swiper-slide master-city-slide -->
            <?php endforeach; ?>
        </div>
    </div>
</section>"""

tail_part = re.sub(
    r'const swiperNav = new Swiper\(\'\.swiper\'.*?\);',
    '',
    tail_part,
    flags=re.DOTALL
)

tail_part = re.sub(
    r'function reloadPage.*?}',
    '',
    tail_part,
    flags=re.DOTALL
)

tail_part = tail_part.replace("""        function updateClock() {
            const clockElement = document.getElementById('realtime-clock');
            const timezone = '<?php echo $selectedCityData['timezone']; ?>';
            const date = new Date();
            const options = { timeZone: timezone, hour: '2-digit', minute: '2-digit' };
            const formattedTime = date.toLocaleTimeString(undefined, options);
            clockElement.textContent = formattedTime + ' WITA';
        }
        setInterval(updateClock, 1000);
        updateClock();""", """        function updateClock() {
            const clocks = document.querySelectorAll('.realtime-clock');
            clocks.forEach(clock => {
                const timezone = clock.getAttribute('data-timezone') || 'Asia/Jakarta';
                const date = new Date();
                const options = { timeZone: timezone, hour: '2-digit', minute: '2-digit' };
                const formattedTime = date.toLocaleTimeString(undefined, options);
                clock.textContent = formattedTime + ' WITA';
            });
        }
        setInterval(updateClock, 1000);
        updateClock();""")

tail_part = tail_part.replace("""        function filterTable(filter) {
            const table = document.getElementById('weatherTable'); // corrected id
            const rows = table.getElementsByTagName('tr');""", """        function filterTable(selectElement) {
            const filter = selectElement.value;
            const container = selectElement.closest('.swiper-slide');
            const table = container ? container.querySelector('.weather-table') : document.querySelector('.weather-table');
            if(!table) return;
            const rows = table.getElementsByTagName('tr');""")


tail_part = tail_part.replace("const swiperContainers = document.querySelectorAll('.swiper-mobile');", """
            const masterSwiper = new Swiper('.master-city-swiper', {
                direction: 'horizontal',
                loop: false,
                navigation: {
                    nextEl: '.master-next-btn',
                    prevEl: '.master-prev-btn',
                },
                preventClicks: false,
                preventClicksPropagation: false
            });

            // Re-assign next/prev buttons manually due to swiper structure
            document.querySelectorAll('.master-next-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    masterSwiper.slideNext();
                });
            });
            document.querySelectorAll('.master-prev-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    masterSwiper.slidePrev();
                });
            });

            const swiperContainers = document.querySelectorAll('.swiper-mobile');""")

new_content = head_part + new_section + tail_part

with open('cuaca.php', 'w', encoding='utf-8') as f:
    f.write(new_content)

print("cuaca.php updated successfully!")
