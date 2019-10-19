<?php

	switch(@$_GET['view']){
		//
		//
		//
		case 'branch':
			$branchId = $_GET['branch'];

			$response = $api->request('get', 'courses/categories', ['branch' => $branchId])
				->send();

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
			$response = $api->request('get', 'branches')->send();

			// Error?
			if(!isset($response->branches)){
				print 'Page not available now!';

			}else{
				$branches = $response->branches;
				include "list/branches.php";
			}

			break;
	}