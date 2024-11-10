humhub.modules.adsense = humhub.modules.adsense || {
    init: function () {
        var adsenseScriptLoaded = false;
        var adblockerCheckDone = false;

        // Function to check if AdSense script is loaded and AdBlocker is enabled
        function checkAdBlocker() {
            if (!adblockerCheckDone) {
                if (!adsenseScriptLoaded) {
                    console.log('AdBlocker enabled');
                    $('#adblockerModal').modal('show');
                    adblockerCheckDone = true;
                } else {
                    console.log('AdBlocker not detected, loading ads');
                    $('#adblockerModal').modal('hide');
                    adblockerCheckDone = true;
                    // Push AdSense ads if AdBlocker is not enabled
                    try {
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    } catch (e) {
                        console.error('Error pushing ads:', e);
                    }
                }
            }
        }

        // Function to dynamically load the AdSense script
        function loadAdsenseScript() {
            if (!adsenseScriptLoaded) {
                var script = document.createElement('script');
                script.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js';
                script.async = true;
                script.onload = function() {
                    console.log('AdSense script loaded');
                    adsenseScriptLoaded = true;
                    checkAdBlocker();
                };
                script.onerror = function() {
                    console.log('Error loading AdSense script');
                    adsenseScriptLoaded = false;
                    checkAdBlocker();
                };
                document.head.appendChild(script);
            } else {
                console.log('AdSense script already loaded');
                checkAdBlocker();
            }
        }

        // Handle PJAX page updates
        $(document).on('pjax:end', function() {
            console.log('PJAX content loaded, checking ads again');
            loadAdsenseScript();
        });

        // Check if AdSense script is loaded on initial page load
        $(document).ready(function() {
            if (typeof adsbygoogle === 'undefined') {
                adsenseScriptLoaded = false;
                console.log('AdSense script not found');
            } else {
                adsenseScriptLoaded = true;
                console.log('AdSense script found');
            }
            loadAdsenseScript();
        });
    }
};

// Initialize the module when the document is ready
$(document).ready(function() {
    humhub.modules.adsense.init();
});
