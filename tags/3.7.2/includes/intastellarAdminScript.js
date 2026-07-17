window.addEventListener("DOMContentLoaded", function () {
    /* Ask for review (on WordPress) banner & popup */
    (function () {
        var banner = document.getElementById("intastellarReviewBanner");
        var popup = document.getElementById("intastellarReviewPopup");
        var openBtn = document.getElementById("intastellarReviewOpenPopup");
        var directLink = document.getElementById("intastellarReviewDirect");
        var dismissBtn = document.getElementById("intastellarReviewDismiss");
        var popupBackdrop = document.getElementById("intastellarReviewPopupBackdrop");
        var popupLink = document.getElementById("intastellarReviewPopupLink");
        var popupClose = document.getElementById("intastellarReviewPopupClose");

        if (!banner || typeof intastellarReview === "undefined") return;

        function openPopup() {
            if (popup) {
                popup.classList.add("is-open");
                popup.setAttribute("aria-hidden", "false");
            }
        }

        function closePopup() {
            if (popup) {
                popup.classList.remove("is-open");
                popup.setAttribute("aria-hidden", "true");
            }
        }

        function dismissBanner() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", intastellarReview.ajaxUrl, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    try {
                        var res = JSON.parse(xhr.responseText);
                        if (res.success && banner) banner.style.display = "none";
                    } catch (e) {}
                }
            };
            xhr.send("action=intastellar_dismiss_review&nonce=" + encodeURIComponent(intastellarReview.nonce));
        }

        if (openBtn) openBtn.addEventListener("click", openPopup);
        if (popupBackdrop) popupBackdrop.addEventListener("click", closePopup);
        if (popupClose) popupClose.addEventListener("click", closePopup);
        if (dismissBtn) dismissBtn.addEventListener("click", function () { dismissBanner(); });
        if (popupLink) {
            popupLink.addEventListener("click", function () {
                closePopup();
                dismissBanner();
            });
        }
        if (directLink) {
            directLink.addEventListener("click", function () { dismissBanner(); });
        }
    })();

    document.querySelectorAll(".intastellarPluginHeader__smallHeader-item").forEach((menu) => {
        menu.addEventListener("click", function () {
            if (this.getAttribute("href") == "#logo") {
                document.querySelector(this.getAttribute("href")).classList.toggle("intastellarPluginContent__items--show");

            } else if (this.getAttribute("href") == "#text") {
                document.querySelector(this.getAttribute("href")).classList.toggle("intastellarPluginContent__items--show");
            } else if (this.getAttribute("href") == "#placement") {
                document.querySelector(this.getAttribute("href")).classList.toggle("intastellarPluginContent__items--show");
            } else if (this.getAttribute("href") == "#privacy") {
                document.querySelector(this.getAttribute("href")).classList.toggle("intastellarPluginContent__items--show");
            } else if (this.getAttribute("href") == "#language") {
                document.querySelector(this.getAttribute("href")).classList.toggle("intastellarPluginContent__items--show");
            } else if (this.getAttribute("href") == "#color") {
                document.querySelector(this.getAttribute("href")).classList.toggle("intastellarPluginContent__items--show");
            }
        })
    })

    function isURL(str) {
        const pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
            '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
            '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
            '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
            '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
            '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator

        const tmp = document.createElement('a');
        tmp.href = str;

        if (tmp.host !== window.location.host || tmp.host == window.location.host) {
            if (pattern.test(str) && str.indexOf("policy") != -1 ||
                pattern.test(str) && str.indexOf("cookie") != -1 ||
                pattern.test(str) && str.indexOf("privat") != -1 ||
                pattern.test(str) && str.indexOf("privacy") != -1 ||
                pattern.test(str) && str.indexOf("datenschutz") != -1 ||
                pattern.test(str) && str.indexOf("handelsbetingelser") != -1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function isURL(str) {
        const pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
            '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
            '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
            '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
            '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
            '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator

        const tmp = document.createElement('a');
        tmp.href = str;

        if (tmp.host !== window.location.host || tmp.host == window.location.host) {
            if (pattern.test(str) && str.indexOf("policy") != -1 ||
                pattern.test(str) && str.indexOf("cookie") != -1 ||
                pattern.test(str) && str.indexOf("privat") != -1 ||
                pattern.test(str) && str.indexOf("privacy") != -1 ||
                pattern.test(str) && str.indexOf("datenschutz") != -1 ||
                pattern.test(str) && str.indexOf("handelsbetingelser") != -1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    if (document.querySelector("#intastellarPrivacyLink_id") != null) {
        if (!isURL(document.querySelector("#intastellarPrivacyLink_id").value)) {
            document.querySelector("#intastellarPrivacyLink_id").style.borderColor = "red";
        }
        document.querySelector("#intastellarPrivacyLink_id").addEventListener("keyup", function (e) {
            if (!isURL(e.target.value)) {
                document.querySelector("#intastellarPrivacyLink_id").style.borderColor = "red";
            } else {
                document.querySelector("#intastellarPrivacyLink_id").style.borderColor = "";
            }
        })
    }

    /* if (document.querySelector("#intastellarCustomIcon_id") != null) {

        document.querySelector("#intastellarCustomIcon_id").addEventListener("change", (e) => {
            document.querySelector(".intastellarCookieSettingsLogo").src = e.target.value;
        })
    } */


    let colorButton = document.getElementById("intastellarCookieBannerColor_id");
    let colorDiv = document.getElementById("intastellarCookieBannerColorValue");
    let previewColor = document.getElementById("intastellarBrandingPreviewColor");

    function syncColorToPreview(val) {
        if (previewColor) previewColor.style.backgroundColor = val;
    }

    if (colorButton != null && colorDiv != null) {
        colorButton.oninput = function () {
            colorDiv.value = colorButton.value;
            syncColorToPreview(colorButton.value);
        };
        colorDiv.addEventListener("input", function (e) {
            var val = e.target.value;
            if (/^#[0-9a-fA-F]{6}$/.test(val) || /^[0-9a-fA-F]{6}$/.test(val)) {
                if (val.indexOf("#") !== 0) val = "#" + val;
                colorButton.value = val;
                colorDiv.value = val;
                syncColorToPreview(val);
            }
        });
    }

    const currentVersion = document.querySelector("#intastellarPluginVersion")?.textContent;

    console.log(currentVersion);

    fetch("https://apis.intastellarsolutions.com/js/wp-version-checker.php").then((response) => {
        return response.json();
    }).then((data) => {
        if (data.version > currentVersion) {
            document.querySelector(".intastellarPluginHeader__smallHeader-item--version").classList.add("intastellarPluginHeader__smallHeader-item--update");
            document.querySelector(".intastellarPluginHeader__smallHeader-item--version").innerHTML = "Update Available";
        }
    })

});