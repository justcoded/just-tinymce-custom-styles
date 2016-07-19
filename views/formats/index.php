<?php
/* @var $model \jtmce\models\Formats */
/* @var $features array */

use jtmce\models\Settings;
?>
<?php include(JTMCE_ROOT . '/views/_header.php'); ?>
<br><br>

<?php if ( empty($features) ) : ?>
	<div class="updated notice error is-dismissible below-h2">
		<p><?php _e(strtr('<b>Warning</b>. Please check and save Settings before adding new style formats. <a href="{link}">Open Settings</a>.', array(
				'{link}' => get_admin_url(null, 'options-general.php?page=jtmce_settings'),
			))); ?></p>
		<button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button>
	</div>
<?php else : ?>
	<div class="jtmce_tab_content">
		<form action="<?php get_permalink(); ?>" id="jtmce_settings" method="post">
			<div class="style-formats"></div>
			<?php wp_nonce_field("just-nonce"); ?>
			<p>
				<input type="submit" class="button-primary" name="jtmce_update_settings" value="<?php _e('Save all settings'); ?>" />
			</p>
		</form>
	</div>

	<?php

	array_unshift($features, 'title');
	$features_conf = \jtmce\models\Formats::getFeaturesControls();

	$multi_field_config = array();
	foreach ($features as $feature) {
		$conf = $features_conf[$feature];
		$field = array(
			'name' => $feature,
			'placeholder' => $conf[0],
			'type' => $conf[1],
			'items' => @$conf['items'],
		);
		$multi_field_config[] = $field;
	}
	//pa($multi_field_config,1);

	?>

	<style type="text/css">
		.jcmf-multi-field .handle {
			background-color: transparent !important;
			color: #aaa;
		}
		.jcmf-multi-field .handle.sortable {
			color: #333;
		}
		.jcmf-multi-field .button {
			margin-left: 23px;
		}
	</style>
	<script type="text/javascript">
		( function( $ ) {

		  $(document).ready(function() {
			 //init plugin

			$('.style-formats').jcMultiField({
				addButton: { class: 'button' },
				removeButton: { class: 'dashicons dashicons-no-alt' },
				dragHandler: { class: 'dashicons dashicons-menu' },
				
			  fieldId: 'formats',
			  structure: <?php echo json_encode($multi_field_config) ?>,
			  data: [
				  {'title': 'my custom style'}
			  ]
			});
		  });

		}( jQuery ));
	</script>

<?php endif; ?>

<?php /*
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
					<input type="text" name="source_theme_file" id="jtmce_source_theme_file" placeholder="Ex.: editor-formats.json" value="<?php esc_attr($model->source_theme_file); ?>">
				</p>
			</div>
		</div>

		<div class="card pressthis">
			<h3 class="header"><?php _e('Features:'); ?></h3>

			<p>You can enable or disable editing of different style formats controls. Full documentation is available on <a href="https://codex.wordpress.org/TinyMCE_Custom_Styles" target="_blank">codex.wordpress.org</a></p>

			<?php foreach( \jtmce\models\Formats::getFeaturesList() as $key => $description ) : ?>

				<p>
					<input type="hidden" name="features[<?php echo $key; ?>]" value="0">
					<input type="checkbox" name="features[<?php echo $key; ?>]" id="jtmce_feature_<?php echo $key; ?>"
						   value="1" <?php checked( in_array($key,$model->features), true ); ?> >
					<label for="jtmce_feature_<?php echo $key; ?>">
						<?php echo "<b>$key</b><br>$description"; ?>
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
 */ ?>


<?php include(JTMCE_ROOT . '/views/_footer.php'); ?>
