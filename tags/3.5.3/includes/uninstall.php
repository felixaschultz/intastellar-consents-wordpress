<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

if (! defined('ABSPATH')) exit;

delete_option('intastellarCookieBanner');
delete_option('intastellarSiteRoot');
delete_option('intastellar_plugin_activated_at');
delete_option('intastellar_review_prompt_dismissed');
// repeat for all plugin-specific settings
