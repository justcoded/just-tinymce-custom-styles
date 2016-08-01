<?php
/* @var $model Preset */

use jtmce\models\Preset;
?>
<?php include(JTMCE_ROOT . '/views/_header.php'); ?>

<div class="jtmce_tab_content">

	<p>On this page you can import pre-defined popular presets. <br>
		If you don't check "Overwrite" option they will be merged with already existed rules.</p>
	
	<div class="card pressthis">
		<form action="<?php get_permalink(); ?>" id="jtmce_settings" method="post">
			<h3 class="header"><?php _e('Bootstrap'); ?></h3>
	
			<p>
				Preset for Bootstrap CSS framework. If your theme is based on this framework, than this is a must have option!<br>
				You can add different button classes, text colors, alert etc. However this preset has very basic elements, because complex structures is not recommended to be added inside editor by WordPress.
			</p>
			<p>For more information about bootstrap you can read here: <a href="http://getbootstrap.com/css/" target="_blank">http://getbootstrap.com/css/</a></p>
			<p>
				<input type="hidden" name="overwrite" value="0">
				<input type="checkbox" name="overwrite" id="overwrite_bootstrap" value="1" >
				<label for="overwrite_bootstrap"><?php _e('Overwrite'); ?></label>
			</p>
	
			<?php wp_nonce_field("just-nonce"); ?>
			<p>
				<input type="hidden" name="preset_file" value="bootstrap.json">
				<input type="submit" class="button-primary" name="jtmce_import" value="<?php _e('Import'); ?>" />
			</p>

		</form>
	</div>

</div>

<?php include(JTMCE_ROOT . '/views/_footer.php'); ?>
