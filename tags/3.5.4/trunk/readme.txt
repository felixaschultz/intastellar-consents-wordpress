=== Intastellar Consents – GDPR Cookie Banner & Google Consent Mode ===

License:            GPL v2 or later
License URI:        https://www.gnu.org/licenses/gpl-2.0.html
Stable tag:         3.5.4
Tested up to:       6.9
Contributors:       intastellar
Requires at least:  5.8
Requires PHP:       7.4
Tags: gdpr, cookie consent, cookie banner, google consent mode, consent mode v2, ccpa, privacy, wordpress gdpr, cookie compliance

= Short Description =
Automatically block tracking scripts and display a GDPR-compliant cookie banner with Google Consent Mode support.

GDPR cookie consent for WordPress – lightweight, fast, and built for small to mid-size websites.

Intastellar Consents is a simple and privacy-first GDPR cookie consent solution for WordPress.
It helps website owners comply with GDPR and ePrivacy requirements without bloated dashboards, aggressive upsells, or complicated setups.
Designed for small businesses, developers, and site owners who want a clean, compliant cookie banner that works out of the box.

== Description ==
Intastellar Consents allows you to display a compliant cookie consent banner on your WordPress website and block non-essential scripts until consent is given.

Unlike heavy consent management platforms, Intastellar Consents focuses on:

- Fast implementation
- Clear consent choices
- Minimal performance impact
- No tracking of users by default

The plugin integrates seamlessly by loading the Intastellar Consents script and handling consent logic centrally, ensuring consistent behavior across pages.

== Google Consent Mode ==
Intastellar Consents supports Google Consent Mode, allowing Google Analytics and Google Ads
to adapt their behavior based on user consent while preventing tracking cookies before consent.

Consent signals are updated dynamically when users change their preferences.

== Key Features ==
- GDPR & ePrivacy compliant consent banner
- Google Consent Mode support (advanced setups included)
- CCPA / CPRA support with “Do Not Sell My Personal Information” option
- Blocks marketing and analytics scripts until consent is granted
- Lightweight, minimal performance impact
- Customizable look and feel to match your brand
- Multi-language support based on site language
- Easy plugin install or single-script integration
- Hosted securely in the EU
- Compatible with Google Analytics, Meta Pixel, Microsoft UET/Clarity, HubSpot, and others

== Supported WordPress Languages ==
The full plugin admin (Settings, Branding, Intro, Privacy, Help, and the “Ask for review” prompt) is translated into the following languages. Set your site or admin language in **Settings → General** (or your user profile language for the admin) to use them.

- English (default)
- Danish (Dansk)
- German (Deutsch)
- French (Français)
- Spanish (Español)
- Italian (Italiano)
- Dutch (Nederlands)
- Polish (Polski)
- Portuguese – Portugal (Português)

== Translations ==
* **Plugin admin:** The list above is built into the plugin; no extra setup is needed. Just set your WordPress or user language and the admin will appear in that language.
* **This page (WordPress.org):** To have the plugin description and this readme shown in more languages on the WordPress.org plugin page, translators can contribute at **translate.wordpress.org** → project **wp-plugins/intastellar-gdpr-cookie-banner**. Approved translations there are used for the plugin’s landing page and for automatic language-pack updates.

== Installation ==
1. Go to Plugins → Add New in your WordPress dashboard
2. Search for “Intastellar Consents"
3. Click Install Now
4. Activate the plugin
5. Go to Settings → Intastellar Consents
6. Configure the privacy policy URL and language
7. The cookie banner will appear automatically on your site

== Who Is This Plugin For? ==
- Small business websites
- Freelancers and agencies building WordPress sites
- Developers who want a clean consent solution
- Website owners who don’t want enterprise-level CMP complexity
- Anyone tired of bloated cookie plugins
- Agencies managing multiple client sites that need a consistent consent solution
- WordPress developers looking for a lightweight and easy-to-use consent solution

== How It Works ==
Intastellar Consents loads a secure script that:
1. Detects visitors’ region and initializes consent defaults (GDPR, CCPA, etc.)
2. Prevents non-essential scripts from firing until consent is given
3. Applies Google Consent Mode signals based on user consent
4. Ensures personalized banner presentation via multi-language detection
5. Fires permitted scripts only after valid consent
This approach helps you balance privacy compliance with data insights, especially for analytics and ads platforms.

== GDPR & Privacy Compliance ==
Intastellar Consents is built with GDPR principles in mind:

- Consent before non-essential cookies
- Clear and explicit user choice
- No pre-checked consent
- No user profiling by the plugin itself
- Consent handling aligned with GDPR and ePrivacy Directive

Intastellar Consents does not claim to provide full legal compliance on its own.

== Privacy & Data Handling ==
The plugin itself does not store personal data on the WordPress site.
Consent logic is handled via Intastellar Consents’ infrastructure.

**Note:** Website owners remain responsible for ensuring their overall site configuration, cookie usage, and privacy policy are GDPR-compliant.


== External Resources ==
The plugin loads the following external resources which are required for the consent banner to function:
JavaScript from:
https://consents.cdn.intastellarsolutions.com
CSS styling from:
https://downloads.intastellarsolutions.com
The banner and consent management logic run from these hosted resources.
Without these external files, the plugin will not display or function properly.
No personal data or WordPress user information is sent to these domains simply by loading the script.

No tracking, analytics, or marketing cookies are set by these resources before user consent is given.

Why are external resources required?
The consent system is centrally maintained so updates to compliance rules, UI, and consent logic can be rolled out without requiring site owners to manually update the plugin.

You can find the service on our website: https://www.intastellarsolutions.com/solutions/cookie-consents
Find the privacy policy here: https://www.intastellarsolutions.com/about/legal/privacy
Find the terms of service here: https://www.intastellarsolutions.com/about/legal/terms


== Frequently Asked Questions ==
= Does this plugin make my site GDPR compliant? =
It helps you meet GDPR requirements for cookie consent, script blocking, and consent signals. Full compliance also depends on how other tools on your site are configured.

= Does it support Google Consent Mode? =
Yes. The plugin emits consent signals compatible with Google Consent Mode and related integrations.

= What about CCPA/CPRA? =
Visitors from California see an additional “Do Not Sell My Personal Information” option. If selected, consent signals are adjusted automatically.

= Is this plugin free? =
Yes. The core cookie banner and consent handling are free. Upgrades to full consent management features are optional.

= Can I customize the banner’s appearance? =
Yes. Custom colors and layout options let you match your website’s style.

= How do I change the placement of the banner? =
You can change the placement of the banner by going to the settings page and choosing a placement.

== Screenshots ==
1. The intro menu, where you can add a privacy policy and choose a language.
2. The dashboard widget, where you can see the status of your site's GDPR compliance.
3. The branding menu, where you can choose your logo and brand color.
4. The settings page: placement, cookie notice text, fullscreen mode, and language.
5. The privacy menu, where you can change the link or URL to your privacy policy.
6. The cookie banner in fullscreen mode.
7. The cookie banner in compact mode.

== Changelog ==
= 3.5.4 =
Added a dashboard widget to the admin panel & updated the screenshots.
= 3.5.3 =
Fixed a bug where the plugin was not showing up in the admin panel.
= 3.5.2 =
Fixed a bug where the plugin was not showing up in the admin panel.
= 3.5.1 =
Fixed a bug where the plugin was not showing up in the admin panel.
= 3.5.0 =
* Added “Ask for review on WordPress.org” prompt in the plugin admin (shown after 7 days of use).
* Added support for multiple admin languages: Danish, German, French, Spanish, Italian, Dutch, Polish, and Portuguese (Portugal).
* Updated readme with supported WordPress languages.
= 3.4.2 =
Fixed small bugs and updated the plugin's readme file.
= 3.4.1 =
Fixed small styling bugs.
= 3.4.0 =
Added new feature to the plugin, where you can add a company name to the cookie overview list.
= 3.3.9 =
Fixed logo path
= 3.3.8 =
Bug fixes, missing logo
= 3.3.7 =
General bug fixes
= 3.3.6 =
Added support for new languages & banner styles. General bug fixing
= 3.3.2 =
Added a new feature to the plugin, where you can upload or select a logo from the media library.
= 3.3.1 =
Fixed a bug where the cookie banner was not showing up & fixed small styling bugs.
= 3.3.0 =
We've updated the plugin to support the latest WordPress version, added support for Spanish language and added the possibility to choose a banner style.
= 3.2.2 =
Removed the advanced view settings because of a bug.
= 3.2.1 =
Fixed a bug where the cookie banner was not showing up.
= 3.2.0 =
Updated plugin to support root domain feature as well as the new cookie banner script.
= 3.0.1 =
Fixed a bug where the cookie banner was not showing up.
= 3.0.0 =
Updated the plugin to the latest Cookie Consent script.
= 2.1.1 =
Fixed some minor errors
= 2.1.0 =
Added the ability to add a company name for the cookie overview list. Then we updated the cookie banner file link to a new one.
= 2.0.0 =
In this version we've redesigned the admin page for the plugin. We have categorized everything into: branding, intro, settings, and privacy policy.
= 1.1.1 =
Fixed a bug where the main script was loaded inside the admin panel and update page.
= 1.1.0 =
Added on the intro page the possibility to add the Privacy Policy link, and on the settings page the option to start with the cookie settings page directly.
= 1.0.2 =
Added CCPA – California Consumer Privacy Act to the banner. It is currently under development and only shows the user a link to your CCPA policy.
= 1.0.1 =
Added a source parameter to the script to find out, which plugin source the outgoing link is coming from.
= 1.0 =
Created the plugins menu as well as the settings page and the plugin in itself.

== Upgrade Notice ==
= 3.5.0 =
New: “Ask for review” prompt in the admin, plus admin translations for Danish, German, French, Spanish, Italian, Dutch, Polish, and Portuguese.
= 2.0.0 =
In this version we've redesigned the admin page for the plugin. We have categorized everything into: branding, intro, settings, and privacy policy.
= 1.0.2 =
Added CCPA – California Consumer Privacy Act to the banner. It is currently under development and only shows the user a link to your CCPA policy.
= 1.0.1 =
Added a source parameter to the script to find out, which plugin source the outgoing link is coming from.
= 1.0 =
We've updated the settings page: you can now change your color, add a custom logo, add a link to your privacy policy, and more.