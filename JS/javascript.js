var filterSetting = false;

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

	$('.filter-itemlist-job :checkbox').click(function () {
		if ($('.filter-itemlist-job :checkbox').is(':checked')) {
			$('.course-card').hide();
			$('.filter-itemlist-job :checkbox:checked').each(function() {
				coursename = $(this).val().replace(/ /g, '.');
				$('.course-card.' + coursename).show();
			})
		} else {
			$('.course-card').show();
		}
	})

	$('#journey-model-filter').click(function () {
		if (filterSetting == false) {
			$(".course-card-container .course-card").sort(sortFilterAsc).appendTo('.course-card-container');
			filterSetting = true;
			$('#journey-model-filter').text("Z - A");
		} else {
			$(".course-card-container .course-card").sort(sortFilterDesc).appendTo('.course-card-container');
			filterSetting = false;
			$('#journey-model-filter').text("A - Z");
		}
	});
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
		$('.overall-cards').filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
		})
		if ($('.overall-cards_wrapper .overall-cards:visible').length == 0) {
			$(".search-found-msg").show();
		} else {
			$(".search-found-msg").hide();
		}

		$('.course-card').filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		})

		if ($('.course-card-container .course-card:visible').length == 0) {
			$(".search-found-msg").show();
		} else {
			$(".search-found-msg").hide();
		}
	})
}

// Filter Asc function
function sortFilterAsc(a, b) {
	return ($(b).text().toUpperCase()) < ($(a).text().toUpperCase()) ? 1 : -1; 
}

// Filter Desc function
function sortFilterDesc(a, b) {
	return ($(b).text().toUpperCase()) > ($(a).text().toUpperCase()) ? 1 : -1; 
}
