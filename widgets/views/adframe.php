<?php

use yii\helpers\Url;
use humhub\libs\Html;
use humhub\widgets\PanelMenu;
use humhub\modules\ui\view\components\View;

/* @var $client string */
/* @var $slot string */
/* @var $this View */

$module = Yii::$app->getModule('adsense');
$urlJs = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js';

try {
    // Try to register the JS file
    $this->registerJsFile($urlJs, ['data-ad-client' => Yii::$app->getModule('adsense')->getClient(), 'src' => 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=' . Yii::$app->getModule('adsense')->getClient() . 'crossorigin="anonymous"', 'position' => View::POS_HEAD]);
} catch (Exception $e) {
    // Handle the error here, you can log it or perform any other action
    Yii::error('Error loading Google AdSense script: ' . $e->getMessage());
}

$this->registerMetaTag([
    'name' => 'google-adsense-account',
    'content' => Yii::$app->getModule('adsense')->getClient(),
]);
?>
<style>
.ins.adsbygoogle[data-ad-status="unfilled"] {
    display: none !important;
}
.adblocker-warning {
    padding: 10px;
    background-color: #f2dede;
    color: #a94442;
    border: 1px solid #ebccd1;
    border-radius: 4px;
}
</style>

<div class="panel panel-adsense panel-default" id="panel-adsense">
    <?= PanelMenu::widget(['id' => 'panel-adsense']); ?>
    <div class="panel-heading">
        <?= Yii::t('AdsenseModule.base', '<strong>Community</strong> Ad'); ?>
    </div>

    <div class="panel-body">
        <?= Html::beginTag('div') ?>
        <?php if (empty($client && $slot)): ?>
        <p><?= $module->getMessage() ?></p>
        <?php else: ?>
        <script async src="<?= $urlJs; ?>"></script>
        <ins class="adsbygoogle"
            style="display:block;"
            data-ad-client="<?= $client; ?>"
            data-ad-slot="<?= $slot; ?>"
            data-ad-format="auto"
            data-full-width-responsive="true"></ins>
        <div id="adblockerModal" class="modal fade" role="dialog" aria-labelledby="adblockerModalLabel" aria-hidden="true" style="display: none; background: rgba(0, 0, 0, 0.5);" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title" id="adblockerModalLabel"><b>AdBlocker Detected</b></div>
                    </div>
                    <div class="modal-body">
                        <div class="adblocker-warning">Please disable AdBlocker to view content.</div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif ?>
        <script <?= Html::nonce() ?>>
            // Variable to track if AdSense script has been loaded
            var adsenseScriptLoaded = false;
            // Variable to track if adblocker check has been done
            var adblockerCheckDone = false;

            // Function to check if AdSense script is loaded and AdBlocker is enabled
            function checkAdBlocker() {
                if (!adblockerCheckDone && !adsenseScriptLoaded) {
                    console.log('AdBlocker enabled');
                    $('#adblockerModal').modal('show'); // Show modal if AdSense script is not loaded
                    adblockerCheckDone = true;
                } else if (!adblockerCheckDone && adsenseScriptLoaded) {
                    console.log('AdBlocker not enabled');
                    $('#adblockerModal').modal('hide'); // Hide modal if AdSense script is loaded
                    adblockerCheckDone = true;
                    // Push AdSense ads if AdBlocker is not enabled
                    (adsbygoogle = window.adsbygoogle || []).push({});
                }
            }

            // Check if AdSense script is loaded
            window.addEventListener('load', function() {
                if (typeof adsbygoogle === 'undefined') {
                    adsenseScriptLoaded = false;
                } else {
                    adsenseScriptLoaded = true;
                }
                checkAdBlocker(); // Check initially
            });

        </script>
        <?= Html::endTag('div') ?>
    </div>
</div>
