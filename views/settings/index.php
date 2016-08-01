<?php
/* @var $model Settings */

use jtmce\models\Settings;
?>
<?php include(JTMCE_ROOT . '/views/_header.php'); ?>

<div class="jtmce_tab_content">
	<form action="<?php get_permalink(); ?>" id="jtmce_settings" method="post">

		<div class="card pressthis">
			<h3 class="header"><?php _e('Settings storage configuration:'); ?></h3>

			<p>
				<input type="radio" name="source" id="jtmce_read_db"
					   value="<?php echo Settings::CONF_SOURCE_DB; ?>" <?php  checked($model->source, Settings::CONF_SOURCE_DB); ?>/>
				<label for="jtmce_read_db"><?php _e('<b>Database</b>. All settings will be stored in wp_options table.'); ?></label>
			</p>

			<p>
				<input type="radio" name="source" id="jtmce_read_file"
					   value="<?php echo Settings::CONF_SOURCE_THEME; ?>" <?php checked($model->source, Settings::CONF_SOURCE_THEME); ?>/>
				<label for="jtmce_read_file">
					<?php _e('<b>Active theme</b>. All settings will be stored inside the active theme with .json file.'); ?>
				</label>
			</p>

			<div class="jtmce_source_theme_wrapper">
				<p>
					<label for="jtmce_source_theme_file"><?php _e('Theme relative file path'); ?></label><br>
					<input type="text" name="source_theme_file" id="jtmce_source_theme_file" placeholder="Ex.: editor-formats.json" value="<?php echo esc_attr($model->source_theme_file); ?>">
				</p>
			</div>
		</div>

		<div class="card pressthis">
			<h3 class="header"><?php _e('Features:'); ?></h3>

			<p>You can enable or disable editing of different style formats controls. Full documentation is available on <a href="https://codex.wordpress.org/TinyMCE_Custom_Styles" target="_blank">codex.wordpress.org</a></p>

			<input type="hidden" name="features" value="">
			<?php foreach( \jtmce\models\Formats::getFeaturesList() as $key => $description ) : ?>

				<p>
					<input type="checkbox" name="features[]" id="jtmce_feature_<?php echo $key; ?>"
						   value="<?php echo $key; ?>" <?php checked( in_array($key, (array)$model->features), true ); ?> >
					<label for="jtmce_feature_<?php echo $key; ?>">
						<?php echo "<b>$key</b><br>" . nl2br(esc_html($description)); ?>
					</label>
				</p>

			<?php endforeach; ?>

			<p class="howto"><?php _e("<b>Note:</b> The visual editor's behavior when using custom styles, especially inline/block features, can be surprising and seemingly random. Please test carefully how the buttons work with your configuration and ensure your users understand what to expect."); ?></p>
		</div>

		<?php wp_nonce_field("just-nonce"); ?>
		<p>
			<input type="submit" class="button-primary" name="jtmce_update_settings" value="<?php _e('Save all settings'); ?>" />
		</p>
	</form>
</div>

<?php include(JTMCE_ROOT . '/views/_footer.php'); ?>

<style type="text/css">
	.jtmce_tab_content .card {
		max-width: none;
	}
</style>
<script type="text/javascript">
	( function( $ ) {

		$(document).ready(function() {
			$('#jtmce_settings input[name=source]').click(function(){

				$('div.jtmce_source_theme_wrapper').hide();
				if ( $(this).val() == '<?php echo Settings::CONF_SOURCE_THEME; ?>' ) {
					$('div.jtmce_source_theme_wrapper').show();
				}
			})
			$('#jtmce_settings input[name=source]:checked').click();
		})

	}( jQuery ));
</script>