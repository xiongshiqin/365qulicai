<script src="<?php echo BASE_URL; ?>/html/js/jquery.slides.min.js"></script>

	<div class="container">
		<div id="slides">
			<img src="http://img3.3lian.com/2006/013/02/059.jpg"/>
			<img src="http://img3.3lian.com/2006/013/02/058.jpg"/>
			<img src="http://img3.3lian.com/2006/013/02/057.jpg"/>
		</div>
		<div id="slidesjs-log">Slide <span class="slidesjs-slide-number">1</span> of 4</div>
	</div>

<script>
	$(function() {
		$('#slides').slidesjs({
			width: 940,
			height: 528,
			callback: {
				loaded: function(number) {
					// Use your browser console to view log
					console.log('SlidesJS: Loaded with slide #' + number);

					// Show start slide in log
					$('#slidesjs-log .slidesjs-slide-number').text(number);
				},
				start: function(number) {
					// Use your browser console to view log
					console.log('SlidesJS: Start Animation on slide #' + number);
				},
				complete: function(number) {
					// Use your browser console to view log
					console.log('SlidesJS: Animation Complete. Current slide is #' + number);

					// Change slide number on animation complete
					$('#slidesjs-log .slidesjs-slide-number').text(number);
				}
			}
		});
	});
</script>