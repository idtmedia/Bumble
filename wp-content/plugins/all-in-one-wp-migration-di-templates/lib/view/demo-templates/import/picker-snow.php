<div id="ai1wmdi-import-modal-snow" class="ai1wmdi-modal ai1wm-not-visible">
	<div class="ai1wm-modal-action">
		<h2><?php _e( 'Import Demo Site', AI1WMDI_PLUGIN_NAME ); ?></h2>
		<p>
			<button type="button" class="ai1wm-button-red" id="ai1wmdi-import-file-cancel" v-on="click: cancel">
				<i class="ai1wm-icon-notification"></i>
				<?php _e( 'Cancel', AI1WMDI_PLUGIN_NAME ); ?>
			</button>
			<button type="button" class="ai1wmdi-import-url-snow ai1wm-button-green" id="ai1wmdi-import-url-snow" value="https://assets.designinvento.net/classiads-auth/files/classiads-snow.wpress" v-on="click: select" /><?php _e( 'Confirm', AI1WMDI_PLUGIN_NAME ); ?></button>
			<button type="button" class="ai1wm-button-green" id="ai1wmdi-import-file" v-if="selected_filename" v-on="click: import">
				<i class="ai1wm-icon-publish"></i>
				<?php _e( 'Import', AI1WMDI_PLUGIN_NAME ); ?>
			</button>
		</p>
	</div>
</div>
