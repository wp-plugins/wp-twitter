<script type="text/javascript" src="<?php echo admin_url(); ?>load-scripts.php?c=0&amp;load=jquery-ui-core,jquery-ui-widget,jquery-ui-mouse,jquery-ui-sortable,postbox,post"></script>
<script language="JavaScript" type="text/javascript">
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