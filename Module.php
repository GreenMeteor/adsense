<?php

namespace humhub\modules\adsense;

use Yii;
use yii\helpers\Url;
use humhub\components\Module as BaseModule;

class Module extends BaseModule
{
    /**
     * @inheritdoc
     */
    public $resourcesPath = 'resources';

    /**
     * @inheritdoc
     */
    public function getConfigUrl()
    {
        return Url::to(['/adsense/admin']);
    }

    public function getClient()
    {
        $client = $this->settings->get('client');
        if (empty($client)) {
            return 'ca-pub-';
        }

        return $client;
    }

    public function getSlot()
    {
        $slot = $this->settings->get('slot');
        if (empty($slot)) {
            return '';
        }

        return $slot;
    }

    public function getMessage()
    {
        return Yii::t('AdsenseModule.base', 'Please set your ad client and ad slot ids in <a href="/adsense/admin">admin</a>');
    }
}
