<?php
/**
 * File as example how to handle settings.
 *
 * @package easy-settings-for-wordpress-demo
 */

// prevent direct access.
defined( 'ABSPATH' ) || exit;

use easySettingsForWordPress\Fields\Button;
use easySettingsForWordPress\Fields\Checkbox;
use easySettingsForWordPress\Fields\Checkboxes;
use easySettingsForWordPress\Fields\File;
use easySettingsForWordPress\Fields\Files;
use easySettingsForWordPress\Fields\MultiSelect;
use easySettingsForWordPress\Fields\Number;
use easySettingsForWordPress\Fields\Password;
use easySettingsForWordPress\Fields\PermalinkSlug;
use easySettingsForWordPress\Fields\Radio;
use easySettingsForWordPress\Fields\Select;
use easySettingsForWordPress\Fields\SelectPostTypeObject;
use easySettingsForWordPress\Fields\Text;
use easySettingsForWordPress\Fields\Textarea;
use easySettingsForWordPress\Fields\TextInfo;
use easySettingsForWordPress\Fields\Value;
use easySettingsForWordPress\Page;
use easySettingsForWordPress\Settings;

/**
 * Initialize the settings.
 */
function easy_settings_for_wordpress_demo_init(): void {
	/**
	 * Configure the basic settings object.
	 */
	$settings_obj = easy_settings_for_wordpress_demo_get_settings_object();
	$settings_obj->set_slug( 'demo_settings' ); // set a slug to use intern.
	$settings_obj->set_menu_title( _x( 'Demo Settings', 'settings menu title', 'easy-settings-for-wordpress-demo' ) ); // set the menu title.
	$settings_obj->set_title( __( 'Demo Settings', 'easy-settings-for-wordpress-demo' ) ); // set the settings title.
	$settings_obj->set_menu_slug( 'demo-settings' ); // set the menu slug.
	$settings_obj->set_menu_parent_slug( 'options-general.php' ); // set where the settings are assigned to, e.g., 'options-general.php' for the WordPress-own settings menu.
	$settings_obj->show_settings_link_in_plugin_list( true ); // set to true to show link to settings on plugin list.
	$settings_obj->set_view( get_option( 'esfwd_view' ) );

	// get the actual for to set its styling.
	$view = $settings_obj->get_views()->get_view();
	if ( $view instanceof \easySettingsForWordPress\View_Base ) {
		$view->set_styling( get_option( 'esfwd_view_classic_style' ) );
	}

	// get the settings page.
	$settings_page = $settings_obj->get_page( 'demo-settings' );

	// bail if page could not be found.
	if ( ! $settings_page instanceof Page ) {
		return;
	}

	// add a tab on this page.
	$fields_tab = $settings_page->add_tab( 'demo_basic', 10 );
	$fields_tab->set_title( __( 'The fields', 'easy-settings-for-wordpress-demo' ) );
	$fields_tab->set_description( '<p>' . __( 'These tab presents the simple fields the composer package "Easy Settings for WordPress" support.', 'easy-settings-for-wordpress-demo' ) . '</p>' );
	$settings_page->set_default_tab( $fields_tab );

	// add a section.
	$section = $fields_tab->add_section( 'first_section', 10 );
	$section->set_title( __( 'Examples for all supported fields', 'easy-settings-for-wordpress-demo' ) );

	// add setting for Button.
	$setting = $settings_obj->add_setting( 'esfw_demo_button' );
	$setting->set_section( $section );
	$setting->prevent_export( true );
	$field = new Button( $settings_obj );
	$field->set_button_title( __( 'Click me', 'easy-settings-for-wordpress-demo' ) );
	$field->set_title( __( 'Button', 'easy-settings-for-wordpress-demo' ) );
	$field->set_description( __( 'This is a button. It does not save any value as setting but could be used start an action.', 'easy-settings-for-wordpress-demo' ) );
	$field->set_button_url( '#' );
	$field->add_data(
		'dialog',
		(string) wp_json_encode(
			array(
				'title'   => __( 'You clicked me!', 'easy-settings-for-wordpress-demo' ),
				'texts'   => array(
					'<p></p>',
				),
				'buttons' => array(
					array(
						'action'  => 'closeDialog();',
						'variant' => 'primary',
						'text'    => __( 'Close', 'easy-settings-for-wordpress-demo' ),
					),
				),
			)
		)
	);
	$field->add_class( 'easy-dialog-for-wordpress' );
	$setting->set_field( $field );

	// add setting for a Checkbox.
	$setting = $settings_obj->add_setting( 'esfw_demo_checkbox' );
	$setting->set_default( 0 );
	$setting->set_section( $section );
	$field = new Checkbox( $settings_obj );
	$field->set_title( __( 'Checkbox', 'easy-settings-for-wordpress-demo' ) );
	$field->set_description( __( 'This is a checkbox. It could be used to enable or disable things.', 'easy-settings-for-wordpress-demo' ) );
	$setting->set_field( $field );

	// add setting for multiple Checkboxes.
	$setting = $settings_obj->add_setting( 'esfw_demo_checkboxes' );
	$setting->set_type( 'array' );
	$setting->set_default(
		array(
			'second' => '1',
		)
	);
	$setting->set_section( $section );
	$field = new Checkboxes( $settings_obj );
	$field->set_title( __( 'Checkboxes', 'easy-settings-for-wordpress-demo' ) );
	$field->set_options(
		array(
			'first'  => array(
				'label' => __( 'First', 'easy-settings-for-wordpress-demo' ),
			),
			'second' => array(
				'label'       => __( 'Second', 'easy-settings-for-wordpress-demo' ),
				'description' => __( 'Could have a description.', 'easy-settings-for-wordpress-demo' ),
			),
			'third'  => array(
				'label' => __( 'Third', 'easy-settings-for-wordpress-demo' ),
			),
		)
	);
	$field->set_description( __( 'These are multiple checkboxes. It could be used to enable or disable multiple things.', 'easy-settings-for-wordpress-demo' ) );
	$setting->set_field( $field );

	// add setting for a File.
	$setting = $settings_obj->add_setting( 'esfw_demo_file' );
	$setting->set_type( 'string' );
	$setting->set_default( '' );
	$setting->set_section( $section );
	$field = new File( $settings_obj );
	$field->set_title( __( 'File', 'easy-settings-for-wordpress-demo' ) );
	$field->set_description( __( 'This allows you to select an image file from your media library, which will be saved in the settings.', 'easy-settings-for-wordpress-demo' ) );
	$field->set_add_file_title( __( 'Add an image', 'easy-settings-for-wordpress-demo' ) );
	$field->set_remove_file_title( __( 'Remove image', 'easy-settings-for-wordpress-demo' ) );
	$setting->set_field( $field );

	// add setting for Files.
	$setting = $settings_obj->add_setting( 'esfw_demo_files' );
	$setting->set_type( 'array' );
	$setting->set_default( array() );
	$setting->set_section( $section );
	$field = new Files( $settings_obj );
	$field->set_title( __( 'Files', 'easy-settings-for-wordpress-demo' ) );
	$field->set_description( __( 'This allows you to select images from your media library, which will be saved in the settings.', 'easy-settings-for-wordpress-demo' ) );
	$field->set_add_file_title( __( 'Add images', 'easy-settings-for-wordpress-demo' ) );
	$setting->set_field( $field );

	// add setting for a MultiSelect.
	$setting = $settings_obj->add_setting( 'esfw_demo_multiselect' );
	$setting->set_type( 'array' );
	$setting->set_default(
		array(
			'second',
		)
	);
	$setting->set_section( $section );
	$field = new MultiSelect( $settings_obj );
	$field->set_title( __( 'Multiple values', 'easy-settings-for-wordpress-demo' ) );
	$field->set_description( __( 'This allows you to choose multiple values from a list.', 'easy-settings-for-wordpress-demo' ) );
	$field->set_options(
		array(
			'first'  => __( 'First', 'easy-settings-for-wordpress-demo' ),
			'second' => __( 'Second', 'easy-settings-for-wordpress-demo' ),
			'third'  => __( 'Third', 'easy-settings-for-wordpress-demo' ),
		)
	);
	$setting->set_field( $field );

	// add setting for a Number.
	$setting = $settings_obj->add_setting( 'esfw_demo_number' );
	$setting->set_type( 'integer' );
	$setting->set_default( 0 );
	$setting->set_section( $section );
	$field = new Number( $settings_obj );
	$field->set_title( __( 'Number', 'easy-settings-for-wordpress-demo' ) );
	$field->set_description( __( 'This allows you to set a number in the settings.', 'easy-settings-for-wordpress-demo' ) );
	$setting->set_field( $field );

	// add setting for a Password.
	$setting = $settings_obj->add_setting( 'esfw_demo_password' );
	$setting->set_type( 'string' );
	$setting->set_default( '' );
	$setting->set_section( $section );
	$field = new Password( $settings_obj );
	$field->set_title( __( 'Password', 'easy-settings-for-wordpress-demo' ) );
	$field->set_description( __( 'This allows you to set a hidden password in the settings.', 'easy-settings-for-wordpress-demo' ) );
	$setting->set_field( $field );

	// add setting for a PermalinkSlug.
	$setting = $settings_obj->add_setting( 'esfw_demo_permalink_slug' );
	$setting->set_type( 'string' );
	$setting->set_default( '' );
	$setting->set_section( $section );
	$field = new PermalinkSlug( $settings_obj );
	$field->set_title( __( 'Permalink Slug', 'easy-settings-for-wordpress-demo' ) );
	$field->set_list_title( __( 'Choose params', 'easy-settings-for-wordpress-demo' ) );
	$field->set_options(
		array(
			'first'  => __( 'First', 'easy-settings-for-wordpress-demo' ),
			'second' => __( 'Second', 'easy-settings-for-wordpress-demo' ),
			'third'  => __( 'Third', 'easy-settings-for-wordpress-demo' ),
		)
	);
	$field->set_description( __( 'This allows you to set a permalink slug in the settings.', 'easy-settings-for-wordpress-demo' ) );
	$setting->set_field( $field );

	// add setting for a Radio.
	$setting = $settings_obj->add_setting( 'esfw_demo_radio' );
	$setting->set_type( 'string' );
	$setting->set_default( 'first' );
	$setting->set_section( $section );
	$field = new Radio( $settings_obj );
	$field->set_title( __( 'Radio', 'easy-settings-for-wordpress-demo' ) );
	$field->set_description( __( 'This allows you to show a set of possible options for a single setting.', 'easy-settings-for-wordpress-demo' ) );
	$field->set_options(
		array(
			'first'  => __( 'First', 'easy-settings-for-wordpress-demo' ),
			'second' => __( 'Second', 'easy-settings-for-wordpress-demo' ),
			'third'  => __( 'Third', 'easy-settings-for-wordpress-demo' ),
		)
	);
	$setting->set_field( $field );

	// add setting for a Select.
	$setting = $settings_obj->add_setting( 'esfw_demo_select' );
	$setting->set_type( 'string' );
	$setting->set_default( '' );
	$setting->set_section( $section );
	$field = new Select( $settings_obj );
	$field->set_title( __( 'Select', 'easy-settings-for-wordpress-demo' ) );
	$field->set_description( __( 'This allows you to show a set of possible options for a single setting.', 'easy-settings-for-wordpress-demo' ) );
	$field->set_options(
		array(
			'first'  => __( 'First', 'easy-settings-for-wordpress-demo' ),
			'second' => __( 'Second', 'easy-settings-for-wordpress-demo' ),
			'third'  => __( 'Third', 'easy-settings-for-wordpress-demo' ),
		)
	);
	$setting->set_field( $field );

	// add setting for a SelectPostTypeObject.
	$setting = $settings_obj->add_setting( 'esfw_demo_select_post_type' );
	$setting->set_type( 'string' );
	$setting->set_default( '' );
	$setting->set_section( $section );
	$field = new SelectPostTypeObject( $settings_obj );
	$field->set_title( __( 'Select a post type object', 'easy-settings-for-wordpress-demo' ) );
	$field->set_description( __( 'This allows you to choose a post type object like a page or a post. We show here how to select a page.', 'easy-settings-for-wordpress-demo' ) );
	$field->set_button_title( __( 'Choose', 'easy-settings-for-wordpress-demo' ) );
	$field->set_cancel_button_title( __( 'Cancel', 'easy-settings-for-wordpress-demo' ) );
	$field->set_chosen_title( __( 'Choose a page', 'easy-settings-for-wordpress-demo' ) );
	$field->set_popup_title( __( 'Choose a page', 'easy-settings-for-wordpress-demo' ) );
	$field->set_popup_description( __( 'Please choose a post type you want to set in the settings.', 'easy-settings-for-wordpress-demo' ) );
	$field->set_endpoint( '/wp-json/wp/v2/pages' );
	$setting->set_field( $field );

	// add setting for a Text.
	$setting = $settings_obj->add_setting( 'esfw_demo_text' );
	$setting->set_type( 'string' );
	$setting->set_default( '' );
	$setting->set_section( $section );
	$field = new Text( $settings_obj );
	$field->set_title( __( 'Text', 'easy-settings-for-wordpress-demo' ) );
	$field->set_description( __( 'This allows you to add a simple text in the settings.', 'easy-settings-for-wordpress-demo' ) );
	$field->set_placeholder( __( 'This is a placeholder', 'easy-settings-for-wordpress-demo' ) );
	$setting->set_field( $field );

	// add setting for a Text.
	$setting = $settings_obj->add_setting( 'esfw_demo_text_with_callback' );
	$setting->set_type( 'string' );
	$setting->set_default( '' );
	$setting->set_section( $section );
	$setting->set_read_callback( 'easy_settings_for_wordpress_demo_read_callback' );
	$field = new Text( $settings_obj );
	$field->set_title( __( 'Text with a read callback', 'easy-settings-for-wordpress-demo' ) );
	$field->set_description( __( 'This field is run through a read callback to change its content.', 'easy-settings-for-wordpress-demo' ) );
	$field->set_placeholder( __( 'This is a placeholder', 'easy-settings-for-wordpress-demo' ) );
	$setting->set_field( $field );

	// add setting for a Text.
	$setting = $settings_obj->add_setting( 'esfw_demo_text_with_save_callback' );
	$setting->set_type( 'string' );
	$setting->set_default( '' );
	$setting->set_section( $section );
	$setting->set_read_callback( 'easy_settings_for_wordpress_demo_save_callback' );
	$field = new Text( $settings_obj );
	$field->set_title( __( 'Text with a save callback', 'easy-settings-for-wordpress-demo' ) );
	$field->set_description( __( 'This field is run through a callback to check the content before saving it.', 'easy-settings-for-wordpress-demo' ) );
	$field->set_placeholder( __( 'This is a placeholder', 'easy-settings-for-wordpress-demo' ) );
	$setting->set_field( $field );

	// add setting for a Textarea.
	$setting = $settings_obj->add_setting( 'esfw_demo_textarea' );
	$setting->set_type( 'string' );
	$setting->set_default( '' );
	$setting->set_section( $section );
	$field = new Textarea( $settings_obj );
	$field->set_title( __( 'Textarea', 'easy-settings-for-wordpress-demo' ) );
	$field->set_description( __( 'This allows you to add a multiline text in the settings.', 'easy-settings-for-wordpress-demo' ) );
	$field->set_placeholder( __( 'This is a placeholder', 'easy-settings-for-wordpress-demo' ) );
	$setting->set_field( $field );

	// add setting for a TextInfo.
	$setting = $settings_obj->add_setting( 'esfw_demo_textinfo' );
	$setting->set_section( $section );
	$field = new TextInfo( $settings_obj );
	$field->set_title( __( 'TextInfo', 'easy-settings-for-wordpress-demo' ) );
	$field->set_description( __( 'This allows you to show a simple text info between the settings. This text here is such a text.', 'easy-settings-for-wordpress-demo' ) );
	$setting->set_field( $field );

	// add setting for a Value.
	$setting = $settings_obj->add_setting( 'esfw_demo_value' );
	$setting->set_section( $section );
	$setting->set_type( 'string' );
	$field = new Value( $settings_obj );
	$field->set_title( __( 'Value', 'easy-settings-for-wordpress-demo' ) );
	$field->set_value( 'Hallo World' );
	$field->set_description( __( 'This allows you to show the value of this setting without any change to change it.', 'easy-settings-for-wordpress-demo' ) );
	$setting->set_field( $field );

	// add a tab on this page to demonstration dependency.
	$dependency_tab = $settings_page->add_tab( 'dependency', 10 );
	$dependency_tab->set_title( __( 'Dependency of fields', 'easy-settings-for-wordpress-demo' ) );
	$dependency_tab->set_description( '<p>' . __( 'These tab show how fields could be dependent from each other.', 'easy-settings-for-wordpress-demo' ) . '</p>' );

	// add a section.
	$dependency_section = $dependency_tab->add_section( 'second_section', 20 );
	$dependency_section->set_title( __( 'Example for dependency of fields', 'easy-settings-for-wordpress-demo' ) );

	// add setting for a Checkbox.
	$master_setting = $settings_obj->add_setting( 'esfw_demo_master_field' );
	$master_setting->set_type( 'integer' );
	$master_setting->set_default( 0 );
	$master_setting->set_section( $dependency_section );
	$field = new Checkbox( $settings_obj );
	$field->set_title( __( 'Checkbox', 'easy-settings-for-wordpress-demo' ) );
	$field->set_description( __( 'If this checkbox is enabled, the other settings will be displayed.', 'easy-settings-for-wordpress-demo' ) );
	$master_setting->set_field( $field );

	// add setting for a Text.
	$setting = $settings_obj->add_setting( 'esfw_demo_slave_field' );
	$setting->set_type( 'string' );
	$setting->set_default( '' );
	$setting->set_section( $dependency_section );
	$field = new Text( $settings_obj );
	$field->set_title( __( 'Text', 'easy-settings-for-wordpress-demo' ) );
	$field->set_description( __( 'This allows you to add a simple text in the settings.', 'easy-settings-for-wordpress-demo' ) );
	$field->set_placeholder( __( 'This is a placeholder', 'easy-settings-for-wordpress-demo' ) );
	$field->add_depend( $master_setting, 1 );
	$setting->set_field( $field );

	// add setting for a Radio.
	$setting = $settings_obj->add_setting( 'esfw_demo_second_slave_field' );
	$setting->set_type( 'string' );
	$setting->set_default( 'first' );
	$setting->set_section( $dependency_section );
	$field = new Radio( $settings_obj );
	$field->set_title( __( 'Radio', 'easy-settings-for-wordpress-demo' ) );
	$field->set_description( __( 'This allows you to show a set of possible options for a single setting.', 'easy-settings-for-wordpress-demo' ) );
	$field->set_options(
		array(
			'first'  => __( 'First', 'easy-settings-for-wordpress-demo' ),
			'second' => __( 'Second', 'easy-settings-for-wordpress-demo' ),
			'third'  => __( 'Third', 'easy-settings-for-wordpress-demo' ),
		)
	);
	$field->add_depend( $master_setting, 1 );
	$setting->set_field( $field );

	// add a tab on this page to demonstration dependency.
	$sections_tab = $settings_page->add_tab( 'sections', 30 );
	$sections_tab->set_title( __( 'Sections', 'easy-settings-for-wordpress-demo' ) );
	$sections_tab->set_description( '<p>' . __( 'These tab show how fields could be assigned to sections.', 'easy-settings-for-wordpress-demo' ) . '</p>' );

	// add a section.
	$first_section = $sections_tab->add_section( 'third_section', 10 );
	$first_section->set_title( __( 'First section', 'easy-settings-for-wordpress-demo' ) );

	// add setting for a Checkbox.
	$master_setting = $settings_obj->add_setting( 'esfw_demo_section_field_1' );
	$master_setting->set_type( 'integer' );
	$master_setting->set_default( 0 );
	$master_setting->set_section( $first_section );
	$field = new Checkbox( $settings_obj );
	$field->set_title( __( 'Checkbox', 'easy-settings-for-wordpress-demo' ) );
	$master_setting->set_field( $field );

	// add a section.
	$second_section = $sections_tab->add_section( 'fourth_section', 20 );
	$second_section->set_title( __( 'Second section', 'easy-settings-for-wordpress-demo' ) );

	// add setting for a Checkbox.
	$master_setting = $settings_obj->add_setting( 'esfw_demo_section_field_2' );
	$master_setting->set_type( 'integer' );
	$master_setting->set_default( 0 );
	$master_setting->set_section( $second_section );
	$field = new Checkbox( $settings_obj );
	$field->set_title( __( 'Checkbox', 'easy-settings-for-wordpress-demo' ) );
	$master_setting->set_field( $field );

	// add a tab on this page to demonstration subtabs.
	$subtabs_tab = $settings_page->add_tab( 'subtabs', 40 );
	$subtabs_tab->set_title( __( 'Sub-Tabs', 'easy-settings-for-wordpress-demo' ) );
	$subtabs_tab->set_description( '<p>' . __( 'These tab show how we could use sub-tabs.', 'easy-settings-for-wordpress-demo' ) . '</p>' );
	$subtabs_tab->set_hide_save( true );

	// add a tab on this page to demonstration dependency.
	$sub_1_tab = $subtabs_tab->add_tab( 'first', 10 );
	$sub_1_tab->set_title( __( 'First', 'easy-settings-for-wordpress-demo' ) );
	$sub_1_tab->set_hide_save( true );
	$subtabs_tab->set_default_tab( $sub_1_tab );

	// add a tab on this page to demonstration dependency.
	$sub_2_tab = $subtabs_tab->add_tab( 'second', 20 );
	$sub_2_tab->set_title( __( 'Second', 'easy-settings-for-wordpress-demo' ) );
	$sub_2_tab->set_hide_save( true );

	// add a tab on this page to demonstration dependency.
	$sub_3_tab = $subtabs_tab->add_tab( 'third', 30 );
	$sub_3_tab->set_title( __( 'Third', 'easy-settings-for-wordpress-demo' ) );
	$sub_3_tab->set_hide_save( true );

	// add a section.
	$sub_1_section = $sub_1_tab->add_section( 'sub_1_tab_section', 10 );
	$sub_1_section->set_title( __( 'Fields in first tab', 'easy-settings-for-wordpress-demo' ) );

	// add setting for a TextInfo.
	$setting = $settings_obj->add_setting( 'esfw_demo_hint_1' );
	$setting->set_section( $sub_1_section );
	$field = new TextInfo( $settings_obj );
	$field->set_title( __( 'Field with hint', 'easy-settings-for-wordpress-demo' ) );
	$field->set_description( __( 'Fields could be used here in the first sub-tab.', 'easy-settings-for-wordpress-demo' ) );
	$setting->set_field( $field );

	// add a section.
	$sub_2_section = $sub_2_tab->add_section( 'sub_2_tab_section', 10 );
	$sub_2_section->set_title( __( 'Fields in second tab', 'easy-settings-for-wordpress-demo' ) );

	// add setting for a TextInfo.
	$setting = $settings_obj->add_setting( 'esfw_demo_hint_2' );
	$setting->set_section( $sub_2_section );
	$field = new TextInfo( $settings_obj );
	$field->set_title( __( 'Field with hint', 'easy-settings-for-wordpress-demo' ) );
	$field->set_description( __( 'Fields could be used here in the second sub-tab.', 'easy-settings-for-wordpress-demo' ) );
	$setting->set_field( $field );

	// add a section.
	$sub_3_section = $sub_3_tab->add_section( 'sub_3_tab_section', 10 );
	$sub_3_section->set_title( __( 'Fields in third tab', 'easy-settings-for-wordpress-demo' ) );

	// add setting for a TextInfo.
	$setting = $settings_obj->add_setting( 'esfw_demo_hint_3' );
	$setting->set_section( $sub_3_section );
	$field = new TextInfo( $settings_obj );
	$field->set_title( __( 'Field with hint', 'easy-settings-for-wordpress-demo' ) );
	$field->set_description( __( 'Fields could be used here in the third sub-tab.', 'easy-settings-for-wordpress-demo' ) );
	$setting->set_field( $field );

	// add a tab on this page to demonstration import and export of settings.
	$import_export_tab = $settings_page->add_tab( 'import_export', 40 );
	$import_export_tab->set_title( __( 'Import & Export', 'easy-settings-for-wordpress-demo' ) );
	$import_export_tab->set_hide_save( true );

	// add a section.
	$import_export_section = $import_export_tab->add_section( 'import_export_section', 10 );
	$import_export_section->set_title( __( 'Use import and export of settings', 'easy-settings-for-wordpress-demo' ) );

	// create import dialog.
	$dialog = array(
		'title'   => __( 'Import settings', 'easy-settings-for-wordpress-demo' ),
		'texts'   => array(
			'<p><strong>' . __( 'Choose the JSON-file with the settings.', 'easy-settings-for-wordpress-demo' ) . '</strong></p>',
			'<input type="file" accept="application/json" name="import_settings_file" id="import_settings_file">',
		),
		'buttons' => array(
			array(
				'action'  => 'esefw_settings_import_file();',
				'variant' => 'primary',
				'text'    => __( 'Import now', 'easy-settings-for-wordpress-demo' ),
			),
			array(
				'action'  => 'closeDialog();',
				'variant' => 'secondary',
				'text'    => __( 'Cancel', 'easy-settings-for-wordpress-demo' ),
			),
		),
	);

	// add setting.
	$setting = $settings_obj->add_setting( 'import_settings' );
	$setting->set_section( $import_export_section );
	$setting->set_autoload( false );
	$setting->prevent_export( true );
	$field = new Button( $settings_obj );
	$field->set_title( __( 'Import', 'easy-settings-for-wordpress-demo' ) );
	$field->set_button_title( __( 'Import now', 'easy-settings-for-wordpress-demo' ) );
	$field->add_class( 'easy-dialog-for-wordpress' );
	$field->add_data( 'dialog', (string) wp_json_encode( $dialog ) );
	$setting->set_field( $field );

	// create export dialog.
	$dialog = array(
		'title'   => __( 'Export settings', 'easy-settings-for-wordpress-demo' ),
		'texts'   => array(
			'<p><strong>' . __( 'Click on the following button to download the settings as JSON-file.', 'easy-settings-for-wordpress-demo' ) . '</strong></p>',
			'<p>' . __( 'You can import this JSON-file in other projects using this WordPress plugin or theme.', 'easy-settings-for-wordpress-demo' ) . '</p>',
		),
		'buttons' => array(
			array(
				'action'  => 'closeDialog();location.href="' . $settings_obj->get_export_obj()->get_download_url() . '";',
				'variant' => 'primary',
				'text'    => __( 'Export now', 'easy-settings-for-wordpress-demo' ),
			),
			array(
				'action'  => 'closeDialog();',
				'variant' => 'secondary',
				'text'    => __( 'Cancel', 'easy-settings-for-wordpress-demo' ),
			),
		),
	);

	// add setting.
	$setting = $settings_obj->add_setting( 'export_settings' );
	$setting->set_section( $import_export_section );
	$setting->set_autoload( false );
	$setting->prevent_export( true );
	$field = new Button( $settings_obj );
	$field->set_title( __( 'Export', 'easy-settings-for-wordpress-demo' ) );
	$field->set_button_title( __( 'Export now', 'easy-settings-for-wordpress-demo' ) );
	$field->set_button_url( $settings_obj->get_export_obj()->get_download_url() );
	$field->add_class( 'easy-dialog-for-wordpress' );
	$field->add_data( 'dialog', (string) wp_json_encode( $dialog ) );
	$setting->set_field( $field );

	// add a tab on this page to show the debug information of the settings object.
	$debug_tab = $settings_page->add_tab( 'settings_debug', 50 );
	$debug_tab->set_title( __( 'Debug', 'easy-settings-for-wordpress-demo' ) );
	$debug_tab->set_hide_save( true );

	// add a section.
	$debug_section = $debug_tab->add_section( 'import_export_section', 10 );
	$debug_section->set_title( __( 'Use import and export of settings', 'easy-settings-for-wordpress-demo' ) );

	// get the debug information.
	$debug = $settings_obj->debug();

	// add setting.
	$setting = $settings_obj->add_setting( 'settings_debug_plugin' );
	$setting->set_section( $debug_section );
	$setting->set_autoload( false );
	$setting->prevent_export( true );
	$field = new TextInfo( $settings_obj );
	$field->set_title( __( 'Used plugin', 'easy-settings-for-wordpress-demo' ) );
	$field->set_description( $debug['plugin_path'] );
	$setting->set_field( $field );

	// add setting.
	$setting = $settings_obj->add_setting( 'settings_debug_method' );
	$setting->set_section( $debug_section );
	$setting->set_autoload( false );
	$setting->prevent_export( true );
	$field = new TextInfo( $settings_obj );
	$field->set_title( __( 'Used method', 'easy-settings-for-wordpress-demo' ) );
	$field->set_description( $debug['method'] );
	$setting->set_field( $field );

	// add setting.
	$setting = $settings_obj->add_setting( 'settings_debug_view' );
	$setting->set_section( $debug_section );
	$setting->set_autoload( false );
	$setting->prevent_export( true );
	$field = new TextInfo( $settings_obj );
	$field->set_title( __( 'Used view', 'easy-settings-for-wordpress-demo' ) );
	$field->set_description( $debug['view'] );
	$setting->set_field( $field );

	// get the list of errors.
	$errors     = easy_settings_for_wordpress_demo_get_settings_object()->get_errors();
	$error_list = array();
	if ( $errors instanceof WP_Error ) {
		foreach ( $errors->get_error_messages() as $error_message ) {
			$error_list[] = $error_message;
		}
	}

	// add setting.
	$setting = $settings_obj->add_setting( 'settings_debug_errors' );
	$setting->set_section( $debug_section );
	$setting->set_autoload( false );
	$setting->prevent_export( true );
	$field = new TextInfo( $settings_obj );
	$field->set_title( __( 'Errors', 'easy-settings-for-wordpress-demo' ) );
	$field->set_description( ! empty( $error_list ) ? implode( ',', $error_list ) : __( 'None', 'easy-settings-for-wordpress-demo' ) );
	$setting->set_field( $field );

	// add a tab on this page.
	$demo_tab = $settings_page->add_tab( 'demo_settings', 60 );
	$demo_tab->set_title( __( 'Demo settings', 'easy-settings-for-wordpress-demo' ) );
	$demo_tab->set_description( '<p>' . __( 'Change settings in the demo to show different views and styles.', 'easy-settings-for-wordpress-demo' ) . '</p>' );

	// add a section.
	$section = $demo_tab->add_section( 'demo_settings', 10 );
	$section->set_title( __( 'Settings', 'easy-settings-for-wordpress-demo' ) );

	// add setting.
	$view_setting = $settings_obj->add_setting( 'esfwd_view' );
	$view_setting->set_type( 'string' );
	$view_setting->set_default( 'classic' );
	$view_setting->set_section( $section );
	$field = new Radio( $settings_obj );
	$field->set_title( __( 'Choose the view', 'easy-settings-for-wordpress-demo' ) );
	$field->set_options(
		array(
			'classic'  => __( 'Classic', 'easy-settings-for-wordpress-demo' ),
			'dataview' => __( 'DataView', 'easy-settings-for-wordpress-demo' ),
		)
	);
	$view_setting->set_field( $field );

	// add setting.
	$setting = $settings_obj->add_setting( 'esfwd_view_classic_style' );
	$setting->set_type( 'string' );
	$setting->set_default( 'horizontal_tabs' );
	$setting->set_section( $section );
	$field = new Radio( $settings_obj );
	$field->set_title( __( 'Choose the alignment', 'easy-settings-for-wordpress-demo' ) );
	$field->set_options(
		array(
			'horizontal_tabs' => __( 'Horizontal tabs', 'easy-settings-for-wordpress-demo' ),
			'vertical_tabs'   => __( 'Vertical tabs', 'easy-settings-for-wordpress-demo' ),
		)
	);
	$field->add_depend( $view_setting, 'classic' );
	$setting->set_field( $field );

	// add external link as tab.
	$external_link_tab = $settings_page->add_tab( 'settings_external_link', 100 );
	$external_link_tab->set_title( __( 'Easy Settings for WordPress Demo', 'easy-settings-for-wordpress-demo' ) );
	$external_link_tab->set_url( 'https://github.com/threadi/easy-settings-for-wordpress-demo' );
	$external_link_tab->set_url_target( '_blank' );

	// initialize the settings.
	$settings_obj->init();
}
add_action( 'init', 'easy_settings_for_wordpress_demo_init' );

/**
 * Return the settings object.
 *
 * @return Settings
 */
function easy_settings_for_wordpress_demo_get_settings_object(): Settings {
	/**
	 * Variable for the object.
	 */
	static $settings = null;

	/**
	 * Get the object one time.
	 */
	if ( null === $settings ) {
		$settings = new Settings( ESFWD_FILE );
	}

	// return it.
	return $settings;
}

/**
 * Return another value for a field as read callback.
 *
 * @return string
 */
function easy_settings_for_wordpress_demo_read_callback(): string {
	return __( 'Run through read callback changes the value.', 'easy-settings-for-wordpress-demo' );
}

/**
 * Save another value for a field as callback during the save process.
 *
 * @param mixed $value The value to save.
 * @return string
 */
function easy_settings_for_wordpress_demo_save_callback( mixed $value ): string {
	if ( ! is_string( $value ) ) {
		$value = '';
	}

	// get the text to use.
	$text_preset = __( 'Has been removed during saving. Original was:', 'easy-settings-for-wordpress-demo' );

	// bail if text is already in the field.
	if ( str_contains( $value, $text_preset ) ) {
		return $value;
	}

	// add the text and return it together with the value.
	return $text_preset . ' ' . $value;
}

/**
 * Process any settings error.
 *
 * @return void
 */
function easy_settings_for_wordpress_demo_get_settings_errors(): void {
	// get the settings object.
	$settings_obj = easy_settings_for_wordpress_demo_get_settings_object();

	// bail if we have no errors.
    if ( ! method_exists( $settings_obj, 'has_errors' ) || $settings_obj->has_errors() ) { // @phpstan-ignore function.alreadyNarrowedType
		return;
	}

	// get the errors.
	$errors = $settings_obj->get_errors();

	// bail if errors are not set.
	if ( ! $errors instanceof WP_Error ) {
		return;
	}

	// log these errors.
	foreach ( $errors->errors as $key => $errors ) {
		_doing_it_wrong( '\easySettingsForWordPress\Settings::add_settings()', '<em>' . esc_html( $key ) . '</em>: ' . esc_html( implode( ' ', $errors ) ), '1.0.0' );
	}
}
add_action( 'admin_init', 'easy_settings_for_wordpress_demo_get_settings_errors', 20 );
