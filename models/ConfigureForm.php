<?php

namespace humhub\modules\adsense\models;

use Yii;
use yii\base\Model;

class ConfigureForm extends Model
{

    public $client;

    public $slot;

    public $sort;

    public function rules()
    {
        return [
            [['client','slot', 'sort'], 'safe'],
            [['client'], 'string', 'max' => 255],
            [['slot'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'client' => Yii::t('AdsenseModule.base', 'Client'),
            'slot' => Yii::t('AdsenseModule.base', 'Slot'),
            'sort' => Yii::t('AdsenseModule.base', 'Sort Order'),
        ];
    }

    public function loadSettings()
    {
        $module =  Yii::$app->getModule('adsense');

        $this->client = $module->settings->get('client');

        $this->slot = $module->settings->get('slot');

        $this->sort = $module->settings->get('sort');

        return true;
    }

    public function save()
    {
        $module = Yii::$app->getModule('adsense');
        
        $module->settings->set('client', $this->client);

        $module->settings->set('slot', $this->slot);

        $module->settings->set('sort', $this->sort);

        return true;
    }
}
