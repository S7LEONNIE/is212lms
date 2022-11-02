var filterSetting = false;

var rolesTable = $('#role-table').DataTable({
	scrollX: true,
    scroller: true,
	scrollY: 500,
	responsive: true,
	pageLength: 25,
	lengthMenu: [25, 50, 75, 100],

	data: [],
	columns: [
		{ title: 'id' },
		{ title: 'Name' },
		{ title: 'Description' },
		{ title: 'Status' },
		{ title: '' } // this row is for update/delete buttons
	]
});

var skillsTable = $('#skill-table').DataTable({
	scrollX: true,
    scroller: true,
	scrollY: 500,
	responsive: true,
	pageLength: 25,
	lengthMenu: [25, 50, 75, 100],
	
	data: [],
	columns: [
		{ title: 'id' },
		{ title: 'Name' },
		{ title: 'Description' },
		{ title: 'Status' },
		{ title: '' } // this row is for update/delete buttons
	]
});

$(document).ready(function(){
	// Run our swapImages() function every 5secs
	setInterval('carouselChange()', 8000);

	$("#journey-model" ).on("click", function() { 
		$('.journey-model').toggle();
	});

	$("#journey-model_close" ).on("click", function() {
		$('.journey-model').toggle();
	});

	// refuses to work
	// $(".myjourney-edit-btn" ).on("click", function() { 
	// 	$('.journey-model-edit').toggle();
	// });

	$("#journey-model-edit_close" ).on("click", function() { 
		$('.journey-model-edit').toggle();
	});

	$("#admin-role-btn_new" ).on("click", function() { 
		$('.admin-model_header .title').text('Add Role');
		$('.admin-model.role').toggle();
	});

	// This functionality refused to work normally so I built it into vue's roleUpdateBtn function.
	// $(".admin-role-btn_update" ).on("click", function() { 
	// 	$('.admin-model_header .title').text('Update Role');
	// 	$('.admin-model.role').toggle();
	// });

	$(".admin-model_close.role" ).on("click", function() { 
		$('.admin-model.role').toggle();
	});

	$("#admin-skill-btn_new" ).on("click", function() { 
		$('.admin-model_header .title').text('Add Skill');
		$('.admin-model.skill').toggle();
	});
	
	$(".admin-skill-btn_update" ).on("click", function() { 
		$('.admin-model_header .title').text('Update Skill');
		$('.admin-model.skill').toggle();
	});

	$(".admin-model_close.skill" ).on("click", function() { 
		$('.admin-model.skill').toggle();
	});

	$(".admin-staff-btn_view" ).on("click", function() { 
		$('.admin-model_header .title').text('View Role');
		$('.admin-model.staff .action_button.action_positive').hide();
		$("input").prop('disabled', true);
		$("select").prop('disabled', true);
		$(".admin-model-select.learning-journey").prop('disabled', false);
		$('.journey-model_list').hide();
		$('.admin-model.staff').toggle();
	});

	$(".admin-staff-btn_update" ).on("click", function() { 
		$('.admin-model_header .title').text('Update Role');
		$('.admin-model.staff .action_button.action_positive').show();
		$('.journey-model_list').hide();
		$('.admin-model.staff ').toggle();
	});

	$(".admin-model_close.staff" ).on("click", function() { 
		$('.admin-model.staff').toggle();
		$("input").prop('disabled', false);
		$("select").prop('disabled', false);
	});

	$('.admin-model-select.staff').select2();

	$('.admin-model-select.learning-journey').select2();

	$('.admin-model-select.learning-journey').change(function() {
		$('.journey-model_list').show();
	})

	generalSearch();

	$('#search-filter').on("click", function() {
		$('.search-page_filter_container').toggleClass("search-filter_show");
	});

	$('.filter-itemlist-role').on("click", function () {
		console.log('e');
		if ($('.filter-itemlist-role input:checkbox').is(':checked')) {
			$('.course-card').hide();
			$('.filter-itemlist-role input:checkbox:checked').each(function() {
				coursename = $(this).val().replace(/ /g, '.');
				$('.course-card.' + coursename).show();
			})
		} else {
			$('.course-card').show();
		}
	});

	$('#journey-model-filter').on("change", function () {
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

	$('.tab-selection-wrapper button').click(function() {
		var t = $(this).attr('name');

		$('.tab-selection-wrapper button').removeClass('tab-selected')
		$(this).addClass('tab-selected');
		
		$('.tab-selection-content').hide();
		$('.tab-selection-content.' + t).fadeIn('slow');

		if (t == 'all') {
			$('.tab-selection-content').fadeIn('slow');
		}

	})

	$('#staff-table').DataTable({
		scrollX: true,
        scroller: true,
		scrollY: 500,
		responsive: true,
		pageLength: 25,
        lengthMenu: [25, 50, 75, 100],
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

function toggleSkillsModal () {
	$('.admin-model_header .title').text('Update Skill');
	$('.admin-model.skill').toggle();
}