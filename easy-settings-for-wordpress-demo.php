<?php
/**
 * Plugin Name:       Easy Settings for WordPress Demo
 * Description:       This plugin demonstrates the usage of the composer package threadi/easy-settings-for-wordpress.
 * Requires at least: 6.0
 * Requires PHP:      8.1
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

// do nothing if the PHP version is not 8.0 or newer.
if ( PHP_VERSION_ID < 80000 ) { // @phpstan-ignore smaller.alwaysFalse
	return;
}

// save our path.
const ESFWD_FILE = __FILE__;

// embed the composer packages.
require __DIR__ . '/vendor/autoload.php';

// this file contains the examples how to use the settings.
require __DIR__ . '/settings.php';

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
