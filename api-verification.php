<?php
// Paystack API call
function paystack_bvn_verification($bvn, $api_key) {
    $url = 'https://api.paystack.co/verify_bvn/'.$bvn;
    $response = wp_remote_get($url, [
        'headers' => [
            'Authorization' => 'Bearer ' . $api_key
        ]
    ]);

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);

    return isset($data->status) && $data->status == 'success';
}

// Flutterwave API call
function flutterwave_bvn_verification($bvn, $api_key) {
    $url = 'https://api.flutterwave.com/v3/verify-bvn/'.$bvn;
    $response = wp_remote_get($url, [
        'headers' => [
            'Authorization' => 'Bearer ' . $api_key
        ]
    ]);

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);

    return isset($data->status) && $data->status == 'success';
}

// Monnify API call
function monnify_bvn_verification($bvn, $api_key) {
    $url = 'https://api.monnify.com/v1/bvn/'.$bvn;
    $response = wp_remote_get($url, [
        'headers' => [
            'Authorization' => 'Bearer ' . $api_key
        ]
    ]);

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);

    return isset($data->status) && $data->status == 'success';
}
