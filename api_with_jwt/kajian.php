<?php 
    // Turn off all error reporting
    // error_reporting(0);

    require_once "../functions.php";
    require_once "helper.php";

    $request_method = $_SERVER['REQUEST_METHOD'];

    switch($request_method)
    {
        case 'GET':
            api_get_kajian();
            break;

        case 'POST':
            api_post_kajian();
            break;

        case 'DELETE':  
            api_delete_kajian();
            break;

        case 'PUT':
            api_put_post();
            break;

        default:

        $respon = array(
            'status' => FALSE,
            'message' => "Not Found",
            'data' => array()
        );
        echo response($respon, 404);
        break;
    }