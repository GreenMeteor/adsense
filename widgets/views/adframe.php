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
$this->registerJsFile($urlJs, ['data-ad-client' => Yii::$app->getModule('adsense')->getClient(), 'src' => 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=' . Yii::$app->getModule('adsense')->getClient() . 'crossorigin="anonymous"', 'position' => View::POS_END]);
?>
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
        <ins class="adsbygoogle"
            style="display:block;"
            data-ad-client="<?= $client; ?>"
            data-ad-slot="<?= $slot; ?>"
            data-ad-format="auto"></ins>
        <script <?= Html::nonce() ?>>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        <?php endif ?>
        <?= Html::endTag('div') ?>
    </div>
</div>
