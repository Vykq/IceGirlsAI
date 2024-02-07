<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/wp-load.php");

$response = array();
$title = $_POST['face-title'];
$image = $_FILES['uploading-face'];


$userID = get_current_user_id();
$userPostsCount = count_user_posts($userID, 'faces');

if ($userPostsCount >= 10) {
    // If user has more than 10 posts, delete the oldest post
    $args = array(
        'author'         => $userID,
        'post_type'      => 'faces', // Change this to your custom post type if needed
        'posts_per_page' => 1,
        'orderby'        => 'date',
        'order'          => 'ASC',
    );

    $user_posts = get_posts($args);

    if ($user_posts) {
        foreach ($user_posts as $post) {
            wp_delete_post($post->ID, true);
        }
    }
}

$post_data = array(
    'post_title'   => $title,
    'post_status'  => 'publish',
    'post_type'    => 'faces', // Change this to your custom post type if needed
    'post_author'  => $userID,
);

// Insert the post and get the post ID
$post_id = wp_insert_post($post_data);
$response['postid'] = $post_id;
$upload = wp_upload_bits($image['name'], null, file_get_contents($image['tmp_name']));

if (!$upload['error']) {
    $file_path = $upload['file'];

    // Set the post thumbnail
    $attachment_id = wp_insert_attachment(array(
        'post_mime_type' => $upload['type'],
        'post_title'     => $title,
        'post_content'   => '',
        'post_status'    => 'inherit',
    ), $file_path, $post_id);

    if (!is_wp_error($attachment_id)) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');

        // Set the post thumbnail
        set_post_thumbnail($post_id, $attachment_id);

        $base64_image = base64_encode(file_get_contents($image['tmp_name']));

        // Update the ACF field with the base64 data
        update_field('base64_image', $base64_image, $post_id);
    } else {
        echo "Error setting post thumbnail: " . $attachment_id->get_error_message();
    }
} else {
    echo "Error uploading file: " . $upload['error'];
}

wp_send_json($response);
wp_die();