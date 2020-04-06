<?php

	switch(@$_GET['view']){
		// Courses list
		case 'courses':
			try{
				$branchId = $_GET['branch'];
				$categoryId = $_GET['category'];

				// Get the courses list
				$response = $api->request('get', "courses", ['branchId' => $branchId, 'categoryId' => $categoryId])
					->send();

				dd($response);

				return tamkeen_render_view('courses', [
					'courses' => $response->courses
				]);

			}catch (Exception $e){
				return tamkeen_display_error($e);
			}

			break;

		default:
			try{
				// Get the categories list
				$response = $api->request('get', 'courses/categories')
						->send();

				// Find the selected branch
				$selectedBranch = null;
				if(isset($_GET['branch'])){
					foreach($response->categories as $branchId => $branch){
						if($branchId == $_GET['branch']){
							$selectedBranch = $branch->branch;
							break;
						}
					}
				}

				return tamkeen_render_view('categories', [
					'categories' => $response->categories,
					'selectedBranch' => $selectedBranch
				]);

			}catch (Exception $e){
				return tamkeen_display_error($e);
			}

			break;
	}