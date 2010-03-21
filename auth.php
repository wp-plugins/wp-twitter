<?php include('inc/functions.php'); ?>
function closebox() {
    document.body.removeChild(document.getElementById('twitterframe'));
    document.body.removeChild(document.getElementById('closebutton'));
	opened = false;
}

if (opened != true) {
	var opened = true;
	
    var panel = document.createElement("iframe");
    panel.width = "417";
    panel.height = "100%";
    panel.id = "twitterframe";
    panel.name = "twitterframe";
    panel.src = "<?php bloginfo('wpurl') ?>/wp-content/plugins/wp-twitter/timeline.php";
    panel.style.cssText = "background: #94E4E8 url('<?php bloginfo('wpurl') ?>/wp-content/plugins/wp-twitter/inc/ajax-loader.gif') no-repeat 12px 12px; position: fixed; opacity: 0.95; top: 0px; left: 0px; z-index: 999998;";
    panel.setAttribute("frameborder", "no");
    panel.frameBorder = "no";

    var newDiv = document.createElement("div");
    newDiv.id = "closebutton";
	newDiv.style.cssText = "position: fixed; bottom: 0px; left: 375px; z-index: 999999;";
    newDiv.innerHTML = '<a href="#" onclick="closebox(); return false" title="<?php _e('Close / Esc Key', 'wp-twitter') ?>"><img  src="<?php bloginfo('wpurl') ?>/wp-content/plugins/wp-twitter/inc/close.png" alt="close" width="24" height="24" border="0"></a>';

    function removeBox(e) {
        var keycode;
        if (window.event) {
            keycode = window.event.keyCode;
        }
        else if (e) {
            keycode = e.which;
        }
        if (keycode == 27) {
            closebox();
        }
    }

    document.body.appendChild(panel);
    document.body.appendChild(newDiv);
    document.onkeydown = removeBox;
}
else {
    closebox();
}
