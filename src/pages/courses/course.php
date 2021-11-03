<?php

	$courseId = isset($_GET['id']) ?sanitize_text_field($_GET['id']) :null;

	// If the course is not found
	if(empty($courseId)){
		throw new Exception('No course was selected! Make sure you visited the correct URL address.');
	}

	// Get the courses list
	try{
		$data = tamkeen_api_request('get', "plugins/wordPress/courses/$courseId");
	}catch (Exception $e){}

	// If the course wasn't found
	if(!$data->course){
		return tamkeen_display_error('Sorry, but it seems that the requested course does not exist or not currently published to the catalog!');
	}

	return tamkeen_render_view('courses/course', [
		'branch' => $data->branch,
		'category' => $data->category,
		'course' => $data->course
	]);