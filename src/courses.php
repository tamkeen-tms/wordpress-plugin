<?php

    try{
        // The page to view
        $page = isset($_GET['view']) ?$_GET['view'] :null;

        switch($page){
            case 'cart-add':
                if(!isset($_SESSION['tamkeen-cart-items'])){
                    $_SESSION['tamkeen-cart-items'] = [];
                }

                if(isset($_GET['courseId']) && is_numeric($_GET['courseId'])){
                    // Add the course id
                    $_SESSION['tamkeen-cart-items'][] = $_GET['courseId'];

                    // Remove duplicates
                    $_SESSION['tamkeen-cart-items'] = array_unique($_SESSION['tamkeen-cart-items']);
                }

                // Create the request submission url
                $requestUrl = get_option('tamkeen_base_url') . '/service/' .
                    get_option('tamkeen_tenant_id') . '/redirects/plugins/wordPress/request?' .
                    'courseIds=' . implode(',', $_SESSION['tamkeen-cart-items']);

                return tamkeen_render_view('cart/add.blade.php', [
                    'requestUrl' => $requestUrl
                ]);
                break;

            case 'cart-remove':
                // Remove the course from the session
                $courseIndex = array_search($_GET['courseId'], $_SESSION['tamkeen-cart-items']);

                // If the course is on the session array
                if($courseIndex !== false && isset($_SESSION['tamkeen-cart-items'][$courseIndex])){
                    // Remove it
                    unset($_SESSION['tamkeen-cart-items'][$courseIndex]);
                }

                tamkeen_redirect('back');
                break;

            case 'category':
                return include tamkeen_get_path('pages/courses/category.php');
                break;

            case 'course':
                return include tamkeen_get_path('pages/courses/course.php');
                break;

            case 'signup':
                return include tamkeen_get_path('pages/courses/request.php');
                break;

            default:
                return include tamkeen_get_path('pages/home.php');
                break;
        }

    }catch (Exception $e){
        return tamkeen_display_error($e);
    }
