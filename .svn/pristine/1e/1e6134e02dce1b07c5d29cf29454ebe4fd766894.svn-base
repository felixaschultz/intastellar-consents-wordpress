<?php

/**
 * Plugin Name: Intastellar Consents Solutions
 * Plugin URI: https://www.intastellarsolutions.com/solutions/cookie-consents
 * Description: Automatically add a GDPR compliant cookie consent banner and block scripts until consent is given.
 * Version: 3.4.2
 * Author: Intastellar Solutions, International
 * Author URI: https://www.intastellarsolutions.com
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: intastellar-consents
 * Requires at least: 5.8
 * Requires PHP: 7.4
 */
if (! defined('ABSPATH')) exit;

if (!function_exists('add_action')) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}


/**
 * Store activation timestamp for "Ask for review" prompt (shown after 7 days).
 */
register_activation_hook(__FILE__, function () {
    if (! get_option('intastellar_plugin_activated_at')) {
        update_option('intastellar_plugin_activated_at', time());
    }
});

add_action('plugins_loaded', function () {
    $plugin_data = get_plugin_data(__FILE__);
    $plugin_version = $plugin_data['Version'];
    if (isset($_SERVER["REQUEST_URI"]) && !str_contains(sanitize_url(wp_unslash($_SERVER["REQUEST_URI"])), 'wp-admin')) {
        wp_enqueue_script("intastellar-gdpr-settings", "https://consents.cdn.intastellarsolutions.com/uc.js?utm_source=Intastellar+GDPR+Wordpress+Plugin", false, $plugin_version, false);
    }
    include_once plugin_dir_path(__FILE__) . 'includes/int-functions.php';
}, 1);