<?php

	/**
	 * Plugin Name: Tamkeen
	 * Plugin URI: http://www.tamkeentms.com
	 * Description: WordPress integration plugin for Tamkeen
	 * Version: 1.0
	 * Author: Tamkeen Team
	 * Author URI: http://www.tamkeentms.com
	 */

	const TAMKEEN_DEV_MODE = false;

	/**
	 * Initiation
	 */
	function tamkeen_init(){
		session_start();
	}

	add_action('init', 'tamkeen_init', 1);
	add_action('admin_init', 'tamkeen_admin_init');
	add_action('admin_menu', 'tamkeen_admin_menu');
	add_action('wp_enqueue_scripts', 'tamkeen_ui_assets');

	/**
	 * Register settings
	 */
	function tamkeen_admin_init(){
		add_settings_section('tamkeen_settings', null, null, 'tamkeen');

		// API Base url
		add_settings_field('tamkeen_base_url', 'Tamkeen service base Url', function(){
			print '<input name="tamkeen_base_url" value="' . get_option('tamkeen_base_url') . '" size="40" />';

		}, 'tamkeen', 'tamkeen_settings');

		// API Tenant
		add_settings_field('tamkeen_tenant_id', 'API tenant id', function(){
			print '<input name="tamkeen_tenant_id" value="' . get_option('tamkeen_tenant_id') . '" size="20" />';

		}, 'tamkeen', 'tamkeen_settings');

		// API secret
		add_settings_field('tamkeen_api_key', 'API secret key', function(){
			print '<input name="tamkeen_api_key" value="' . get_option('tamkeen_api_key') . '" size="40" />';

		}, 'tamkeen', 'tamkeen_settings');

		// Locale
		add_settings_field('tamkeen_locale', 'Display locale', function(){
			$locale = get_option('tamkeen_locale');

			print '<select name="tamkeen_locale">
				<option value="en" ' . ($locale == 'en' ?'selected' :'') . '>English</option>
				<option value="ar" ' . ($locale == 'ar' ?'selected' :'') . '>Arabic</option>
			</select>';

		}, 'tamkeen', 'tamkeen_settings');

		// Num categories per page
		add_settings_field('tamkeen_grid_items_per_row', 'Num. thumbnails per row', function(){
			print '<input name="tamkeen_grid_items_per_row" value="' . get_option('tamkeen_grid_items_per_row') . '" size="10" />';

		}, 'tamkeen', 'tamkeen_settings');

		register_setting('tamkeen', 'tamkeen_base_url');
		register_setting('tamkeen', 'tamkeen_tenant_id');
		register_setting('tamkeen', 'tamkeen_api_key');
		register_setting('tamkeen', 'tamkeen_locale');
		register_setting('tamkeen', 'tamkeen_grid_items_per_row');
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
		wp_register_script('jquery', 'https://code.jquery.com/jquery-3.6.0.min.js');
		wp_register_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js');

		wp_register_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
		wp_register_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css');

		wp_enqueue_script('jquery');
		wp_enqueue_script('bootstrap');

		wp_enqueue_style('bootstrap');
		wp_enqueue_style('bootstrap-icons');
	}

	//////////////////////////////////////////////////////////////////////////////////////////
	//
	//  Utils
	//
	//////////////////////////////////////////////////////////////////////////////////////////

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
		ob_start();

		extract($data, EXTR_OVERWRITE);
		include tamkeen_get_path("views/layout/before.php");
		include tamkeen_get_path("views/{$view}.php");
		include tamkeen_get_path("views/layout/after.php");
		ob_end_flush();

		return ob_get_contents();
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
	 * @param       $method
	 * @param       $path
	 * @param array $params
	 * @param array $data
	 *
	 * @return mixed
	 */
	function tamkeen_api_request($method, $path, array $params = [], array $data = []){
		$curl = curl_init();

		// API access
		$baseUrl = get_option('tamkeen_base_url');
		$tenantId = get_option('tamkeen_tenant_id');
		$apiKey = get_option('tamkeen_api_key');
		$locale = get_option('tamkeen_locale');

		// Url and params
		$params['locale'] = $locale;
		$url = $baseUrl . '/api/v1/' . $path . '?' . http_build_query($params);

		// The method
		$method = strtoupper($method);

		curl_setopt_array($curl, [
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => $method,
			CURLOPT_HTTPHEADER => [
				"Authorization: Bearer " . $apiKey,
				"X-Tenant: " . $tenantId,
				"Content-Type: application/json"
			]
		]);

		// POST method?
		if($method === 'POST'){
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}

		// Skip SSL verification?
		if(TAMKEEN_DEV_MODE){
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		}

		$response = curl_exec($curl);
		$error = curl_error($curl);

		curl_close($curl);

		if($error){
			throw new \Exception($error);

		}else{
			return json_decode($response);
		}
	}

	/**
	 * @param $key
	 * @param $ar
	 * @return mixed
	 */
	function tamkeen_trans($key, $default = null){
		static $locale, $keys;

		if(!$locale){
			$locale = get_option('tamkeen_locale');
		}

		if(!$keys){
			$keys = include_once tamkeen_get_path("translation/{$locale}.php");
		}

		if(strpos($key, '.') === false){
			return $keys[$key] ?? value($default);
		}

		$translation = $keys;
		foreach(explode('.', $key) as $segment){
			if(array_key_exists($segment, $translation)){
				$translation = $translation[$segment];

			}else{
				return $default;
			}
		}

		return $translation;
	}

	/**
	 * Dump
	 */
	function tamkeen_dd(){
		var_dump(func_get_args());
		exit;
	}

	/**
	 * @param string $path
	 *
	 * @return string
	 */
	function tamkeen_url($path = ''){
		return get_page_link() . $path;
	}

	/**
	 * @param $type
	 * @param $text
	 *
	 * @return string
	 */
	function tamkeen_alert($type, $text){
		return '<div class="alert alert-' . $type  . '">
			<i class="bi bi-info-circle-fill"></i> ' . $text . '</div>';
	}

	/**
	 * @param $url
	 */
	function tamkeen_redirect($url){
		if($url === 'back'){
			$url = $_SERVER['HTTP_REFERER'];
		}

		if(!empty($url)){
			print '<script>location.href = "' . $url . '";</script>';
			exit;
		}
	}

	//////////////////////////////////////////////////////////////////////////////////////////
	//
	//  Short codes
	//
	//////////////////////////////////////////////////////////////////////////////////////////
	add_shortcode('tamkeen_courses_catalog', function($attrs, $content, $tag) use($api){
		return include_once tamkeen_get_path('courses.php');
	});
