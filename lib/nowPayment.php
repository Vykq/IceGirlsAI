<?php

//const API_URL = 'https://api-sandbox.nowpayments.io/v1/'; //SANDBOX
//const API_KEY = 'M1MJGBG-GNMM0TD-HF4C13X-19W4Z4T'; //SANDBOX
const API_URL = 'https://api.nowpayments.io/v1/';
const API_KEY = '611GQ0K-GC2MHGK-NDY9C5Y-HSDQ861';

// NEW SIMPLIFIED METHOD

add_action('wp_ajax_nopriv_createInvoice', 'createInvoice');
add_action('wp_ajax_createInvoice', 'createInvoice');

function createInvoice(){

    $response = array();
    $current_user = wp_get_current_user();
    $user_email = $current_user->user_email;
    $user_id = $current_user->ID;

    if($user_email && $user_id){
        //create Order
        $post_id = wp_insert_post(array(
            'post_title' => 'Premium.: ' . $user_email,
            'post_type' => 'orders',
            'post_status' => 'private',
            'post_author' => $user_id
        ));

        update_field('email', $user_email, $post_id);
        update_field('date', date('Y-m-d'), $post_id);


        if($post_id){
            $data = array(
                "price_amount" => 15,
                "price_currency" => 'usd',
                "ipn_callback_url" => get_home_url() . "/wp-json/mycustom/v1/now-payments/",
//                "ipn_callback_url" => "https://eosux8im1yvpkeh.m.pipedream.net",
                "order_id" => $post_id,
                'order_description' => $user_email,
                'success_url' => get_home_url() . '/thank-you?order_id=' . $post_id
            );

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => API_URL . 'invoice',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'x-api-key: ' . API_KEY
                ),
                CURLOPT_SSL_VERIFYPEER => false //remove later
            ));

            $curlResponse = curl_exec($curl);

            curl_close($curl);
            $jsonresponse = json_decode($curlResponse, true);
            update_field('id', $jsonresponse['id'], $post_id);
            $response['url'] = $jsonresponse['invoice_url'];
        }


    }

    wp_send_json($response);
    wp_die();

}

function setPremiumForCryptoPurchase($paymentID, $orderID){

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => API_URL . 'payment/' . $paymentID,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_SSL_VERIFYPEER => false, //remove late
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'x-api-key: ' . API_KEY
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $response = json_decode($response, true);

    if($response['payment_status'] == "finished"){
        $current_user = wp_get_current_user();
        $user_email = $current_user->user_email;
        $user_id = $current_user->ID;

        if($response['order_description'] == $user_email){
            $today = date('Y-m-d');
            update_field('subscription_id', $_GET['NP_id'], 'user_' . $user_id);
            $current_user->set_role('premium');
            update_field('status', 'finished', $orderID);
            update_field('date_since_premium', $today, 'user_' . $user_id);
            $date = new DateTime($today);
            $date->modify('+30 days');
            $premiumUntil = $date->format('Y-m-d');
            update_field('date_until_premium', $premiumUntil, 'user_' . $user_id);
            return true;
        }

    } else {
        return false;
    }
}

function removePremiumAfterDate() {
    $users = get_users(array('meta_key' => 'date_until_premium')); // Get all users with 'until_premium' meta key

    foreach ($users as $user) {
        $user_id = $user->ID;
        $premiumUntil = get_user_meta($user_id, 'date_until_premium', true);
        $currentDate = date('Y-m-d');

        if (strtotime($premiumUntil) <= strtotime($currentDate)) {
            // Remove 'premium' role
            $user->remove_role('premium');

            // Add 'subscriber' role
            $user->add_role('subscriber');
            update_field('tokens', 10, 'user_' . $user_id);
        }
    }
}

if (!wp_next_scheduled('check_premium_users_daily')) {
    wp_schedule_event(time(), 'daily', 'removePremiumAfterDate');
}

// Hook the function to the scheduled event
add_action('check_premium_users_daily', 'removePremiumAfterDate');

add_action('rest_api_init', function () {
    register_rest_route('mycustom/v1', '/now-payments/', array(
        'methods' => 'POST', // Use POST since webhooks usually send data via POST
        'callback' => 'cryptoUserUpdate',
        'permission_callback' => '__return_true', // Allow public access, adjust as necessary for your use case
    ));
});

function cryptoUserUpdate($request) {
    // Get the JSON body of the request
    $body = $request->get_json_params();


    $log_entry = json_encode($body, JSON_PRETTY_PRINT); // Pretty print for readability
    $log_file = WP_CONTENT_DIR . '/crypto_payments.log';
    file_put_contents($log_file, $log_entry . PHP_EOL, FILE_APPEND | LOCK_EX);


    if($body){
        // Extract other necessary fields
        $order_id = isset($body['order_id']) ? sanitize_text_field($body['order_id']) : '';
        $payment_status = isset($body['payment_status']) ? sanitize_text_field($body['payment_status']) : '';
        $payment_id = $body['payment_id'] ?? '';
        $email = $body['order_description'] ?? '';


        if($payment_status == "failed"){
            update_field('status', 'failed', $order_id);

        } else if ($payment_status == "partially_paid"){
            update_field('status', 'partially', $order_id);

        } else if ($payment_status == "expired"){
            update_field('status', 'expired', $order_id);

        } else if ($payment_status == "finished") {
            update_field('status', 'finished', $order_id);
            $current_user =  get_user_by('email', $email);
            $user_id = $current_user->ID;

            if ($current_user) {
                $today = date('Y-m-d');
                update_field('subscription_id', $payment_id, 'user_' . $user_id);
                $current_user->set_role('premium');
                update_field('status', 'finished', $order_id);
                update_field('date_since_premium', $today, 'user_' . $user_id);
                $date = new DateTime($today);
                $date->modify('+30 days');
                $premiumUntil = $date->format('Y-m-d');
                update_field('date_until_premium', $premiumUntil, 'user_' . $user_id);
            }
        }


    }
}