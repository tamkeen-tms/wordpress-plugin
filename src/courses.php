<?php

    try{
        // The page to view
        $_view = isset($_GET['view']) ?$_GET['view'] :null;

        switch($_view){
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
