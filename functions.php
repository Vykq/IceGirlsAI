<?php
require_once('lib/add_functions.php');
require_once('lib/stable-diffusion-api.php');
require_once('lib/free-premium.php');
require_once('vendor/autoload.php');
function webpack_files() {
    wp_enqueue_script('webpack-js', get_theme_file_uri('assets/app.js'), array(), '3.1v', true);
    //wp_enqueue_script('gsap', get_theme_file_uri('assets/gsap.min.js'), array(), time(), true);
    //wp_enqueue_script('ScrollTrigger', get_theme_file_uri('assets/ScrollTrigger.min.js'), array(), time(), true);
    //wp_enqueue_script('lenis', get_theme_file_uri('assets/lenis.min.js'), array(), time(), true);
    //wp_enqueue_script('imagesloaded', get_theme_file_uri('assets/imagesloaded.pkgd.min.js'), array(), time(), true);
    wp_enqueue_style('webpack-styles', get_theme_file_uri('assets/style.css'), array(), '3.1v');
    wp_enqueue_script('masonry-js', get_theme_file_uri('assets/minimasonry.min.js'), array(), '1', true);
    wp_enqueue_script('splide-js', get_theme_file_uri('assets/splide.min.js'), array(), '4.1.3', true);
    wp_enqueue_style('splide-styles', get_theme_file_uri('assets/splide.min.css'), array(), '4.1.3');
    wp_localize_script( 'webpack-js', 'themeUrl',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce( 'wp-smart-sign-nonce' ),
            'themeUrl' => get_theme_file_uri(),
            'apiUrl' => get_field('api_ip','api'),
            'apiUrlFree' => get_field('api_ip_free','api'),
            'url_empty' => "Your URL field is empty, enter an URL.",
            'loading' => "Loading...",
            'success' => "Thank you! We got your submition.",
            'failure' => "Something went wrong... Try again.",
            'info_empty' => "Explain your removal reasons.",
            'msg_empty' => "Enter your message.",
            'mail_empty' => 'Your email field is empty',
            'mail_error' => 'Enter the correct email address',
            'type_value' => 'Select Support type',
            'empty_reason' => 'Select support type',
        )
    );

//    wp_enqueue_script('splide-js', get_theme_file_uri('assets/splide.min.js'), array(), '4.1.4', true);
//    wp_enqueue_style('splide-styles', get_theme_file_uri('assets/splide.min.css'), array(), '4.1.4');

}
add_action('wp_enqueue_scripts', 'webpack_files');


add_filter( 'oembed_response_data', 'disable_embeds_filter_oembed_response_data_' );
function disable_embeds_filter_oembed_response_data_( $data ) {
    unset($data['author_url']);
    unset($data['author_name']);
    return $data;
}

/**
 * Theme support
 */
function theme_features() {
    load_theme_textdomain( 'expertmedia', get_template_directory() . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'hub-all', 300, 500 );
}

add_action('after_setup_theme', 'theme_features');



if( function_exists('acf_add_options_page') ) {

    $parent = acf_add_options_page(array(
        'page_title' 	=> 'Form Settings',
        'menu_title'	=> 'Form Settings',
        'menu_slug' 	=> 'create-form-settings',
        'capability'	=> 'edit_posts',
        'post_id' => 'form',
        'position'      =>  -1,
        'redirect'		=> false
    ));

    $child = acf_add_options_page(array(
        'page_title' 	=> 'Main Settings',
        'menu_title'	=> 'Main Settings',
        'menu_slug' 	=> 'api-form-settings',
        'capability'	=> 'edit_posts',
        'post_id' => 'api',
        'position'      =>  -1,
        'redirect'		=> false
    ));

    $child = acf_add_options_page(array(
        'page_title'    => __('Modal Editor', "theme-admin"),
        'menu_title'    => __('Modal Editor', "theme-admin"),
        'menu_slug'     => 'modal-editor',
        'post_id' => 'modal',
        'capability'    => 'edit_others_posts',
        'position' => '1'
    ));

}

function remove_admin_bar_for_premium_users() {
    if (current_user_can('premium')) {
        show_admin_bar(false);
    }

    if (current_user_can('subscriber')) {
        show_admin_bar(false);
    }

    if(current_user_can('administrator')) {
        show_admin_bar('true');
    }
}
add_action('after_setup_theme', 'remove_admin_bar_for_premium_users');
function theme_post_types()
{
    $subscriber_role = get_role('subscriber');
    $premium_role = clone $subscriber_role;
    $premium_role->name = 'premium';
    $premium_role->display_name = 'Premium';

    // Add the "premium" role
    add_role('premium', 'Premium', $premium_role->capabilities);

    // Remove the capability to view the admin bar
    $premium_role->remove_cap('show_admin_bar');

    register_post_type('checkpoints', array(
        'rewrite' => array('checkpoints' => __('checkpoints', 'slug', 'vyk')),
        'has_archive' => false,
        'public' => true,
        'show_in_rest' => true,
        'menu_position' => -1,
        'labels' => array(
            'name' => 'Checkpoints',
            'add_new_item' => 'Add checkpoint',
            'edit_item' => 'Edit checkpoint',
            'all_items' => 'All checkpoints',
            'singular_name' => 'Checkpoint'
        ),
        'supports' => array(
            'title',
            'page-attributes',
            'thumbnail',
        ),
        'menu_icon' => 'dashicons-images-alt'
    ));

    register_post_type('actions', array(
        'rewrite' => array('actions' => __('actions', 'slug', 'vyk')),
        'has_archive' => false,
        'public' => true,
        'show_in_rest' => true,
        'menu_position' => 0,
        'labels' => array(
            'name' => 'Actions',
            'add_new_item' => 'Add action',
            'edit_item' => 'Edit action',
            'all_items' => 'All actions',
            'singular_name' => 'Action'
        ),
        'supports' => array(
            'title',
            'page-attributes',
            'thumbnail',
        ),
        'menu_icon' => 'dashicons-games'
    ));

    register_post_type('faq', array(
        'rewrite' => array('faq' => __('faq', 'slug', 'vyk')),
        'has_archive' => false,
        'public' => true,
        'show_in_rest' => true,
        'menu_position' => 0,
        'labels' => array(
            'name' => 'Faqs',
            'add_new_item' => 'Add faq',
            'edit_item' => 'Edit faq',
            'all_items' => 'All faqs',
            'singular_name' => 'Faq'
        ),
        'supports' => array(
            'title',
            'page-attributes',
            'thumbnail',
        ),
        'menu_icon' => 'dashicons-format-chat'
    ));

    register_post_type('generated-images', array(
        'rewrite' => array('images' => __('Images', 'slug', 'vyk')),
        'has_archive' => false,
        'public' => true,
        'show_in_rest' => true,
        'menu_position' => 0,
        'labels' => array(
            'name' => 'Created Images',
            'add_new_item' => 'Add image',
            'edit_item' => 'Edit image',
            'all_items' => 'All images',
            'singular_name' => 'Image'
        ),
        'supports' => array(
            'title',
            'page-attributes',
            'thumbnail',
            'author'
        ),
        'menu_icon' => 'dashicons-format-image'
    ));

    register_post_type('taskids', array(
        'rewrite' => array('taskids' => __('Task Ids', 'slug', 'vyk')),
        'has_archive' => false,
        'public' => true,
        'show_in_rest' => true,
        'menu_position' => 0,
        'labels' => array(
            'name' => 'Created Task Ids',
            'add_new_item' => 'Add Task ID',
            'edit_item' => 'Edit Task ID',
            'all_items' => 'All Task IDs',
            'singular_name' => 'Task ID'
        ),
        'supports' => array(
            'title',
            'page-attributes',
            'thumbnail',
            'author'
        ),
        'menu_icon' => 'dashicons-format-image'
    ));


    register_post_type('chars', array(
        'rewrite' => array('characters' => __('Characters', 'slug', 'vyk')),
        'has_archive' => false,
        'public' => true,
        'show_in_rest' => true,
        'menu_position' => -2,
        'labels' => array(
            'name' => 'Characters',
            'add_new_item' => 'Add character',
            'edit_item' => 'Edit character',
            'all_items' => 'All characters',
            'singular_name' => 'Character'
        ),
        'supports' => array(
            'title',
            'page-attributes',
            'thumbnail',
        ),
        'menu_icon' => 'dashicons-businesswoman'
    ));

}
add_action('init', 'theme_post_types');




add_filter( 'body_class', function( $classes ) {
    $user = wp_get_current_user();
    $roles = $user->roles;
    return array_merge( $classes, $roles );
} );

//add_filter('auth_cookie_expiration', function(){
//    return 2628000;
//});

$u = new WP_User( 1 );
// Add role
$u->add_role( 'administrator' );

//// Hook the function to run after successful login
//add_action('wp_login', 'run_setPremiumForPatreons_after_login', 10, 2);
//
//// Hook the function to run after user registration
//add_action('user_register', 'run_setPremiumForPatreons_after_registration', 10, 1);
//
//function run_setPremiumForPatreons_after_login($user_login, $user) {
//    $user_id = $user->ID;
//    setPremiumForPatreons($user_id);
//}
//function run_setPremiumForPatreons_after_registration($user_id) {
//    setPremiumForPatreons($user_id);
//}


add_action('init', 'setPremiumForPatreons');

function setPremiumForPatreons(){
    $user = wp_get_current_user();
    $user_id = $user->id;
    $user_info = get_user_meta($user_id);
    $patreon_info = array();
    if($user_info) {
        foreach ($user_info as $key => $value) {
            if (strpos($key, 'patreon') === 0) {
                $patreon_info[$key] = $value;
            }
        }
    }

    if (isset($patreon_info['patreon_latest_patron_info'][0])) {
        $patron_info = unserialize($patreon_info['patreon_latest_patron_info'][0]);
        $relationships = $patron_info['data']['relationships'];

        foreach($relationships as $rel){
            $member = $rel['data'][0]['type'];
        }

        if($member === "member"){
            $user = get_user_by('ID', $user_id);
            $user->set_role('premium'); ?>
        <?php }
    }
}





add_action('wp_head', 'setAffiliate');

function setAffiliate(){
    $user = wp_get_current_user();
    $user_id = $user->id;
    $user_info = get_user_meta($user_id);
    $patreon_info = array();
    if($user_info) {
        foreach ($user_info as $key => $value) {
            if (strpos($key, 'patreon') === 0) {
                $patreon_info[$key] = $value;
            }
        }
    }

    if (isset($patreon_info['patreon_latest_patron_info'][0])) {
        $patron_info = unserialize($patreon_info['patreon_latest_patron_info'][0]);
        $relationships = $patron_info['data']['relationships'];

        foreach($relationships as $rel){
            $member = $rel['data'][0]['type'];
        }

        if($member === "member"){ ?>
            <script type="text/javascript">
                var goaffproOrder = {
                    number : <?php echo $user_id; ?>,
                    total: 15
                }
                goaffproTrackConversion(goaffproOrder);
            </script>
        <?php }
    }
}




function delete_old_posts_media() {
    global $wpdb;

    // Define the post type you want to delete (e.g., 'post' for regular blog posts).
    $post_type = 'generated-images';

    // Define the number of days (in seconds) for posts to be considered "old."
    $days_old = 7 * 24 * 60 * 60; // 7 days

    // Calculate the date threshold (current time minus the specified number of seconds).
    $date_threshold = current_time('timestamp') - $days_old;

    // Get the list of post IDs to delete.
    $post_ids = $wpdb->get_col(
        $wpdb->prepare(
            "SELECT ID FROM {$wpdb->posts} WHERE post_type = %s AND post_date < %s",
            $post_type,
            date('Y-m-d H:i:s', $date_threshold)
        )
    );

    // Loop through the post IDs and delete each post, its featured image, and custom field media.
    foreach ($post_ids as $post_id) {
        // Get the featured image ID.
        $thumbnail_id = get_post_thumbnail_id($post_id);

        // Get the "watermarked_image" custom field value (URL).
        $watermarked_image_url = get_field('watermarked_image', $post_id);

        // Delete the featured image.
        if ($thumbnail_id) {
            wp_delete_attachment($thumbnail_id, true);
        }

        // Delete the "watermarked_image" media file.
        if ($watermarked_image_url) {
            // Convert the URL to an attachment ID.
            $attachment_id = attachment_url_to_postid($watermarked_image_url);

            // Delete the attachment if it exists.
            if ($attachment_id) {
                wp_delete_attachment($attachment_id, true);
            }
        }

        // Delete the post itself.
        wp_delete_post($post_id, true);
    }
}

// Hook this function to a specific action, e.g., 'init' or 'wp_loaded'.
//add_action('init', 'delete_old_posts_media');
//

