<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="icon" type="image/x-icon" href="img/logo.png">
	<meta charset="utf-8">
	<title>Achievements</title>
	<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
	<link rel="stylesheet" type="text/css" href="css/wmagz.css">
	<link rel="stylesheet" href="css/outer.css">
    <link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
	<script type="text/javascript">
		$(window).on('scroll', function(){
			if ($(window).scrollTop()) {
				$('header').addClass('black');
			} else {
				$('header').removeClass('black');
			}
		})
	</script>
</head>
<body>
    <?php include 'header.php'; ?>
	<section >
		<div class="content">
			<div class="textBox">
				<h2>W'Magazines</h2>
				<p>Weather Magazine merupakan publikasi meteorologi yang memberikan prakiraan cuaca akurat, analisis tren iklim, dan wawasan ilmiah dari Stasiun Meteorologi Juwata Tarakan.</p>
				<a href="wmagz-full.php">Learn More</a>
			</div>

			<div class="imgBox">
				<div class="swiper-container">
				    <div class="swiper-wrapper">

						<div class="swiper-slide">
							<a href="magazine_january_2025/viewer.html">
								<img src="magazine_january_2025/pages/1.jpg">
							</a>
				    		<h2>W'Magz January 2025</h2>
				    		<p>Kilas Balik Desember 2024</p>
				    	</div>
						<div class="swiper-slide">
							<a href="magazine_january_2025/viewer.html">
								<img src="magazine_january_2025/pages/1.jpg">
							</a>
				    		<h2>W'Magz January 2025</h2>
				    		<p>Kilas Balik Desember 2024</p>
				    	</div>
						<div class="swiper-slide">
							<a href="magazine_january_2025/viewer.html">
								<img src="magazine_january_2025/pages/1.jpg">
							</a>
				    		<h2>W'Magz January 2025</h2>
				    		<p>Kilas Balik Desember 2024</p>
				    	</div>
						<div class="swiper-slide">
							<a href="magazine_january_2025/viewer.html">
								<img src="magazine_january_2025/pages/1.jpg">
							</a>
				    		<h2>W'Magz January 2025</h2>
				    		<p>Kilas Balik Desember 2024</p>
				    	</div>
						<div class="swiper-slide">
							<a href="magazine_january_2025/viewer.html">
								<img src="magazine_january_2025/pages/1.jpg">
							</a>
				    		<h2>W'Magz January 2025</h2>
				    		<p>Kilas Balik Desember 2024</p>
				    	</div>
				    </div>
				</div>
			</div>

		</div>
	</section>
	<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
	<script>
    var swiper = new Swiper('.swiper-container', {
		effect: 'coverflow',
		grabCursor: true,
		centeredSlides: true,
		slidesPerView: 'auto',
		coverflowEffect: {
			rotate: 10,
			stretch: 0,
			depth: 200,
			modifier: 1,
			slideShadows: true,
		},
		pagination: {
			el: '.swiper-pagination',
		},
		loop: true,
		on: {
			slideChangeTransitionStart: function () {
			var slides = this.slides;
			for (var i = 0; i < slides.length; i++) {
				var slide = slides[i];
				if (slide.classList.contains('swiper-slide-active')) {
				slide.querySelector('h2').style.opacity = '1';
				slide.querySelector('p').style.opacity = '1';
				} else {
				slide.querySelector('h2').style.opacity = '0';
				slide.querySelector('p').style.opacity = '0';
				}
			}
			},
		},
	});

  </script>
  <?php include 'footer.php'; ?>
</body>
</html>