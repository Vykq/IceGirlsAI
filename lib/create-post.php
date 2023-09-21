<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/wp-load.php");

if ( ! function_exists( 'wp_handle_upload' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once(ABSPATH . 'wp-admin/includes/image.php');
}

add_action('wp_ajax_nopriv_create_generated_post', 'create_generated_post');
add_action('wp_ajax_create_generated_post', 'create_generated_post');
function create_generated_post() {
    $response = array(); // Create an array to hold the response data
    if (isset($_POST['action']) && $_POST['action'] === 'create_generated_post') {
            if ($_POST['image'] && $_POST['infoText']) {
                $imageData = $_POST['image'];
                $infoText = $_POST['infoText'];
                $current_user = wp_get_current_user();
                $post_id = wp_insert_post(array(
                    'post_title' => 'Generated Image Post',
                    'post_type' => 'generated-images',
                    'post_status' => 'publish',
                    'post_author' => $current_user
                ));

                if ($post_id) {
                    $pattern = '/(.+?)\s*<lora:/';
                    preg_match($pattern, $infoText, $matches);
                    $prompt = trim($matches[1]);

                    // Step 2: Extract loras
                    $loras = array();
                    $pattern = '/<lora:(\w+):([^>]+)>/';
                    preg_match_all($pattern, $infoText, $matches, PREG_SET_ORDER);
                    foreach ($matches as $match) {
                        $loras[$match[1]] = $match[2];
                    }
                    print_r($loras);
                    // Step 3: Extract info
                    $pattern = '/<lora:.*?<\/lora>/';
                    $infoText = preg_replace($pattern, '', $infoText);
                    $infoText = str_replace("\n", '', $infoText);
                    $pattern = '/(\w+):\s*([^,]+)/';
                    preg_match_all($pattern, $infoText, $matches, PREG_SET_ORDER);
                    $info = array();
                    foreach ($matches as $match) {
                        $info[$match[1]] = trim($match[2]);
                    }

                    // Set the uploaded image as the post's featured image/thumbnail

                    update_field('prompt', $prompt, $post_id);
                    update_field('size', $info['Size'], $post_id);
                    update_field('model', $info['Model'], $post_id);
                    update_field('sampler', $info['Sampler'], $post_id);
                    update_field('details', $loras['more_details'], $post_id);
                    update_field('task_id', $_POST['task-id'], $post_id);
                    update_field('like_count', '0', $post_id);
                    $response['success'] = 'post created';
                }

                $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
                $upload = wp_upload_bits('generated_image.png', null, $decodedImage);
                if ($upload['error'] == false) {
                    // Add the uploaded image to the media library
                    $file_path = $upload['file'];
                    $file_name = basename($file_path);
                    $attachment = array(
                        'post_mime_type' => 'image/png', // Adjust mime type accordingly
                        'post_title'     => 'Generated Image', // Adjust title
                        'post_content'   => '',
                        'post_status'    => 'inherit'
                    );
                    $attach_id = wp_insert_attachment($attachment, $file_path);

                    $attach_data = wp_generate_attachment_metadata($attach_id, $file_path);
                    wp_update_attachment_metadata($attach_id, $attach_data);
                    set_post_thumbnail($post_id, $attach_id);
                } else {
                    // Error uploading image
                    $response['error'] = 'Error uploading image';
                }
            }

    } else {
        $response['error'] = 'Error';
    }
    $response['status'] = 'yey';
    wp_send_json($response);
    die();
}
