<?php

	/**
	 * Plugin Name: Tamkeen
	 * Plugin URI: http://www.tamkeenapp.com
	 * Description: WordPress integration plugin for Tamkeen
	 * Version: 1.0
	 * Author: Tamkeen Team
	 * Author URI: http://www.tamkeenapp.com
	 */

	// Auto-loading
	include_once 'vendor/autoload.php';

	// Setup the client
	$api = new \Tamkeen\Client();

	$api->setBaseUrl(get_option('tamkeen_api_url'))
		->setApiKey(get_option('tamkeen_api_key'));

	add_action('admin_init', 'tamkeen_settings_init');
	add_action('admin_menu', 'tamkeen_admin_menu');

	/**
	 * Register settings
	 */
	function tamkeen_settings_init(){
		add_settings_section('tamkeen_settings', null, null, 'tamkeen');

		add_settings_field('tamkeen_api_url', 'API Url', function(){
			print '<input name="tamkeen_api_url" value="' . get_option('tamkeen_api_url') . '" size="60" />';

		}, 'tamkeen', 'tamkeen_settings');

		add_settings_field('tamkeen_api_key', 'API Key', function(){
			print '<input name="tamkeen_api_key" value="' . get_option('tamkeen_api_key') . '" size="80" />';

		}, 'tamkeen', 'tamkeen_settings');

		register_setting('tamkeen', 'tamkeen_api_url');
		register_setting('tamkeen', 'tamkeen_api_key');
	}

	/**
	 * Add to the admin main menu
	 */
	function tamkeen_admin_menu(){
		add_menu_page('tamkeen', 'Tamkeen', 'manage_options', 'tamkeen', 'tamkeen_options_page',
			plugin_dir_url(__FILE__) . '/src/icon.png');
	}

	/**
	 * The options page
	 */
	function tamkeen_options_page() {
		if(!current_user_can('manage_options')){
			wp_die(__('You do not have sufficient permissions to access this page.'));
		}

		include 'src/admin.php';
	}

	//////////////////////////////////////////////////////////////////////////////////////////
	//
	//  Short codes
	//
	//////////////////////////////////////////////////////////////////////////////////////////

	add_shortcode('tamkeen_courses_list', function($attrs, $content, $tag) use($api){
		include 'src/pages/courses/list.php';
	});

	add_shortcode('tamkeen_course_view', function($attrs, $content, $tag) use($api){
		include 'src/pages/courses/course/view.php';
	});

	add_shortcode('tamkeen_course_signup', function($attrs, $content, $tag) use($api){
		include 'src/pages/courses/course/signup.php';
	});
