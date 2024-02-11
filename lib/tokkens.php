<?php


function setTokkensForUser($user_login, $user) {
    $user_id = $user->ID;
    if (!in_array('premium', (array)$user->roles)) {
        if (!get_field('tokkens_set', 'user_' . $user_id)) {
            update_field('tokkens_set', 1, 'user_' . $user_id);
            update_field('tokens', 10, 'user_' . $user_id);
        }
    } else {
        update_field('tokkens_set', 1, 'user_' . $user_id);
        update_field('tokens', 9999, 'user_' . $user_id);
    }

}
add_action('wp_login', 'setTokkensForUser', 10, 2);


function setTokensForRegisterUser($user_id) {
    $user = get_userdata($user_id);
    if (!in_array('premium', (array) $user->roles)) {
        update_field('tokens', 10, 'user_' . $user_id);
    } else {
        update_field('tokens', 9999, 'user_' . $user_id);
    }
    update_field('tokkens_set', 1, 'user_' . $user_id);
}

add_action('user_register', 'setTokensForRegisterUser', 10, 1);
add_action('rtcamp.google_user_created', 'setTokensForRegisterUser', 10, 1);




add_action('wp_ajax_nopriv_tokkens_left_for_user', 'tokkens_left_for_user');
add_action('wp_ajax_tokkens_left_for_user', 'tokkens_left_for_user');

function tokkens_left_for_user(){
    $response = array();
    $user = wp_get_current_user();
    $user_id = $user->ID;
    $tokkens = get_field('tokens','user_' . $user_id);

    $response['tokkens'] = $tokkens;
    wp_send_json($response);
    wp_die();
}


add_action('wp_ajax_nopriv_tokkens_used', 'tokkens_used');
add_action('wp_ajax_tokkens_used', 'tokkens_used');

function tokkens_used(){
    $response = array();
    $user = wp_get_current_user();
    $user_id = $user->ID;
    if (!in_array('premium', (array)$user->roles)) {
        $tokkens = get_field('tokens','user_' . $user_id);
        $newTokkens = $tokkens - 1;
        update_field('tokens', $newTokkens, 'user_' . $user_id);
        $response['tokkens'] = $newTokkens;
    } else {
        $response['tokkens'] = 9999;
    }
    wp_send_json($response);
    wp_die();
}




add_action('wp_ajax_nopriv_tokkens_back', 'tokkens_back');
add_action('wp_ajax_tokkens_back', 'tokkens_back');

function tokkens_back(){
    $response = array();
    $user = wp_get_current_user();
    $user_id = $user->ID;
    if (!in_array('premium', (array)$user->roles)) {
        $tokkens = get_field('tokens', 'user_' . $user_id);
        $newTokkens = $tokkens + 1;
        update_field('tokens', $newTokkens, 'user_' . $user_id);
        $response['tokkens'] = $newTokkens;
    } else {
        $response['tokkens'] = 9999;
    }
    wp_send_json($response);
    wp_die();
}

//
//
//
//update tokens every day
if (!wp_next_scheduled('daily_tokens_update')) {
    wp_schedule_event(time(), 'daily', 'daily_tokens_update');
}

// Hook the function to the scheduled event
add_action('daily_tokens_update', 'update_tokens_daily');

// Define the function to update tokens
function update_tokens_daily() {
    // Get all user IDs excluding users with the 'premium' role
    $user_ids = get_users(array(
        'fields' => 'ID',
        'role__not_in' => array('premium'),
    ));

    // Loop through each user and update the 'tokens' field
    foreach ($user_ids as $user_id) {
        update_field('tokens', 10, 'user_' . $user_id);
    }
}