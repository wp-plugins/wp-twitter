<script language="JavaScript" type="text/javascript">
function PopupCenter(pageURL, title,w,h,scrol) {
var left = (screen.width/2)-(w/2);
var top = (screen.height/2)-(h/2);
var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars='+scrol+', resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}
//reset
jQuery(document).ready(function($) {
$("#fdxReset").submit(function(event) {
var ask = confirm('<?php _e('Are you sure you want to reset all settings?', 'fdx-lang') ?>');
if (!ask) {
event.preventDefault();
return false;
}
   });
  });
</script>
<script type="text/javascript" src="<?php echo admin_url(); ?>load-scripts.php?c=0&amp;load=jquery,jquery-ui-core,jquery-ui-widget,jquery-ui-mouse,jquery-ui-sortable,postbox,post"></script>
