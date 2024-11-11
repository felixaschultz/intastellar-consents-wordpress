<?php
/*
    Plugin Name: Intastellar Consents Solution
    Plugin URI: https://www.intastellarsolutions.com/solutions/cookie-consents
    Version: 3.2.2
    Description: Get your Website GDPR Compliance: Remove 3rd partie cookies from begin on until user gives consents. We are helping you and your Website to become GDPR compliant.
    Author: Intastellar Solutions, International
    Text Domain: intastellar-consents
    Author URI: https://www.intastellarsolutions.com
    License:           GPL v2 or later
    License URI:       https://www.gnu.org/licenses/gpl-2.0.html
    */
require_once(ABSPATH . 'wp-admin/includes/plugin.php');

function intastellarSettingsRegistration()
{
    register_setting('intastellar-consents_plugin_options_group', 'intastellarCustomIcon');
    register_setting('intastellar-consents_plugin_options_group', 'intastellarCookieBannerColor');
    register_setting('intastellar-consents_plugin_options_group', 'intastellarCookieBanner-brandName');
    register_setting('intastellar-consents_plugin_options_group', 'intastellarPrivacyLink');
    register_setting('intastellar-consents_plugin_options_group', 'intastellarPrivacyLink-checkbox');
    register_setting('intastellar-consents_plugin_options_group', 'intastellarSetCookiePosition');
    register_setting('intastellar-consents_plugin_options_group', 'intastellarDisplayCookieNoticeText');
    register_setting('intastellar-consents_plugin_options_group', 'intastellarSelectLanguage');
    register_setting('intastellar-consents_plugin_options_group', 'intastellarCCPA');
    register_setting('intastellar-consents_plugin_options_group', 'intastellarCCPAUrl');
    register_setting('intastellar-consents_plugin_options_group', "intastellarDisplayCookieAdvenced");
    register_setting('intastellar-consents_plugin_options_group', 'intastellarCCPAcollection');
    register_setting('intastellar-consents_plugin_options_group', 'intastellarCookieList');
    register_setting('intastellar-consents_plugin_options_group', 'intastellarSiteRoot');
}

add_action('admin_init', 'intastellarSettingsRegistration', 1);
add_action('admin_enqueue_scripts', 'initIntastellarAdminStyles', 1);

function initIntastellarAdminStyles()
{
    wp_register_style('intastellarStyle', plugin_dir_url(__FILE__) . 'intastellarAdminStyle.css', false, '1.5.0');
    wp_enqueue_style('intastellarStyle');
    wp_enqueue_script('intastellarScript', plugin_dir_url(__FILE__) . 'intastellarAdminScript.js', false, '1.5.0');
}

function initIntastellarSettingsPage()
{
    add_menu_page('Intastellar Consents', 'Intastellar Consents', 'manage_options', 'intastellar-consents', 'intastellarGDPRSettingsForm', 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDI2LjAuMSwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9IjAgMCA1MDEuOCAyMzEuMyIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTAxLjggMjMxLjM7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPHN0eWxlIHR5cGU9InRleHQvY3NzIj4KCS5zdDB7ZmlsbC1ydWxlOmV2ZW5vZGQ7Y2xpcC1ydWxlOmV2ZW5vZGQ7ZmlsbDojRkZGRkZGO30KPC9zdHlsZT4KPHBhdGggY2xhc3M9InN0MCIgZD0iTTE2MS43LDExNC41Yy0yMTIuOS04Ni0yNS02Ni4zLTI1LTY2LjNzLTI3OS42LTQ0LjUsNy45LDc5YzE3MS4zLDczLjYsMzI1LjgsMjguMSwzMjUuOCwyOC4xCglTMzUwLjEsMTkwLjcsMTYxLjcsMTE0LjV6Ii8+CjxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0xOTMuNSwxMDcuMWMtMTY3LjYtNjQuMy0xNC00OS45LTE0LTQ5LjlzLTIxOS40LTI5LjIsOC4zLDYwLjRjMTM0LjMsNTIuOSwyNjIsMjYuNSwyNjIsMjYuNQoJUzM0My45LDE2NC44LDE5My41LDEwNy4xeiIvPgo8cGF0aCBjbGFzcz0ic3QwIiBkPSJNMzEwLjUsMTguMmMwLDAtMTAxLjctMzAuMS0xMzUuMSw3MS41bDMyLjEsMTIuNEMyMDcuNSwxMDIuMiwyMDIuOSwxOC41LDMxMC41LDE4LjJ6Ii8+CjxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0yMTMuMywxNTEuMWwtMzMuNi0xMC4yYzMyLjksNjAuMiw5Mi43LDY2LjQsOTIuNyw2Ni40QzIzMS45LDE5Ni4yLDIxMy4zLDE1MS4xLDIxMy4zLDE1MS4xeiIvPgo8L3N2Zz4K');
    add_submenu_page("intastellar-consents", "Intro", "Intro", "manage_options", "intastellar-consents", "intastellarGDPRSettingsForm", null);
    add_submenu_page("intastellar-consents", "Branding", "Branding", "manage_options", "intastellar-consents/branding", "intastellarCookieBranding", null);
    add_submenu_page("intastellar-consents", "Settings", "Settings", "manage_options", "intastellar-consents/settings", "intastellarCookieSettings", null);
    add_submenu_page("intastellar-consents", "Privacy", "Privacy", "manage_options", "intastellar-consents/privacy", "intastellarGDPRPrivacyPage", null);
    add_submenu_page("intastellar-consents", "Help", "Help", "manage_options", "intastellar-consents/help", "intastellarCookieHelp", null);
}
add_action('admin_menu', 'initIntastellarSettingsPage');

if (strpos($_SERVER["REQUEST_URI"], "wp-login.php") === false && !is_admin()) {
    add_action("init", "loadIntastellarCookieBanner");
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
        'window.INTA = ' . json_encode(array(
            'policy_link' => $link,
            'settings' => array(
                'language' => get_option("intastellarSelectLanguage"),
                'arrange' => get_option("intastellarSetCookiePosition"),
                'logo' => $logo,
                'color' => $color,
                'company' => $brandName,
                'text' => filter_var(get_option('intastellarDisplayCookieNoticeText'), FILTER_VALIDATE_BOOLEAN),
                'ccpa' => array(
                    "on" => filter_var(get_option('intastellarCCPA'), FILTER_VALIDATE_BOOLEAN),
                    "url" => get_option('intastellarCCPAurl'),
                    "collection" => $collection
                ),
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
    $intastellarDisplayCookieAdvencedvalue = get_option('intastellarDisplayCookieAdvenced');
    $checkbox = get_option('intastellarPrivacyLink-checkbox');
    $language = get_option('intastellarSelectLanguage');
    $ccpa = get_option('intastellarCCPA');
?>
    <section class="intastellarPluginContent">
        <?php include("intastellarGDPRAdminPanelHeader.php"); ?>
        <section class="intastellarPluginGrid">
            <aside class="intastellarPlugin-sideNavigation">
                <a href="?page=intastellar-consents">Intro</a>
                <a href="?page=intastellar-consents/branding">Branding</a>
                <a href="?page=intastellar-consents/settings" class="active">Settings</a>
                <a href="?page=intastellar-consents/privacy">Privacy Policy</a>
                <a href="?page=intastellar-consents/help">Help</a>
            </aside>
            <div class="intastellarPluginContent">
                <header class="intastellarPluginPage-header">
                    <h3 class="intastellarPluginHeader__headline">Settings</h3>
                    <p>Adjust here your settings for the cookiebanner, choose where the banner should be position, if you want to have Cookie notice text, view it in fullscreen and change your prefered language.</p>
                </header>
                <form method="post" action="options.php" enctype="multipart/form-data">
                    <?php settings_fields('intastellar-consents_plugin_options_group'); ?>
                    <section id="placement" class="intastellarPluginContent__items">
                        <label for="intastellarSetCookiePosition_id">Placement:</label>
                        <select name="intastellarSetCookiePosition" class="regular-text" id="intastellarSetCookiePosition_id">
                            <option value="ltr" <?php _e(($value1 == 'ltr' ? 'selected="selected"' : '')); ?>>Left</option>
                            <option value="rtl" <?php _e(($value1 == 'rtl' ? 'selected="selected"' : '')); ?>>Right</option>
                        </select>
                    </section>
                    <section class="intastellarPluginContent__items">
                        <label for="rootDomain">Your Main Domain</label>
                        <input type="text" name="intastellarSiteRoot" class="regular-text" id="rootDomain" value="<?php _e(get_option("intastellarSiteRoot")); ?>">
                    </section>
                    <section>
                        <label>
                            <p>Required Cookies list:</p>
                            <p>Write here a list of cookies that the website is required to use.</p>
                            <p>Example 1: <code>cookie1, cookie2, cookie3</code></p>
                            <p>Example 2: <code>
                                    cookie1
                                    cookie2
                                    cookie3
                                </code></p>
                            <textarea name="" id="cookieList" cols="30" rows="10" value="<?php _e(get_option('intastellarCookieList')); ?>"></textarea>
                        </label>
                    </section>
                    <section id="text" class="intastellarPluginContent__items">
                        Display Cookie Notice text:
                        <section>
                            <input type="radio" class="regular-text --radio" name="intastellarDisplayCookieNoticeText" value="true" <?php _e(($value == 'true' ? 'checked="checked"' : '')); ?> /> Yes
                            <input type="radio" class="regular-text --radio" name="intastellarDisplayCookieNoticeText" value="false" <?php _e(($value == 'false' || $value == '' ? 'checked="checked"' : '')); ?> /> No
                        </section>
                    </section>
                    <!-- <section id="text" class="intastellarPluginContent__items">
                        <span>None fullscreen? <span class="intastellarPluginContent__items-viewImage">(?) <img src="<?php _e(plugin_dir_url(__FILE__)) ?>/settings_page.png" class="IntastellarCookieSettingsPage__Image"></span></span>
                        <section>
                            <input type="radio" class="regular-text --radio" name="intastellarDisplayCookieAdvenced" value="true" <?php _e(($intastellarDisplayCookieAdvencedvalue == 'true' ? 'checked="checked"' : '')); ?> /> Yes
                            <input type="radio" class="regular-text --radio" name="intastellarDisplayCookieAdvenced" value="false" <?php _e(($intastellarDisplayCookieAdvencedvalue == 'false' || $intastellarDisplayCookieAdvencedvalue == '' ? 'checked="checked"' : '')); ?> /> No
                        </section>
                    </section> -->
                    <section id="language" class="intastellarPluginContent__items">
                        <label for="intastellarSelectLanguage_id">Language:</label>
                        <select id="intastellarSelectLanguage_id" class="regular-text" name="intastellarSelectLanguage">
                            <option value="auto" <?php _e(($language == 'auto' ? 'selected="selected"' : '')); ?> selected>Auto detect</option>
                            <option value="danish" <?php _e(($language == 'danish' ? 'selected="selected"' : '')); ?>>Danish</option>
                            <option value="german" <?php _e(($language == 'german' ? 'selected="selected"' : '')); ?>>German</option>
                            <option value="english" <?php _e(($language == 'english' ? 'selected="selected"' : '')); ?>>English</option>
                        </select>
                    </section>
                    <!-- <section class="intastellarPluginContent__items">
                            Activate CCPA (Currently under development. It´s showing currently only an banner to your policy):
                            <input type="radio" class="regular-text --radio" name="intastellarCCPA" value="true" <?php _e((get_option('intastellarCCPA') == 'true' ? 'checked="checked"' : '')); ?>/> Yes
                            <input type="radio" class="regular-text --radio" name="intastellarCCPA" value="false" <?php _e((get_option('intastellarCCPA') == 'false' || get_option('intastellarCCPA') == '' ? 'checked="checked"' : '')); ?>/> No
                        </section>
                        <section>
                            CCPA policy link:
                            <input type="text" class="regular-text" name="intastellarCCPAUrl" value="<?php if (get_option('intastellarCCPAUrl')) {
                                                                                                            _e(get_option('intastellarCCPAUrl'));
                                                                                                        } ?>">
                            <p>CCPA personal data to be collect beside of IP-Address:</p>
                            <textarea class="regular-text" name="intastellarCCPAcollection"><?php if (get_option('intastellarCCPAcollection')) {
                                                                                                _e(get_option('intastellarCCPAcollection'));
                                                                                            } ?></textarea>
                        </section> -->
                    <input type='hidden' class="regular-text --fullWidth" id="intastellarCustomIcon_id" name="intastellarCustomIcon" value="<?php _e(get_option('intastellarCustomIcon')); ?>">
                    <input type='hidden' class="regular-text --color" id="intastellarCookieBannerColor_id" name="intastellarCookieBannerColor" value="<?php if (get_option('intastellarCookieBannerColor')) {
                                                                                                                                                            _e(get_option('intastellarCookieBannerColor'));
                                                                                                                                                        } else {
                                                                                                                                                            _e(get_theme_mod('background_color'));
                                                                                                                                                        } ?>">
                    <input type='hidden' class="regular-text" id="intastellarPrivacyLink_id" name="intastellarPrivacyLink" required value="<?php _e(get_option('intastellarPrivacyLink')); ?>">
                    <input type="hidden" id="intastellarPrivacyLink-checkbox" name="intastellarPrivacyLink-checkbox" value="<?php _e(get_option('intastellarPrivacyLink-checkbox')); ?>">
                    <input type="hidden" class="regular-text --color" id="intastellarCookieBanner-brandName" value="<?php if (get_option('intastellarCookieBanner-brandName"')) {
                                                                                                                        _e(get_option('intastellarCookieBanner-brandName"'));
                                                                                                                    } else {
                                                                                                                        _e(get_bloginfo("name"));
                                                                                                                    } ?>">
                    <button type="submit" class="intastellarPluginSaveButton">Save changes</button>
                </form>
                <p>You can also read the docs and download the newest version: <a href="https://developers.intastellarsolutions.com/gdpr-cookiebanner/docs/wordpress-docs?utm_medium=wordpress_plugin&utm_source=<?php _e($_SERVER["HTTP_HOST"]) ?>" target="_blank" rel="noopener">Intastellar GDPR cookie banner</a></p>
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
?>
    <section class="intastellarPluginContent">
        <?php include("intastellarGDPRAdminPanelHeader.php"); ?>
        <section class="intastellarPluginGrid">
            <aside class="intastellarPlugin-sideNavigation">
                <a href="?page=intastellar-consents" class="active">Intro</a>
                <a href="?page=intastellar-consents/branding">Branding</a>
                <a href="?page=intastellar-consents/settings">Settings</a>
                <a href="?page=intastellar-consents/privacy">Privacy Policy</a>
                <a href="?page=intastellar-consents/help">Help</a>
            </aside>
            <div class="intastellarPluginContent">
                <header class="intastellarPluginPage-header">
                    <h3 class="intastellarPluginHeader__headline">Welcome to Intastellar Consents Solutions</h3>
                    <p>This cookiebanner helps you and your Website to become GDPR conform.</p>
                </header>
                <form method="post" action="options.php" enctype="multipart/form-data">
                    <p>To get started we need your Privacy Policy to begin with. After that you can edit the branding: choose your brand color and your own logo, and under the settings page you can go into detail, the placement of the cookie banner, choose whether nor to display text in the cookie notice, or what language you wanna use.</p>
                    <p>You wanna learn more about this cookie banner? Then you can read more under: <a target="_blank" href="https://www.intastellarsolutions.com/solutions/cookie-consents">www.intastellarsolutions.com/solutions/cookie-consents</a></p>
                    <p>So lets get started with your privacy policy & prefered language.</p>
                    <?php settings_fields('intastellar-consents_plugin_options_group'); ?>
                    <section id="privacy" class="intastellarPluginContent__items">
                        <label for="intastellarPrivacyLink_id">URL to <strong>your</strong> Privacy Policy page*:</label>
                        <section>
                            <input type='text' class="regular-text" id="intastellarPrivacyLink_id" name="intastellarPrivacyLink" required value="<?php _e(get_option('intastellarPrivacyLink')); ?>">
                            <input type="checkbox" class="intastellarPluginContent__items-checkbox" id="intastellarPrivacyLink-checkbox" name="intastellarPrivacyLink-checkbox" value="true" <?php _e(($checkbox == 'true' ? 'checked="checked"' : '')); ?>> <label for="intastellarPrivacyLink-checkbox">Open in new window</label>
                        </section>
                    </section>
                    <section class="intastellarPluginContent__items">
                        <label for="rootDomain">Your Main Domain</label>
                        <input type="text" name="intastellarSiteRoot" class="regular-text" id="rootDomain" value="<?php _e(get_option("intastellarSiteRoot")); ?>">
                    </section>
                    <section id="language" class="intastellarPluginContent__items">
                        <label for="intastellarSelectLanguage_id">Language:</label>
                        <select id="intastellarSelectLanguage_id" class="regular-text" name="intastellarSelectLanguage">
                            <option value="auto" <?php _e(($language == 'auto' ? 'selected="selected"' : '')); ?> selected>Auto detect</option>
                            <option value="danish" <?php _e(($language == 'danish' ? 'selected="selected"' : '')); ?>>Danish</option>
                            <option value="german" <?php _e(($language == 'german' ? 'selected="selected"' : '')); ?>>German</option>
                            <option value="english" <?php _e(($language == 'english' ? 'selected="selected"' : '')); ?>>English</option>
                        </select>
                    </section>
                    <input type='hidden' class="regular-text --fullWidth" id="intastellarCustomIcon_id" name="intastellarCustomIcon" value="<?php _e(get_option('intastellarCustomIcon')); ?>">
                    <input type="hidden" name="intastellarSetCookiePosition" id="intastellarSetCookiePosition_id" value="<?php _e(get_option('intastellarSetCookiePosition')); ?>">
                    <input type='hidden' class="regular-text --color" id="intastellarCookieBannerColor_id" name="intastellarCookieBannerColor" value="<?php if (get_option('intastellarCookieBannerColor')) {
                                                                                                                                                            _e(get_option('intastellarCookieBannerColor'));
                                                                                                                                                        } else {
                                                                                                                                                            _e(get_theme_mod('background_color'));
                                                                                                                                                        } ?>">
                    <input type="hidden" name="intastellarDisplayCookieAdvenced" id="intastellarDisplayCookieAdvenced" value="<?php _e(get_option('intastellarDisplayCookieAdvenced')); ?>">
                    <input type="hidden" name="intastellarDisplayCookieNoticeText" id="intastellarDisplayCookieNoticeText" value="<?php _e(get_option('intastellarDisplayCookieNoticeText')); ?>">
                    <input type="hidden" class="regular-text --color" id="intastellarCookieBanner-brandName" value="<?php if (get_option('intastellarCookieBanner-brandName')) {
                                                                                                                        _e(get_option('intastellarCookieBanner-brandName'));
                                                                                                                    } else {
                                                                                                                        _e(get_bloginfo("name"));
                                                                                                                    } ?>">
                    <button type="submit" class="intastellarPluginSaveButton">Save changes</button>
                </form>
                <p>You can also read the docs or download the newest version: <a href="https://developers.intastellarsolutions.com/gdpr-cookiebanner/docs/wordpress-docs?utm_medium=wordpress_plugin&utm_source=<?php _e($_SERVER["HTTP_HOST"]) ?>" target="_blank" rel="noopener">Intastellar Consents Solutions</a></p>
                <?php include("intastellarGDPRAdminPanelFooter.php"); ?>
            </div>
        </section>
    </section>
<?php } ?>
<?php
function intastellarGDPRPrivacyPage()
{
    $checkbox = get_option('intastellarPrivacyLink-checkbox');
    $language = get_option('intastellarSelectLanguage');
?>
    <section class="intastellarPluginContent">
        <?php include("intastellarGDPRAdminPanelHeader.php"); ?>
        <section class="intastellarPluginGrid">
            <aside class="intastellarPlugin-sideNavigation">
                <a href="?page=intastellar-consents">Intro</a>
                <a href="?page=intastellar-consents/branding">Branding</a>
                <a href="?page=intastellar-consents/settings">Settings</a>
                <a href="?page=intastellar-consents/privacy" class="active">Privacy Policy</a>
                <a href="?page=intastellar-consents/help">Help</a>
            </aside>
            <div class="intastellarPluginContent">
                <header class="intastellarPluginPage-header">
                    <h3 class="intastellarPluginHeader__headline">Privacy Policy</h3>
                    <p>Change your privacy link and if you want to have it open in a new window.</p>
                </header>
                <form method="post" action="options.php" enctype="multipart/form-data">
                    <?php settings_fields('intastellar-consents_plugin_options_group'); ?>
                    <section id="privacy" class="intastellarPluginContent__items">
                        <label for="intastellarPrivacyLink_id">URL to <strong>your</strong> Privacy Policy page*:</label>
                        <section>
                            <input type='text' class="regular-text" id="intastellarPrivacyLink_id" name="intastellarPrivacyLink" required value="<?php _e(get_option('intastellarPrivacyLink')); ?>">
                            <input type="checkbox" class="intastellarPluginContent__items-checkbox" id="intastellarPrivacyLink-checkbox" name="intastellarPrivacyLink-checkbox" value="true" <?php _e(($checkbox == 'true' ? 'checked="checked"' : '')); ?>> <label for="intastellarPrivacyLink-checkbox">Open in new window</label>
                        </section>
                    </section>
                    <input type="hidden" id="intastellarSelectLanguage_id" name="intastellarSelectLanguage" value="<?php _e(get_option('intastellarSelectLanguage')); ?>">
                    <input type='hidden' class="regular-text --fullWidth" id="intastellarCustomIcon_id" name="intastellarCustomIcon" value="<?php _e(get_option('intastellarCustomIcon')); ?>">
                    <input type='hidden' class="regular-text --color" id="intastellarCookieBannerColor_id" name="intastellarCookieBannerColor" value="<?php if (get_option('intastellarCookieBannerColor')) {
                                                                                                                                                            _e(get_option('intastellarCookieBannerColor'));
                                                                                                                                                        } else {
                                                                                                                                                            _e(get_theme_mod('background_color'));
                                                                                                                                                        } ?>">
                    <input type="hidden" name="intastellarSetCookiePosition" id="intastellarSetCookiePosition_id" value="<?php _e(get_option('intastellarSetCookiePosition')); ?>">
                    <input type="hidden" class="regular-text --color" id="intastellarCookieBanner-brandName" value="<?php if (get_option('intastellarCookieBanner-brandName')) {
                                                                                                                        _e(get_option('intastellarCookieBanner-brandName'));
                                                                                                                    } else {
                                                                                                                        _e(get_bloginfo("name"));
                                                                                                                    } ?>">
                    <input type="hidden" name="intastellarDisplayCookieAdvenced" id="intastellarDisplayCookieAdvenced" value="<?php _e(get_option('intastellarDisplayCookieAdvenced')); ?>">
                    <input type="hidden" name="intastellarDisplayCookieNoticeText" id="intastellarDisplayCookieNoticeText" value="<?php _e(get_option('intastellarDisplayCookieNoticeText')); ?>">
                    <button type="submit" class="intastellarPluginSaveButton">Save changes</button>
                </form>
                <p>You can also read the docs or download the newest version: <a href="https://developers.intastellarsolutions.com/gdpr-cookiebanner/docs/wordpress-docs?utm_medium=wordpress_plugin&utm_source=<?php _e($_SERVER["HTTP_HOST"]) ?>" target="_blank" rel="noopener">Intastellar Consents Solutions</a></p>
                <?php include("intastellarGDPRAdminPanelFooter.php"); ?>
            </div>
        </section>
    </section>
<?php } ?>
<?php
function intastellarCookieBranding()
{
    $checkbox = get_option('intastellarPrivacyLink-checkbox');
    $language = get_option('intastellarSelectLanguage');
?>
    <section class="intastellarPluginContent">
        <?php include("intastellarGDPRAdminPanelHeader.php"); ?>
        <section class="intastellarPluginGrid">
            <aside class="intastellarPlugin-sideNavigation">
                <a href="?page=intastellar-consents">Intro</a>
                <a href="?page=intastellar-consents/branding" class="active">Branding</a>
                <a href="?page=intastellar-consents/settings" class="">Settings</a>
                <a href="?page=intastellar-consents/privacy">Privacy Policy</a>
                <a href="?page=intastellar-consents/help">Help</a>
            </aside>
            <div class="intastellarPluginContent">
                <header class="intastellarPluginPage-header">
                    <h3 class="intastellarPluginHeader__headline">Branding</h3>
                    <p>Customize your banner to reflect your brands identity. Change the apperance of the cookie banner, by using your brand color and logo. </p>
                </header>
                <form method="post" action="options.php" enctype="multipart/form-data">
                    <?php settings_fields('intastellar-consents_plugin_options_group'); ?>
                    <section id="brandname" class="intastellarPluginContent__items">
                        <label for="intastellarCustomIcon_id">
                            Brand name / Company name:
                        </label>
                        <section>
                            <input type="text" class="regular-text" id="intastellarCookieBanner-brandName" name="intastellarCookieBanner-brandName" value="<?php if (get_option('intastellarCookieBanner-brandName')) {
                                                                                                                                                                _e(get_option('intastellarCookieBanner-brandName'));
                                                                                                                                                            } else {
                                                                                                                                                                _e(get_bloginfo("name"));
                                                                                                                                                            } ?>">
                        </section>
                    </section>
                    <section id="color" class="intastellarPluginContent__items">
                        <label for="intastellarCookieBannerColor_id">Brand Color:</label>
                        <div class="colorPallet">
                            <input type='color' class="regular-text --color" id="intastellarCookieBannerColor_id" name="intastellarCookieBannerColor" value="<?php if (get_option('intastellarCookieBannerColor')) {
                                                                                                                                                                    _e(get_option('intastellarCookieBannerColor'));
                                                                                                                                                                } else {
                                                                                                                                                                    _e(get_theme_mod('background_color'));
                                                                                                                                                                } ?>">
                            <span class="colorValue" id="intastellarCookieBannerColorValue" contenteditable><?php if (get_option('intastellarCookieBannerColor')) {
                                                                                                                _e(get_option('intastellarCookieBannerColor'));
                                                                                                            } else {
                                                                                                                _e(get_theme_mod('background_color'));
                                                                                                            } ?></span>
                        </div>
                    </section>
                    <section id="logo" class="intastellarPluginContent__items">
                        <label for="intastellarCustomIcon_id">Cookie Setting Logo:
                            <br>
                            <small>Recommended:<br>A max-width of 200px <br> and a min-width of 100px <br>for near square logos</small>
                        </label>
                        <section>
                            <img src="<?php _e(get_option('intastellarCustomIcon')); ?>" class="intastellarCookieSettingsLogo">
                            <input type='text' class="regular-text --fullWidth" id="intastellarCustomIcon_id" name="intastellarCustomIcon" value="<?php _e(get_option('intastellarCustomIcon')); ?>">
                        </section>
                    </section>
                    <input type='hidden' class="regular-text" id="intastellarPrivacyLink_id" name="intastellarPrivacyLink" required value="<?php _e(get_option('intastellarPrivacyLink')); ?>">
                    <input type="hidden" id="intastellarSelectLanguage_id" name="intastellarSelectLanguage" value="<?php _e(get_option('intastellarSelectLanguage')); ?>">
                    <input type="hidden" name="intastellarSetCookiePosition" id="intastellarSetCookiePosition_id" value="<?php _e(get_option('intastellarSetCookiePosition')); ?>">
                    <input type="hidden" id="intastellarPrivacyLink-checkbox" name="intastellarPrivacyLink-checkbox" value="<?php _e(get_option('intastellarPrivacyLink-checkbox')); ?>">
                    <input type="hidden" name="intastellarDisplayCookieAdvenced" id="intastellarDisplayCookieAdvenced" value="<?php _e(get_option('intastellarDisplayCookieAdvenced')); ?>">
                    <input type="hidden" name="intastellarDisplayCookieNoticeText" id="intastellarDisplayCookieNoticeText" value="<?php _e(get_option('intastellarDisplayCookieNoticeText')); ?>">
                    <button type="submit" class="intastellarPluginSaveButton">Save changes</button>
                </form>
                <p>You can also read the docs and download the newest version: <a href="https://developers.intastellarsolutions.com/gdpr-cookiebanner/docs/wordpress-docs?utm_medium=wordpress_plugin&utm_source=<?php _e($_SERVER["HTTP_HOST"]) ?>" target="_blank" rel="noopener">Intastellar GDPR cookie banner</a></p>
                <?php include("intastellarGDPRAdminPanelFooter.php"); ?>
            </div>
        </section>
    </section>
<?php } ?>
<?php
function intastellarCookieHelp()
{
?>
    <section class="intastellarPluginContent">
        <?php include("intastellarGDPRAdminPanelHeader.php"); ?>
        <section class="intastellarPluginGrid">
            <aside class="intastellarPlugin-sideNavigation">
                <a href="?page=intastellar-consents">Intro</a>
                <a href="?page=intastellar-consents/branding">Branding</a>
                <a href="?page=intastellar-consents/settings">Settings</a>
                <a href="?page=intastellar-consents/privacy">Privacy Policy</a>
                <a href="?page=intastellar-consents/help" class="active">Help</a>
            </aside>
            <div class="intastellarPluginContent">
                <h1>Help</h1>
                <p>A list of documentation & faq´s to help you further:</p>
                <ul>
                    <li><a href="https://developers.intastellarsolutions.com/gdpr-cookiebanner/docs/wordpress-docs" target="_blank">Official Documentation</a></li>
                    <li><a href="https://support.intastellarsolutions.com/gdpr-cookiebanner/faq" target="_blank">Official FAQ´s</a></li>
                </ul>
                <?php include("intastellarGDPRAdminPanelFooter.php"); ?>
            </div>
        </section>
    </section>
<?php } ?>