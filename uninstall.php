<?php
/**
 * Tasks to run during uninstallation of this plugin.
 *
 * @package easy-settings-for-wordpress-demo
 */

// prevent direct access.
defined( 'ABSPATH' ) || exit;

// if uninstall.php is not called by WordPress, die.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

// embed the composer packages.
require __DIR__ . '/vendor/autoload.php';

// this file contains the examples how to use the settings.
require __DIR__ . '/settings.php';

// initialize the settings.
easy_settings_for_wordpress_demo_init();

// delete them.
easy_settings_for_wordpress_demo_get_settings_object()->delete_settings();
