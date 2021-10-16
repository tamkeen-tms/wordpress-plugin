<?php

	$courseId = isset($_GET['id']) ?$_GET['id'] :null;

	// If the course is not found
	if(empty($courseId)){
		throw new Exception('No course was selected! Make sure you visited the correct URL address.');
	}

	// Get the courses list
	$data = tamkeen_api_request('get', "plugins/wordPress/courses/$courseId");

	// If the course wasn't found
	if(!$data->course){
		return tamkeen_display_error('Sorry, but it seems that the request course does not exist!');
	}

	return tamkeen_render_view('courses.course', [
		'course' => $data->course
	]);