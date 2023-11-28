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


function redirect_to_profile() {
    $redirect_to = get_option('home') . '/account/';
    return $redirect_to;
}
add_filter('login_redirect', 'redirect_to_profile');


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