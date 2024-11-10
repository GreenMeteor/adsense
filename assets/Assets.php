<?php

namespace humhub\modules\adsense\assets;

use yii\web\AssetBundle;

class Assets extends AssetBundle
{
    public $sourcePath = '@adsense/resources';
    public $js = [
        'js/adsense.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
