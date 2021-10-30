<?php

    try{
        // The page to view
        $page = isset($_GET['view']) ?$_GET['view'] :null;

        switch($page){
            case 'cart-add':
                if(!isset($_SESSION['tamkeen-cart'])){
                    $_SESSION['tamkeen-cart'] = [];
                }

                if(isset($_GET['courseId']) && is_numeric($_GET['courseId'])){
                    // Add the course id
                    $_SESSION['tamkeen-cart'][] = $_GET['courseId'];

                    // Remove duplicates
                    $_SESSION['tamkeen-cart'] = array_unique($_SESSION['tamkeen-cart']);
                }

                return tamkeen_render_view('cart/add.blade.php', [
                    'requestUrl' => tamkeen_url('?view=cart-request')
                ]);
                break;

            case 'cart-remove':
                // Remove the course from the session
                $courseIndex = array_search($_GET['courseId'], $_SESSION['tamkeen-cart']);

                // If the course is on the session array
                if($courseIndex !== false && isset($_SESSION['tamkeen-cart'][$courseIndex])){
                    // Remove it
                    unset($_SESSION['tamkeen-cart'][$courseIndex]);
                }

                tamkeen_redirect('back');
                break;

            case 'cart-empty':
                // Clear the cart's content
                $_SESSION['tamkeen-cart'] = [];

                tamkeen_redirect('back');
                break;

            case 'cart-request':
                $itemIds = $_SESSION['tamkeen-cart'];

                if(!count($itemIds)){
                    tamkeen_display_error('No courses were selected!');
                }

                // Get the cart id
                $response = tamkeen_api_request('post', 'plugins/wordPress/cart/save', [
                    'courseIds' => $itemIds
                ]);

                if(!isset($response->cartId)){
                    tamkeen_display_error('Failed to proceed with the request process; unable to save your cart.');
                }

                // Create the request submission url
                $requestUrl = get_option('tamkeen_base_url') . '/service/' .
                    get_option('tamkeen_tenant_id') . '/redirects/plugins/wordPress/request?cartId=' . $response->cartId;

                tamkeen_redirect($requestUrl);
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
