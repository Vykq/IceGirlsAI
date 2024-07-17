<?php
get_header();
if(!is_user_logged_in()){ ?>
<div class="wp-form"><?php echo do_shortcode('[theme-my-login]'); ?></div>
<?php } else {
    $user = wp_get_current_user();
    $user_id = $user->ID;
    $userName = $user->user_login;
    $user_info = get_user_meta($user);
    $userPatreon = false;
    $subscriptionID = get_field('subscription_id', 'user_' . $user_id);
    $subItemID = get_field('subscription_item_id', 'user_' . $user_id);



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
                                <?php if($patreon_image_url) : ?>
                                    <img src="<?php echo $patreon_image_url; ?>" alt="IceGirls.Ai member <?php echo $patreon_username; ?>">
                                    <?php else: ?>
                                    <img src="<?php echo get_template_directory_uri() . '/assets/images/logo.png'; ?>" alt="IceGirls.Ai member <?php echo $userName; ?>">
                                <?php endif; ?>
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
                        <?php
                        $next_run_timestamp = wp_next_scheduled('daily_tokens_update');

                        // Convert the timestamp to a human-readable date and time format
                        $next_run_date_time = date('Y-m-d H:i', $next_run_timestamp);
                        if(!in_array( 'premium', (array) $user->roles )) {?>
                            <p class="log-out">Credits will be recharged in </br><?php echo $next_run_date_time; ?></p>
                        <?php } else {
                            $premiumUntil = get_field('date_until_premium', 'user_' . $user_id);
                            ?>
                            <p class="log-out">Your premium membership ends: <?php echo $premiumUntil; ?></p>
                        <?php }?>
                        <a href="<?php echo wp_logout_url( home_url()); ?>" class="log-out"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path class="door" d="M8.51465 20H4.51465C3.41008 20 2.51465 19.1046 2.51465 18V6C2.51465 4.89543 3.41008 4 4.51465 4H8.51465V6H4.51465V18H8.51465V20Z" fill="#FFA702FF"></path> <path class="arrow" d="M13.8422 17.385L15.2624 15.9768L11.3432 12.0242L20.4861 12.0242C21.0384 12.0242 21.4861 11.5765 21.4861 11.0242C21.4861 10.4719 21.0384 10.0242 20.4861 10.0242L11.3239 10.0242L15.3044 6.0774L13.8962 4.6572L7.50527 10.9941L13.8422 17.385Z" fill="#FFA702FF"></path> </g></svg> Log out</a>
                            <?php
                            //user is not premium
                                if ( !in_array( 'premium', (array) $user->roles )) { ?>
                                    <span class="main-button small create-invoice">Buy premium </br>(crypto)</span>
                                <?php } ?>
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



<?php
    if (in_array( 'premium', (array) $user->roles ) && $subscriptionID !== "") { ?>
        <div class="backdrop models-modal-wrapper modals cancel-sub">

        <div class="main-modal">
        <div class="modal-wrapper">
        <div class="top">
            <p class="title" id="current-scene">Cancel your subscription</p>
            <div class="close-modal">
                <svg viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffa702"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 21.32L21 3.32001" stroke="#ffa702" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 3.32001L21 21.32" stroke="#ffa702" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
            </div>
        </div>
        <div class="content">
        <div class="wrapper">
            <div class="spinner-area hidden">
                <span class="loader"></span>
            </div>
            <div id="cancel-step1" class="step">
                <div class="cancel-info-area">
                    <div class="top">

                        <form class="cancel-reason">
                            <p class="white">Please answer these questions:</p>
                            <div class="inputs">


                                <div class="radio-buttons">
                                    <div class="single-radio">
                                        <label for="slow"><input type="checkbox" id="slow" value="Too slow generation" name="reasonInput[]">Too slow generation
                                        </label>
                                    </div>
                                    <div class="single-radio">
                                        <label for="expensive">
                                            <input type="checkbox" id="expensive" name="reasonInput[]" value="Too expensive" >Too expensive
                                        </label>
                                    </div>
                                    <div class="single-radio">
                                        <label for="interface">
                                            <input type="checkbox" id="interface" name="reasonInput[]" value="I don't like website's interface" >I don't like website's interface
                                        </label>
                                    </div>
                                    <div class="single-radio">
                                        <label for="low-quality">
                                            <input type="checkbox" id="low-quality" name="reasonInput[]" value="Generations are low quality">Generations are low quality
                                        </label>
                                    </div>
                                    <div class="single-radio">
                                        <label for="try">
                                            <input type="checkbox" id="try" name="reasonInput[]" value="I just wanted to try this website">I just wanted to try this website
                                        </label>
                                    </div>
                                </div>
                                <div class="prompt">
                                    <textarea name="reason" class="textarea" placeholder="Additional message..."></textarea>
                                    <p class="error-msg"></p>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="bottom">
                        <div class="buttons-area">
                            <div class="left">
                                <button name="cancel-subscription" value="<?php echo $subscriptionID; ?>" class="secondary-button close-modal">Close</button>
                            </div>
                            <div class="right">
                                <button name="submit-and-cancel" class="main-button submit-cancel-form">Submit and cancel</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div id="cancel-step2" class="step hidden">
                <div class="cancel-info-area">
                    <div class="title">Are you sure?</div>
                    <p class="sub">We really want you to stay, here is a special offer for you, change your subscription to $10/month and get the same features as before.</p>
                    <div class="buttons-area">
                        <div class="left">
                            <button name="cheaper-subscription" data-userid="<?php echo $user_id; ?>" value="<?php echo $subItemID; ?>" class="skip-cancel-form main-button update-sub">Deal</button>
                        </div>
                        <div class="right">
                            <button name="cancel-subscription" data-userid="<?php echo $user_id; ?>" value="<?php echo $subscriptionID; ?>" class="skip-cancel-form secondary-button insta-cancel">Cancel anyways</button>
                        </div>
                    </div>

                </div>
            </div>
            <div id="cancel-step3" class="step hidden">
                <div class="cancel-info-area">
                    <p class="title">Error</p>
                    <p class="sub">Sorry, please try again later or contact support.</p>
                </div>
            </div>
            <div id="cancel-step4" class="step hidden">
                <div class="cancel-info-area">
                    <p class="title">Success</p>
                    <p class="sub">You successfully changed your plan to $10 per month.</p>
                </div>
            </div>
            <div id="cancel-step5" class="step hidden">
                <div class="cancel-info-area">
                    <p class="title">Success</p>
                    <p class="sub">You successfully canceled your subscription.</p>
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>

        </div>

    <?php } ?>

<?php }
get_footer();