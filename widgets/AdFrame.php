<?php

namespace humhub\modules\adsense\widgets;

use Yii;
use humhub\components\Widget;

class AdFrame extends Widget
{

    public $contentContainer;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $client = Yii::$app->getModule('adsense')->getClient() . '';

        $slot = Yii::$app->getModule('adsense')->getSlot();

        return $this->render('adframe', ['client' => $client, 'slot' => $slot]);
    }
}
