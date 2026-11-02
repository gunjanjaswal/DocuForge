<?php
/**
 * Plugin Name:       DocuForge — PDF Viewer
 * Plugin URI:        https://github.com/gunjanjaswal/DocuForge
 * Description:       Embed a PDF on your site with a block or a shortcode. A clean, responsive, full-width inline viewer that uses the browser's own PDF reader. No external services.
 * Version:           1.1.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Gunjan Jaswal
 * Author URI:        https://www.gunjanjaswal.me
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       docuforge
 * Domain Path:       /languages
 *
 * @package DocuForge
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'DOCUFORGE_VERSION', '1.1.0' );
define( 'DOCUFORGE_FILE', __FILE__ );
define( 'DOCUFORGE_DIR', plugin_dir_path( __FILE__ ) );
define( 'DOCUFORGE_URL', plugin_dir_url( __FILE__ ) );

require_once DOCUFORGE_DIR . 'includes/class-docuforge.php';

DocuForge::instance();
