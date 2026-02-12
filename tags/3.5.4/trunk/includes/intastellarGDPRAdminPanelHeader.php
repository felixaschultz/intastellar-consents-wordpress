<?php
if (! defined('ABSPATH')) exit;
$plugin_dir = plugin_dir_url(__FILE__) . '/';
$plugin_version = get_plugin_data(__FILE__)['Version'];
$show_review_prompt = function_exists('intastellar_should_show_review_prompt') && intastellar_should_show_review_prompt();
?>
<?php if ($show_review_prompt) : ?>
<div class="intastellar-review-banner" id="intastellarReviewBanner">
    <div class="intastellar-review-banner__content">
        <span class="intastellar-review-banner__text"><?php esc_html_e('Enjoying Intastellar Consents? Leave us a review on WordPress.org — it helps others discover the plugin.', 'intastellar-consents'); ?></span>
        <div class="intastellar-review-banner__actions">
            <button type="button" class="intastellar-review-banner__btn intastellar-review-banner__btn--primary" id="intastellarReviewOpenPopup"><?php esc_html_e('Leave a review', 'intastellar-consents'); ?></button>
            <a href="<?php echo esc_url(intastellar_get_review_url()); ?>" target="_blank" rel="noopener noreferrer" class="intastellar-review-banner__btn intastellar-review-banner__btn--secondary" id="intastellarReviewDirect"><?php esc_html_e('Open on WordPress.org', 'intastellar-consents'); ?></a>
            <button type="button" class="intastellar-review-banner__btn intastellar-review-banner__btn--dismiss" id="intastellarReviewDismiss"><?php esc_html_e('Maybe later', 'intastellar-consents'); ?></button>
        </div>
    </div>
</div>
<div class="intastellar-review-popup" id="intastellarReviewPopup" role="dialog" aria-labelledby="intastellarReviewPopupTitle" aria-hidden="true">
    <div class="intastellar-review-popup__backdrop" id="intastellarReviewPopupBackdrop"></div>
    <div class="intastellar-review-popup__box">
        <h3 class="intastellar-review-popup__title" id="intastellarReviewPopupTitle"><?php esc_html_e('Leave a review on WordPress.org', 'intastellar-consents'); ?></h3>
        <p class="intastellar-review-popup__text"><?php esc_html_e('Your review helps other users and supports the plugin. Thank you!', 'intastellar-consents'); ?></p>
        <div class="intastellar-review-popup__actions">
            <a href="<?php echo esc_url(intastellar_get_review_url()); ?>" target="_blank" rel="noopener noreferrer" class="intastellar-review-banner__btn intastellar-review-banner__btn--primary" id="intastellarReviewPopupLink"><?php esc_html_e('Open review page', 'intastellar-consents'); ?></a>
            <button type="button" class="intastellar-review-banner__btn intastellar-review-banner__btn--dismiss" id="intastellarReviewPopupClose"><?php esc_html_e('Close', 'intastellar-consents'); ?></button>
        </div>
    </div>
</div>
<?php endif; ?>
<div class="intastellar-version"></div>
<header class="intastellarPluginHeader">
    <section class="intastellarPluginHeader-content">
        <img class="intastellarPluginHeader__logo" src="<?php echo esc_url($plugin_dir . 'assets/intastellar-consents-black.png'); ?>">
        <h2>v <span id="intastellarPluginVersion"><?php echo esc_html($plugin_version); ?></span></h2>
        <a href="https://developers.intastellarsolutions.com/feedback?plugin=GDPR Cookiebanner for Wordpress" target="_blank" rel="noopener noreferrer" class="intastellarFeedback"><?php esc_html_e('Send Feedback', 'intastellar-consents'); ?></a>
    </section>
</header>
