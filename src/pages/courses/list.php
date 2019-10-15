<?php

	switch(@$_GET['view']){
		//
		//
		//
		case 'branch':
			$branchId = $_GET['branch'];

			$request = TamkeenLMSAPI\Client::makeRequest('courses/categories', ['branch' => $branchId]);
			$response = $request->send();

			if(!isset($response->categories) || empty($response->categories)){
				print 'No courses yet available!';

			}else{
				$categories = $response->categories;
				include "list/categories.php";
			}

			break;

		//
		//
		//
		case 'category':
			break;

		//
		//
		//
		case 'course':
			break;

		//
		// Home
		//
		default:
			$request = new TamkeenLMSAPI\Requests\Branches();
			$response = $request->get();

			// Error?
			if(!isset($response->branches)){
				print 'Page not available now!';

			}else{
				$branches = $response->branches;
				include "list/branches.php";
			}

			break;
	}