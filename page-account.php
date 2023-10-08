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

    $user = wp_get_current_user();
    $user_id = $user->ID;
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

                            <?php if($userPatreon){ ?>
                                <a class="main-button smaller" href="https://www.patreon.com/IceGirls_Ai/membership" target="_blank">Manage subscription</a>
                            <?php } else { ?>

                            <?php } ?>
                            <a href="<?php echo wp_logout_url( home_url()); ?>" class="log-out"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path class="door" d="M8.51465 20H4.51465C3.41008 20 2.51465 19.1046 2.51465 18V6C2.51465 4.89543 3.41008 4 4.51465 4H8.51465V6H4.51465V18H8.51465V20Z" fill="#FFA702FF"></path> <path class="arrow" d="M13.8422 17.385L15.2624 15.9768L11.3432 12.0242L20.4861 12.0242C21.0384 12.0242 21.4861 11.5765 21.4861 11.0242C21.4861 10.4719 21.0384 10.0242 20.4861 10.0242L11.3239 10.0242L15.3044 6.0774L13.8962 4.6572L7.50527 10.9941L13.8422 17.385Z" fill="#FFA702FF"></path> </g></svg> Log out</a>

                    </div>
                </div>
                <div class="right">
                    <div class="last-creations-wrapper">
                        <p class="title">Your last generations</p>
                        <?php if(have_rows('tasks','user_' . $user_id)) :
                            $counter = 1;
                            ?>
                            <div class="last-creations-grid">
                                <div class="grid-wrapper">
                                    <?php
                                    // Get the repeater field data and reverse it
                                    $repeater_data = get_field('tasks', 'user_' . $user_id);
                                    $repeater_data = array_reverse($repeater_data);
                                    // Loop through the reversed repeater data
                                    if ($repeater_data) :
                                        foreach ($repeater_data as $row) : ?>
                                            <?php
                                            $query = new WP_Query(
                                                array(
                                                    'post_type'              => 'generated-images',
                                                    'title'                  => $row['id'],
                                                    'post_status'            => 'all',
                                                    'posts_per_page'         => 1,
                                                )
                                            );
                                            if ( ! empty( $query->post ) ) {
                                                $page_got_by_title = $query->post;
                                                $postid = $page_got_by_title->ID;
                                            }
                                            ?>
                                            <?php if(get_field('size', $postid) == "512x512"){
                                                $imageSize = "square";
                                            } else if(get_field('size', $postid) == "960x512"){
                                                $imageSize = "horizontal";
                                            } else {
                                                $imageSize = "normal";
                                            } ?>
                                            <div class="single-image <?php echo $imageSize; ?>">
                                                <a href="<?php echo get_permalink($postid); ?>">
                                                    <div class="single-wrapper">
                                                        <div class="post-image">
                                                            <img class="hub-single-image hide <?php echo $imageSize; ?>" data-id="<?php echo get_the_title($postid); ?>" src="<?php //echo $imageUrl; ?>" alt="">
                                                        </div>
                                                        <div class="hover-area">
                                                            <div class="hover-con">
                                                                <div class="wrapper">
                                                                    <div class="left">
                                                                        <img loading="lazy" src="<?php echo get_theme_file_uri() . '/assets/images/like.svg';?>" alt="IceGirls.AI generated Image">
                                                                    </div>
                                                                    <div class="right">
                                                                        <p><?php the_field('like_count', $postid); ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <div class="loaderis">
                                                    <div class="spinner">
                                                        <span class="loader"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php $counter++;
                                        if($counter == 10){
                                            break;
                                        } ?>
                                        <?php endforeach;
                                    endif;
                                    ?>
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