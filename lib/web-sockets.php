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
