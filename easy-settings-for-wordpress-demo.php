<?php
/**
 * Plugin Name:       Easy Settings for WordPress Demo
 * Description:       This plugin demonstrates the usage of the composer package threadi/easy-settings-for-wordpress.
 * Requires at least: 6.0
 * Requires PHP:      8.2
 * Version:           @@VersionNumber@@
 * Author:            Thomas Zwirner
 * Author URI:        https://www.thomaszwirner.de
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       easy-settings-for-wordpress-demo
 *
 * @package easy-settings-for-wordpress-demo
 */

// prevent direct access.
defined( 'ABSPATH' ) || exit;

// do nothing if the PHP version is not 8.2 or newer.
if ( PHP_VERSION_ID < 80200 ) { // @phpstan-ignore smaller.alwaysFalse
	return;
}

// save our path.
const ESFWD_FILE = __FILE__;

// set the version.
const ESFWD_VERSION = '@@VersionNumber@@';

// bail if composer is not used.
if ( ! file_exists( plugin_dir_path( ESFWD_FILE ) . 'vendor/autoload.php' ) ) {
	add_action( 'admin_notices', 'easy_settings_for_wordpress_demo_autoloader_missing' );
	return;
}

// embed the composer packages.
require __DIR__ . '/vendor/autoload.php';

// this file contains the examples how to use the settings.
require __DIR__ . '/settings.php';
require __DIR__ . '/settings_json.php';

/**
 * Register the settings during plugin activation.
 */
function easy_settings_for_wordpress_demo_activation(): void {
	// load the settings.
	easy_settings_for_wordpress_demo_init();

	// initiate the settings.
	easy_settings_for_wordpress_demo_get_settings_object()->activation();
}
register_activation_hook( __FILE__, 'easy_settings_for_wordpress_demo_activation' );

/**
 * Show an admin notice error message if the composer autoloader is missing.
 */
function easy_settings_for_wordpress_demo_autoloader_missing(): void {
	echo '<div class="error"><p>';
	/* translators: %1$s will be replaced by a URL */
	echo wp_kses_post( sprintf( __( 'The plugin <em>Easy Settings for WordPress Demo</em> is missing the Composer autoloader file. Please run `composer install --no-dev -o` in the root folder of the plugin or <a href="%1$s" target="_blank">use a release version</a> including the `vendor` folder.', 'easy-settings-for-wordpress-demo' ), 'https://github.com/threadi/easy-dialog-for-wordpress-demo/releases' ) );
	echo '</p></div>';
}

/**
 * Load the language files.
 *
 * @return void
 */
function easy_settings_for_wordpress_demo_languages(): void {
	load_plugin_textdomain( 'easy-settings-for-wordpress-demo', false, dirname( plugin_basename( ESFWD_FILE ) ) . '/languages' );
}
add_action( 'init', 'easy_settings_for_wordpress_demo_languages', 5 );
