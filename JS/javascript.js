
$(document).ready(function(){
	// Run our swapImages() function every 5secs
	setInterval('carouselChange()', 8000);
  })


function classToggle() {
	const navs = document.querySelectorAll('.Navbar__Items')

	navs.forEach(nav => nav.classList.toggle('Navbar__ToggleShow'));
}


function carouselChange() {
	var $active = $('.carousel .carousel-shown');
	var $next = ($('.carousel .carousel-shown').next().length > 0) ? $('.carousel .carousel-shown').next() : $('.carousel li:first');
	
	$active.fadeOut(function(){
		$active.removeClass('carousel-shown');
		$next.fadeIn().addClass('carousel-shown');
	});
}
