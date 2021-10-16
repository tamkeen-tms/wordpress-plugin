<?php

	// The website course id
	$courseId = isset($_GET['course']) ?$_GET['course'] :null;

	// If the course is not found
	if(empty($courseId)){
		return tamkeen_display_error('No course was selected! Make sure you visited the correct URL address.');
	}

	// Get the courses list
	$response = $api->request('get', "courses/$courseId")
		->send();

	if(!$response->course){
		return tamkeen_display_error('Sorry, but it seems that the request course does not exist!');
	}

	// Form was submitted?
	$signupSuccessful = null;
	$signupErrors = null;
	if(
		isset($_POST['course_signup_form']) &&
		$_POST['course_signup_form'] == 'true'
	){
		// Verify the reCaptcha
		$reCaptcha = new \ReCaptcha\ReCaptcha(get_option('tamkeen_recaptcha_secret'));

		// Run the verification
		$reCaptchaVerification = $reCaptcha->verify($_POST['g-recaptcha-response']);

		// Success?
		if($reCaptchaVerification->isSuccess()){
			// Submit the data
			$signupResponse = $api->request('post', 'courses/signup', [
				'course_id'     => $response->course->id, // Website course id
				'name'          => $_POST['tamkeen_name'],
				'phone_number'  => $_POST['tamkeen_phone_number'],
				'email'         => $_POST['tamkeen_email'],
				'job_title'     => $_POST['tamkeen_job_title'],
				'note'          => $_POST['tamkeen_note']

			])->send();

			$signupSuccessful = $signupResponse->message == 'success';
			if(is_array($signupResponse->errors)){
				$signupErrors = $signupResponse->errors;

			}elseif(!$signupSuccessful){
				$signupErrors = [
					'Failed to submit your request! Please try again later.'
				];
			}

			if($signupSuccessful){
				$_POST = []; // Clear the POST contents
			}

		}else{
			$signupErrors = [
				'ReCaptcha check failed! Make sure to check the "I am not a robot" box below the form.'
			];
		}
	}

	return tamkeen_render_view('courses.course.signup', [
		'course' => $response->course,
		'signupErrors' => $signupErrors,
		'signupSuccessful' => $signupSuccessful
	]);
