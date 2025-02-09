<!DOCTYPE html>
   <html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!--=============== REMIXICONS ===============-->
      <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
      <!--=============== CSS ===============-->
      <link rel="stylesheet" href="assets-nav/css/styles.css">
   </head>
   <body>
      <!--=============== HEADER ===============-->
      <header class="header">
         <nav class="nav container">
            <div class="nav__data">
               <a href="#" class="nav__logo">
                  <img src="../web/assets/image/logo_noname.png" alt="BMKG Logo">
                  <div class="nav__text-container">
                     <p class="nav__meteorologi">Badan Meteorologi, Klimatologi, dan Geofisika</p>
                     <p class="nav__bmkg">BMKG Juwata Tarakan</p>
                     <p class="nav__cepat-tanggap">Cepat, Tepat, Akurat, Luas, dan Mudah Dipahami</p>
                  </div>
               </a>
                              
               <div class="nav__toggle" id="nav-toggle">
                  <i class="ri-menu-line nav__burger"></i>
                  <i class="ri-close-line nav__close"></i>
               </div>
            </div>

            <!--=============== NAV MENU ===============-->
            <div class="nav__menu" id="nav-menu">
               <ul class="nav__list">
                  <li><a href="index.php" class="nav__link">Beranda</a></li>

                  <li><a href="profil.php" class="nav__link">Profil</a></li>

                  <!--=============== DROPDOWN 1 ===============-->
                  <li class="dropdown__item">
                     <div class="nav__link">
                        Cuaca <i class="ri-arrow-down-s-line dropdown__arrow"></i>
                     </div>

                     <ul class="dropdown__menu">
                        <li>
                           <a href="cuaca.php" class="dropdown__link">
                              Cuaca Wilayah
                           </a>                          
                        </li>

                        <li>
                           <a href="wisata.php" class="dropdown__link">
                              Cuaca Tempat Wisata
                           </a>
                        </li>

                     </ul>
                  </li>
                  

                  <!--=============== DROPDOWN 2 ===============-->
                  <li class="dropdown__item">
                     <div class="nav__link">
                        Pelayanan Publik <i class="ri-arrow-down-s-line dropdown__arrow"></i>
                     </div>

                     <ul class="dropdown__menu">
                        <li>
                           <a href="wmagz.php" class="dropdown__link">
                              W'magazine
                           </a>                          
                        </li>

                        <li>
                           <a href="aduan.php" class="dropdown__link">
                              Aduan
                           </a>
                        </li>

                        <li>
                           <a href="kritik-saran.php" class="dropdown__link">
                              Kritik Dan Saran
                           </a>
                        </li>
                        <li>
                           <a href="https://ptsp.bmkg.go.id/" class="dropdown__link">
                              PTSP
                           </a>
                        </li>
                        <li>
                           <a href="#" class="dropdown__link">
                              Kontak
                           </a>
                        </li>
                        <li>
                           <a href="pelayanan-publik.php" class="dropdown__link">
                              Selengkapnya
                           </a>
                        </li>
                     </ul>
                  </li>
               </ul>
            </div>
         </nav>
      </header>

      <!--=============== MAIN JS ===============-->
      <script src="assets-nav/js/main.js"></script>
   </body>
</html>