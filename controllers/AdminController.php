<?php

namespace humhub\modules\adsense\controllers;

use Yii;
use yii\helpers\Url;
use humhub\models\Setting;
use humhub\components\behaviors\AccessControl;
use humhub\modules\admin\components\Controller;
use humhub\modules\adsense\models\forms\SettingsForm;

class AdminController extends Controller
{

    public function behaviors()
    {
        return [
            'acl' => [
                'class' => AccessControl::class,
                'adminOnly' => true
            ]
        ];
    }

    public function actionIndex()
    {
        $form = new SettingsForm();
        if ($form->load(Yii::$app->request->post())) {
            if ($form->validate()) {
                Setting::Set('client', $form->client, 'adsense');
                Setting::Set('slot', $form->slot, 'adsense');

                Yii::$app->session->setFlash('data-saved', Yii::t('AdsenseModule.base', 'Saved'));
                // $this->redirect(Url::toRoute('index'));
            }
        } else {
            $form->client = Setting::Get('client', 'adsense');
            $form->slot = Setting::Get('slot', 'adsense');
        }

        return $this->render('index', [
            'model' => $form
        ]);
    }

}
