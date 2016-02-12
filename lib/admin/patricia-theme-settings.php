<?php
/**
 * Patricia Settings
 *
 * This file registers all of Patricia's specific Theme Settings, accessible from
 * Genesis --> Patricia Settings.
 *
 * NOTE: Change out "Patricia" in this file with name of theme and delete this note
 */ 
 
/**
 * Registers a new admin page, providing content and corresponding menu item
 * for the Child Theme Settings page.
 *
 * @since 1.0.0
 *
 * @package patricia
 * @subpackage WSM_Patricia_Settings
 */
class WSM_Patricia_Settings extends Genesis_Admin_Boxes {
	
	/**
	 * Create an admin menu item and settings page.
	 * @since 1.0.0
	 */
	function __construct() {
		
		// Specify a unique page ID. 
		$page_id = 'patricia';
		
		// Set it as a child to genesis, and define the menu and page titles
		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'genesis',
				'page_title'  => __( 'Patricia Settings', 'patricia' ),
				'menu_title'  => __( 'Patricia Settings', 'patricia' ),
				'capability' => 'manage_options',
			)
		);
		
		// Set up page options. These are optional, so only uncomment if you want to change the defaults
		$page_ops = array(
		//	'screen_icon'       => 'options-general',
		//	'save_button_text'  => 'Save Settings',
		//	'reset_button_text' => 'Reset Settings',
		//	'save_notice_text'  => 'Settings saved.',
		//	'reset_notice_text' => 'Settings reset.',
		);		
		
		// Give it a unique settings field. 
		// You'll access them from genesis_get_option( 'option_name', 'patricia-settings' );
		$settings_field = 'patricia-settings';
		
		// Set the default values
		$default_settings = array(
			'wsm_copyright' => 'My Name, All Rights Reserved',
			'wsm_contact_info' => '123 Streetname, Anytown, US 12345',
			'wsm_credit' => 'Patricia is a Genesis Child Theme Designed by Web Savvy Marketing',
			'wsm_ignore_updates' => 0,
			'wsm_gforms_placeholder' => 1,
		);
		
		// Create the Admin Page
		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

		// Initialize the Sanitization Filter
		add_action( 'genesis_settings_sanitizer_init', array( $this, 'sanitization_filters' ) );
			
	}

	/** 
	 * Set up Sanitization Filters
	 * @since 1.0.0
	 *
	 * See /lib/classes/sanitization.php for all available filters.
	 */	
	function sanitization_filters() {
				
		genesis_add_option_filter( 'safe_html', $this->settings_field,
			array(
				'wsm_copyright',
				'wsm_contact_info',
				'wsm_credit',
			) );
	}
	
	/**
	 * Set up Help Tab
	 * @since 1.0.0
	 *
	 * Genesis automatically looks for a help() function, and if provided uses it for the help tabs
	 * @link http://wpdevel.wordpress.com/2011/12/06/help-and-screen-api-changes-in-3-3/
	 */
	 function help() {
	 	$screen = get_current_screen();

		$screen->add_help_tab( array(
			'id'      => 'sample-help', 
			'title'   => 'Sample Help',
			'content' => '<p>Help content goes here.</p>',
		) );
	 }
	
	/**
	 * Register metaboxes on Child Theme Settings page
	 * @since 1.0.0
	 */
	function metaboxes() {
		
		add_meta_box('wsm_footer_info_metabox', __( 'Footer Info', 'patricia' ), array( $this, 'wsm_footer_info_metabox' ), $this->pagehook, 'main', 'high');
		add_meta_box('wsm_gforms_placeholders_metabox', __( 'Gravity Forms Auto Placeholders', 'patricia' ), array( $this, 'wsm_gforms_placeholders_metabox' ), $this->pagehook, 'main', 'high');
		add_meta_box('wsm_upate_notifications_metabox', __( 'Update Notifications', 'patricia' ), array( $this, 'wsm_upate_notifications_metabox' ), $this->pagehook, 'main', 'high');
				
	}
	
	
	/**
	 * Footer Info Metabox
	 * @since 1.0.0
	 */
	function wsm_footer_info_metabox() {

		echo '<p><strong>' . __( 'Copyright Info:', 'patricia' ) . '</strong></p>';
		echo '<p><input type="text" name="' . $this->get_field_name( 'wsm_copyright' ) . '" id="' . $this->get_field_id( 'wsm_copyright' ) . '" value="' . esc_attr( $this->get_field_value( 'wsm_copyright' ) ) . '" size="70" /></p>';

		echo '<p><strong>' . __( 'Contact Info:', 'patricia' ) . '</strong></p>';
		echo '<p><input type="text" name="' . $this->get_field_name( 'wsm_contact_info' ) . '" id="' . $this->get_field_id( 'wsm_contact_info' ) . '" value="' . esc_attr( $this->get_field_value( 'wsm_contact_info' ) ) . '" size="70" /></p>';

		echo '<p><strong>' . __( 'Credit Info:', 'patricia' ) . '</strong></p>';
		echo '<p><input type="text" name="' . $this->get_field_name( 'wsm_credit' ) . '" id="' . $this->get_field_id( 'wsm_credit' ) . '" value="' . esc_attr( $this->get_field_value( 'wsm_credit' ) ) . '" size="70" /></p>';

	
	}
	
	/**
	 * Gravity Forms Auto Placeholders Metabox
	 * @since 2.0.0
	 */
	function wsm_gforms_placeholders_metabox() {

		echo '<input type="checkbox" name="' . $this->get_field_name( 'wsm_gforms_placeholder' ) . '" id="' .  $this->get_field_id( 'wsm_gforms_placeholder' ) . '" value="1"';
		checked( 1, $this->get_field_value( 'wsm_gforms_placeholder' ) ); echo '/>';
		
		echo '<label for="' . $this->get_field_id( 'wsm_gforms_placeholder' ) . '"> ' . __( 'Only convert labels to placeholders on forms or form items with the class <strong><em>gforms-placeholder</em></strong>', 'patricia' ) . '</label>';
		echo '<p><em>' . __( 'By default, leaving this unchecked will apply the effect to all Gravity Form fields.', 'patricia' ) . '</em></p>';
			
	}
	
	/**
	 * Update Notifications Metabox
	 * @since 2.0.0
	 */
	function wsm_upate_notifications_metabox() {

		echo '<p>' . __( 'Please check the box below if you wish to ignore/hide the theme update notification.<br/>Uncheck the box if you wish to be notified of theme updates.', 'patricia' ) . '</p>';
		
		echo '<input type="checkbox" name="' . $this->get_field_name( 'wsm_ignore_updates' ) . '" id="' .  $this->get_field_id( 'wsm_ignore_updates' ) . '" value="1" ';
		checked( 1, $this->get_field_value( 'wsm_ignore_updates' ) ); 
		echo '/> <label for="' . $this->get_field_id( 'wsm_ignore_updates' ) . '">' . __( 'Ignore Theme Updates?', 'patricia' ) . '</label>';
			
	}
	
	
}

/**
 * Add the Theme Settings Page
 * @since 1.0.0
 */
function wsm_add_patricia_settings() {
	global $_child_theme_settings;
	$_child_theme_settings = new WSM_Patricia_Settings;	 	
}
add_action( 'genesis_admin_menu', 'wsm_add_patricia_settings' );
