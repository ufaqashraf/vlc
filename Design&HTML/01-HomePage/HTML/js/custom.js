$(document).ready(function(){
	
	'use strict';

 //Bootstrap Select JS Plugin
 $('.selectpicker').selectpicker();
 
  //Tabs remove Jquery
 $(".closeTab").click(function(){
  $(".tabsHolder .tab-content .tab-pane").removeClass("active show");
  $(".tabsHolder .nav .nav-link").removeClass("show active");
});
 

});


