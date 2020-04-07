<?php

    $_view = isset($_GET['view']) ?$_GET['view'] :null;
    $_pageUrl = get_page_link();

    function tamkeen_url($path = ''){
        return $_pageUrl . $path;
    }

    function tamkeen_get_course_url($course){
        return tamkeen_url('?view=course&course=' . $course->id);
    }

    switch($_view){
        //////////////////////////////////////////////////////////////////////////////////////////
        //
        //  Courses list
        //
        //////////////////////////////////////////////////////////////////////////////////////////
        case 'courses':
            try{
                $branchId = isset($_GET['branch']) ?$_GET['branch'] :null;
                $categoryId = isset($_GET['category']) ?$_GET['category'] :null;

                if(empty($branchId) || empty($categoryId)){
                    return tamkeen_display_error('No branch and/or category selected. Please go back to the courses list.');
                }

                // Get the courses list
                $response = $api->request('get', "courses", ['branch' => $branchId, 'category' => $categoryId])
                    ->send();

                return tamkeen_render_view('courses.list', [
                    'branch' => $response->branch,
                    'category' => $response->category,
                    'courses' => $response->courses
                ]);

            }catch (Exception $e){
                return tamkeen_display_error($e);
            }
            break;

        //////////////////////////////////////////////////////////////////////////////////////////
        //
        //  Course view
        //
        //////////////////////////////////////////////////////////////////////////////////////////
        case 'course':
            try{
                $courseId = isset($_GET['course']) ?$_GET['course'] :null;

                // If the course is not found
                if(empty($courseId)){
                    return tamkeen_display_error(new Exception('No course was selected! Make sure you visited the correct URL address.'));
                }

                // Get the courses list
                $response = $api->request('get', "courses/$courseId")
                    ->send();

                // If the course wasn't found
                if(!$response->course){
                    return tamkeen_display_error('Sorry, but it seems that the request course does not exist!');
                }

                return tamkeen_render_view('courses.course.view', [
                    'course' => $response->course
                ]);

            }catch (Exception $e){
                return tamkeen_display_error($e);
            }
            break;

        //////////////////////////////////////////////////////////////////////////////////////////
        //
        //  Signup view
        //
        //////////////////////////////////////////////////////////////////////////////////////////
        case 'signup':
            try{
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
                if(!empty($_POST)){
                    // Submit the data
                    $response = $api->request('post', 'courses/signup', $_POST)->send();

                    $signupSuccessful = $response->message == 'success';
                    $signupErrors = $response->errors;
                }

                return tamkeen_render_view('courses.course.signup', [
                    'course' => $response->course,
                    'signupErrors' => $signupErrors,
                    'signupSuccessful' => $signupSuccessful
                ]);

            }catch (Exception $e){
                return tamkeen_display_error($e);
            }
            break;

        //////////////////////////////////////////////////////////////////////////////////////////
        //
        //  Home
        //
        //////////////////////////////////////////////////////////////////////////////////////////
        default:
            try{
                // Get the categories list, grouped by branch
                $response = $api->request('get', 'courses/categories')
                    ->send();

                // Find the selected branch (via the url)
                $selectedBranch = null;
                if(isset($_GET['branch'])){
                    foreach($response->categories as $branchId => $branch){
                        if($branchId == $_GET['branch']){
                            $selectedBranch = $branch->branch;
                            break;
                        }
                    }
                }

                return tamkeen_render_view('courses.home', [
                    'categories' => $response->categories,
                    'selectedBranch' => $selectedBranch
                ]);

            }catch (Exception $e){
                return tamkeen_display_error($e);
            }

            break;
    }