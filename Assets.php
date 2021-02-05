<?php

namespace humhub\modules\adsense;

use Yii;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class Assets extends AssetBundle
{
    public $sourcePath = '@adsense/assets';

    public $depends = [
        JqueryAsset::class
    ];
}
