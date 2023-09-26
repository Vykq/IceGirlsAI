<?php

//add_action('init', 'custom_function_name');
//function custom_function_name()
//{
//    if (is_user_logged_in() && !is_admin()) {
//        $userID = get_current_user_id();
//        $user = new WP_User($userID);
//
//        // Use get_field() to retrieve the ACF field value
//        $freePremium = get_field('free_premium', 'user_' . $userID);
//
//
//        if(!$user->get_role('administrator')) {
//            if (!$user->get_role('premium')) {
//                    if ($freePremium) {
//                        $user->set_role('premium');
//                        update_field('free_premium', 0, 'user_' . $userID);
//                    } else {
//                        $user_post_count = count_user_posts($userID);
//                        if ($user_post_count === 0) {
//                            $user->set_role('subscriber');
//                        }
//                }
//            }
//        }
//    }
//}
