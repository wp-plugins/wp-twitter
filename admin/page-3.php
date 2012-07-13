<div class="wrap">
<div id="icon-edit" class="icon32 icon32-posts-post"><br /></div><h2><?php echo FDX_PLUGIN_N1;?>: <?php _e('Page Title', 'fdx-lang') ?></h2>
<!-- ********************************************************************************************************* -->
<?php echo '<div class="error fade"><p><strong>' . __( 'Error', 'fdx-lang' ) . '.</strong></p></div>';?>

<?php
if ( ( isset( $_GET['updated'] ) && $_GET['updated'] == 'true' ) || ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == 'true' ) ) {
echo '<div class="updated fade"><p><strong>' . __( 'Settings updated', 'fdx-lang' ) . '.</strong></p></div>';
}
?>
<!-- ********************************************************************************************************* -->
<div id="poststuff">
<div id="post-body" class="metabox-holder columns-2">

<?php include('inc/sidebar.php'); ?>

<div class="postbox-container">
<div class="meta-box-sortables">
<form action="options.php" method="post">

<div class="postbox">
<div class="handlediv" title="<?php _e('Click to toggle', 'fdx-lang') ?>"><br /></div><h3 class='hndle'><span><?php _e('Content head 1', 'fdx-lang') ?></span></h3>
<div class="inside">
<!-- ############################################################################################################### -->
<select name='post_author_override'>
	<option value='6' selected='selected'>Fabrix</option>
	<option value='3'>Fallcom</option>
	<option value='7'>Frederico Dourado</option>
	<option value='4'>Leandro Ribeiro</option>
</select>
<!-- ############################################################################################################### -->  
</div>
</div>


<div class="postbox closed">
<div class="handlediv" title="<?php _e('Click to toggle', 'fdx-lang') ?>"><br /></div><h3 class='hndle'><span><?php _e('Content head 2', 'fdx-lang') ?></span></h3>
<div class="inside">
<!-- ############################################################################################################### -->
<p><?php _e('Content head 3Ham hock cow tri-tip, excepteur dolore shoulder occaecat. Biltong tempor consectetur,
ex hamburger t-bone voluptate ut tongue culpa shank andouille. In eiusmod tempor prosciutto irure.
Dolor ribeye brisket, ea aute enim meatloaf magna commodo exercitation pork loin swine quis ad.
Nulla sausage short ribs, bresaola aute magna meatloaf consectetur shank andouille turkey veniam
cillum commodo anim. In short ribs leberkas ut sunt, ball tip fatback commodo cillum andouille t.', 'fdx-lang') ?></p>
<!-- ############################################################################################################### -->
</div>
</div>

<div class="postbox closed" >
<div class="handlediv" title="<?php _e('Click to toggle', 'fdx-lang') ?>"><br /></div><h3 class='hndle'><span><?php _e('Content head 3', 'fdx-lang') ?></span></h3>
<div class="inside">
<!-- ############################################################################################################### -->
<p><?php _e('Content head 3Ham hock cow tri-tip, excepteur dolore shoulder occaecat. Biltong tempor consectetur,
ex hamburger t-bone voluptate ut tongue culpa shank andouille. In eiusmod tempor prosciutto irure.
Dolor ribeye brisket, ea aute enim meatloaf magna commodo exercitation pork loin swine quis ad.
Nulla sausage short ribs, bresaola aute magna meatloaf consectetur shank andouille turkey veniam
cillum commodo anim. In short ribs leberkas ut sunt, ball tip fatback commodo cillum andouille t.', 'fdx-lang') ?></p>
<!-- ############################################################################################################### -->
</div>
</div>

<div class="postbox closed">
<div class="handlediv" title="<?php _e('Click to toggle', 'fdx-lang') ?>"><br /></div><h3 class='hndle'><span><?php _e('Content head 4', 'fdx-lang') ?></span></h3>
<div class="inside">
<!-- ############################################################################################################### -->
<p><?php _e('Content head 3Ham hock cow tri-tip, excepteur dolore shoulder occaecat. Biltong tempor consectetur,
ex hamburger t-bone voluptate ut tongue culpa shank andouille. In eiusmod tempor prosciutto irure.
Dolor ribeye brisket, ea aute enim meatloaf magna commodo exercitation pork loin swine quis ad.
Nulla sausage short ribs, bresaola aute magna meatloaf consectetur shank andouille turkey veniam
cillum commodo anim. In short ribs leberkas ut sunt, ball tip fatback commodo cillum andouille t.', 'fdx-lang') ?></p>
<!-- ############################################################################################################### -->
</div>
</div>


<div align="center"><input name="Submit" class="button-primary"  type="submit" value="<?php _e('Save All Options', 'fdx-lang') ?>" /></div>
</form>
</div> <!-- /postbox-container -->
</div><!-- /meta-box-sortables -->



</div><!-- /post-body -->
</div><!-- /poststuff -->


</div><!-- /wrap -->
<?php include('inc/footer_js.php'); ?>
<!-- carregar javascript especifico aqui -->
<div class="clear"></div>