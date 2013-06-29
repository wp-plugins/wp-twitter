/* popup normal para share
-------------------------------------------------------------- */
function PopupCenter(pageURL, title,w,h,scrol) {
var left = (screen.width/2)-(w/2);
var top = (screen.height/2)-(h/2);
var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars='+scrol+', resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}

/* alert
-------------------------------------------------------------- */
jQuery(document).ready(function($) {  
$("#cl").click(function(){
alert("fabrix@fabrix.net");
});
});

/* Select
-------------------------------------------------------------- */
jQuery( document ).ready( function() {
	jQuery( '#url_shortener' ).live( 'change', function() {
		var currentValue = jQuery( this ).val();
 		jQuery( '#select1, #select2' ).hide();
		if ( currentValue == 'yourls' ) {
			jQuery( '#select1' ).slideDown();
		  		} else if ( currentValue == 'bitly' ) {
		   	jQuery( '#select2' ).slideDown();
		}
	}).change();

 });

/* Tabs
-------------------------------------------------------------- */
jQuery(document).ready(function($){
	//Default Action
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content

	//On Click Event
	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content
		var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active content
		return false;
	});

});

