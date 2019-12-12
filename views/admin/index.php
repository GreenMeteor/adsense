<?php

use humhub\compat\CHtml;
use humhub\models\Setting;
use humhub\compat\CActiveForm;
use humhub\modules\adsense\controllers\AdminController;
?>
<div class="panel panel-default">
	<div class="panel-heading"><?=Yii::t('AdsenseModule.base', '<strong>AdSense</strong>'); ?></div>
	<div class="panel-body">
		<?php $form = CActiveForm::begin(['id' => 'adsense-settings-form']); ?>
			<?=$form->errorSummary($model); ?>
			<div class="form-group">
				<?=$form->labelEx($model, 'client'); ?>
				<?=$form->textField($model, 'client', ['class' => 'form-control', 'readonly' => Setting::IsFixed('client', 'adsense')]); ?>
			</div>
			<p class="help-block"><?=Yii::t('AdsenseModule.base', 'eg: "ca-pub-XXXXXXXXX"'); ?></p>
			<div class="form-group">
				<?=$form->labelEx($model, 'slot'); ?>
				<?=$form->textField($model, 'slot', ['class' => 'form-control', 'readonly' => Setting::IsFixed('slot', 'adsense')]); ?>
			</div>
			<?= CHtml::submitButton(Yii::t('AdsenseModule.base', 'save'), ['class' => 'btn btn-primary']); ?>
			<?=\humhub\widgets\DataSaved::widget(); ?>
		<?php CActiveForm::end(); ?>
	</div>
</div>
