<?php

namespace humhub\modules\adsense\models\forms;

use Yii;

class SettingsForm extends \yii\base\Model
{

    public $client;

    public $slot;

    public function rules()
    {
        return [
            [['client','slot', 'sort'], 'safe'],
            [['client', 'slot','sort'], 'required'],
            [['client'], 'string', 'max' => 255],
            [['slot'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'client' => Yii::t('AdsenseModule.base', 'client'),
            'slot' => Yii::t('AdsenseModule.base', 'slot'),
        ];
    }
}
