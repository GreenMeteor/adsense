<?php

use yii\helpers\Html;
use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\modules\ui\form\widgets\SortOrderField;

?>

<div class="panel panel-default">
    <div class="panel-heading"><?= \Yii::t('AdsenseModule.base', '<strong>AdSense</strong> module configuration') ?></div>

    <div class="panel-body">
        <?php $form = ActiveForm::begin(['id' => 'adsense-settings-form']); ?>
        <div class="form-group">
            <?= $form->field($model, 'client')->hint('ca-pub-xxxxxxxxxxxxxxxx')->label('Client'); ?>
            <?= $form->field($model, 'slot')->hint('xxxxxxxxxx')->label('Slot'); ?>
            <?= $form->field($model, 'sort')->widget(SortOrderField::class) ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(\Yii::t('AdsenseModule.base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']); ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading"><?= \Yii::t('AdsenseModule.base', 'Manage <strong>Ads.txt</strong> File') ?></div>

    <div class="panel-body">
        <?php $form = ActiveForm::begin(['id' => 'ads-txt-form', 'method' => 'post']); ?>

        <!-- Textarea for Ads.txt content -->
        <?= $form->field($model, 'adsTxtContent')->textarea(['rows' => 5, 'placeholder' => 'Enter or edit your Ads.txt content here...'])->label('Ads.txt Content') ?>

        <div class="form-group">
            <?= Html::submitButton(\Yii::t('AdsenseModule.base', 'Create Ads.txt'), ['class' => 'btn btn-success', 'name' => 'create_ads_txt']) ?>
            <?= Html::submitButton(\Yii::t('AdsenseModule.base', 'Overwrite Ads.txt'), ['class' => 'btn btn-warning', 'name' => 'overwrite_ads_txt']) ?>
            <?= Html::submitButton(\Yii::t('AdsenseModule.base', 'Append to Ads.txt'), ['class' => 'btn btn-info', 'name' => 'append_ads_txt']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
