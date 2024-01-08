<?php

add_action( 'rest_api_init', function () {
    register_rest_route( 'mycustom/v1', '/exchange-ids/', array(
        'methods' => 'GET',
        'callback' => 'exchangeIDs',
        'args' => array(
            'email' => array(
                'required' => true,
                'validate_callback' => function($param, $request, $key) {
                    return is_email($param);
                }
            ),
        ),
    ) );
});

function exchangeIDs( $data ) {
    $email = $data['email'];
    $subID = $data['subscription-id'];
    $user = get_user_by( 'email', $email );
    $userID = '';
    if ( $user ) {
        $userID = $user->ID;
        update_field('subscription_id', $subID, 'user_' . $userID);
        return new WP_REST_Response( array('user_id' => $userID), 200 );
    } else {
        return new WP_Error( 'no_user', 'Invalid email', array( 'status' => 404 ) );
    }
}


// Add a custom REST API endpoint
add_action('rest_api_init', 'register_custom_route');

function register_custom_route() {
    register_rest_route( 'mycustom/v1', '/task_done/', array(
        'methods'  => 'POST',
        'callback' => 'handle_task_completed_request',
    ));
}

// Callback function to handle the incoming request
function handle_task_completed_request(WP_REST_Request $request) {
    // Get data from the request
    $task_id = $request->get_param('task_id');
    $status = $request->get_param('status');
    $files = $request->get_param('files');

    $post_id = wp_insert_post(array(
        'post_title' => $task_id,
        'post_type' => 'test',
        'post_status' => 'publish',
    ));

    error_log("Custom debug message: " . print_r($request, true));
//    if($post_id){
//        update_field('status', $status, $post_id);
//        foreach ($files as $index => $file) {
//            update_field('image', $file['base64data'], $post_id);
//        }
//
//    }

    // Process the data as needed
    // For example, save the information to a custom post type or perform other actions

    // Return a response (optional)
    return new WP_REST_Response(array('message' => 'Request received successfully'), 200);
}