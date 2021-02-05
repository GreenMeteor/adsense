<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use humhub\modules\ui\form\widgets\SortOrderField;

?>

<div class="panel panel-default">

    <div class="panel-heading"><?= \Yii::t('AdsenseModule.base', '<strong>AdSense</strong> module configuration') ?></div>

    <div class="panel-body">

        <?php $form = ActiveForm::begin(['id' => 'adsense-settings-form']); ?>
        <div class="form-group">
            <?= $form->field($model, 'client'); ?>
            <?= $form->field($model, 'slot'); ?>
            <?= $form->field($model, 'sort')->widget(SortOrderField::class) ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(\Yii::t('AdsenseModule.base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']); ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
