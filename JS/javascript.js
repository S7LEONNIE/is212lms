$(document).ready(function(){
	// Run our swapImages() function every 5secs
	setInterval('carouselChange()', 8000);

	$("#journey-model" ).on("click", function() { 
		$('.journey-model').toggle();
	});

	$("#journey-model_close" ).on("click", function() { 
		$('.journey-model').toggle();
	});

	generalSearch();

	$('#search-filter').on("click", function() {
		$('.search-page_filter_container').toggleClass("search-filter_show");
	})

	$('.filter-itemlist :checkbox').click(function () {
		if ($('.filter-itemlist :checkbox').is(':checked')) {
			$('.course-card').hide();
			$('.filter-itemlist :checkbox:checked').each(function() {
				coursename = $(this).val().replace(/ /g, '.');
				$('.course-card.' + coursename).show();
			})
		} else {
			$('.course-card').show();
		}
	})
});

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

function generalSearch() {
	$('#general_search').on('keyup', function() {
		var value = $(this).val().toLowerCase();
		$('.filter-itemlist :checkbox').prop('checked', false);
		console.log(value);
		$('.overall-cards').filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		})

		$('.course-card').filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		})
	})
}
