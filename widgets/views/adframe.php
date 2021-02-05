<?php

use yii\helpers\Url;
use humhub\libs\Html;
use humhub\models\Setting;
use humhub\widgets\PanelMenu;
use humhub\modules\ui\view\components\View;

/* @var $client string */
/* @var $slot string */
/* @var $this View */

$module = Yii::$app->getModule('adsense');

$this->registerJsFile('https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js', ['data-ad-client' => Yii::$app->getModule('adsense')->getClient(), 'async' => 'async', 'src' => 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js', 'position' => View::POS_HEAD]);
?>
<div class="panel panel-adsense panel-default" id="panel-adsense">

    <?= PanelMenu::widget(['id' => 'panel-adsense']); ?>
    <div class="panel-heading">
        <?= Yii::t('AdsenseModule.base', '<strong>Community</strong> Ad'); ?>
    </div>

    <div class="panel-body">
        <?= Html::beginTag('div') ?>
        <?php if (!empty($module->getClient() === '')): ?>
        <p><?= $module->getMessage() ?></p>
        <?php else: ?>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <ins class="adsbygoogle"
            style="display:block;"
            data-ad-client="$client"
            data-ad-slot="$slot"
            data-ad-format="auto"
            data-full-width-responsive="true"></ins>
        <script <?= Html::nonce() ?>>
        $(document).ready(function(){
            var $analyticsOn = $('.adsbygoogle:visible');

            $analyticsOn.each(function() {
                (adsbygoogle = window.adsbygoogle || []).push({});

            });

        });
        </script>
        <?php endif ?>
        <?= Html::endTag('div') ?>
    </div>
</div>
