<?php

use yii\helpers\Url;
use humhub\libs\Html;
use humhub\widgets\PanelMenu;
use humhub\modules\ui\view\components\View;

/* @var $client string */
/* @var $slot string */
/* @var $this View */

$this->registerJsFile('https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js', ['data-ad-client' => Yii::$app->getModule('adsense')->getClient(), 'async' => 'async', 'position' => View::POS_HEAD]);
?>
<div class="panel panel-adsense panel-default" id="panel-adsense">

    <?= PanelMenu::widget(['id' => 'panel-adsense']); ?>
    <div class="panel-heading">
        <?= Yii::t('AdsenseModule.base', '<strong>Community</strong> Ad'); ?>
    </div>

    <div class="panel-body">
        <?= Html::beginTag('div') ?>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <ins class="adsbygoogle"
            style="display:block"
            data-ad-client="<?= $client; ?>"
            data-ad-slot="<?= $slot; ?>"
            data-ad-format="auto"
            data-ad-layout-key="-gu-3+1f-3d+2z"
            data-full-width-responsive="true"></ins>
        <script <?= Html::nonce() ?>>
        $(document).ready(function(){
            var $analyticsOff = $('.adsbygoogle:hidden');
            var $analyticsOn = $('.adsbygoogle:visible');

            $analyticsOff.each(function() {
                $(this).remove();

            });
            $analyticsOn.each(function() {
                (adsbygoogle = window.adsbygoogle || []).push({});

            });

        });
        </script>
        <?= Html::endTag('div') ?>
    </div>
</div>
