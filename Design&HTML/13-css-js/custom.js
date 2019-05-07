$(document).ready(function () {

	'use strict';
	
	
//	var j = jQuery.noConflict();
	$("input[type=checkbox]").parent().closest( ".col-sm-6" ).addClass("col-sm-12");

	//Bootstrap Select JS Plugin
	$('.selectpicker').selectpicker();

	//

	// gm code here
	$("#nav-tab a").click(function () {
		$(".main-Box").addClass("hideForce");

		$(".tabsHolder .tab-content").addClass("setB");
	});
	// end gm here

	//Tabs remove Jquery
	$(".closeTab").click(function () {
		$(".tabsHolder .tab-content .tab-pane").removeClass("active show");
		$(".tabsHolder .nav .nav-link").removeClass("show active");
		$(".main-Box").removeClass("hideForce");
		$(".tabsHolder .tab-content").removeClass("setB");
	});



	// Save Search Added
	$(".saveSearch > li > a").click(function () {
		$(".saveSearch").toggleClass("searchAdded");
	});

	// Close Tag Jquery
	$(".faClose-icon").click(function (event) {
		event.preventDefault();
		$(this).parents('li').remove();
	});

	// Show More Category
	////$(".showMore").click(function () {
	//	$(this).parent().parent().parent(".categoryHolderMain").addClass("showMoreCat");
	//});

	// Show Less Category
	//$(".showLess").click(function () {
	//	$(this).parent().parent().parent(".categoryHolderMain").removeClass("showMoreCat");
	//});

	// Show More Filters in Search
	$(".showMoreLink").click(function () {
		$(this).parent().parent(".checkboxHolder").addClass("showMoreCat");
	});

	// Show More Filters in Search
	$(".showLessLink").click(function () {
		$(this).parent().parent(".checkboxHolder").removeClass("showMoreCat");
	});


	// Advance Search Filters add more
	$(".advSearchMore").click(function () {
		$(this).parent(".searchTitle").addClass("advSearchMoreHolder");
	});

	// Advance Search Filters minus
	$(".advSearchLess").click(function () {
		$(this).parent(".searchTitle").removeClass("advSearchMoreHolder");
	});


	// waqas

	// Show More Category
	$(".sh").click(function () {
		$(this).parent().parent(".abcMain").addClass("showMoreCat").removeClass("grey");
	});
	// Show Less Category
	$(".sho").click(function () {
		//$(".abcMain").removeClass("showMoreCat");

		$(this).parent().parent(".abcMain").removeClass("showMoreCat").addClass("grey");
	});




	// Custom Range Jquery
	if (jQuery('.slider-range').length > 0) {


		jQuery('.slider-range').slider({
			range: true,
			min: 0,
			max: 50000,
			values: [10000, 40000],
			create: function () {
				var val = "$10,000";
				var val2 = "$40,000";
				// console.log(val);
				jQuery(".amount1").text(val);
				jQuery(".amount2").text(val2);
			},
			slide: function (event, ui) {
				var val = "$" + ui.values[0].toLocaleString('us-US');
				var val2 = "$" + ui.values[1].toLocaleString('us-US');
				// console.log(val);


				jQuery(".amount1").text(val);
				jQuery(".amount2").text(val2);
				var mi = ui.values[0];
				var mx = ui.values[1];
				filterSystem(mi, mx);
			}
		});
	}



	function filterSystem(minPrice, maxPrice) {
		jQuery("li.column").hide().filter(function () {
			var price = parseInt(jQuery(this).data("price"), 10);
			return price >= minPrice && price <= maxPrice;
		}).show();
	}

	// Custom Range Jquery
	if (jQuery('.slider-range2').length > 0) {
		jQuery('.slider-range2').slider({
			range: true,
			min: 0,
			max: 50000,
			values: [10000, 40000],
			create: function () {
				var val3 = "11,00";
				var val4 = "40,000";
				// console.log(val);
				jQuery(".amount5").text(val3);
				jQuery(".amount6").text(val4);
			},
			slide: function (event, ui) {
				var val3 = "" + ui.values[0].toLocaleString('us-US');
				var val4 = "" + ui.values[1].toLocaleString('us-US');
				// console.log(val);


				jQuery(".amount5").text(val3);
				jQuery(".amount6").text(val4);
				var mi = ui.values[0];
				var mx = ui.values[1];
				filterSystem(mi, mx);
			}
		})

	}

	function filterSystem(minPrice, maxPrice) {
		jQuery("li.column").hide().filter(function () {
			var price = parseInt(jQuery(this).data("price"), 10);
			return price >= minPrice && price <= maxPrice;
		}).show();
	}



	// Custom Range Jquery
	$(function () {

		if (jQuery('.slider-range-date').length > 0) {
			$(".slider-range-date").slider({
				range: true,
				min: 1990,
				max: 2019,
				values: [2000, 2015],
				slide: function (event, ui) {
					// $( ".amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
					$(".amount3").val(ui.values[0]);
					$(".amount4").val(ui.values[1]);
				}
			});
			//  $(".amount" ).val( "$" + $( ".slider-range" ).slider( "values", 0 ) + " - $" + $( ".slider-range" ).slider( "values", 1 ) );
			$(".amount3").val($(".slider-range-date").slider("values", 0));
			$(".amount4").val($(".slider-range-date").slider("values", 1));
		}
	});



	//********************** gmd start from here ************************************************

	$('.count').prop('disabled', true);
	$(document).on('click', '.plus', function () {
		$('.count').val(parseInt($('.count').val()) + 1);
	});
	$(document).on('click', '.minus', function () {
		$('.count').val(parseInt($('.count').val()) - 1);
		if ($('.count').val() == 0) {
			$('.count').val(1);
		}
	});

	$('.count2').prop('disabled', true);
	$(document).on('click', '.plus2', function () {
		$('.count2').val(parseInt($('.count2').val()) + 1);
	});
	$(document).on('click', '.minus2', function () {
		$('.count2').val(parseInt($('.count2').val()) - 1);
		if ($('.count2').val() == 0) {
			$('.count2').val(1);
		}
	});


	$('#advnce-ser').click(function () {

		// $('#togle').toggleClass('hide-section', 777);
		//$('#togle').addClass( "hide-section" ).slideToggle('slow');

		var icon = $(this).find("i");
		icon.toggleClass("fa-plus-circle fa-minus-circle");
	})



	// ************************ end here ***************************
	var window_w = $(window).innerWidth();


	$(window).on('load', function () {
		/*------------------
          Preloder
        --------------------*/
		if (jQuery('.loader').length > 0) {
			$(".loader").fadeOut();
			$("#preloder").delay(500).fadeOut("slow");
		}
		//__portfolio(); // call portfolio function

	});


	// ***** car-detail page flexslider js function start ******

	$(window).load(function(){
		$('#carousel').flexslider({
			animation: "slide",
			controlNav: false,
			animationLoop: false,
			slideshow: false,
			itemWidth: 95,
			itemMargin:7,
			asNavFor: '#slider'
		});

		$('#slider').flexslider({
			animation: "slide",
			controlNav: false,
			animationLoop: false,
			slideshow: false,
			sync: "#carousel",
			start: function(slider){
				$('body').removeClass('loading');
			}
		});
	});

	// ****** car-detail page flexslider js function end *******
 

	// ****** privacy policy page js function end *******

	
		$('.prv-points li a').on('click', function (e) {
			e.preventDefault();

			$('html, body').animate({
				scrollTop: $($(this).attr('href')).offset().top
			}, 500, 'linear');
		});

	// ****** privacy policy js function end *******

 
	//removes the "active" class to .popup and .popup-content when the "Close" button is clicked
	$(".btn_close").on("click", function(){
		$(".popup-overlay, .popup-content").removeClass("active");


	});
	
	
	//$("#dynamic-header-form input[type=checkbox]").parent().closest( ".col-sm-6" ).addClass("col-sm-12")
	if ( $('.holder ul.categoryHolder.list-unstyled').length > 0) {
// manage show more btn by gmd	
	 var text = $('.holder ul.categoryHolder.list-unstyled') ,
     btn = $('.showMore'); 
	// var h = document.getElementById('categoryHoldermlist');
	 //alert(h.offsetHeight);
	var h = text[0].scrollHeight; 
	//var h= text[0].height();
		//var h= $(".holder ul.categoryHolder.list-unstyled").$( document ).height();
if(h > 87) {
	btn.addClass('less');
	btn.css('display', 'block');
}

btn.click(function(e) 
{
  e.stopPropagation();

  if (btn.hasClass('less')) {
      btn.removeClass('less');
      btn.addClass('more');
      btn.text('Show Less ˄');

      text.animate({'height': h});
  } else {
      btn.addClass('less');
      btn.removeClass('more');
      btn.text('Show More ˅');
      text.animate({'height': '87px'});
  }  
});

// end showmore	
	}
});


