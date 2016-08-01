<?php
/* @var $model \jtmce\models\Formats */
/* @var $features array */

use jtmce\models\Settings;
use jtmce\models\Formats;
?>
<?php include(JTMCE_ROOT . '/views/_header.php'); ?>

<?php if ( empty($features) ) : ?>
	<br><br>
	<div class="updated notice error is-dismissible below-h2">
		<p><?php _e(strtr('<b>Warning</b>. Please check and save Settings before adding new style formats. <a href="{link}">Open Settings</a>.', array(
				'{link}' => get_admin_url(null, 'options-general.php?page=jtmce_settings'),
			))); ?></p>
		<button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button>
	</div>
<?php else : ?>
	<div class="jtmce_tab_content">
		<p><a class="jtmce_help" href="#">Help <span class="dashicons dashicons-editor-help"></span></a></p>
		<div class="jtmce_help_box howto hidden">
			<p>This plugin controls TinyMce "style_formats" parameter. It allows to add custom formatters to the Wysiwyg editor.</p>
			<p>This is only user interface to the standard feature, which is disabled by default and explained in official documentation on <a href="https://codex.wordpress.org/TinyMCE_Custom_Styles" target="_blank">codex.wordpress.org</a></p>
			<h3>Options details</h3>
			<?php
			$features_info = $features_conf = Formats::getFeaturesList();
			foreach ($features as $feature) : ?>
				<p><strong><?php echo $feature; ?></strong><br>
					<?php echo esc_html($features_info[$feature]); ?>
				</p>
			<?php endforeach; ?>
			<a href="#" class="jtmce_help"><span class="dashicons dashicons-arrow-up"></span> Collapse</a>
		</div>

		<form action="<?php get_permalink(); ?>" id="jtmce_settings" method="post">
			<div class="style-formats"></div>
			<?php wp_nonce_field("just-nonce"); ?>
			<p>
				<input type="submit" class="button-primary" name="jtmce_update_settings" value="<?php _e('Save all settings'); ?>" />
			</p>
		</form>
	</div>

	<?php
	// prepare script data
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
	?>
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
			  data: <?php echo json_encode( $model->formats ); ?>
			});
			// init help
			$('a.jtmce_help').click(function(e){
				e.preventDefault();
				$('.jtmce_help_box').toggleClass('hidden');
			})

			// init type "group"
			$(document).on('change', 'select[name$="type]"]', function(){
				var val = $(this).val();
				var row = $(this).parents('.jcmf-form-item');
				if ( val == "<?php echo Formats::TYPE_GROUP; ?>" ) {
					row.find('.jcmf-input').slice(2).hide();
				}
				else {
					row.find('.jcmf-input').slice(2).show();
				}
			})
			$('select[name$="type]"]').change();
		  });

		}( jQuery ));
	</script>
	<style type="text/css">
		.jcmf-multi-field .handle { background-color: transparent !important; color: #aaa; }
		.jcmf-multi-field .handle.sortable { color: #333; }
		.jcmf-multi-field .button { margin-left: 23px; }
		.jtmce_help .dashicons{ text-decoration: none !important; }
		.jtmce_help_box { max-width: 800px; padding: 0 0 30px; }
		.jtmce_help_box.hidden { display: none;}
	</style>

<?php endif; ?>

<?php include(JTMCE_ROOT . '/views/_footer.php'); ?>
