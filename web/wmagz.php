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
				<p>I have 22+ certificates and still counting, which are from online courses, competitions, webinar, seminar, and project completion.
				Let’s take a look! And you can also see the pdf version by clicking this button bellow.</p>
				<a href="https://drive.google.com/drive/folders/19aCnxYu_d2NI-9vwRG8GQwzrwq0xG9ss?usp=sharing">Learn More</a>
			</div>

			<div class="imgBox">
				<div class="swiper-container">
				    <div class="swiper-wrapper">

						<div class="swiper-slide">
				    		<img src="magazine_january_2025/pages/1.jpg">
				    		<h2>GDSC Lead Graduation 2023-2024</h2>
				    		<p>Signed by Google's Global Program Lead</p>
				    	</div>
						<div class="swiper-slide">
				    		<img src="magazine_january_2025/pages/1.jpg">
				    		<h2>Being The Official Translator of TechFest 2024</h2>
				    		<p>An international collaboration event</p>
							<p>between Google DSC, HMTK and CE Universitas Borneo Tarakan</p>
				    	</div>
						<div class="swiper-slide">
				    		<img src="magazine_january_2025/pages/1.jpg">
				    		<h2>Basic DevOps</h2>
				    		<p>Dicoding - Valid till 6 May 2026</p>
				    	</div>
						<div class="swiper-slide">
				    		<img src="magazine_january_2025/pages/1.jpg">
				    		<h2>Youth Abroad Expeditions #3</h2>
				    		<p>Europe Youth Summit 2023, by Indonesian Millenial of Change</p>
				    	</div>
						<div class="swiper-slide">
				    		<img src="magazine_january_2025/pages/1.jpg">
				    		<h2>Bali FAB Fest 2022</h2>
				    		<p>by FAB Foundation ( October 2022 )</p>
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