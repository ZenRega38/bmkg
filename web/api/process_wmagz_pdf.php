<?php
/**
 * process_wmagz_pdf.php
 * 
 * Pipeline otomatis: PDF → WebP per halaman → folder majalah → viewer.html
 * Dipanggil oleh upload_wmagz.php setelah PDF berhasil disimpan.
 *
 * Parameter (POST atau argumen internal):
 *   $pdfAbsPath  — Absolute path ke file PDF di server
 *   $year        — Tahun edisi (e.g. "2025")
 *   $month       — Bulan edisi (e.g. "January")
 *   $title       — Judul majalah
 *
 * Return: array ['success' => bool, 'message' => string, 'pages' => int, 'viewerPath' => string]
 */

function processMagazinePdf(string $pdfAbsPath, string $year, string $month, string $title): array
{
    // ---------------------------------------------------------------
    // 1. Tentukan folder output untuk edisi ini
    // ---------------------------------------------------------------
    $slug        = 'magazine_' . strtolower($month) . '_' . $year;
    $webRoot     = dirname(__DIR__);  // web/
    $magazineDir = $webRoot . '/assets/wmagz/' . $slug;
    $pagesDir    = $magazineDir . '/pages';

    if (!is_dir($magazineDir)) {
        mkdir($magazineDir, 0755, true);
    }
    if (!is_dir($pagesDir)) {
        mkdir($pagesDir, 0755, true);
    }

    // ---------------------------------------------------------------
    // 2. Jalankan Python script untuk konversi PDF → WebP
    // ---------------------------------------------------------------
    $pythonScript = $webRoot . '/script/convert_pdf_to_webp.py';
    $pythonBin    = 'python';  // atau 'python3' tergantung server

    // Escape path untuk shell
    $safePdf   = escapeshellarg($pdfAbsPath);
    $safeOut   = escapeshellarg($pagesDir);
    $safeDpi   = '150';

    $cmd = "$pythonBin " . escapeshellarg($pythonScript)
         . " --pdf $safePdf"
         . " --out $safeOut"
         . " --dpi $safeDpi"
         . " 2>&1";

    $output   = [];
    $exitCode = 0;
    exec($cmd, $output, $exitCode);

    if ($exitCode !== 0) {
        $errMsg = implode("\n", $output);
        return [
            'success' => false,
            'message' => "Konversi PDF gagal (exit $exitCode): $errMsg",
            'pages'   => 0,
            'viewerPath' => ''
        ];
    }

    // Baris terakhir stdout adalah jumlah halaman
    $numPages = (int) trim(end($output));
    if ($numPages < 1) {
        return [
            'success' => false,
            'message' => 'Script Python tidak mengembalikan jumlah halaman yang valid.',
            'pages'   => 0,
            'viewerPath' => ''
        ];
    }

    // ---------------------------------------------------------------
    // 3. Generate viewer.html untuk edisi ini
    // ---------------------------------------------------------------
    $viewerHtml = generateViewerHtml($title, $month, $year, $numPages);
    file_put_contents($magazineDir . '/viewer.html', $viewerHtml);

    // ---------------------------------------------------------------
    // 4. Tentukan path viewer relatif (untuk disimpan di JSON)
    // ---------------------------------------------------------------
    // Path relatif dari web/ root, pakai forward slashes
    $viewerRelPath = 'assets/wmagz/' . $slug . '/viewer.html';

    return [
        'success'    => true,
        'message'    => "Berhasil membuat $numPages halaman WebP untuk $title.",
        'pages'      => $numPages,
        'viewerPath' => $viewerRelPath,
        'slug'       => $slug
    ];
}


/**
 * Generate viewer.html lengkap untuk satu edisi majalah.
 * Thumbnail dan jumlah halaman digenerate dinamis.
 */
function generateViewerHtml(string $title, string $month, string $year, int $numPages): string
{
    // Build thumbnail list HTML
    $thumbItems = '';

    // Halaman 1 selalu single (cover)
    $thumbItems .= "\t\t\t<li class=\"i\">\n";
    $thumbItems .= "\t\t\t\t<img src=\"pages/1-thumb.webp\" width=\"76\" height=\"100\" class=\"page-1\">\n";
    $thumbItems .= "\t\t\t\t<span>1</span>\n";
    $thumbItems .= "\t\t\t</li>\n";

    // Halaman 2 sampai N-1: berpasangan
    for ($i = 2; $i < $numPages; $i += 2) {
        $left  = $i;
        $right = $i + 1;
        if ($right > $numPages) {
            // Halaman tunggal di akhir (jika ganjil)
            $thumbItems .= "\t\t\t<li class=\"i\">\n";
            $thumbItems .= "\t\t\t\t<img src=\"pages/{$left}-thumb.webp\" width=\"76\" height=\"100\" class=\"page-{$left}\">\n";
            $thumbItems .= "\t\t\t\t<span>{$left}</span>\n";
            $thumbItems .= "\t\t\t</li>\n";
        } else {
            $thumbItems .= "\t\t\t<li class=\"d\">\n";
            $thumbItems .= "\t\t\t\t<img src=\"pages/{$left}-thumb.webp\" width=\"76\" height=\"100\" class=\"page-{$left}\">\n";
            $thumbItems .= "\t\t\t\t<img src=\"pages/{$right}-thumb.webp\" width=\"76\" height=\"100\" class=\"page-{$right}\">\n";
            $thumbItems .= "\t\t\t\t<span>{$left}-{$right}</span>\n";
            $thumbItems .= "\t\t\t</li>\n";
        }
    }

    // Halaman terakhir (jika genap = single page)
    if ($numPages % 2 === 0) {
        $thumbItems .= "\t\t\t<li class=\"i\">\n";
        $thumbItems .= "\t\t\t\t<img src=\"pages/{$numPages}-thumb.webp\" width=\"76\" height=\"100\" class=\"page-{$numPages}\">\n";
        $thumbItems .= "\t\t\t\t<span>{$numPages}</span>\n";
        $thumbItems .= "\t\t\t</li>\n";
    }

    $safeTitle = htmlspecialchars($title, ENT_QUOTES);

    return <<<HTML
<!doctype html>
<!--[if lt IE 7 ]> <html lang="id" class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="id" class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="id" class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="id" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="id"> <!--<![endif]-->
<head>
	<meta charset="UTF-8">
	<title>$safeTitle — BMKG W'Magz</title>
	<meta name="viewport" content="width=1050, user-scalable=no">
	<link rel="icon" type="image/x-icon" href="../../image/logo_noname.png">
	<script type="text/javascript" src="../../../../extras/jquery.min.1.7.js"></script>
	<script type="text/javascript" src="../../../../extras/modernizr.2.5.3.min.js"></script>
	<script type="text/javascript" src="../../../../lib/hash.js"></script>
</head>
<body>

<div id="canvas">

<div class="zoom-icon zoom-icon-in"></div>

<div class="magazine-viewport">
	<div class="container">
		<div class="magazine">
			<!-- Next button -->
			<div ignore="1" class="next-button"></div>
			<!-- Previous button -->
			<div ignore="1" class="previous-button"></div>
		</div>
	</div>
</div>

<!-- Thumbnails -->
<div class="thumbnails">
	<div>
		<ul>
$thumbItems		</ul>
	<div>
</div>
</div>

<script type="text/javascript">

var TOTAL_PAGES = $numPages;

function loadApp() {

	\$('#canvas').fadeIn(1000);

	var flipbook = \$('.magazine');

	if (flipbook.width()==0 || flipbook.height()==0) {
		setTimeout(loadApp, 10);
		return;
	}

	flipbook.turn({
		width: 922,
		height: 600,
		duration: 1000,
		acceleration: !isChrome(),
		gradients: true,
		autoCenter: true,
		elevation: 50,
		pages: TOTAL_PAGES,
		when: {
			turning: function(event, page, view) {
				var book = \$(this),
				currentPage = book.turn('page'),
				pages = book.turn('pages');

				Hash.go('page/' + page).update();
				disableControls(page);

				\$('.thumbnails .page-'+currentPage).parent().removeClass('current');
				\$('.thumbnails .page-'+page).parent().addClass('current');
			},
			turned: function(event, page, view) {
				disableControls(page);
				\$(this).turn('center');
				if (page==1) { \$(this).turn('peel', 'br'); }
			},
			missing: function(event, pages) {
				for (var i = 0; i < pages.length; i++)
					addPage(pages[i], \$(this));
			}
		}
	});

	\$('.magazine-viewport').zoom({
		flipbook: \$('.magazine'),
		max: function() { return largeMagazineWidth() / \$('.magazine').width(); },
		when: {
			swipeLeft:  function() { \$(this).zoom('flipbook').turn('next'); },
			swipeRight: function() { \$(this).zoom('flipbook').turn('previous'); },
			resize: function(event, scale, page, pageElement) {
				if (scale==1) loadSmallPage(page, pageElement);
				else          loadLargePage(page, pageElement);
			},
			zoomIn: function() {
				\$('.thumbnails').hide();
				\$('.made').hide();
				\$('.magazine').removeClass('animated').addClass('zoom-in');
				\$('.zoom-icon').removeClass('zoom-icon-in').addClass('zoom-icon-out');
				if (!window.escTip && !\$.isTouch) {
					escTip = true;
					\$('<div />', {'class': 'exit-message'}).html('<div>Press ESC to exit</div>')
						.appendTo(\$('body')).delay(2000).animate({opacity:0}, 500, function() { \$(this).remove(); });
				}
			},
			zoomOut: function() {
				\$('.exit-message').hide();
				\$('.thumbnails').fadeIn();
				\$('.made').fadeIn();
				\$('.zoom-icon').removeClass('zoom-icon-out').addClass('zoom-icon-in');
				setTimeout(function(){
					\$('.magazine').addClass('animated').removeClass('zoom-in');
					resizeViewport();
				}, 0);
			}
		}
	});

	if (\$.isTouch) \$('.magazine-viewport').bind('zoom.doubleTap', zoomTo);
	else           \$('.magazine-viewport').bind('zoom.tap', zoomTo);

	\$(document).keydown(function(e) {
		var previous = 37, next = 39, esc = 27;
		switch (e.keyCode) {
			case previous: \$('.magazine').turn('previous'); e.preventDefault(); break;
			case next:     \$('.magazine').turn('next');     e.preventDefault(); break;
			case esc:      \$('.magazine-viewport').zoom('zoomOut'); e.preventDefault(); break;
		}
	});

	Hash.on('^page\\/([0-9]*)\$', {
		yep: function(path, parts) {
			var page = parts[1];
			if (page !== undefined && \$('.magazine').turn('is'))
				\$('.magazine').turn('page', page);
		},
		nop: function(path) {
			if (\$('.magazine').turn('is')) \$('.magazine').turn('page', 1);
		}
	});

	\$(window).resize(function() { resizeViewport(); }).bind('orientationchange', function() { resizeViewport(); });

	\$('.thumbnails').click(function(event) {
		var page;
		if (event.target && (page = /page-([0-9]+)/.exec(\$(event.target).attr('class')))) {
			\$('.magazine').turn('page', page[1]);
		}
	});

	\$('.thumbnails li')
		.bind(\$.mouseEvents.over, function() { \$(this).addClass('thumb-hover'); })
		.bind(\$.mouseEvents.out,  function() { \$(this).removeClass('thumb-hover'); });

	if (\$.isTouch) {
		\$('.thumbnails').addClass('thumbanils-touch').bind(\$.mouseEvents.move, function(e) { e.preventDefault(); });
	} else {
		\$('.thumbnails ul')
			.mouseover(function() { \$('.thumbnails').addClass('thumbnails-hover'); })
			.mousedown(function() { return false; })
			.mouseout(function()  { \$('.thumbnails').removeClass('thumbnails-hover'); });
	}

	if (\$.isTouch) \$('.magazine').bind('touchstart', regionClick);
	else           \$('.magazine').click(regionClick);

	\$('.next-button')
		.bind(\$.mouseEvents.over,  function() { \$(this).addClass('next-button-hover'); })
		.bind(\$.mouseEvents.out,   function() { \$(this).removeClass('next-button-hover'); })
		.bind(\$.mouseEvents.down,  function() { \$(this).addClass('next-button-down'); })
		.bind(\$.mouseEvents.up,    function() { \$(this).removeClass('next-button-down'); })
		.click(function()           { \$('.magazine').turn('next'); });

	\$('.previous-button')
		.bind(\$.mouseEvents.over,  function() { \$(this).addClass('previous-button-hover'); })
		.bind(\$.mouseEvents.out,   function() { \$(this).removeClass('previous-button-hover'); })
		.bind(\$.mouseEvents.down,  function() { \$(this).addClass('previous-button-down'); })
		.bind(\$.mouseEvents.up,    function() { \$(this).removeClass('previous-button-down'); })
		.click(function()           { \$('.magazine').turn('previous'); });

	resizeViewport();
	\$('.magazine').addClass('animated');
}

\$('.zoom-icon')
	.bind('mouseover', function() {
		if (\$(this).hasClass('zoom-icon-in'))  \$(this).addClass('zoom-icon-in-hover');
		if (\$(this).hasClass('zoom-icon-out')) \$(this).addClass('zoom-icon-out-hover');
	})
	.bind('mouseout', function() {
		if (\$(this).hasClass('zoom-icon-in'))  \$(this).removeClass('zoom-icon-in-hover');
		if (\$(this).hasClass('zoom-icon-out')) \$(this).removeClass('zoom-icon-out-hover');
	})
	.bind('click', function() {
		if (\$(this).hasClass('zoom-icon-in'))       \$('.magazine-viewport').zoom('zoomIn');
		else if (\$(this).hasClass('zoom-icon-out')) \$('.magazine-viewport').zoom('zoomOut');
	});

\$('#canvas').hide();

yepnope({
	test: Modernizr.csstransforms,
	yep:  ['../../../../lib/turn.js'],
	nope: ['../../../../lib/turn.html4.min.js'],
	both: ['../../../../lib/zoom.min.js', '../../script/magazine.js', '../../../css/magazine.css'],
	complete: loadApp
});

</script>
</body>
</html>
HTML;
}
?>
