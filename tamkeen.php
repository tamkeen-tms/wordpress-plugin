<?php

	/**
	 * Plugin Name: Tamkeen
	 * Plugin URI: http://www.tamkeentms.com
	 * Description: WordPress integration plugin for Tamkeen
	 * Version: 1.0
	 * Author: Tamkeen Team
	 * Author URI: http://www.tamkeentms.com
	 */

	// Auto-loading
	include_once 'vendor/autoload.php';

	Use eftec\bladeone\BladeOne;

	// Setup the client
	$api = new \Tamkeen\Client();

	$api->setBaseUrl(get_option('tamkeen_api_url'))
		->setApiKey(get_option('tamkeen_api_key'))
		->setDefaultLocale(get_option('tamkeen_locale') ?: 'ar');

	add_action('admin_init', 'tamkeen_settings_init');
	add_action('admin_menu', 'tamkeen_admin_menu');
	add_action('wp_enqueue_scripts', 'tamkeen_ui_assets');

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

		add_settings_field('tamkeen_locale', 'Locale ("en" or "ar")', function(){
			print '<input name="tamkeen_locale" value="' . (get_option('tamkeen_locale') ?: 'ar') . '" size="20" />';

		}, 'tamkeen', 'tamkeen_settings');

		add_settings_field('tamkeen_signup_success_message', 'Successful signup message', function(){
			print '<input name="tamkeen_signup_success_message" value="' . get_option('tamkeen_signup_success_message') . '" size="80" />';

		}, 'tamkeen', 'tamkeen_settings');

		add_settings_field('tamkeen_recaptcha_key', 'Google reCaptcha site key', function(){
			print '<input name="tamkeen_recaptcha_key" value="' . get_option('tamkeen_recaptcha_key') . '" size="80" />';

		}, 'tamkeen', 'tamkeen_settings');

		add_settings_field('tamkeen_recaptcha_secret', 'Google reCaptcha secret', function(){
			print '<input name="tamkeen_recaptcha_secret" value="' . get_option('tamkeen_recaptcha_secret') . '" size="80" />';

		}, 'tamkeen', 'tamkeen_settings');

		register_setting('tamkeen', 'tamkeen_api_url');
		register_setting('tamkeen', 'tamkeen_api_key');
		register_setting('tamkeen', 'tamkeen_locale');
		register_setting('tamkeen', 'tamkeen_signup_success_message');
		register_setting('tamkeen', 'tamkeen_recaptcha_key');
		register_setting('tamkeen', 'tamkeen_recaptcha_secret');
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

	/**
	 * Add UI assets to the queue
	 */
	function tamkeen_ui_assets(){
		wp_enqueue_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
	}

	/**
	 * @param string $path
	 * @return string
	 */
	function tamkeen_get_path($path = ''){
		return plugin_dir_path(__FILE__) . 'src/' . $path;
	}

	/**
	 * @param $view
	 * @param array $data
	 * @return mixed
	 */
	function tamkeen_render_view($view, array $data = []){
		static $renderer;

		if(!$renderer){
			$renderer = new \eftec\bladeone\BladeOne(
				tamkeen_get_path('views/views'),
				tamkeen_get_path('views/cache'),
				BladeOne::MODE_AUTO
			);
		}

		return $renderer->run($view, $data);
	}

	/**
	 * Display errors
	 * @param Exception $e
	 * @return string
	 */
	function tamkeen_display_error($e){
		if($e instanceof Exception){
			$message = $e->getMessage();

			if($e instanceof \Tamkeen\Exceptions\RequestException){
				$message = 'API Error: ' . $message;
			}

		}else{
			$message = $e;
		}

		return '<h4>Sorry, an error has happened.</h4>'
			. '<div>' . $message . '</div>';
	}

	/**
	 * @param $en
	 * @param $ar
	 * @return mixed
	 */
	function tamkeen_trans($en, $ar){
		static $locale;

		if(!$locale){
			$locale = get_option('tamkeen_locale');
		}

		return [
			'en' => $en,
			'ar' => $ar

		][$locale];
	}

	/**
	 * Dump
	 */
	function tamkeen_dd(){
		var_dump(func_get_args());
		exit;
	}

	//////////////////////////////////////////////////////////////////////////////////////////
	//
	//  Short codes
	//
	//////////////////////////////////////////////////////////////////////////////////////////
	add_shortcode('tamkeen_courses_catalog', function($attrs, $content, $tag) use($api){
		return include_once tamkeen_get_path('courses.php');
	});
