<?php

	$categoryId = isset($_GET['id']) ?$_GET['id'] :null;

	if(empty($categoryId)){
		return tamkeen_display_error('No category was selected. Please go back and pick a category to view the courses below it');
	}

	// Get the courses list
	$data = tamkeen_api_request('get', 'plugins/wordPress/courses/categories/' . $categoryId);

	if(isset($data->error)){
		// An error e.g the category was not found, or not published to the catalog
		if($data->error == 'not_found'){
			throw new Exception('Sorry, the category you have selected does not exist, or not currently published to the catalog!');
		}

		throw new Exception($data->error);
	}

	return tamkeen_render_view('courses.category', [
		'branch' => $data->branch,
		'category' => $data->category,
		'courses' => $data->courses
	]);
