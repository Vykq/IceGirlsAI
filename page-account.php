<?php
get_header();
if(!is_user_logged_in()){ ?>
<div class="wp-form"><?php echo do_shortcode('[theme-my-login]'); ?></div>
<?php } else {
    $user = get_current_user_id();
    $current_user = get_user_by( 'id', $user );
    $userName = $current_user->user_login;
    $user_info = get_user_meta($user);
    $userPatreon = false;
    if ($user_info) {
        foreach ($user_info as $key => $value) {
            if (strpos($key, 'patreon') === 0) {
                $patreon_info[$key] = $value;
            }
        }
        if (isset($patreon_info['patreon_latest_patron_info'][0])) {
            $userPatreon = true;
            $patron_info = unserialize($patreon_info['patreon_latest_patron_info'][0]);
            $patreon_username = $patron_info['data']['attributes']['vanity'];
            $patreon_image_url = $patron_info['data']['attributes']['image_url'];
        }
    }

    $args = array(
        'post_type' => 'generated-images', // Your custom post type
        'author' => $user,
        'posts_per_page' => 12, // Retrieve all posts by the author
    );

    $images = new WP_Query($args);
    $user = wp_get_current_user();
    $isPremiumClass = "";
    if ( in_array( 'premium', (array) $user->roles ) ) {
        $isPremiumClass = "no-watermark-image";
    } else {
        $isPremiumClass = "watermarked-image";
    }


    ?>

    <div class="account-page-template">
        <div class="container">
            <div class="grid">
                <div class="left">
                    <div class="account-info-area">
                        <?php if($userPatreon) { ?>
                            <div class="avatar-area">
                                <img src="<?php echo $patreon_image_url; ?>" alt="IceGirls.Ai member <?php echo $patreon_username; ?>">
                            </div>
                        <?php } else { ?>
                            <div class="avatar-area">
                                <img src="<?php echo get_template_directory_uri() . '/assets/images/logo.png'; ?>" alt="IceGirls.Ai member <?php echo $userName; ?>">
                            </div>
                        <?php } ?>
                            <p class="name">
                                <?php if($userPatreon){
                                    echo $patreon_username;
                                } else {
                                    echo $userName;
                                }?>
                            </p>
                            <a href="<?php echo wp_logout_url( home_url()); ?>" class="log-out"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path class="door" d="M8.51465 20H4.51465C3.41008 20 2.51465 19.1046 2.51465 18V6C2.51465 4.89543 3.41008 4 4.51465 4H8.51465V6H4.51465V18H8.51465V20Z" fill="#FFA702FF"></path> <path class="arrow" d="M13.8422 17.385L15.2624 15.9768L11.3432 12.0242L20.4861 12.0242C21.0384 12.0242 21.4861 11.5765 21.4861 11.0242C21.4861 10.4719 21.0384 10.0242 20.4861 10.0242L11.3239 10.0242L15.3044 6.0774L13.8962 4.6572L7.50527 10.9941L13.8422 17.385Z" fill="#FFA702FF"></path> </g></svg> Log out</a>

        

                    </div>
                </div>
                <div class="right">
                    <div class="last-creations-wrapper">
                        <p class="title">Your last generations</p>
                        <?php if($images->have_posts()) : ?>
                            <div class="last-creations-grid">
                                <div class="grid-wrapper">
                                <?php while($images->have_posts()) : ?>
                                        <?php $images->the_post();
                                            if(get_field('size') == "512x512"){
                                                $imageSize = "square";
                                            } else if(get_field('size') == "960x512"){
                                                $imageSize = "horizontal";
                                            } else {
                                                $imageSize = "normal";
                                            }
                                        ?>
                                    <div class="single-image <?php echo $imageSize; ?>">
                                        <a href="<?php echo get_permalink(); ?>">
                                                <div class="post-image">
                                                    <?php if ( in_array( 'premium', (array) $user->roles ) ) {
                                                        the_post_thumbnail('hub-all', array( 'loading' => 'lazy', 'class' => 'lazy ' . $isPremiumClass ));
                                                    } else { ?>
                                                        <img class="lazy watermarked-image" loading="lazy" src="<?php echo get_field('watermarked_image', get_the_id()); ?>" alt="<?php echo get_the_title(); ?>">
                                                    <?php }?>
                                                </div>
                                        </a>

                                    </div>
                                <?php endwhile; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>





<?php }
get_footer();