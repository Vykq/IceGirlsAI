<?php
add_action('wp_ajax_nopriv_generate_image', 'sd_generate_image');
add_action('wp_ajax_generate_image', 'sd_generate_image');

function sd_generate_image() {
    $return = array();
    $user = wp_get_current_user();
    if ( wp_verify_nonce( $_POST['generation'], 'generation' )) {
        $return['success'] = false;
        wp_send_json($return);
        exit;
    } else {
        $return['success'] = true;
        // Check if the user has the "premium_access" capability
        if(in_array( 'premium', (array) $user->roles)) {
            $return['premium'] = true;
            $post_id = wp_insert_post(array(
                'post_title'    => $_POST['taskID'],
                'post_status'   => 'publish',
                'post_author'   => $user->id,
                'post_type' => 'taskids'
            ));

        } else {
            $return['premium'] = false;
        }

        wp_send_json($return);
    }

    exit;
}


add_action('wp_ajax_nopriv_premium_tasks', 'sd_premium_tasks');
add_action('wp_ajax_premium_tasks', 'sd_premium_tasks');

function sd_premium_tasks(){
    if(is_user_logged_in()){
        $user = wp_get_current_user();
        if ( !in_array( 'Premium', (array) $user->roles ) ) {
            $return['status'] = true;

            $taskID = $_POST['taskID'];
            $pendingTaskIds = $_POST['pendingTaskIds'];
            $pendingTaskIdsArray = explode(',', $pendingTaskIds);

            $args = array(
                'post_type' => 'taskids',
                'posts_per_page' => -1,
                'post_status' => 'publish'
            );

            $posts = new WP_Query($args);
            $matchingTaskIds = array();

            if ($posts->have_posts()) {
                while ($posts->have_posts()) :
                    $posts->the_post();
                    $postTitle = get_the_title();
                    if (in_array($postTitle, $pendingTaskIdsArray)) {
                        $matchingTaskIds[] = $postTitle; // Add matching task ID to the array
                    }
                endwhile;
            }
            $matchingTaskIds[] = $taskID; //here the aray is grayed out

            $return['position'] = count($matchingTaskIds) + 1;

            wp_send_json($return); // Send the JSON response
        } else {
            $return['status'] = false;
            wp_send_json($return); // Send the JSON response
        }
    } else {
        $return['status'] = false;
        wp_send_json($return); // Send the JSON response
    }
    exit;
}



add_action('wp_ajax_nopriv_addTaskToUser', 'addTaskToUser');
add_action('wp_ajax_addTaskToUser', 'addTaskToUser');

function addTaskToUser() {
    $return = array();


    if (is_user_logged_in()) {
        $user = wp_get_current_user();
        $taskID = $_POST['taskID'];
        $user_id = $user->ID;
        $existing_data = get_field('tasks', 'user_' . $user_id);
        if($taskID !== "undefined"){
            $new_entry = array(
                'id' => $taskID,
            );

            if (is_array($existing_data)) {
                $existing_data[] = $new_entry;
            } else {
                $existing_data = array($new_entry);
            }
        }
        // Update the repeater field with the new data.
        update_field('tasks', $existing_data, 'user_' . $user_id);

        $return['success'] = true;


        $post_id = wp_insert_post(array(
            'post_title' => $_POST['taskID'],
            'post_type' => 'generated-images',
            'post_status' => 'publish',
            'post_author' => $user_id
        ));

        if($post_id){
            $infoText = $_POST['infoText'];
            $infoText = json_decode($infoText, true);
            print_r($infoText);
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


            if(in_array( 'premium', (array) $user->roles)){
                update_field('premium', 1, $post_id);
            }

            update_field('prompt', $prompt, $post_id);
            update_field('size', $info['Size'], $post_id);
            update_field('model', $info['Model'], $post_id);
            update_field('sampler', $info['Sampler'], $post_id);
            update_field('details', $loras['more_details'], $post_id);
            update_field('task_id', $_POST['task-id'], $post_id);
            update_field('like_count', '0', $post_id);
        }

        $return['postid'] = $post_id;

    } else {
        $post_id = wp_insert_post(array(
            'post_title' => $_POST['taskID'],
            'post_type' => 'generated-images',
            'post_status' => 'publish',
            'post_author' => '0'
        ));
        $return['postid'] = $post_id;
    }


    wp_send_json($return);
    exit;
}



function getImageFromAPI($taskID) {
    ob_start();
    $apiUrl = get_field('api_ip', 'api') . 'agent-scheduler/v1/task/' . $taskID . '/results?zip=false';

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $apiUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer 6Q9cRilLA1E0D9PHBl1mht7XsmxJKZkBRlLDy_yveAo'
        ),
    ));

    $response = curl_exec($curl);
    $data = json_decode($response, true);

    $resp = array();
    if ($data && $data['success'] === true) {
       // $resp['image'] = $data['data'][0]['image'];
        $resp['status'] = $data['success'];
    } else {
        // If cURL request fails, use the fallback API URL
        $fallbackApiUrl = get_field('api_ip_free', 'api') . 'agent-scheduler/v1/task/' . $taskID . '/results?zip=false';
        $fallbackCurl = curl_init();

        curl_setopt_array($fallbackCurl, array(
            CURLOPT_URL => $fallbackApiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer 6Q9cRilLA1E0D9PHBl1mht7XsmxJKZkBRlLDy_yveAo'
            ),
        ));

        $fallbackResponse = curl_exec($fallbackCurl);
        $fallbackData = json_decode($fallbackResponse, true);

        if ($fallbackData && $fallbackData['success'] === true) {
            print_r($data['data'][0]);
           // $resp['image'] = $fallbackData['data'][0]['image'];
        } else {
            //echo 'Both API requests failed.';
        }

        curl_close($fallbackCurl);
    }

    curl_close($curl);
    ob_clean();
    return $resp;
}



function getHistoryFromApi($pageNumber) {

    if($pageNumber == 1){
        $pageNumber = 0;
    } else {
        $pageNumber = $pageNumber * 10;
    }
    $apiUrl = get_field('api_ip_free', 'api') . 'agent-scheduler/v1/history?status=done&limit=1&offset=' . $pageNumber;
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $apiUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer 6Q9cRilLA1E0D9PHBl1mht7XsmxJKZkBRlLDy_yveAo'
        ),
    ));

    $response = curl_exec($curl);
    $data = json_decode($response, true);

    if($response) {
        $total = $data['total'];
        $info['total'] = $total;
    }

    $info['ids'] = array(); // Initialize the 'ids' array

    if (isset($data['tasks']) && is_array($data['tasks'])) {
        foreach ($data['tasks'] as $task) {
            if ($task['status'] === 'done') {
                $info['ids'][] = $task['id']; // Add the task ID to the 'ids' array
            }
        }
    }

    return $info;
}