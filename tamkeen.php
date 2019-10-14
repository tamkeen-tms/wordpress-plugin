<?php

	/**
	 * Plugin Name: Tamkeen
	 * Plugin URI: http://www.tamkeenapp.com
	 * Description: WordPress integration plugin for Tamkeen
	 * Version: 1.0
	 * Author: Tamkeen Team
	 * Author URI: http://www.tamkeenapp.com
	 */

	add_action('admin_menu', 'tamkeen_admin_menu');

	/**
	 * Add to the admin main menu
	 */
	function tamkeen_admin_menu(){
		add_menu_page('Tamkeen', 'Tamkeen', 'manage_options', 'tamkeen', 'tamkeen_options_page');
	}

	/**
	 * The options page
	 */
	function tamkeen_options_page() {
		if(!current_user_can('manage_options')){
			wp_die(__('You do not have sufficient permissions to access this page.'));
		}

		include 'admin.php';
	}

	//////////////////////////////////////////////////////////////////////////////////////////
	//
	//  Short codes
	//
	//////////////////////////////////////////////////////////////////////////////////////////

	add_shortcode('tamkeen_courses_list', function($attrs, $content, $tag){
		include 'pages/courses/list.php';
	});

	add_shortcode('tamkeen_course_view', function($attrs, $content, $tag){
		include 'pages/courses/course/view.php';
	});

	add_shortcode('tamkeen_course_signup', function($attrs, $content, $tag){
		include 'pages/courses/course/signup.php';
	});
