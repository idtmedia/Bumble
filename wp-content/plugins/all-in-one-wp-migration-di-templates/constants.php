<?php
// ==================
// = Plugin Version =
// ==================
define( 'AI1WMDI_VERSION', '1.0' );

// ===============
// = Plugin Name =
// ===============
define( 'AI1WMDI_PLUGIN_NAME', 'all-in-one-wp-migration-di-templates' );

// ============
// = Lib Path =
// ============
define( 'AI1WMDI_LIB_PATH', AI1WMDI_PATH . DIRECTORY_SEPARATOR . 'lib' );

// ===================
// = Controller Path =
// ===================
define( 'AI1WMDI_CONTROLLER_PATH', AI1WMDI_LIB_PATH . DIRECTORY_SEPARATOR . 'controller' );

// ==============
// = Model Path =
// ==============
define( 'AI1WMDI_MODEL_PATH', AI1WMDI_LIB_PATH . DIRECTORY_SEPARATOR . 'model' );

// ===============
// = Import Path =
// ===============
define( 'AI1WMDI_IMPORT_PATH', AI1WMDI_MODEL_PATH . DIRECTORY_SEPARATOR . 'import' );

// =============
// = View Path =
// =============
define( 'AI1WMDI_TEMPLATES_PATH', AI1WMDI_LIB_PATH . DIRECTORY_SEPARATOR . 'view' );

// ===============
// = Vendor Path =
// ===============
define( 'AI1WMDI_VENDOR_PATH', AI1WMDI_LIB_PATH . DIRECTORY_SEPARATOR . 'vendor' );

// ===================
// = File Chunk Size =
// ===================
define( 'AI1WMDI_FILE_CHUNK_SIZE', 5 * 1024 * 1024 );

// =================
// = Max File Size =
// =================
define( 'AI1WMDI_MAX_FILE_SIZE', 0 );

// ===============
// = Purchase ID =
// ===============

define( 'AI1WMDI_PURCHASE_ID', '' );
define('AI1WMDI_URL_DEMO', AI1WMDI_URL.'/lib/view');
require_once AI1WMDI_TEMPLATES_PATH."/demo-templates/install-template.php";
