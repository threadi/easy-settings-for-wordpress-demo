<?php
/**
 * File to handle the JSON view of settings.
 *
 * @package easy-settings-for-wordpress-demo
 */

// prevent direct access.
defined( 'ABSPATH' ) || exit;

use easySettingsForWordPress\Settings;

/**
 * Show a second settings page on base of JSON.
 *
 * @return void
 */
function easy_settings_for_wordpress_demo_init_second(): void {
    $settings_obj = new Settings( ESFWD_FILE );
    $settings_obj->set_json_by_path(  __DIR__ . '/example.json' );
    $settings_obj->init();
}
add_action( 'init', 'easy_settings_for_wordpress_demo_init_second', 20 );