@extends('user.master')

@section('childHead')

<title>{{ $title }}</title>
<script src="{!! asset('js/jssor.slider.min.js'); !!}"></script>

<style>
	/* Begin custom jssor sliders */

	.slider-style {
		overflow: hidden;
	}

	.jssorb064 {
		position: absolute;
	}

	.jssorb064 .i {
		position: absolute;
		cursor: pointer;
	}

	.jssorb064 .i .b {
		fill: #000;
		fill-opacity: .5;
		stroke: #fff;
		stroke-width: 400;
		stroke-miterlimit: 10;
		stroke-opacity: 0.5;
	}

	.jssorb064 .i:hover .b {
		fill-opacity: .8;
	}

	.jssorb064 .iav .b {
		fill: #ffe200;
		fill-opacity: 1;
		stroke: #ffaa00;
		stroke-opacity: .7;
		stroke-width: 2000;
	}

	.jssorb064 .iav:hover .b {
		fill-opacity: .6;
	}

	.jssorb064 .i.idn {
		opacity: .3;
	}

	.jssora074 {
		display: block;
		position: absolute;
		cursor: pointer;
	}

	.jssora074 .a {
		fill: #333;
		fill-opacity: .7;
		stroke: #fff;
		stroke-width: 160;
		stroke-miterlimit: 10;
		stroke-opacity: .7;
	}

	.jssora074:hover {
		opacity: .8;
	}

	.jssora074.jssora074dn {
		opacity: .4;
	}

	.jssora074.jssora074ds {
		opacity: .3;
		pointer-events: none;
	}

	/* End custom jssor sliders */
</style>

@endsection

@section('content')

<div class="row">
	<div class="col-xl-1"></div>
	<div class="col-xl-10">
		<div id="jssor_slider" class="slider-style">
			<div data-u="slides" class="slider-style"></div>
			<!-- Bullet Navigator -->
			<div data-u="navigator" class="jssorb064" style="bottom: 16px; right: 16px;">
				<div data-u="prototype" class="i" style="width: 16px; height: 16px;">
					<svg viewBox="0 0 16000 16000" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
						<circle class="b" cx="8000" cy="8000" r="5800" />
					</svg>
				</div>
			</div>
			<!-- Arrow Navigator -->
			<div data-u="arrowleft" class="jssora074" style="width: 50px; height: 50px; top: 0px; left: 30px;" data-scale="0.75" data-scale-left="0.75">
				<svg viewBox="0 0 16000 16000" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
					<path class="a" d="M4037.7,8357.3l5891.8,5891.8c100.6,100.6,219.7,150.9,357.3,150.9s256.7-50.3,357.3-150.9 l1318.1-1318.1c100.6-100.6,150.9-219.7,150.9-357.3c0-137.6-50.3-256.7-150.9-357.3L7745.9,8000l4216.4-4216.4 c100.6-100.6,150.9-219.7,150.9-357.3c0-137.6-50.3-256.7-150.9-357.3l-1318.1-1318.1c-100.6-100.6-219.7-150.9-357.3-150.9 s-256.7,50.3-357.3,150.9L4037.7,7642.7c-100.6,100.6-150.9,219.7-150.9,357.3C3886.8,8137.6,3937.1,8256.7,4037.7,8357.3 L4037.7,8357.3z">
					</path>
				</svg>
			</div>
			<div data-u="arrowright" class="jssora074" style="width: 50px; height: 50px; top: 0px; right: 30px;" data-scale="0.75" data-scale-right="0.75">
				<svg viewBox="0 0 16000 16000" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
					<path class="a" d="M11962.3,8357.3l-5891.8,5891.8c-100.6,100.6-219.7,150.9-357.3,150.9s-256.7-50.3-357.3-150.9 L4037.7,12931c-100.6-100.6-150.9-219.7-150.9-357.3c0-137.6,50.3-256.7,150.9-357.3L8254.1,8000L4037.7,3783.6 c-100.6-100.6-150.9-219.7-150.9-357.3c0-137.6,50.3-256.7,150.9-357.3l1318.1-1318.1c100.6-100.6,219.7-150.9,357.3-150.9 s256.7,50.3,357.3,150.9l5891.8,5891.8c100.6,100.6,150.9,219.7,150.9,357.3C12113.2,8137.6,12062.9,8256.7,11962.3,8357.3 L11962.3,8357.3z">
					</path>
				</svg>
			</div>
		</div>
	</div>
	<div class="col-xl-1"></div>
</div>
<div class="row">
	<div class="col-xl-3"></div>
	<div class="col-xl-6">
		<div id="googleMaps" style="margin: 0.5rem 0rem; width: 100%; height: 500px;"></div>
	</div>
	<div class="col-xl-3"></div>
</div>

<script>
	$(document).ready(function() {
		$('.slider-style').css({
			'width': $($('.slider-style')[0]).parent().width() + 'px',
			'height': ($($('.slider-style')[0]).parent().width() / 4) + 'px'
		});

		var options = {
			$AutoPlay: 1,
			$BulletNavigatorOptions: {
				$Class: $JssorBulletNavigator$,
				$ChanceToShow: 2,
				$AutoCenter: 1,
				$Steps: 1,
				$Rows: 1,
				$SpacingX: 10,
				$SpacingY: 10,
				$Orientation: 1
			},
			$ArrowNavigatorOptions: {
				$Class: $JssorArrowNavigator$,
				$ChanceToShow: 2,
				$AutoCenter: 2,
				$Steps: 1
			}
		};

		var jssor_slider = new $JssorSlider$('jssor_slider', options);
		jssor_slider.$ReloadSlides(createImages());

		$(window).resize(function() {
			setTimeout(() => {
				var jssor_width = $($('.slider-style')[0]).parent().width() + 'px';

				$('.slider-style').css({
					'width': jssor_width
				});

				jssor_slider.$ScaleWidth(
					jssor_width
				);
			});
		});
	});

	function createImages() {
		var htmlSliders = '';
		var slides = <?php echo json_encode($slides) ?>;

		slides.forEach(slide => {
			htmlSliders += `
			<div>
				<a target="_blank" rel="noopener noreferrer" href="${slide.link}">
					<img data-u='image' src='/${slide.image}' alt='${slide.title}' title='${slide.title}' />
				</a>
			</div>`
		});

		return htmlSliders;
	}

	function initMap() {
		var latLng = {
			lat: <?php echo mb_split(', ', $setting->location)[0] ?>,
			lng: <?php echo mb_split(', ', $setting->location)[1] ?>
		};

		var mapsProperties = {
			center: new google.maps.LatLng(latLng.lat, latLng.lng),
			zoom: 18,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};

		var maps = new google.maps.Map(document.getElementById("googleMaps"), mapsProperties);

		var mapsMarker = new google.maps.Marker({
			position: latLng,
			map: maps
		});
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBl6lkFL7-Bat440Q8rQUcf4x3tSTth5cw&callback=initMap" async defer></script>

@endsection