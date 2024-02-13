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




add_action('wp_ajax_nopriv_get_lora_info', 'getLoraInfo');
add_action('wp_ajax_get_lora_info', 'getLoraInfo');
function getLoraInfo() {
    $response = array(); // Create an array to hold the response data
    $loras = $_POST['loras'];
    $lorasArray = explode(',', $loras);
    $charsInfo = array();
    $actionsInfo = array();
    foreach ($lorasArray as $lora){
        $args = array(
            'post_type' => 'chars',
            'post_status' => 'publish',
            'posts_per_page' => -1
        );
        $chars = new WP_Query($args);

        if($chars->have_posts()):
            while($chars->have_posts()) : $chars->the_post();
                if(get_field('lora_name',get_the_id()) == $lora){
                    $charsInfo['title'] = get_the_title();
                    $charsInfo['image'] = get_the_post_thumbnail_url();
                    $charsInfo['trigger'] = get_field('trigger_word',get_the_id());
                    $charsInfo['type'] = "Character";
                }
            endwhile;
                $response['chars'] = $charsInfo;
        endif;
        wp_reset_query();


        $args = array(
            'post_type' => 'actions',
            'post_status' => 'publish',
            'posts_per_page' => -1
        );
        $actions = new WP_Query($args);

        if($actions->have_posts()):
            while($actions->have_posts()) : $actions->the_post();
                if(get_field('lora_name',get_the_id()) == $lora){
                    $actionsInfo['title'] = get_the_title();
                    $actionsInfo['image'] = get_the_post_thumbnail_url();
                    $actionsInfo['trigger'] = get_field('trigger_word',get_the_id());
                    $actionsInfo['type'] = "Action";
                }
            endwhile;
            $response['actions'] = $actionsInfo;
        endif;

    }

    wp_send_json($response);
    die();
}


add_action('wp_ajax_nopriv_get_nice_cp_title', 'getNiceCpName');
add_action('wp_ajax_get_nice_cp_title', 'getNiceCpName');
function getNiceCpName() {
    $response = array(); // Create an array to hold the response data
    $model = $_POST['model'];
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
                $response['model'] = $cpName;
                $response['image'] = get_the_post_thumbnail_url();
                $response['type'] = "Style";
            endif;
        endwhile;
    endif;
    wp_send_json($response);
    die();
}


//function redirect_to_profile() {
//    $redirect_to = get_option('home') . '/account/';
//    return $redirect_to;
//}
//add_filter('login_redirect', 'redirect_to_profile');


function getCurrentPatronCount(){

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.patreon.com/oauth2/v2/campaigns/11111306/members?include=currently_entitled_tiers&fields%5Btier%5D=patron_count&fields%5Bmember%5D=email',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer UPCTqrr5rA8cf2v4A5sZwbMpD2Ag550tqTtx-rKeAK8',
            'Cookie: __cf_bm=sDwnGsk9sJuOYtVgVJpJvEsAG0EM9282bBdldlXWp0Q-1696062070-0-Ae7c/7dbF/ySK4VrX+g/Co/Xt+SjcOWeZLWsgEGGJ3nOXII0TGRhPgZ1Wwk3hsYtf42yjx7wWKjFEd+9Q5eP+oXAjYTtOIT1hFLNTHcuRy6R; a_csrf=e1ws07llb1ud7f4RRSa_9xlqSl8sZvl08dFnSDdkhus; patreon_device_id=4d3b3606-22bc-4745-a591-fbf75de1cc13; AWSALBTG=0fJC87UHerSHlWdcmSO95bEr4T9BP1SkpOUHi3CD4bVKg34J9Bnxhot0tacJeR4G4iI8gMeGwe8c7+dClIiKz+K79PxMx4bR27m68z/SFH05B4Xlwcl/t1lHWQLTEBok8bS5vghFDPWSYKnfYIakhIVtDHuST/wlaofyjPAFC6NF; AWSALBTGCORS=0fJC87UHerSHlWdcmSO95bEr4T9BP1SkpOUHi3CD4bVKg34J9Bnxhot0tacJeR4G4iI8gMeGwe8c7+dClIiKz+K79PxMx4bR27m68z/SFH05B4Xlwcl/t1lHWQLTEBok8bS5vghFDPWSYKnfYIakhIVtDHuST/wlaofyjPAFC6NF'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $responseData = json_decode($response, true);

    $tierPatronCounts = [];


        // Iterate through the "data" array in the JSON response
        foreach ($responseData['data'] as $member) {
            // Check if the "currently_entitled_tiers" data is not empty
            if (!empty($member['relationships']['currently_entitled_tiers']['data'])) {
                // Retrieve the tier ID from the "tier" data
                $tierId = $member['relationships']['currently_entitled_tiers']['data'][0]['id'];

                // Find the corresponding tier information from the "included" section
                foreach ($responseData['included'] as $tierInfo) {
                    if ($tierInfo['id'] === $tierId && $tierInfo['type'] === 'tier') {
                        // Get the patron count for this tier
                        $patronCount = $tierInfo['attributes']['patron_count'];

                        // Store the patron count in the array using the tier ID as the key
                        $tierPatronCounts[$tierId] = $patronCount;
                        //echo $patronCount;
                        // You can also access the email of the member if needed
                        $email = $member['attributes']['email'];
                        //echo "Email: $email, Tier Patron Count: $patronCount\n";

                        break; // Exit the inner loop once we find the tier information
                    }
                }
            }
        }
        //return $tierPatronCounts['10233790'];
        return '98';


}


function getPremiumUserCount(){
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.patreon.com/oauth2/v2/campaigns/11111306/members?include=currently_entitled_tiers&fields%5Btier%5D=patron_count&fields%5Bmember%5D=email',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer 2pgmsRxCnjXOjBD346nrGW4j_xLwpwnoBfgFnOnVSbc',
            'Cookie: __cf_bm=sDwnGsk9sJuOYtVgVJpJvEsAG0EM9282bBdldlXWp0Q-1696062070-0-Ae7c/7dbF/ySK4VrX+g/Co/Xt+SjcOWeZLWsgEGGJ3nOXII0TGRhPgZ1Wwk3hsYtf42yjx7wWKjFEd+9Q5eP+oXAjYTtOIT1hFLNTHcuRy6R; a_csrf=e1ws07llb1ud7f4RRSa_9xlqSl8sZvl08dFnSDdkhus; patreon_device_id=4d3b3606-22bc-4745-a591-fbf75de1cc13; AWSALBTG=0fJC87UHerSHlWdcmSO95bEr4T9BP1SkpOUHi3CD4bVKg34J9Bnxhot0tacJeR4G4iI8gMeGwe8c7+dClIiKz+K79PxMx4bR27m68z/SFH05B4Xlwcl/t1lHWQLTEBok8bS5vghFDPWSYKnfYIakhIVtDHuST/wlaofyjPAFC6NF; AWSALBTGCORS=0fJC87UHerSHlWdcmSO95bEr4T9BP1SkpOUHi3CD4bVKg34J9Bnxhot0tacJeR4G4iI8gMeGwe8c7+dClIiKz+K79PxMx4bR27m68z/SFH05B4Xlwcl/t1lHWQLTEBok8bS5vghFDPWSYKnfYIakhIVtDHuST/wlaofyjPAFC6NF'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $responseData = json_decode($response, true);


    $total = $responseData['meta']['pagination']['total'];
    return $total;
}


function checkIfChecked($toCheck){
    $user = wp_get_current_user();
    if (in_array('premium', (array)$user->roles)) {
        if ($_GET) {
            foreach ($_GET as $item) {
                if ($item == $toCheck) {
                    echo "checked";
                }
            }
        }
    } else {
        return '';
    }
}

function checkAnswer($toCheck){
    $user = wp_get_current_user();
    if (in_array('premium', (array)$user->roles)) {
        if ($_GET) {
            if ($_GET['prompt']) {
                $tabs = get_field('tab', 'form');
                $promptArray = explode(", ", $_GET['prompt']);
                $allAnswers = array();
                $removedValues = array(); // Array to store removed values
                if ($tabs) {
                    foreach ($tabs as $tab) {
                        foreach ($tab['question'] as $question) {
                            foreach ($question['answers'] as $answer) {
                                array_push($allAnswers, trim($answer['input_value']));
                            }
                        }
                    }
                }

                $promptArray = array_map('trim', $promptArray);


                // Iterate over the elements and store removed values in $removedValues
                foreach ($promptArray as $value) {
                    if (in_array($value, $allAnswers)) {
                        $removedValues[] = $value;
                    }
                }

                $words = explode(', ', $toCheck);
                foreach ($words as $word) {
                    if (in_array($word, $removedValues)) {
                        echo "checked";
                    }
                }
                return $removedValues;
            }
        } else {
            return '';
        }
    } else {
        return '';
    }
}


function fixPrompt(){
    $user = wp_get_current_user();
    if (in_array('premium', (array)$user->roles)) {
        if ($_GET) {
            if ($_GET['prompt']) {
                $tabs = get_field('tab', 'form');
                $promptArray = explode(", ", $_GET['prompt']);
                $allAnswers = array();
                $removedValues = array(); // Array to store removed values
                $leftPrompt = array(); // Array to store removed values
                if ($tabs) {
                    foreach ($tabs as $tab) {
                        foreach ($tab['question'] as $question) {
                            foreach ($question['answers'] as $answer) {
                                array_push($allAnswers, trim($answer['input_value']));
                            }
                        }
                    }
                }

                $promptArray = array_map('trim', $promptArray);

                // Iterate over the elements and store removed values in $removedValues
                foreach ($promptArray as $value) {
                    if (in_array($value, $allAnswers)) {
                        $removedValues[] = $value;
                    }
                    if (!in_array($value, $allAnswers)) {
                        $leftPrompt[] = $value;
                    }
                }


                $leftPrompt = array_filter($leftPrompt);
                $leftPromptString = implode(', ', $leftPrompt);
                return $leftPromptString;
            }
        } else {
            return '';
        }
    } else {
        return '';
    }

}




add_action('wp_ajax_nopriv_cancelSubscription', 'cancelSubscription');
add_action('wp_ajax_cancelSubscription', 'cancelSubscription');

function cancelSubscription(){
    $user_id = $_POST['userID'];
    $user = wp_get_current_user($user_id);
    $subscriptionID = get_field('subscription_id', 'user_' . $user_id);
    $response = array();
    $sk_live = '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';

    if (!empty($subscriptionID)) {
        $url = "https://api.stripe.com/v1/subscriptions/{$subscriptionID}";

        $headers = array(
            'Authorization: Bearer ' . $sk_live,
            'Content-Type: application/x-www-form-urlencoded',
        );


        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($httpCode == 200) {
            $response['success'] = true;
            $response['message'] = 'Subscription canceled successfully';
            update_field('subscription_id', '', 'user_' . $user_id);
            update_field('tokkens_set', 1, 'user_' . $user_id);
            update_field('tokens', 10, 'user_' . $user_id);
            $user->set_role('subscriber');
            add_expremium_to_klaviyo_list($user_id);
        } else {
            $response['success'] = false;
            $response['message'] = 'Error canceling subscription. HTTP Code: ' . $httpCode;
            //update_field('subscription_id', '', 'user_' . $user_id);
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'Subscription ID is missing';
    }

    // Output the response as JSON
    header('Content-Type: application/json');
    echo wp_send_json($response);
    wp_die();
}


add_action('wp_ajax_nopriv_cancelSubscription2', 'cancelSubscription2');
add_action('wp_ajax_cancelSubscription2', 'cancelSubscription2');

function cancelSubscription2(){
    $user_id = $_POST['userID'];
    $user = wp_get_current_user($user_id);
    $subscriptionID = get_field('subscription_id', 'user_' . $user_id);
    $response = array();
    $sk_live = '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';

    if (!empty($subscriptionID)) {
        $url = "https://api.stripe.com/v1/subscriptions/{$subscriptionID}";

        $headers = array(
            'Authorization: Bearer ' . $sk_live,
            'Content-Type: application/x-www-form-urlencoded',
        );


        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($httpCode == 200) {
            $response['success'] = true;
            $response['message'] = 'Subscription canceled successfully';
            update_field('subscription_id', '', 'user_' . $user_id);
            update_field('tokkens_set', 1, 'user_' . $user_id);
            update_field('tokens', 10, 'user_' . $user_id);
            $user->set_role('subscriber');
        } else {
            $response['success'] = false;
            $response['message'] = 'Error canceling subscription. HTTP Code: ' . $httpCode;
            //update_field('subscription_id', '', 'user_' . $user_id);
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'Subscription ID is missing';
    }

    // Output the response as JSON
    header('Content-Type: application/json');
    echo wp_send_json($response);
    wp_die();
}


add_action('wp_ajax_nopriv_isLoggedIn', 'isLoggedIn');
add_action('wp_ajax_isLoggedIn', 'isLoggedIn');

function isLoggedIn(){
    $user = wp_get_current_user();
    wp_send_json($user->exists());
    wp_die();
}

add_action('wp_ajax_nopriv_updateSubscription', 'updateSubscription');
add_action('wp_ajax_updateSubscription', 'updateSubscription');

function updateSubscription(){
    $user_id = $_POST['userID'];
    $subscriptionItemID = get_field('subscription_item_id', 'user_' . $user_id);
    $response = array();
    $sk_live = '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';

//    $sk_live = 'sk_test_2LR5IRUyN4Hy5zX8Hh8Cld4Q00y10Iev2H';
    $new_price_id = 'price_1OO6H7I7TOk6FZawbshkObay'; //Zymn
//    $new_price_id = 'price_1ONElTBLwWwcKcmiIWlpCmZB'; //my

    $url = "https://api.stripe.com/v1/subscription_items/" . $subscriptionItemID . "?price=" . $new_price_id . "&proration_behavior=none";

    $headers = array(
        'Authorization: Basic ' . base64_encode($sk_live . ":"),
        'Content-Type: application/x-www-form-urlencoded',
    );


    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $chResponse = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
// Handle the response as needed
   // var_dump(json_decode($chResponse, true));

    curl_close($ch);

    if($httpCode == 200){
        $response['success'] = true;
    }

    wp_send_json($response);
    wp_die();
}


function setPremiumForStripePurchase($checkoutID){
    $sk_live = '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';
//    $sk_live = 'sk_test_2LR5IRUyN4Hy5zX8Hh8Cld4Q00y10Iev2H';

    $url = "https://api.stripe.com/v1/checkout/sessions/" . $checkoutID;

        $headers = array(
            'Authorization: Bearer ' . $sk_live,
            'Content-Type: application/x-www-form-urlencoded',
        );


        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        $responseData = json_decode($result, true);
        $email = $responseData['customer_details']['email'];
        $status = $responseData['status'];
        $subscription_id = $responseData['subscription'];

        if($status === "complete"){
            setUserPremiumByEmail($subscription_id);
            return true;
        } else {
            return false;
        }


}

function setUserPremiumByEmail($subscription_id){
    $user = wp_get_current_user();
    $userID = get_current_user_id();
    if($userID){
        update_field('subscription_id', $subscription_id, 'user_' . $userID);
        $user->set_role('premium');
        $subItemID = getSubscriptionItemID($subscription_id);
        update_field('subscription_item_id', $subItemID, 'user_' . $userID);
    }

}



function getSubscriptionItemID($subscription_id){
    $sk_live = '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';
//    $sk_live = 'sk_test_2LR5IRUyN4Hy5zX8Hh8Cld4Q00y10Iev2H';

    $url = "https://api.stripe.com/v1/subscriptions/" . $subscription_id;

    $headers = array(
        'Authorization: Bearer ' . $sk_live,
        'Content-Type: application/x-www-form-urlencoded',
    );


    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    $responseData = json_decode($result, true);

    if (isset($responseData['items']['data']) && !empty($responseData['items']['data'])) {
        // Get the first item's "id" value
        $firstItemId = $responseData['items']['data'][0]['id'];
        return $firstItemId;
    } else {
        return '';
    }
}

add_action('user_register', 'update_klaviyo_list', 10, 1);

function update_klaviyo_list($user_id) {
    $user_info = get_userdata($user_id);
    $user_role = $user_info->roles;

    if (in_array('subscriber', $user_role)) {
        $email = $user_info->user_email;
        $first_name = $user_info->first_name;
        $last_name = $user_info->last_name;

        // Replace with your Klaviyo Private API Key
        $klaviyo_api_key = 'pk_c0fdc261faf90a5ca3f8c9885727df5711';

        $data = array(
            'api_key' => $klaviyo_api_key,
            'profiles' => array(
                array(
                    'email' => $email,
                    '$first_name' => $first_name,
                    '$last_name' => $last_name
                )
            )
        );

        $response = wp_remote_post('https://a.klaviyo.com/api/v2/list/RyQCFK/members', array(
            'body' => json_encode($data),
            'headers' => array('Content-Type' => 'application/json')
        ));

        // Handle response or error
        if (is_wp_error($response)) {
            // Error handling
        } else {
            // Success handling
        }
    }
}



function add_premium_to_klaviyo_list($user_id) {
    $user_info = get_userdata($user_id);
    $user_role = $user_info->roles;

    if (in_array('premium', $user_role)) {
        $email = $user_info->user_email;
        $first_name = $user_info->first_name;
        $last_name = $user_info->last_name;

        // Replace with your Klaviyo Private API Key
        $klaviyo_api_key = 'pk_c0fdc261faf90a5ca3f8c9885727df5711';

        $data = array(
            'api_key' => $klaviyo_api_key,
            'profiles' => array(
                array(
                    'email' => $email,
                    '$first_name' => $first_name,
                    '$last_name' => $last_name
                )
            )
        );

        $response = wp_remote_post('https://a.klaviyo.com/api/v2/list/UNKSPf/members', array(
            'body' => json_encode($data),
            'headers' => array('Content-Type' => 'application/json')
        ));

        // Handle response or error
        if (is_wp_error($response)) {
            // Error handling
        } else {
            // Success handling
        }
    }
}

function add_expremium_to_klaviyo_list($user_id) {
    $user_info = get_userdata($user_id);
        $email = $user_info->user_email;
        $first_name = $user_info->first_name;
        $last_name = $user_info->last_name;

        // Replace with your Klaviyo Private API Key
        $klaviyo_api_key = 'pk_c0fdc261faf90a5ca3f8c9885727df5711';

        $data = array(
            'api_key' => $klaviyo_api_key,
            'profiles' => array(
                array(
                    'email' => $email,
                    '$first_name' => $first_name,
                    '$last_name' => $last_name
                )
            )
        );

        $response = wp_remote_post('https://a.klaviyo.com/api/v2/list/TFVw2Z/members', array(
            'body' => json_encode($data),
            'headers' => array('Content-Type' => 'application/json')
        ));

        // Handle response or error
        if (is_wp_error($response)) {
            // Error handling
        } else {
            // Success handling
        }

}


add_action('wp_ajax_nopriv_checkLastTask', 'checkLastTask');
add_action('wp_ajax_checkLastTask', 'checkLastTask');

function checkLastTask(){
    $user = wp_get_current_user();
    $user_id = $user->ID;
    $tasks = get_field('tasks','user_'.$user_id);
    if(is_array($tasks)){
        if(count($tasks) > 10){
            $tasks = array_slice($tasks, -10, 10);
            update_field('tasks', $tasks, 'user_' . $user_id);
        }
        $last_row = end($tasks);
    } else {
        $last_row['id'] = "";
    }

    wp_send_json($last_row['id']);
    wp_die();
}




//Not using anymore
//add_action('wp_ajax_nopriv_saveFaceToUserTask', 'saveFaceToUserTask');
//add_action('wp_ajax_saveFaceToUserTask', 'saveFaceToUserTask');
//
//function saveFaceToUserTask(){
//    $response = array();
//    if($_POST['taskID']){
//        $user = wp_get_current_user();
//        $user_id = $user->ID;
//        $facesArray = get_field('faces', 'user_' . $user_id);
//        $newRowData = array(
//            'face' => $_POST['taskID']
//        );
//        add_row('faces', $newRowData, 'user_' . $user_id);
//        $response['status'] = true;
//        $numRows = count($facesArray);
//
//        // If there are more than 10 rows, delete the first row
//        if ($numRows > 10) {
//            delete_row('faces', 1, 'user_' . $user_id);
//        }
//    } else {
//        $response['status'] = false;
//    }
//    wp_send_json($response);
//    wp_die();
//}


add_action('wp_ajax_nopriv_getImageBase64ByPostID', 'getImageBase64ByPostID');
add_action('wp_ajax_getImageBase64ByPostID', 'getImageBase64ByPostID');

function getImageBase64ByPostID() {
    $response = array();

    if($_POST['id']){
        $response['image'] = get_the_post_thumbnail_url($_POST['id']);
    }

    wp_send_json($response);
    wp_die();
}



add_action('wp_ajax_nopriv_uploadFaceImageToUser', 'uploadFaceImageToUser');
add_action('wp_ajax_uploadFaceImageToUser', 'uploadFaceImageToUser');

function uploadFaceImageToUser() {
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


    $post_id = wp_insert_post($post_data);

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
        }
    }
    $response['postid'] = $post_id;
    wp_send_json($response);
    wp_die();
}



add_action('wp_ajax_nopriv_saveFaceImageToUser', 'saveFaceImageToUser');
add_action('wp_ajax_saveFaceImageToUser', 'saveFaceImageToUser');

function saveFaceImageToUser(){
    $response = array();
    $userID = get_current_user_id();
    $userPostsCount = count_user_posts($userID, 'faces');
    $response['userPosts'] = $userPostsCount;

    if(isset($_POST['image']) && !empty($_POST['image'])) {
        $image_data = $_POST['image'];

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

        // Insert new post
        $post_data = array(
            'post_title'   => 'Generated face',
            'post_status'  => 'publish',
            'post_type'    => 'faces', // Change this to your custom post type if needed
            'post_author'  => $userID,
        );

        $post_id = wp_insert_post($post_data);

        if ($post_id) {
            // Decode base64 image data
            $image_data = str_replace('data:image/png;base64,', '', $image_data);
            $image_data = str_replace(' ', '+', $image_data);
            $decoded_image = base64_decode($image_data);

            // Generate a unique filename
            $upload_dir = wp_upload_dir();
            $upload_path = $upload_dir['path'];
            $upload_file = trailingslashit($upload_path) . md5(uniqid()) . '.png';

            // Save the image to the uploads directory
            $file_saved = file_put_contents($upload_file, $decoded_image);

            if ($file_saved !== false) {
                // Attach the image to the post
                $attachment_id = wp_insert_attachment(array(
                    'guid'           => $upload_file,
                    'post_mime_type' => 'image/png',
                    'post_title'     => 'Generated face image',
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                ), $upload_file);

                if (!is_wp_error($attachment_id)) {
                    set_post_thumbnail($post_id, $attachment_id);
                    update_field('base64_image', $image_data, $post_id);
                    $response['status'] = true;
                    $response['message'] = 'Face saved successfully.';
                    $response['postid'] = $post_id;
                } else {
                    $response['status'] = false;
                    $response['message'] = 'Error attaching image to post.';
                }
            } else {
                $response['status'] = false;
                $response['message'] = 'Error saving image to server.';
            }
        } else {
            $response['status'] = false;
            $response['message'] = 'Error creating post.';
        }
    } else {
        $response['status'] = false;
        $response['message'] = 'Image not provided.';
    }

    wp_send_json($response);
    wp_die();
}


add_action('wp_ajax_nopriv_loadNewFaces', 'loadNewFaces');
add_action('wp_ajax_loadNewFaces', 'loadNewFaces');

function loadNewFaces(){
    $response = array();
    $user = wp_get_current_user();
    $user_id = $user->ID;
    $count = 0;
    while(have_rows('faces', 'user_' . $user_id)) : the_row();
        // Build face data
        $faceData = array(
            'imgId' => 'Face - ' . $count,
            'inputId' => createSlug(get_sub_field('face')),
            'label' => substr('Face - ' . $count, 0, 13) . ((strlen('Face - ' . $count) > 13) ? '...' : ''),
            'imageUrl' => get_template_directory_uri() . '/assets/images/face-empty.jpg',
            'imageAlt' => 'Face - ' . $count,
        );

        // Add face data to the faces array
        $faces[] = $faceData;

        // Increment count
        $count++;
    endwhile;

    // Send faces array as JSON
    $response['faces'] = $faces;
    wp_send_json($response);
    wp_die();
}



add_action('wp_ajax_nopriv_deleteFaceFromUser', 'deleteFaceFromUser');
add_action('wp_ajax_deleteFaceFromUser', 'deleteFaceFromUser');

function deleteFaceFromUser(){
    $response = array();
    if($_POST['faceID']){
        $id = $_POST['faceID'];
        wp_delete_post($id, true);
        $response['message'] = 'Face deleted';
    }
    wp_send_json($response);
    wp_die();
}