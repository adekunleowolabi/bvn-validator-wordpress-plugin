<?php
/*
Plugin Name: BVN Validation Plugin
Plugin URI: https://yourwebsite.com
Description: A plugin to validate BVNs (Bank Verification Numbers) for Nigerian users, with both basic format and real-time API verification.
Version: 1.0
Author: Adekunle Owolabi
Author URI: https://yourwebsite.com
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// Include necessary files
include_once plugin_dir_path( __FILE__ ) . 'admin-settings.php';
include_once plugin_dir_path( __FILE__ ) . 'api-verification.php';

// Basic BVN Validation (11 digits, numeric)
function validate_bvn_basic($bvn) {
    if (strlen($bvn) == 11 && ctype_digit($bvn)) {
        return true;
    }
    return false;
}

// Real BVN Verification using API
function validate_bvn_api($bvn) {
    $api_key = get_option('bvn_api_key');
    $provider = get_option('bvn_api_provider');

    // Use API key and provider to validate BVN
    if ($provider == 'paystack') {
        return paystack_bvn_verification($bvn, $api_key);
    } elseif ($provider == 'flutterwave') {
        return flutterwave_bvn_verification($bvn, $api_key);
    } elseif ($provider == 'monnify') {
        return monnify_bvn_verification($bvn, $api_key);
    }
    return false;
}

// Handle form submission
function handle_bvn_validation($bvn) {
    // Basic validation
    if (!validate_bvn_basic($bvn)) {
        return 'Invalid BVN. Must be 11 digits.';
    }

    // Check API-based validation if enabled
    $api_validation_enabled = get_option('enable_api_verification', false);
    if ($api_validation_enabled) {
        $api_verified = validate_bvn_api($bvn);
        if (!$api_verified) {
            return 'BVN verification failed via API.';
        }
    }

    return true; // Success
}

add_filter('wpcf7_validate_text', 'handle_bvn_validation', 10, 2); // For Contact Form 7, adjust for other plugins as needed
