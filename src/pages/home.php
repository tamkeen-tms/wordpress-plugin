<?php

	$branchId = isset($_GET['branch']) ?$_GET['branch'] :null;

	// Get the home page's data
	$data = tamkeen_api_request('get', 'plugins/wordPress/home');

	// Render the view
	return tamkeen_render_view('home', [
		'branchId' => $branchId,
		'branches' => $data->branches,
		'categories' => $data->categories
	]);
