$(document).ready(function(){
	
	'use strict';

 //Bootstrap Select JS Plugin
 $('.selectpicker').selectpicker();
 
  //Tabs remove Jquery
 $(".closeTab").click(function(){
  $(".tabsHolder .tab-content .tab-pane").removeClass("active show");
  $(".tabsHolder .nav .nav-link").removeClass("show active");
});
 
// Save Search Added
$(".saveSearch > li > a").click(function(){
  $(".saveSearch").toggleClass("searchAdded");
});

// Close Tag Jquery
$(".fa-times").click(function(event) {
  event.preventDefault();
  $(this).parents('li').remove();
});

// Show More Category 
$(".showMore").click(function(){
  $(this).parent().parent().parent(".categoryHolderMain").addClass("showMoreCat");
});

// Show Less Category 
$(".showLess").click(function(){
  $(this).parent().parent().parent(".categoryHolderMain").removeClass("showMoreCat");
});

// Show More Filters in Search 
$(".showMoreLink").click(function(){
  $(this).parent().parent(".checkboxHolder").addClass("showMoreCat");
});

// Show More Filters in Search  
$(".showLessLink").click(function(){
  $(this).parent().parent(".checkboxHolder").removeClass("showMoreCat");
});


// Advance Search Filters add more 
$(".advSearchMore").click(function(){
  $(this).parent(".searchTitle").addClass("advSearchMoreHolder");
});

// Advance Search Filters minus
$(".advSearchLess").click(function(){
  $(this).parent(".searchTitle").removeClass("advSearchMoreHolder");
});


// Custom Range Jquery
$( function() {
  $( ".slider-range" ).slider({
    range: true,
    min: 0,
    max: 50000,
    values: [ 10000, 40000 ],
    slide: function( event, ui ) {
      // $( ".amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      $( ".amount1" ).val( "$" + ui.values[ 0 ] );
      $( ".amount2" ).val( "$" + ui.values[ 1 ] );
    }
  });
//  $(".amount" ).val( "$" + $( ".slider-range" ).slider( "values", 0 ) + " - $" + $( ".slider-range" ).slider( "values", 1 ) );
 $(".amount1" ).val( "$" + $( ".slider-range" ).slider( "values", 0 ) );
 $(".amount2" ).val( "$" + $( ".slider-range" ).slider( "values", 1 ) );
} );

// Custom Range Jquery
$( function() {
  $( ".slider-range-date" ).slider({
    range: true,
    min: 1990,
    max: 2019,
    values: [ 2000, 2015 ],
    slide: function( event, ui ) {
      // $( ".amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      $( ".amount3" ).val( ui.values[ 0 ] );
      $( ".amount4" ).val( ui.values[ 1 ] );
    }
  });
//  $(".amount" ).val( "$" + $( ".slider-range" ).slider( "values", 0 ) + " - $" + $( ".slider-range" ).slider( "values", 1 ) );
 $(".amount3" ).val( $( ".slider-range-date" ).slider( "values", 0 ) );
 $(".amount4" ).val( $( ".slider-range-date" ).slider( "values", 1 ) );
} );


// Custom Range Jquery
$( function() {
  $( ".slider-range-kilometer" ).slider({
    range: true,
    min: 0,
    max: 50000,
    values: [ 10000, 40000 ],
    slide: function( event, ui ) {
      // $( ".amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      $( ".amount5" ).val( ui.values[ 0 ] );
      $( ".amount6" ).val( ui.values[ 1 ] );
    }
  });
//  $(".amount" ).val( "$" + $( ".slider-range" ).slider( "values", 0 ) + " - $" + $( ".slider-range" ).slider( "values", 1 ) );
 $(".amount5" ).val( $( ".slider-range-kilometer" ).slider( "values", 0 ) );
 $(".amount6" ).val( $( ".slider-range-kilometer" ).slider( "values", 1 ) );
} );

//********************** gmd start from here ************************************************

 $('.count').prop('disabled', true);
   			$(document).on('click','.plus',function(){
				$('.count').val(parseInt($('.count').val()) + 1 );
    		});
        	$(document).on('click','.minus',function(){
    			$('.count').val(parseInt($('.count').val()) - 1 );
    				if ($('.count').val() == 0) {
						$('.count').val(1);
					}
   });
   
   $('.count2').prop('disabled', true);
   			$(document).on('click','.plus2',function(){
				$('.count2').val(parseInt($('.count2').val()) + 1 );
    		});
        	$(document).on('click','.minus2',function(){
    			$('.count2').val(parseInt($('.count2').val()) - 1 );
    				if ($('.count2').val() == 0) {
						$('.count2').val(1);
					}
    });


$('#advnce-ser').click(function(){
	
  // $('#togle').toggleClass('hide-section', 777);
  //$('#togle').addClass( "hide-section" ).slideToggle('slow');
   
  var icon = $(this).find("i");
  icon.toggleClass("fa-plus-circle fa-minus-circle");
})



// ************************ end here ***************************

});


