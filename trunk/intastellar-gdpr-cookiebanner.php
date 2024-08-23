<?php
/*
Plugin Name: Intastellar Consents - GDPR Cookiebanner
Plugin URI: https://www.intastellarsolutions.com/gdpr-cookiebanner
Version: 3.2.1
Description: Get your Website GDPR Compliance: Remove 3rd partie cookies from begin on until user gives consents. We are helping you and your Website to become GDPR compliant.
Author: Intastellar Solutions, International
Text Domain: intastellar-gdpr-cookiebanner
Author URI: https://www.intastellarsolutions.com
License:           GPL v2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html
*/
if (!function_exists('add_action')) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

add_action('plugins_loaded', function () {
    if (!str_contains($_SERVER["REQUEST_URI"], 'wp-admin')) {
        wp_enqueue_script("intastellar-gdpr-settings", "https://consents.cdn.intastellarsolutions.com/uc.js?utm_source=Intastellar+GDPR+Wordpress+Plugin", false, '');
    }
    include_once plugin_dir_path(__FILE__) . 'includes/int-functions.php';
}, 1);
