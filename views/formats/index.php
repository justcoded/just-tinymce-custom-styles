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
			  data: <?php echo json_encode( $model->formats ); ?>
			});
		  });

		}( jQuery ));
	</script>

<?php endif; ?>

<?php include(JTMCE_ROOT . '/views/_footer.php'); ?>
