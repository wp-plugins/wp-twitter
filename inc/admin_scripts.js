/*** Character Counter ***/
function textCounter(field, countfield, maxlimit) {
if (field.value.length > maxlimit)
field.value = field.value.substring(0, maxlimit);
else 
countfield.value = maxlimit - field.value.length;
}

/*** Reply/Retweet Buttons ***/
jQuery(document).ready(function() {

	jQuery(".reply").click(function() {
		reply_to_status = jQuery(this).parents().filter('span.status').attr('id');
		reply_to_user = jQuery('#'+reply_to_status+' a.name1').html();
		jQuery('#tweet').val('@'+reply_to_user+' ');
		jQuery('#in_reply_to_user').val(reply_to_user);
		jQuery('#in_reply_to_status').val(reply_to_status);
	});
	
	jQuery('#tweet').keyup(function(){
		var length = jQuery('#tweet').val().length;
		if (length == 0) {
			jQuery('#in_reply_to_user').val('');
			jQuery('#in_reply_to_status').val('');
		}
	});
	
		jQuery(".retweet").click(function() {
		reply_to_status = jQuery(this).parents().filter('span.status').attr('id');
		reply_to_user = jQuery('#'+reply_to_status+' a.name1').html();
		tweet = jQuery('#'+reply_to_status+' div.text').html();
		tweet = tweet.replace(/(<([^>]+)>)/ig,""); 
		jQuery('#tweet').val('RT @'+reply_to_user+' '+tweet);
	});
	
});


/*** Shorten URLs ***/
jQuery(document).ready(function() {

	jQuery("#shorten-url").click(function() {
		theurl = prompt("Enter the URL to be shortened", "http://");
		if (theurl != null && theurl != "" && theurl != "http://" && theurl != false) {
			loading = setInterval(function() {
	     		jQuery('#shorten-url').toggleClass('tw-hide');
			}, 500);
			post_to = jQuery('#post_to').val();
			datastring = 'theurl=' + theurl + '&do=shorten-url';
			jQuery.ajax({
				type: "POST",
				url: post_to,
				data: datastring,
				success: function(data) {
					jQuery('#tweet').val(jQuery('#tweet').val()+' '+data);
					clearInterval(loading);
					jQuery('#shorten-url').removeClass('tw-hide');
				}
			});
		}
	});

});



