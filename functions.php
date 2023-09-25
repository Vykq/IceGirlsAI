<?php
require_once('lib/add_functions.php');
require_once('lib/stable-diffusion-api.php');
function webpack_files() {
    wp_enqueue_script('webpack-js', get_theme_file_uri('assets/app.js'), array(), time(), true);
    //wp_enqueue_script('gsap', get_theme_file_uri('assets/gsap.min.js'), array(), time(), true);
    //wp_enqueue_script('ScrollTrigger', get_theme_file_uri('assets/ScrollTrigger.min.js'), array(), time(), true);
    //wp_enqueue_script('lenis', get_theme_file_uri('assets/lenis.min.js'), array(), time(), true);
    //wp_enqueue_script('imagesloaded', get_theme_file_uri('assets/imagesloaded.pkgd.min.js'), array(), time(), true);
    wp_enqueue_style('webpack-styles', get_theme_file_uri('assets/style.css'), array(), time());
    wp_enqueue_script('masonry-js', get_theme_file_uri('assets/minimasonry.min.js'), array(), time(), true);
    wp_localize_script( 'webpack-js', 'themeUrl',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce( 'wp-smart-sign-nonce' ),
            'themeUrl' => get_theme_file_uri(),
           // 'apiUrl' => 'http://127.0.0.1:7860/',
            'apiUrl' => get_field('api_ip','api'),
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
}

function remove_admin_bar_for_premium_users() {
    if (current_user_can('premium')) {
        show_admin_bar(false);
    }

    if (current_user_can('subscriber')) {
        show_admin_bar(false);
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




// Hook the function to run after successful login
add_action('wp_login', 'run_setPremiumForPatreons_after_login', 10, 2);

// Hook the function to run after user registration
add_action('user_register', 'run_setPremiumForPatreons_after_registration', 10, 1);

function run_setPremiumForPatreons_after_login($user_login, $user) {
    $user_id = $user->ID;
    setPremiumForPatreons($user_id);
}
function run_setPremiumForPatreons_after_registration($user_id) {
    setPremiumForPatreons($user_id);
}


if(is_user_logged_in()){
    $user = wp_get_current_user();
    $user_id = $user->id;
    setPremiumForPatreons($user_id);
}
function setPremiumForPatreons($user_id){
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
            $user->set_role('premium');
        }
    }
}