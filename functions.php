<?php
require_once('lib/add_functions.php');
require_once('lib/web-sockets.php');
require_once('lib/stable-diffusion-api.php');
require_once('lib/free-premium.php');
require_once('lib/blocks.php');
require_once('lib/ga-events.php');
require_once('lib/tokkens.php');
function webpack_files() {
    wp_enqueue_script('webpack-js', get_theme_file_uri('assets/app.js'), array(), '3.4', true);
    wp_enqueue_style('webpack-styles', get_theme_file_uri('assets/style.css'), array(), '3.4');
    wp_enqueue_script('masonry-js', get_theme_file_uri('assets/minimasonry.min.js'), array(), '1', true);
//    wp_enqueue_script('splide-js', get_theme_file_uri('assets/splide.min.js'), array(), '4.1.3', true);
//    wp_enqueue_style('splide-styles', get_theme_file_uri('assets/splide.min.css'), array(), '4.1.3');
    wp_localize_script( 'webpack-js', 'themeUrl',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce( 'wp-smart-sign-nonce' ),
            'themeUrl' => get_theme_file_uri(),
            'apiUrl' => get_field('api_ip','api'),
            'apiUrlFree' => get_field('api_ip_free','api'),
            'stripe_key' => get_field('stripe_live_key','api'),
            'url_empty' => "Your URL field is empty, enter an URL.",
            'loading' => "Loading...",
            'loading_face' => "Uploading your face",
            'success' => "Thank you! We got your submition.",
            'success_face' => "Your face successfully uploaded",
            'failure' => "Something went wrong... Try again.",
            'info_empty' => "Explain your removal reasons.",
            'msg_empty' => "Enter your message.",
            'mail_empty' => 'Your email field is empty',
            'mail_error' => 'Enter the correct email address',
            'type_value' => 'Select Support type',
            'empty_reason' => 'Select support type',
            'cancel_reason' => 'Select canceling reason',
            'file_empty' => 'Select your uploading image',
            'name_empty' => "Enter your title",
            'invalid_file_format' => 'Image should be .jpg or .jpeg format',
            'file_too_large' => 'Image is too big (Maximum file size 1 MB)',
        )
    );

    if(is_front_page()){
        wp_dequeue_style( 'wp-block-library' );
    }
    if ( !is_admin() ) wp_deregister_script('jquery');
    wp_dequeue_style( 'theme-my-login' ); //Name of Style ID.
    wp_dequeue_style( 'patreon-wordpress-css' ); //Name of Style ID.


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

    if (current_user_can('expremium')) {
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


    $pr_role = get_role('premium');
    $expremium_role = clone $pr_role;
    $expremium_role->name = 'expremium';
    $expremium_role->display_name = 'ExPremium';
    // Add the "premium" role
    add_role('expremium', 'ExPremium', $expremium_role->capabilities);
    // Remove the capability to view the admin bar
    $expremium_role->remove_cap('show_admin_bar');

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

    register_taxonomy('types',array('chars'), array(
        'hierarchical' => true,
        'labels' => array(
            'name' => _x( 'Types', 'taxonomy general name', 'vyk' ),
            'singular_name' => _x( 'Type', 'taxonomy singular name', 'vyk' ),
            'search_items' =>  __( 'Search type', 'vyk' ),
            'all_items' => __( 'All types', 'vyk' ),
            'edit_item' => __( 'Edit type', 'vyk' ),
            'update_item' => __( 'Update type', 'vyk' ),
            'add_new_item' => __( 'Add new Type', 'vyk' ),
            'menu_name' => __( 'Types', 'vyk' ),
        ),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array(
            'slug' => _x( 'types', 'slug', 'expertmedia' ),
        ),
    ));

    register_post_type('faces', array(
        'rewrite' => array('faces' => __('Faces', 'slug', 'vyk')),
        'has_archive' => false,
        'public' => true,
        'show_in_rest' => true,
        'menu_position' => -3,
        'labels' => array(
            'name' => 'Users Faces',
            'add_new_item' => 'Add Face',
            'edit_item' => 'Edit Face',
            'all_items' => 'All Faces',
            'singular_name' => 'Face'
        ),
        'supports' => array(
            'title',
            'thumbnail',
            'author'
        ),
        'menu_icon' => 'dashicons-smiley'
    ));

//
//    register_post_type('test', array(
//        'rewrite' => array('test' => __('test', 'slug', 'vyk')),
//        'has_archive' => false,
//        'public' => true,
//        'show_in_rest' => true,
//        'menu_position' => 0,
//        'labels' => array(
//            'name' => 'Tests',
//            'add_new_item' => 'Add test',
//            'edit_item' => 'Edit test',
//            'all_items' => 'All test',
//            'singular_name' => 'Test'
//        ),
//        'supports' => array(
//            'title',
//            'page-attributes',
//            'thumbnail',
//        ),
//        'menu_icon' => 'dashicons-games'
//    ));


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


//add_action('init', 'setPremiumForPatreons');

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

add_action('init', 'setExPremiumForPatreons');

function setExPremiumForPatreons(){
    $user = wp_get_current_user();
    $user_id = $user->id;
    $user_info = get_user_meta($user_id);
    $patreon_info = array();
    $subscriptionID = get_field('subscription_id', 'user_' . $user_id);
    if($subscriptionID == "") {
        if ($user_info) {
            foreach ($user_info as $key => $value) {
                if (strpos($key, 'patreon') === 0) {
                    $patreon_info[$key] = $value;
                }
            }
        }

        if (isset($patreon_info['patreon_latest_patron_info'][0])) {
            $patron_info = unserialize($patreon_info['patreon_latest_patron_info'][0]);
            $relationships = $patron_info['data']['relationships'];

            foreach ($relationships as $rel) {
                $member = $rel['data'][0]['type'];
            }

            if ($member === "member") {
                $user = get_user_by('ID', $user_id);

                // Check if the user does not already have the 'expremium' role
                if (!in_array('expremium', $user->roles)) {
                    $user->add_role('expremium');
                }
            }
        }
    } else {
        //$user->set_role('premium');
    }
}





//add_action('wp_head', 'setAffiliate');

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

function custom_login_redirect() {
    return home_url('/create');
}

add_filter('rtcamp.google_default_redirect', 'custom_login_redirect');

function my_custom_redirect() {
    return home_url('/create');
}
add_filter( 'tml_redirect_url', 'my_custom_redirect' );
?>