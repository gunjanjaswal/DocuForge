<?php
/**
 * Plugin Name:       Embedwell PDF Embed Viewer
 * Plugin URI:        https://github.com/gunjanjaswal/Embedwell
 * Description:       Embed a PDF on your site with a block or a shortcode. A clean, responsive, full-width inline viewer that uses the browser's own PDF reader. No external services.
 * Version:           1.3.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Gunjan Jaswal
 * Author URI:        https://www.gunjanjaswal.me
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       embedwell
 * Domain Path:       /languages
 *
 * @package Embedwell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'EMBEDWELL_VERSION', '1.3.0' );
define( 'EMBEDWELL_FILE', __FILE__ );
define( 'EMBEDWELL_DIR', plugin_dir_path( __FILE__ ) );
define( 'EMBEDWELL_URL', plugin_dir_url( __FILE__ ) );

require_once EMBEDWELL_DIR . 'includes/class-embedwell.php';

Embedwell::instance();
