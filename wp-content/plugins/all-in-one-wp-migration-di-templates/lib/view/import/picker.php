<?php
/**
 * Copyright (C) 2014-2018 ServMask Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * ███████╗███████╗██████╗ ██╗   ██╗███╗   ███╗ █████╗ ███████╗██╗  ██╗
 * ██╔════╝██╔════╝██╔══██╗██║   ██║████╗ ████║██╔══██╗██╔════╝██║ ██╔╝
 * ███████╗█████╗  ██████╔╝██║   ██║██╔████╔██║███████║███████╗█████╔╝
 * ╚════██║██╔══╝  ██╔══██╗╚██╗ ██╔╝██║╚██╔╝██║██╔══██║╚════██║██╔═██╗
 * ███████║███████╗██║  ██║ ╚████╔╝ ██║ ╚═╝ ██║██║  ██║███████║██║  ██╗
 * ╚══════╝╚══════╝╚═╝  ╚═╝  ╚═══╝  ╚═╝     ╚═╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝
 */
?>

<div id="ai1wmdi-import-modal" class="ai1wmdi-modal ai1wm-not-visible">
	<div class="ai1wm-modal-action">
		<h2><?php _e( 'Import from URL', AI1WMDI_PLUGIN_NAME ); ?></h2>
		<p>
			<label for="ai1wmdi-import-url">
				<?php _e( 'URL address', AI1WMDI_PLUGIN_NAME ); ?>
				<br />
				<input type="text" class="ai1wmdi-import-url" id="ai1wmdi-import-url" v-on="keyup: select" placeholder="<?php _e( 'Enter URL to WPRESS file', AI1WMDI_PLUGIN_NAME ); ?>" />
			</label>
		</p>
		<p>
			<span id="ai1wmdi-download-file" class="ai1wmdi-selected-file" v-if="selected_filename" v-animation>
				<i class="ai1wm-icon-file-zip"></i>
				{{selected_filename}}
			</span>
		</p>
		<p>
			<button type="button" class="ai1wm-button-red" id="ai1wmdi-import-file-cancel" v-on="click: cancel">
				<i class="ai1wm-icon-notification"></i>
				<?php _e( 'Cancel', AI1WMDI_PLUGIN_NAME ); ?>
			</button>
			<button type="button" class="ai1wm-button-green" id="ai1wmdi-import-file" v-if="selected_filename" v-on="click: import">
				<i class="ai1wm-icon-publish"></i>
				<?php _e( 'Import', AI1WMDI_PLUGIN_NAME ); ?>
			</button>
		</p>
	</div>
</div>
