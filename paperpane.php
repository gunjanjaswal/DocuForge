<?php
/**
 * Plugin Name:       Paperpane - PDF Embed Viewer
 * Plugin URI:        https://github.com/gunjanjaswal/Paperpane
 * Description:       Embed a PDF on your site with a block or a shortcode. A clean, responsive, full-width inline viewer that uses the browser's own PDF reader. No external services.
 * Version:           1.2.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Gunjan Jaswal
 * Author URI:        https://www.gunjanjaswal.me
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       paperpane
 * Domain Path:       /languages
 *
 * @package Paperpane
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PAPERPANE_VERSION', '1.2.0' );
define( 'PAPERPANE_FILE', __FILE__ );
define( 'PAPERPANE_DIR', plugin_dir_path( __FILE__ ) );
define( 'PAPERPANE_URL', plugin_dir_url( __FILE__ ) );

require_once PAPERPANE_DIR . 'includes/class-paperpane.php';

Paperpane::instance();
