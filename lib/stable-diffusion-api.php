<?php
add_action('wp_ajax_nopriv_generate_image', 'sd_generate_image');
add_action('wp_ajax_generate_image', 'sd_generate_image');

function sd_generate_image() {
    $return = array();
    $user = wp_get_current_user();
    if ( wp_verify_nonce( $_POST['generation'], 'generation' )) {
        $return['success'] = false;
        wp_send_json($return);
        exit;
    } else {
        $return['success'] = true;
        // Check if the user has the "premium_access" capability
        if(in_array( 'premium', (array) $user->roles)) {
            $return['premium'] = true;
            $post_id = wp_insert_post(array(
                'post_title'    => $_POST['taskID'],
                'post_status'   => 'publish',
                'post_author'   => $user->id,
                'post_type' => 'taskids'
            ));

        } else {
            $return['premium'] = false;
        }

        wp_send_json($return);
    }

    exit;
}


add_action('wp_ajax_nopriv_premium_tasks', 'sd_premium_tasks');
add_action('wp_ajax_premium_tasks', 'sd_premium_tasks');

function sd_premium_tasks(){
    $return['status'] = true;

    $taskID = $_POST['taskID'];
    $pendingTaskIds = $_POST['pendingTaskIds'];
    $pendingTaskIdsArray = explode(',', $pendingTaskIds);

    $args = array(
        'post_type' => 'taskids',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    );

    $posts = new WP_Query($args);
    $matchingTaskIds = array();

    if ($posts->have_posts()) {
        while ($posts->have_posts()) :
            $posts->the_post();
            $postTitle = get_the_title();
            if (in_array($postTitle, $pendingTaskIdsArray)) {
                $matchingTaskIds[] = $postTitle; // Add matching task ID to the array
            }
        endwhile;
    }
    $matchingTaskIds[] = $taskID; //here the aray is grayed out

    $return['position'] = count($matchingTaskIds);

    wp_send_json($return); // Send the JSON response
    exit;
}