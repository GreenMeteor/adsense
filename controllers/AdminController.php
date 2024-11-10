<?php

namespace humhub\modules\adsense\controllers;

use Yii;
use humhub\modules\admin\components\Controller;
use humhub\modules\adsense\models\ConfigureForm;

/**
 * AdminController handles the configuration of the Adsense module.
 */
class AdminController extends Controller
{
    /**
     * Displays the Adsense settings and handles form submissions.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new ConfigureForm();
        $model->loadSettings();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                $this->view->saved();
            }
        }

        if (Yii::$app->request->post('create_ads_txt')) {
            $adsContent = Yii::$app->request->post('adsTxtContent');
            $model->createAdsTxt($adsContent);
            $this->view->success(Yii::t('AdsenseModule.base', 'Ads.txt file created successfully.'));
        }

        if (Yii::$app->request->post('overwrite_ads_txt')) {
            $adsContent = Yii::$app->request->post('adsTxtContent');
            $model->overwriteAdsTxt($adsContent);
            $this->view->success(Yii::t('AdsenseModule.base', 'Ads.txt file updated successfully.'));
        }

        if (Yii::$app->request->post('append_ads_txt')) {
            $adsContent = Yii::$app->request->post('adsTxtContent');
            $model->appendToAdsTxt($adsContent);
            $this->view->success(Yii::t('AdsenseModule.base', 'Content appended to Ads.txt.'));
        }

        return $this->render('index', ['model' => $model]);
    }
}
