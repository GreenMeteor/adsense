<?php

namespace humhub\modules\adsense\controllers;

use Yii;
use humhub\models\Setting;
use yii\helpers\Url;
use humhub\modules\admin\components\Controller;
use humhub\components\behaviors\AccessControl;
use humhub\modules\adsense\forms\SettingsForm;

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
                Setting::Set('sort', $form->sort, 'adsense');

                Yii::$app->session->setFlash('data-saved', Yii::t('AdsenseModule.base', 'Saved'));
                // $this->redirect(Url::toRoute('index'));
            }
        } else {
            $form->client = Setting::Get('client', 'adsense');
            $form->slot = Setting::Get('slot', 'adsense');
            $form->sort = Setting::Get('sort', 'adsense');
        }

        return $this->render('index', [
            'model' => $form
        ]);
    }

}
