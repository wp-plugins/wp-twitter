<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<title>Create Tiny URLs</title>
	<meta name="description" content="">
	<style type="text/css">
	body{background:#fff; font-family:verdana; font-size:11px; margin: 0;padding: 0}
	input{ font:11px tahoma, arial, helvetica, sans-serif; padding:5px; }
	</style>

	<script type="text/javascript" src="mootools.js"></script>
	<script type="text/javascript">
		window.addEvent('domready',function() {
			var TinyURL = new Class({
				//implements
				Implements: [Options],
				//options
				options: {
					checkURL: ''
				},
				//initialization
				initialize: function(options) {
					//set options
					this.setOptions(options);
				},
				//a method that does whatever you want
				createURL: function(url,complete) {
					var req = new Request({
						url: this.options.checkURL + '?url=' + url,
						method: 'get',
						async: false,
						onComplete: function(response) { complete(response); }
					}).send();
				}
			});
			
			
			// usage //
			var new_tiny_url = new TinyURL({
				checkURL: 'mootools.php'
			});
			
			$('geturl').addEvent('click',function() {
				if($('url').value) {
					var newu = new_tiny_url.createURL($('url').value,function(resp) {
						$('newurl').set('html','TinyURL:<strong> <a href="' + resp + '" target="_blank">' + resp + '</a></strong>').setStyle('color','green');
					});
				}
			});
		});
	</script>
</head><body>
<input id="url" type="text" style="width: 200px;font-size:11px;background: #FAFAD2;border: solid 1px;">
<div align="center"><input id="geturl" value="TinyURL &raquo;" type="button"></div>
<p id="newurl"></p>

	



</body></html>