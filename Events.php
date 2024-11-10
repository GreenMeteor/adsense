<?php

namespace humhub\modules\adsense;

use Yii;
use yii\helpers\Url;
use humhub\modules\ui\menu\MenuLink;
use humhub\modules\ui\icon\widgets\Icon;
use humhub\modules\admin\widgets\AdminMenu;
use humhub\modules\user\helpers\AuthHelper;
use humhub\modules\admin\permissions\ManageModules;

class Events
{

    public static function onAdminMenuInit($event)
    {
        if (!Yii::$app->user->can(ManageModules::class)) {
            return;
        }

        /** @var AdminMenu $menu */
        $menu = $event->sender;

        $menu->addEntry(new MenuLink([
            'label' => Yii::t('AdsenseModule.base', 'AdSense Settings'),
            'url' => Url::toRoute('/adsense/admin/index'),
            'icon' => Icon::get('google'),
            'isActive' => Yii::$app->controller->module && Yii::$app->controller->module->id == 'adsense' && Yii::$app->controller->id == 'admin',
            'sortOrder' => 650,
            'isVisible' => true,
        ]));
    }

    public static function addAdFrame($event)
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity && AuthHelper::isGuestAccessEnabled())
        {
            $event->sender->addWidget(widgets\AdFrame::class, [], ['sortOrder' => Yii::$app->getModule('adsense')->settings->get('sort')]);

        }
    }
}
