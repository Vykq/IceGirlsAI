<?php
require_once('create-post.php');
function createSlug($str, $delimiter = '-'){
    $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
    return $slug;
}


function getModelName($model) {
    $args = array(
        'post_type' => 'checkpoints',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    );
    $cpName = "";
    $models = new WP_Query($args);
    if($models->have_posts()) :
        while($models->have_posts()):
            $models->the_post();
            if($model == get_field('real_checkpoint_name')) :
                $cpName = get_the_title();
            endif;
        endwhile;
    endif;
    wp_reset_query();
    return $cpName;
}

//favorite posts array
function favorite_id_array() {
    if (!empty( $_COOKIE['liked_post_ids'])) {
        return explode(',', $_COOKIE['liked_post_ids']);
    }
    else {
        return array();
    }
}



add_action('wp_ajax_nopriv_like_image', 'web_like_image');
add_action('wp_ajax_like_image', 'web_like_image');
function web_like_image() {
    $response = array(); // Create an array to hold the response data
    if (isset($_POST['action']) && $_POST['action'] === 'like_image') {
        $post_id = $_POST['postID'];
        if (!empty($post_id)) {
            $new_post_id = array(
                $post_id
            );
            $post_ids = array_merge($new_post_id, favorite_id_array());
            $post_ids = array_diff($post_ids, array(
                ''
            ));
            $post_ids = array_unique($post_ids);
            setcookie('liked_post_ids', implode(',', $post_ids) , time() + 3600 * 24 * 365, '/');
            $currentCount = get_field('like_count', $post_id);
            update_field('like_count', $currentCount+1,$post_id);
            $response['status'] = 'success';
            $response['count'] = $currentCount+1;
        }
    } else {
        $response['error'] = 'Error';
    }

    wp_send_json($response);
    die();
}

add_action('wp_ajax_unlike_image', 'unlike_image');
add_action('wp_ajax_nopriv_unlike_image', 'unlike_image');
function unlike_image() {
    $post_id = (int)$_POST['postID'];
    if (!empty($post_id)) {
        $favorite_id_array = favorite_id_array();
        if (($delete_post_id = array_search($post_id, $favorite_id_array)) !== false) {
            unset($favorite_id_array[$delete_post_id]);
            $currentCount = get_field('like_count', $post_id);
            update_field('like_count', $currentCount-1,$post_id);
        }
        setcookie('liked_post_ids', implode(',', $favorite_id_array) , time() + 3600 * 24 * 30, '/');
    }
    $response['status'] = 'success';
    $response['count'] = $currentCount-1;
    wp_send_json($response);
    die();
}


function redirect_to_profile() {
    $redirect_to = get_option('home') . '/account/';
    return $redirect_to;
}
add_filter('login_redirect', 'redirect_to_profile');



