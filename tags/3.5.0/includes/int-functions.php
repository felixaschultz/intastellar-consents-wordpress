<?php
if (! defined('ABSPATH')) exit;
require_once(ABSPATH . 'wp-admin/includes/plugin.php');

// get the plugin version
$plugin_data = get_plugin_data(__FILE__);
$plugin_version = $plugin_data['Version'];

function intastellarSettingsRegistration()
{
    register_setting('intastellar-consents_plugin_options-group', 'intastellarCustomIcon', array(
        'type' => 'string',
        'sanitize_callback' => 'esc_url',
    ));

    register_setting('intastellar-consents_plugin_options-group', 'intastellarCookieBannerColor', array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    register_setting('intastellar-consents_plugin_options-group', 'intastellarCookieBannerBrandName', array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    register_setting('intastellar-consents_plugin_options-group', 'intastellarPrivacyLink', array(
        'type' => 'string',
        'sanitize_callback' => 'esc_url',
    ));

    register_setting('intastellar-consents_plugin_options-group', 'intastellarPrivacyLinkCheckbox', array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    register_setting('intastellar-consents_plugin_options-group', 'intastellarSetCookiePosition', array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    register_setting('intastellar-consents_plugin_options-group', 'intastellarDisplayCookieNoticeText', array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    register_setting('intastellar-consents_plugin_options-group', 'intastellarSelectLanguage', array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    register_setting('intastellar-consents_plugin_options-group', 'intastellarCCPA', array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    register_setting('intastellar-consents_plugin_options-group', 'intastellarCCPAUrl', array(
        'type' => 'string',
        'sanitize_callback' => 'esc_url',
    ));

    register_setting('intastellar-consents_plugin_options-group', 'intastellarDisplayCookieAdvenced', array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    register_setting('intastellar-consents_plugin_options-group', 'intastellarCCPAcollection', array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    register_setting('intastellar-consents_plugin_options-group', 'intastellarCookieList', array(
        'type' => 'string',
        'sanitize_callback' => 'wp_kses_post',
    ));

    register_setting('intastellar-consents_plugin_options-group', 'intastellarSiteRoot', array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    register_setting('intastellar-consents_plugin_options-group', 'intastellarBannerStyle', array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    register_setting('intastellar-consents_plugin_options-group', 'intastellarPluginVersion', array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
        'default' => '3.3.7'
    ));
}

/**
 * One-time migration: set activation timestamp for sites that were updated
 * (activation hook does not run on update, so the option was never set).
 */
function intastellar_maybe_set_activation_timestamp()
{
    if (get_option('intastellar_plugin_activated_at')) {
        return;
    }
    // Set to 8 days ago so the review prompt shows immediately for existing installs.
    update_option('intastellar_plugin_activated_at', time() - (8 * DAY_IN_SECONDS));
}
add_action('admin_init', 'intastellar_maybe_set_activation_timestamp', 0);

/**
 * Whether to show the "Ask for review (On WordPress)" prompt.
 * Shown only after 7 days since activation and if not dismissed.
 */
function intastellar_should_show_review_prompt()
{
    $activated_at = get_option('intastellar_plugin_activated_at');
    if (! $activated_at) {
        return false;
    }
    if (get_option('intastellar_review_prompt_dismissed')) {
        return false;
    }
    $seven_days_ago = time() - (7 * DAY_IN_SECONDS);
    return $activated_at <= $seven_days_ago;
}

/**
 * WordPress.org review URL for this plugin.
 */
function intastellar_get_review_url()
{
    $slug = 'intastellar-gdpr-cookie-banner';
    return 'https://wordpress.org/support/plugin/' . $slug . '/reviews/#new-post';
}

add_action('wp_ajax_intastellar_dismiss_review', function () {
    if (! current_user_can('manage_options')) {
        wp_send_json_error();
    }
    if (! isset($_REQUEST['nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_REQUEST['nonce'])), 'intastellar_dismiss_review')) {
        wp_send_json_error();
    }
    update_option('intastellar_review_prompt_dismissed', true);
    wp_send_json_success();
});

add_action('admin_init', 'intastellarSettingsRegistration', 1);
add_action('admin_enqueue_scripts', 'initIntastellarAdminStyles', 1);

function initIntastellarAdminStyles($hook)
{
    // Only load on plugin pages to prevent conflicts
    if (strpos($hook, 'intastellar-consents') === false) {
        return;
    }

    $plugin_version = get_plugin_data(__FILE__)['Version'];
    wp_register_style('intastellarStyle', plugin_dir_url(__FILE__) . 'intastellarAdminStyle.css', false, $plugin_version, 'all');
    wp_enqueue_style('intastellarStyle');
    wp_enqueue_script('intastellarScript', plugin_dir_url(__FILE__) . 'intastellarAdminScript.js', array('jquery'), $plugin_version, true);
    wp_localize_script('intastellarScript', 'intastellarReview', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'reviewUrl' => intastellar_get_review_url(),
        'nonce' => wp_create_nonce('intastellar_dismiss_review'),
    ));
}

function intastellar_enqueue_media_uploader($hook)
{
    // Only load on plugin pages to prevent conflicts with media library
    if (strpos($hook, 'intastellar-consents') === false) {
        error_log('intastellar_enqueue_media_uploader skipped for hook: ' . $hook);
        return;
    }

    error_log('intastellar_enqueue_media_uploader executed for hook: ' . $hook);

    $plugin_version = get_plugin_data(__FILE__)['Version'];
    wp_enqueue_media();
    wp_enqueue_script('intastellar-media-uploader', plugin_dir_url(__FILE__) . 'media-uploader.js', array('jquery'), $plugin_version, true);
}

add_action('admin_enqueue_scripts', 'intastellar_enqueue_media_uploader');

function initIntastellarSettingsPage()
{
    add_menu_page('Intastellar CMP', 'Intastellar CMP', 'manage_options', 'intastellar-consents', 'intastellarGDPRSettingsForm', 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4bWxuczpzZXJpZj0iaHR0cDovL3d3dy5zZXJpZi5jb20vIiB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiB2aWV3Qm94PSIwIDAgMzU2MyAxOTQ5IiB2ZXJzaW9uPSIxLjEiIHhtbDpzcGFjZT0icHJlc2VydmUiIHN0eWxlPSJmaWxsLXJ1bGU6ZXZlbm9kZDtjbGlwLXJ1bGU6ZXZlbm9kZDtzdHJva2UtbGluZWpvaW46cm91bmQ7c3Ryb2tlLW1pdGVybGltaXQ6MjsiPjxnIGlkPSJMYXllcl80Ij48cGF0aCBkPSJNMjY4NC45Miw1MTkuMDQyYy0wLDEyNC4xMjUgLTkzLjEyNSwyMjYuNSAtMjEzLjI5MiwyNDEuMDgzYy01MS45MTcsLTEyNy43MDggLTE0Ni4wNDIsLTIzMy43NSAtMjY1LC0zMDAuNzkyYzI2LjU4MywtMTA1LjI1IDEyMS45MTcsLTE4My4xMjUgMjM1LjQ1OCwtMTgzLjEyNWMxMzQuMTI1LDAgMjQyLjg3NSwxMDguNzA5IDI0Mi44NzUsMjQyLjg3NWwtMC4wNDEsLTAuMDQxWiIgc3R5bGU9ImZpbGw6Izc5ODA4NTtmaWxsLXJ1bGU6bm9uemVybzsiLz48cGF0aCBkPSJNMTc5Mi4xNywxMzUxLjYyYy0xNzUuMzM0LC02MC42NjcgLTM1MC4xNjcsLTEyNi40MTcgLTUxNi41LC0xOTMuODMzYzU5LjI5MSwyNzMuMjUgMzAyLjQxNiw0NzcuOTU4IDU5My40MTYsNDc3Ljk1OGMxNDguNzkyLDAgMjg1LjA0MiwtNTMuNTQyIDM5MC42MjUsLTE0Mi4zMzNjLTEzOC42NjYsLTM1LjEyNSAtMjkyLjIwOCwtODEuMTI1IC00NjcuNTQxLC0xNDEuNzkyWiIgc3R5bGU9ImZpbGw6dXJsKCNfTGluZWFyMSk7ZmlsbC1ydWxlOm5vbnplcm87Ii8+PHBhdGggZD0iTTEzMjQuODgsNzc2LjEyNWMyMjguNzUsMTExLjI1IDc4OC4yNSwzMDEuMzc1IDExMzkuNTQsMzcyLjU4M2M3Ljc5MSwtMzguODc1IDExLjkxNiwtNzkuMDgzIDExLjkxNiwtMTIwLjI1YzAsLTMzNS4zNzUgLTI3MS44NzUsLTYwNy4yOTEgLTYwNy4yOTEsLTYwNy4yOTFjLTI0NC4wODQsLTAgLTQ1NC40NTksMTQ0IC01NTAuOTU5LDM1MS42NjZjMi4yNSwxLjA4NCA0LjUsMi4yMDkgNi43OTIsMy4zMzRsMCwtMC4wNDJaIiBzdHlsZT0iZmlsbDp1cmwoI19MaW5lYXI0KTtmaWxsLXJ1bGU6bm9uemVybzsiLz48cGF0aCBkPSJNMjgxMi4wNCwxNDA2LjI1Yy05Ny4xMjUsLTExLjU0MiAtNTUyLjA0MiwtMTA3LjYyNSAtOTk2LjA4NCwtMjU2LjVjLTMwNCwtMTAxLjkxNyAtNjIyLjA4MywtMjQ0LjE2NyAtODI4Ljc1LC0zMzguOTU4Yy0zNzEuNDE2LC0xNzAuMzc1IC00ODYuNTQxLC0zMjIuNzA5IC0xODkuMjkxLC0yNzEuMjA5YzIwOS45MTYsMzYuMzc1IDM3My43MDgsODIuMjkyIDM3My43MDgsODIuMjkyYy0wLDAgLTM4MS45NTgsLTgyLjc5MiAtMzcuNTgzLDExNy45NThjMjU3LjgzMywxNTAuMjkyIDEyNDkuODMsNDQ3LjEyNSAxNTU3LjA0LDQ4NS43NWMxODkuMTY3LDIzLjc1IC01My4zMzMsLTExNS42MjUgLTUzLjMzMywtMTE1LjYyNWMwLDAgOTU5LjEyNSwzODkuNDE3IDE3NC4zNzUsMjk2LjI1bC0wLjA4MywwLjA0MloiIHN0eWxlPSJmaWxsOnVybCgjX0xpbmVhcjMpO2ZpbGwtcnVsZTpub256ZXJvOyIvPjxwYXRoIGQ9Ik0xMTUuMzMzLDQyNC41YzE4OS4xNjcsLTI4LjQxNyA5MDIuNjY3LDEzMy43MDggOTAyLjY2NywxMzMuNzA4YzAsMCAtODQ0LjE2NywtMTY2LjQxNiAtMzAzLjc1LDE0OC45MTdjMjE1LjgzMywxMjUuOTU4IDY2NS44MzMsMzMyLjQ1OCAxMTIxLjcxLDQ3NS4yNWM2MjEuNzkyLDE5NC43NSAxMDk0LjM4LDI5OC43OTIgMTI4NC43NSwyODcuNzA4YzI5Mi43NSwtMTcgLTM1NS4wNDEsLTMxNC41IC0zNTUuMDQxLC0zMTQuNWMtMCwwIDE0OTQuMTcsNTQ5LjA0MiAzODkuNjI1LDQ3Mi45MTdjLTMzNy4zNzUsLTIzLjI1IC03OTMuNSwtMTA5LjM3NSAtMTM1Ni41OCwtMzA5LjQxN2MtMTAyMiwtMzYzLjA0MSAtMjE3MC4xMiwtODIxLjUgLTE2ODMuMzgsLTg5NC41ODNaIiBzdHlsZT0iZmlsbDp1cmwoI19MaW5lYXI0KTtmaWxsLXJ1bGU6bm9uemVybzsiLz48L2c+PGRlZnM+PGxpbmVhckdyYWRpZW50IGlkPSJfTGluZWFyMSIgeDE9IjAiIHkxPSIwIiB4Mj0iMSIgeTI9IjAiIGdyYWRpZW50VW5pdHM9InVzZXJTcGFjZU9uVXNlIiBncmFkaWVudFRyYW5zZm9ybT0ibWF0cml4KDE5NjIuMjksMjkxLjUsLTI5MS41LDE5NjIuMjksMTI0MSwxMzUwLjkyKSI+PHN0b3Agb2Zmc2V0PSIwIiBzdHlsZT0ic3RvcC1jb2xvcjojYmY5ZDRmO3N0b3Atb3BhY2l0eToxIi8+PHN0b3Agb2Zmc2V0PSIwLjY1IiBzdHlsZT0ic3RvcC1jb2xvcjojOGM3MjMwO3N0b3Atb3BhY2l0eToxIi8+PHN0b3Agb2Zmc2V0PSIxIiBzdHlsZT0ic3RvcC1jb2xvcjojNzY2MDIzO3N0b3Atb3BhY2l0eToxIi8+PC9saW5lYXJHcmFkaWVudD48bGluZWFyR3JhZGllbnQgaWQ9Il9MaW5lYXIyIiB4MT0iMCIgeTE9IjAiIHgyPSIxIiB5Mj0iMCIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiIGdyYWRpZW50VHJhbnNmb3JtPSJtYXRyaXgoNjM0NjYzLDU5MjI5LjIsLTU5MjI5LjIsNjM0NjYzLDM3MDU4MCwxMTUxNDApIj48c3RvcCBvZmZzZXQ9IjAiIHN0eWxlPSJzdG9wLWNvbG9yOiNiZjlkNGY7c3RvcC1vcGFjaXR5OjEiLz48c3RvcCBvZmZzZXQ9IjAuNjUiIHN0eWxlPSJzdG9wLWNvbG9yOiM4YzcyMzA7c3RvcC1vcGFjaXR5OjEiLz48c3RvcCBvZmZzZXQ9IjEiIHN0eWxlPSJzdG9wLWNvbG9yOiM3NjYwMjM7c3RvcC1vcGFjaXR5OjEiLz48L2xpbmVhckdyYWRpZW50PjxsaW5lYXJHcmFkaWVudCBpZD0iX0xpbmVhcjMiIHgxPSIwIiB5MT0iMCIgeDI9IjEiIHkyPSIwIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgZ3JhZGllbnRUcmFuc2Zvcm09Im1hdHJpeCgyOTQxLjEyLDExMjQuNjgsLTExMjQuNjgsMjk0MS4xMiwzOTEuMDc3LDQzMC45NjUpIj48c3RvcCBvZmZzZXQ9IjAiIHN0eWxlPSJzdG9wLWNvbG9yOiNiYjk5NGM7c3RvcC1vcGFjaXR5OjEiLz48c3RvcCBvZmZzZXQ9IjAuMzIiIHN0eWxlPSJzdG9wLWNvbG9yOiNiODk2NGE7c3RvcC1vcGFjaXR5OjEiLz48c3RvcCBvZmZzZXQ9IjAuNTIiIHN0eWxlPSJzdG9wLWNvbG9yOiNhZjhmNDQ7c3RvcC1vcGFjaXR5OjEiLz48c3RvcCBvZmZzZXQ9IjAuNjkiIHN0eWxlPSJzdG9wLWNvbG9yOiNhMDgzM2I7c3RvcC1vcGFjaXR5OjEiLz48c3RvcCBvZmZzZXQ9IjAuODQiIHN0eWxlPSJzdG9wLWNvbG9yOiM4YzcyMmQ7c3RvcC1vcGFjaXR5OjEiLz48c3RvcCBvZmZzZXQ9IjAuOTEiIHN0eWxlPSJzdG9wLWNvbG9yOiM4MDY4MjY7c3RvcC1vcGFjaXR5OjEiLz48c3RvcCBvZmZzZXQ9IjEiIHN0eWxlPSJzdG9wLWNvbG9yOiM3YTY0MjQ7c3RvcC1vcGFjaXR5OjEiLz48L2xpbmVhckdyYWRpZW50PjxsaW5lYXJHcmFkaWVudCBpZD0iX0xpbmVhcjQiIHgxPSIwIiB5MT0iMCIgeDI9IjEiIHkyPSIwIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgZ3JhZGllbnRUcmFuc2Zvcm09Im1hdHJpeCgyODIzLjI1LDExNTAuODksLTExNTAuODksMjgyMy4yNSwzOTIuOTc5LDQ4MS4xNDQpIj48c3RvcCBvZmZzZXQ9IjAiIHN0eWxlPSJzdG9wLWNvbG9yOiNiNzk3NGE7c3RvcC1vcGFjaXR5OjEiLz48c3RvcCBvZmZzZXQ9IjAuMTMiIHN0eWxlPSJzdG9wLWNvbG9yOiNiMTkxNDQ7c3RvcC1vcGFjaXR5OjEiLz48c3RvcCBvZmZzZXQ9IjAuNjQiIHN0eWxlPSJzdG9wLWNvbG9yOiNhMDdlMzI7c3RvcC1vcGFjaXR5OjEiLz48c3RvcCBvZmZzZXQ9IjEiIHN0eWxlPSJzdG9wLWNvbG9yOiM5YTc4MmM7c3RvcC1vcGFjaXR5OjEiLz48L2xpbmVhckdyYWRpZW50PjwvZGVmcz48L3N2Zz4=');
    add_submenu_page("intastellar-consents", "Intro", "Intro", "manage_options", "intastellar-consents", "intastellarGDPRSettingsForm", null);
    add_submenu_page("intastellar-consents", "Branding", "Branding", "manage_options", "intastellar-consents/branding", "intastellarCookieBranding", null);
    add_submenu_page("intastellar-consents", "Settings", "Settings", "manage_options", "intastellar-consents/settings", "intastellarCookieSettings", null);
    add_submenu_page("intastellar-consents", "Privacy", "Privacy", "manage_options", "intastellar-consents/privacy", "intastellarGDPRPrivacyPage", null);
    add_submenu_page("intastellar-consents", "Help", "Help", "manage_options", "intastellar-consents/help", "intastellarCookieHelp", null);
}
add_action('admin_menu', 'initIntastellarSettingsPage');

if (isset($_SERVER["REQUEST_URI"]) && strpos(sanitize_url(wp_unslash($_SERVER["REQUEST_URI"])), "wp-login.php") === false && !is_admin()) {
    // Load the cookie banner
    add_action('init', 'loadIntastellarCookieBanner');
}

function loadIntastellarCookieBanner()
{
    if (get_option('intastellarCustomIcon')) {
        $logo = get_option('intastellarCustomIcon');
    } else {
        $logo = "";
    }

    if (get_option("intastellarDisplayCookieAdvenced")) {
        $advanced = filter_var(get_option('intastellarDisplayCookieAdvenced'), FILTER_VALIDATE_BOOLEAN);
    } else {
        $advanced = false;
    }

    if (get_option("intastellarCookieBannerColor")) {
        $color = get_option("intastellarCookieBannerColor");
    } else {
        $color = get_theme_mod('background_color');
    }

    if (get_option("intastellarCookieBanner-brandName")) {
        $brandName = get_option("intastellarCookieBanner-brandName");
    } else {
        $brandName = get_bloginfo("name");
    }

    if (get_option('intastellarPrivacyLink-checkbox')) {
        $link = array(
            "url" => get_option('intastellarPrivacyLink'),
            "target" => "_blank"
        );
    } else {
        $link = get_option('intastellarPrivacyLink');
    }
    $collection = explode("\n", get_option('intastellarCCPAcollection'));
    $collection = array_map('trim', $collection);

    $rootDomain = get_option('intastellarSiteRoot');

    $requiredCookies = (str_contains(get_option('intastellarCookieList'), "\n")) ? explode("\n", get_option('intastellarCookieList')) : explode(",", get_option('intastellarCookieList'));

    wp_add_inline_script(
        'intastellar-gdpr-settings',
        'window.INTA = ' . wp_json_encode(array(
            'policy_link' => $link,
            'settings' => array(
                'language' => get_option("intastellarSelectLanguage"),
                'arrange' => get_option("intastellarSetCookiePosition"),
                'logo' => $logo,
                'color' => $color,
                'company' => $brandName,
                'design' => get_option('intastellarBannerStyle'),
                'text' => filter_var(get_option('intastellarDisplayCookieNoticeText'), FILTER_VALIDATE_BOOLEAN),
                'requiredCookies' => $requiredCookies,
                'advanced' => $advanced,
                'rootDomain' => $rootDomain
            ),
        )),
        'before'
    );
}

?>
<?php
function intastellarCookieSettings()
{
    $value = get_option('intastellarDisplayCookieNoticeText');
    $value1 = get_option('intastellarSetCookiePosition');
    $language = get_option('intastellarSelectLanguage');

    $plugin_version = get_plugin_data(__FILE__)['Version'];
?>
    <section class="intastellarPluginContent">
        <?php include("intastellarGDPRAdminPanelHeader.php"); ?>
        <section class="intastellarPluginGrid">
            <div class="intastellarPluginContent">
                <header class="intastellarPluginPage-header">
                    <h3 class="intastellarPluginHeader__headline">Settings</h3>
                    <p>Adjust here your settings for the cookiebanner, choose where the banner should be position, if you want to have Cookie notice text, view it in fullscreen and change your prefered language.</p>
                </header>
                <form method="post" action="options.php" enctype="multipart/form-data">
                    <?php settings_fields('intastellar-consents_plugin_options-group'); ?>
                    <section class="intastellarPluginContent">
                        <h2>
                            Choose your banner style:
                        </h2>
                        <section class="grid">
                            <label class="intastellarPlugin-style-seletor" for="overlay">
                                <input type="radio" value="overlay" <?php if (get_option("intastellarBannerStyle") == "overlay") {
                                                                        echo esc_html(sanitize_text_field("checked"));
                                                                    } ?> name="intastellarBannerStyle" id="overlay">
                                <img class="intastellar-banner-style-preview" src="<?php echo esc_url(plugin_dir_url(__FILE__) . "/assets/banner-design-2.png") ?>">
                            </label>
                            <label class="intastellarPlugin-style-seletor" for="banner">
                                <input type="radio" value="banner" <?php if (get_option("intastellarBannerStyle") == "banner") {
                                                                        echo esc_html(sanitize_text_field("checked"));
                                                                    } ?> name="intastellarBannerStyle" id="banner">
                                <img class="intastellar-banner-style-preview --banner" src="<?php echo esc_url(plugin_dir_url(__FILE__) . "/assets/banner-design-1.png") ?>">
                            </label>
                            <label class="intastellarPlugin-style-seletor" for="bannerV2">
                                <input type="radio" value="bannerV2" <?php if (get_option("intastellarBannerStyle") == "bannerV2") {
                                                                            echo esc_html(sanitize_text_field("checked"));
                                                                        } ?> name="intastellarBannerStyle" id="bannerV2">
                                <img class="intastellar-banner-style-preview --banner" src="<?php echo esc_url(plugin_dir_url(__FILE__) . "/assets/banner-design-2-v2.png") ?>">
                            </label>
                        </section>
                    </section>
                    <section id="placement" class="intastellarPluginContent__items">
                        <label for="intastellarSetCookiePosition_id">Placement:</label>
                        <select name="intastellarSetCookiePosition" class="regular-text" id="intastellarSetCookiePosition_id">
                            <option value="ltr" <?php echo esc_html(($value1 == 'ltr' ? 'selected="selected"' : '')); ?>>Left</option>
                            <option value="rtl" <?php echo esc_html(($value1 == 'rtl' ? 'selected="selected"' : '')); ?>>Right</option>
                        </select>
                    </section>
                    <section class="intastellarPluginContent__items">
                        <label for="rootDomain">Your Main Domain</label>
                        <input type="text" name="intastellarSiteRoot" class="regular-text" id="rootDomain" value="<?php echo esc_attr(get_option("intastellarSiteRoot")); ?>">
                    </section>
                    <section id="language" class="intastellarPluginContent__items">
                        <label for="intastellarSelectLanguage_id">Language:</label>
                        <select id="intastellarSelectLanguage_id" class="regular-text" name="intastellarSelectLanguage">
                            <option value="auto" <?php echo esc_attr(sanitize_text_field(($language == 'auto' ? 'selected="selected"' : ''))); ?> selected>Auto detect</option>
                            <option value="danish" <?php echo esc_attr(sanitize_text_field(($language == 'danish' ? 'selected="selected"' : ''))); ?>>Danish</option>
                            <option value="dutch" <?php echo esc_attr(sanitize_text_field(($language == 'dutch' ? 'selected="selected"' : ''))); ?>>Dutch</option>
                            <option value="english" <?php echo esc_attr(sanitize_text_field(($language == 'english' ? 'selected="selected"' : ''))); ?>>English</option>
                            <option value="french" <?php echo esc_attr(sanitize_text_field(($language == 'french' ? 'selected="selected"' : ''))); ?>>French</option>
                            <option value="finnish" <?php echo esc_attr(sanitize_text_field(($language == 'finnish' ? 'selected="selected"' : ''))); ?>>Finnish</option>
                            <option value="german" <?php echo esc_attr(sanitize_text_field(($language == 'german' ? 'selected="selected"' : ''))); ?>>German</option>
                            <option value="italian" <?php echo esc_attr(sanitize_text_field(($language == 'italian' ? 'selected="selected"' : ''))); ?>>Italian</option>
                            <option value="norwegian" <?php echo esc_attr(sanitize_text_field(($language == 'norwegian' ? 'selected="selected"' : ''))); ?>>Norwegian</option>
                            <option value="russian" <?php echo esc_attr(sanitize_text_field(($language == 'russian' ? 'selected="selected"' : ''))); ?>>Russian</option>
                            <option value="spanish" <?php echo esc_attr(sanitize_text_field(($language == 'spanish' ? 'selected="selected"' : ''))); ?>>Spanish</option>
                            <option value="swedish" <?php echo esc_attr(sanitize_text_field(($language == 'swedish' ? 'selected="selected"' : ''))); ?>>Swedish</option>
                        </select>
                    </section>
                    <section>
                        <label>
                            <h3>Required Cookies list:</h3>
                            <p>Write here a list of cookies that the website is required to use.</p>
                            <p>Example 1: <code>cookie1, cookie2, cookie3</code></p>
                            <p>Example 2: <code>
                                    cookie1
                                    cookie2
                                    cookie3
                                </code></p>
                            <textarea name="" id="cookieList" cols="30" rows="10" value="<?php echo esc_attr(sanitize_text_field(get_option('intastellarCookieList'))); ?>"></textarea>
                        </label>
                    </section>
                    <section id="text" class="intastellarPluginContent__items">
                        Display Cookie Notice text:
                        <section>
                            <input type="radio" class="regular-text --radio" name="intastellarDisplayCookieNoticeText" value="true" <?php echo esc_html(sanitize_text_field(($value == 'true' ? 'checked="checked"' : ''))); ?> /> Yes
                            <input type="radio" class="regular-text --radio" name="intastellarDisplayCookieNoticeText" value="false" <?php echo esc_html(sanitize_text_field(($value == 'false' || $value == '' ? 'checked="checked"' : ''))); ?> /> No
                        </section>
                    </section>
                    <input type='hidden' class="regular-text --fullWidth" id="intastellarCustomIcon_id" name="intastellarCustomIcon" value="<?php echo esc_attr(sanitize_text_field(get_option('intastellarCustomIcon'))); ?>">
                    <input type='hidden' class="regular-text --color" id="intastellarCookieBannerColor_id" name="intastellarCookieBannerColor" value="<?php if (get_option('intastellarCookieBannerColor')) {
                                                                                                                                                            echo esc_html(get_option('intastellarCookieBannerColor'));
                                                                                                                                                        } else {
                                                                                                                                                            echo esc_html(get_theme_mod('background_color'));
                                                                                                                                                        } ?>">
                    <input type='hidden' class="regular-text" id="intastellarPrivacyLink_id" name="intastellarPrivacyLink" required value="<?php echo esc_attr(sanitize_text_field(get_option('intastellarPrivacyLink'))); ?>">
                    <input type="hidden" id="intastellarPrivacyLink-checkbox" name="intastellarPrivacyLink-checkbox" value="<?php echo esc_attr(sanitize_text_field(get_option('intastellarPrivacyLink-checkbox'))); ?>">
                    <input type="hidden" class="regular-text --color" id="intastellarCookieBanner-brandName" value="<?php if (get_option('intastellarCookieBanner-brandName')) {
                                                                                                                        echo esc_html(sanitize_text_field(get_option('intastellarCookieBanner-brandName')));
                                                                                                                    } else {
                                                                                                                        echo esc_html(sanitize_text_field(get_bloginfo("name")));
                                                                                                                    } ?>">
                    <button type="submit" class="intastellarPluginSaveButton">Save changes</button>
                </form>
                <p>You can also read the docs and download the newest version: <a href="https://developers.intastellarsolutions.com/cookie-solutions/docs/wordpress-docs?utm_medium=wordpress_plugin&utm_source=<?php if (isset($_SERVER["HTTP_HOST"])) {
                                                                                                                                                                                                                    echo esc_url(sanitize_url(wp_unslash($_SERVER["HTTP_HOST"])));
                                                                                                                                                                                                                } ?>" target="_blank" rel="noopener">Intastellar GDPR cookie banner</a></p>
                <?php include("intastellarGDPRAdminPanelFooter.php"); ?>
            </div>
        </section>
    </section>
<?php
}
?>
<?php
function intastellarGDPRSettingsForm()
{
    $checkbox = get_option('intastellarPrivacyLink-checkbox');
    $language = get_option('intastellarSelectLanguage');
    $plugin_version = get_plugin_data(__FILE__)['Version'];
?>
    <section class="intastellarPluginContent">
        <?php include("intastellarGDPRAdminPanelHeader.php"); ?>
        <?php
        $plugin_version = get_plugin_data(__FILE__)['Version'];
        if ($plugin_version != get_option('intastellarPluginVersion')) {
            update_option('intastellarPluginVersion', $plugin_version);
            esc_html('<div class="intastellarPluginContent__items --update">New Version: ' . $plugin_version . '</div>');
        }
        ?>
        <section class="intastellarPluginGrid">

            <div class="intastellarPluginContent">
                <header class="intastellarPluginPage-header">
                    <h3 class="intastellarPluginHeader__headline">Welcome to Intastellar Consents Solutions</h3>
                    <p>This cookie banner helps you and your Website to become GDPR conform.</p>
                </header>
                <form method="post" action="options.php" enctype="multipart/form-data">
                    <p>To get started we need your Privacy Policy to begin with. After that you can edit the branding: choose your brand color and your own logo, and under the settings page you can go into detail, the placement of the cookie banner, choose whether nor to display text in the cookie notice, or what language you wanna use.</p>
                    <p>You wanna learn more about this cookie banner? Then you can read more under: <a target="_blank" href="https://www.intastellarsolutions.com/solutions/cookie-consents">www.intastellarsolutions.com/solutions/cookie-consents</a></p>
                    <p>So lets get started with your privacy policy & prefered language.</p>
                    <?php settings_fields('intastellar-consents_plugin_options-group'); ?>
                    <section id="privacy" class="intastellarPluginContent__items">
                        <label for="intastellarPrivacyLink_id">URL to <strong>your</strong> Privacy Policy page*:</label>
                        <section>
                            <input type='text' class="regular-text" id="intastellarPrivacyLink_id" name="intastellarPrivacyLink" required value="<?php echo esc_attr(sanitize_text_field(get_option('intastellarPrivacyLink'))); ?>">
                            <input type="checkbox" class="intastellarPluginContent__items-checkbox" id="intastellarPrivacyLink-checkbox" name="intastellarPrivacyLink-checkbox" value="true" <?php echo esc_html(sanitize_text_field(($checkbox == 'true' ? 'checked="checked"' : ''))); ?>> <label for="intastellarPrivacyLink-checkbox">Open in new window</label>
                        </section>
                    </section>
                    <section class="intastellarPluginContent__items">
                        <label for="rootDomain">Your Main Domain</label>
                        <input type="text" name="intastellarSiteRoot" class="regular-text" id="rootDomain" value="<?php echo esc_attr(sanitize_text_field(get_option("intastellarSiteRoot"))); ?>">
                    </section>
                    <section id="language" class="intastellarPluginContent__items">
                        <label for="intastellarSelectLanguage_id">Language:</label>
                        <select id="intastellarSelectLanguage_id" class="regular-text" name="intastellarSelectLanguage">
                            <option value="auto" <?php echo esc_attr(sanitize_text_field(($language == 'auto' ? 'selected="selected"' : ''))); ?> selected>Auto detect</option>
                            <option value="danish" <?php echo esc_attr(sanitize_text_field(($language == 'danish' ? 'selected="selected"' : ''))); ?>>Danish</option>
                            <option value="dutch" <?php echo esc_attr(sanitize_text_field(($language == 'dutch' ? 'selected="selected"' : ''))); ?>>Dutch</option>
                            <option value="english" <?php echo esc_attr(sanitize_text_field(($language == 'english' ? 'selected="selected"' : ''))); ?>>English</option>
                            <option value="french" <?php echo esc_attr(sanitize_text_field(($language == 'french' ? 'selected="selected"' : ''))); ?>>French</option>
                            <option value="finnish" <?php echo esc_attr(sanitize_text_field(($language == 'finnish' ? 'selected="selected"' : ''))); ?>>Finnish</option>
                            <option value="german" <?php echo esc_attr(sanitize_text_field(($language == 'german' ? 'selected="selected"' : ''))); ?>>German</option>
                            <option value="italian" <?php echo esc_attr(sanitize_text_field(($language == 'italian' ? 'selected="selected"' : ''))); ?>>Italian</option>
                            <option value="norwegian" <?php echo esc_attr(sanitize_text_field(($language == 'norwegian' ? 'selected="selected"' : ''))); ?>>Norwegian</option>
                            <option value="russian" <?php echo esc_attr(sanitize_text_field(($language == 'russian' ? 'selected="selected"' : ''))); ?>>Russian</option>
                            <option value="spanish" <?php echo esc_attr(sanitize_text_field(($language == 'spanish' ? 'selected="selected"' : ''))); ?>>Spanish</option>
                            <option value="swedish" <?php echo esc_attr(sanitize_text_field(($language == 'swedish' ? 'selected="selected"' : ''))); ?>>Swedish</option>
                        </select>
                    </section>
                    <input type='hidden' class="regular-text --fullWidth" id="intastellarCustomIcon_id" name="intastellarCustomIcon" value="<?php echo esc_attr(sanitize_text_field(get_option('intastellarCustomIcon'))); ?>">
                    <input type="hidden" name="intastellarSetCookiePosition" id="intastellarSetCookiePosition_id" value="<?php echo esc_attr(sanitize_text_field(get_option('intastellarSetCookiePosition'))); ?>">
                    <input type='hidden' class="regular-text --color" id="intastellarCookieBannerColor_id" name="intastellarCookieBannerColor" value="<?php if (get_option('intastellarCookieBannerColor')) {
                                                                                                                                                            echo esc_html(sanitize_text_field(get_option('intastellarCookieBannerColor')));
                                                                                                                                                        } else {
                                                                                                                                                            echo esc_html(sanitize_text_field(get_theme_mod('background_color')));
                                                                                                                                                        } ?>">
                    <input type="hidden" name="intastellarDisplayCookieAdvenced" id="intastellarDisplayCookieAdvenced" value="<?php echo esc_attr(sanitize_text_field(get_option('intastellarDisplayCookieAdvenced'))); ?>">
                    <input type="hidden" name="intastellarDisplayCookieNoticeText" id="intastellarDisplayCookieNoticeText" value="<?php echo esc_attr(sanitize_text_field(get_option('intastellarDisplayCookieNoticeText'))); ?>">
                    <input type="hidden" class="regular-text --color" id="intastellarCookieBanner-brandName" value="<?php if (get_option('intastellarCookieBanner-brandName')) {
                                                                                                                        echo esc_html(sanitize_text_field(get_option('intastellarCookieBanner-brandName')));
                                                                                                                    } else {
                                                                                                                        echo esc_html(sanitize_text_field(get_bloginfo("name")));
                                                                                                                    } ?>">
                    <input type="hidden" name="intastellarBannerStyle" value="<?php if (get_option('intastellarBannerStyle')) {
                                                                                    echo esc_html(sanitize_text_field(get_option('intastellarBannerStyle')));
                                                                                } else {
                                                                                    echo esc_html(sanitize_text_field("overlay"));
                                                                                } ?>">
                    <button type="submit" class="intastellarPluginSaveButton">Save changes</button>
                </form>
                <p>You can also read the docs or download the newest version: <a href="https://developers.intastellarsolutions.com/cookie-solutions/docs/wordpress-docs?utm_medium=wordpress_plugin&utm_source=<?php if (isset($_SERVER["HTTP_HOST"])) {
                                                                                                                                                                                                                    echo esc_url(sanitize_url(wp_unslash($_SERVER["HTTP_HOST"])));
                                                                                                                                                                                                                } ?>" target="_blank" rel="noopener">Intastellar Consents Solutions</a></p>
                <?php include("intastellarGDPRAdminPanelFooter.php"); ?>
            </div>
        </section>
    </section>
<?php } ?>
<?php
function intastellarGDPRPrivacyPage()
{
    $checkbox = get_option('intastellarPrivacyLink-checkbox');
    $plugin_version = get_plugin_data(__FILE__)['Version'];
?>
    <section class="intastellarPluginContent">
        <?php include("intastellarGDPRAdminPanelHeader.php"); ?>
        <section class="intastellarPluginGrid">

            <div class="intastellarPluginContent">
                <header class="intastellarPluginPage-header">
                    <h3 class="intastellarPluginHeader__headline">Privacy Policy</h3>
                    <p>Change your privacy link and if you want to have it open in a new window.</p>
                </header>
                <form method="post" action="options.php" enctype="multipart/form-data">
                    <?php settings_fields('intastellar-consents_plugin_options-group'); ?>
                    <section id="privacy" class="intastellarPluginContent__items">
                        <label for="intastellarPrivacyLink_id">URL to <strong>your</strong> Privacy Policy page*:</label>
                        <section>
                            <input type='text' class="regular-text" id="intastellarPrivacyLink_id" name="intastellarPrivacyLink" required value="<?php echo esc_attr(sanitize_text_field(get_option('intastellarPrivacyLink'))); ?>">
                            <input type="checkbox" class="intastellarPluginContent__items-checkbox" id="intastellarPrivacyLink-checkbox" name="intastellarPrivacyLink-checkbox" value="true" <?php echo esc_html(sanitize_text_field(sanitize_text_field(($checkbox == 'true' ? 'checked="checked"' : '')))); ?>> <label for="intastellarPrivacyLink-checkbox">Open in new window</label>
                        </section>
                    </section>
                    <input type="hidden" id="intastellarSelectLanguage_id" name="intastellarSelectLanguage" value="<?php echo esc_attr(sanitize_text_field(get_option('intastellarSelectLanguage'))); ?>">
                    <input type="hidden" id="intastellarSelectLanguage_id" name="intastellarSiteRoot" value="<?php echo esc_attr(sanitize_text_field(get_option('intastellarSiteRoot'))); ?>">
                    <input type='hidden' class="regular-text --fullWidth" id="intastellarCustomIcon_id" name="intastellarCustomIcon" value="<?php echo esc_attr(sanitize_text_field(get_option('intastellarCustomIcon'))); ?>">
                    <input type='hidden' class="regular-text --color" id="intastellarCookieBannerColor_id" name="intastellarCookieBannerColor" value="<?php if (get_option('intastellarCookieBannerColor')) {
                                                                                                                                                            echo esc_html(sanitize_text_field(get_option('intastellarCookieBannerColor')));
                                                                                                                                                        } else {
                                                                                                                                                            echo esc_html(sanitize_text_field(get_theme_mod('background_color')));
                                                                                                                                                        } ?>">
                    <input type="hidden" name="intastellarSetCookiePosition" id="intastellarSetCookiePosition_id" value="<?php echo esc_attr(sanitize_text_field(get_option('intastellarSetCookiePosition'))); ?>">
                    <input type="hidden" name="intastellarSiteRoot" id="intastellarSetCookiePosition_id" value="<?php echo esc_attr(sanitize_text_field(get_option('intastellarSiteRoot'))); ?>">
                    <input type="hidden" class="regular-text --color" id="intastellarCookieBanner-brandName" value="<?php if (get_option('intastellarCookieBanner-brandName')) {
                                                                                                                        echo esc_html(sanitize_text_field(get_option('intastellarCookieBanner-brandName')));
                                                                                                                    } else {
                                                                                                                        echo esc_html(sanitize_text_field(get_bloginfo("name")));
                                                                                                                    } ?>">
                    <input type="hidden" name="intastellarBannerStyle" value="<?php if (get_option('intastellarBannerStyle')) {
                                                                                    echo esc_html(sanitize_text_field(get_option('intastellarBannerStyle')));
                                                                                } else {
                                                                                    echo esc_html(sanitize_text_field("overlay"));
                                                                                } ?>">
                    <input type="hidden" name="intastellarDisplayCookieAdvenced" id="intastellarDisplayCookieAdvenced" value="<?php echo esc_attr(sanitize_text_field(get_option('intastellarDisplayCookieAdvenced'))); ?>">
                    <input type="hidden" name="intastellarDisplayCookieNoticeText" id="intastellarDisplayCookieNoticeText" value="<?php echo esc_attr(sanitize_text_field(get_option('intastellarDisplayCookieNoticeText'))); ?>">
                    <button type="submit" class="intastellarPluginSaveButton">Save changes</button>
                </form>
                <p>You can also read the docs or download the newest version: <a href="https://developers.intastellarsolutions.com/cookie-solutions/docs/wordpress-docs?utm_medium=wordpress_plugin&utm_source=<?php if (isset($_SERVER["HTTP_HOST"])) {
                                                                                                                                                                                                                    echo esc_url(sanitize_url(wp_unslash($_SERVER["HTTP_HOST"])));
                                                                                                                                                                                                                } ?>" target="_blank" rel="noopener">Intastellar Consents Solutions</a></p>
                <?php include("intastellarGDPRAdminPanelFooter.php"); ?>
            </div>
        </section>
    </section>
<?php } ?>
<?php
function intastellarCookieBranding()
{
    $plugin_version = get_plugin_data(__FILE__)['Version'];
?>
    <section class="intastellarPluginContent">
        <?php include("intastellarGDPRAdminPanelHeader.php"); ?>
        <section class="intastellarPluginGrid">

            <div class="intastellarPluginContent">
                <header class="intastellarPluginPage-header">
                    <h3 class="intastellarPluginHeader__headline">Branding</h3>
                    <p>Customize the banner to reflect your brands identity. Change the apperance of the cookie banner, by using your brand color and logo. </p>
                </header>
                <form method="post" action="options.php" enctype="multipart/form-data">
                    <?php settings_fields('intastellar-consents_plugin_options-group'); ?>
                    <section id="brandname" class="intastellarPluginContent__items">
                        <label for="intastellarCustomIcon_id">
                            Company name:
                        </label>
                        <section>
                            <input type="text" class="regular-text" id="intastellarCookieBanner-brandName" name="intastellarCookieBanner-brandName" value="<?php if (get_option('intastellarCookieBanner-brandName')) {
                                                                                                                                                                echo esc_html(sanitize_text_field(get_option('intastellarCookieBanner-brandName')));
                                                                                                                                                            } else {
                                                                                                                                                                echo esc_html(sanitize_text_field(get_bloginfo("name")));
                                                                                                                                                            } ?>">
                        </section>
                    </section>
                    <section id="color" class="intastellarPluginContent__items">
                        <label for="intastellarCookieBannerColor_id">Brand Color:</label>
                        <div class="colorPallet">
                            <input type='color' class="regular-text --color" id="intastellarCookieBannerColor_id" name="intastellarCookieBannerColor" value="<?php if (get_option('intastellarCookieBannerColor')) {
                                                                                                                                                                    echo esc_html(sanitize_text_field(get_option('intastellarCookieBannerColor')));
                                                                                                                                                                } else {
                                                                                                                                                                    echo esc_html(sanitize_text_field(get_theme_mod('background_color')));
                                                                                                                                                                } ?>">
                            <span class="colorValue" id="intastellarCookieBannerColorValue" contenteditable><?php if (get_option('intastellarCookieBannerColor')) {
                                                                                                                echo esc_html(sanitize_text_field(get_option('intastellarCookieBannerColor')));
                                                                                                            } else {
                                                                                                                echo esc_html(sanitize_text_field(get_theme_mod('background_color')));
                                                                                                            } ?></span>
                        </div>
                    </section>
                    <section id="logo" class="intastellarPluginContent__items">
                        <label for="intastellarCustomIcon_id">Company Logo:
                            <br>
                            <small>Recommended:<br>A max-width of 200px <br> and a min-width of 100px <br>for near square logos</small>
                            <input type='hidden' class="regular-text --fullWidth" id="intastellarCustomIcon_id" name="intastellarCustomIcon" value="<?php echo esc_attr(sanitize_text_field(get_option('intastellarCustomIcon'))); ?>">
                            <button type="button" class="button" id="intastellarCustomIconButton">Select or Upload Logo</button>
                        </label>
                        <section>
                            <img src="<?php echo esc_html(sanitize_text_field(get_option('intastellarCustomIcon'))); ?>" class="intastellarCookieSettingsLogo" id="intastellarCustomIconPreview">
                        </section>
                    </section>
                    <input type='hidden' class="regular-text" id="intastellarPrivacyLink_id" name="intastellarPrivacyLink" required value="<?php echo esc_attr(sanitize_text_field(get_option('intastellarPrivacyLink'))); ?>">
                    <input type="hidden" id="intastellarSelectLanguage_id" name="intastellarSelectLanguage" value="<?php echo esc_attr(sanitize_text_field(get_option('intastellarSelectLanguage'))); ?>">
                    <input type="hidden" name="intastellarSetCookiePosition" id="intastellarSetCookiePosition_id" value="<?php echo esc_attr(sanitize_text_field(get_option('intastellarSetCookiePosition'))); ?>">
                    <input type="hidden" id="intastellarPrivacyLink-checkbox" name="intastellarPrivacyLink-checkbox" value="<?php echo esc_attr(sanitize_text_field(get_option('intastellarPrivacyLink-checkbox'))); ?>">
                    <input type="hidden" name="intastellarDisplayCookieAdvenced" id="intastellarDisplayCookieAdvenced" value="<?php echo esc_attr(sanitize_text_field(get_option('intastellarDisplayCookieAdvenced'))); ?>">
                    <input type="hidden" name="intastellarDisplayCookieNoticeText" id="intastellarDisplayCookieNoticeText" value="<?php echo esc_attr(sanitize_text_field(get_option('intastellarDisplayCookieNoticeText'))); ?>">
                    <input type="hidden" name="intastellarSiteRoot" class="regular-text" id="rootDomain" value="<?php echo esc_attr(sanitize_text_field(get_option("intastellarSiteRoot"))); ?>">
                    <input type="hidden" name="intastellarBannerStyle" value="<?php if (get_option('intastellarBannerStyle')) {
                                                                                    echo esc_html(sanitize_text_field(get_option('intastellarBannerStyle')));
                                                                                } else {
                                                                                    echo esc_html(sanitize_text_field("overlay"));
                                                                                } ?>">
                    <button type="submit" class="intastellarPluginSaveButton">Save changes</button>
                </form>
                <p>You can also read the docs and download the newest version: <a href="https://developers.intastellarsolutions.com/cookie-solutions/docs/wordpress-docs?utm_medium=wordpress_plugin&utm_source=<?php if (isset($_SERVER["HTTP_HOST"])) {
                                                                                                                                                                                                                    echo esc_url(sanitize_url(wp_unslash($_SERVER["HTTP_HOST"])));
                                                                                                                                                                                                                } ?>" target="_blank" rel="noopener">Intastellar Consents Solutions</a></p>
                <?php include("intastellarGDPRAdminPanelFooter.php"); ?>
            </div>
        </section>
    </section>
<?php } ?>
<?php
function intastellarCookieHelp()
{
    $plugin_version = get_plugin_data(__FILE__)['Version'];
?>
    <section class="intastellarPluginContent">
        <?php include("intastellarGDPRAdminPanelHeader.php"); ?>
        <section class="intastellarPluginGrid">

            <div class="intastellarPluginContent">
                <h1>Help</h1>
                <p>A list of documentation & faq´s to help you further:</p>
                <ul>
                    <li><a href="https://developers.intastellarsolutions.com/cookie-solutions/docs/wordpress-docs" target="_blank">Official Documentation</a></li>
                    <li><a href="https://support.intastellarsolutions.com/cookie-solutions/faq" target="_blank">Official FAQ´s</a></li>
                </ul>
                <?php include("intastellarGDPRAdminPanelFooter.php"); ?>
            </div>
        </section>
    </section>
<?php } ?>