<?php

namespace humhub\modules\adsense;

use humhub\modules\adsense\Events;
use humhub\modules\adsense\Module;
use humhub\modules\admin\widgets\AdminMenu;
use humhub\modules\directory\widgets\Sidebar;
use humhub\modules\user\widgets\ProfileSidebar;
use humhub\modules\space\widgets\Sidebar as Spacebar;
use humhub\modules\dashboard\widgets\Sidebar as Dashbar;

return [
    'id' => 'adsense',
    'class' => Module::class,
    'namespace' => 'humhub\modules\adsense',
    'events' => [
        ['class' => Dashbar::class, 'event' => Dashbar::EVENT_INIT, 'callback' => [Events::class, 'addAdFrame']],
        ['class' => Sidebar::class, 'event' => Sidebar::EVENT_INIT, 'callback' => [Events::class, 'addAdFrame']],
        ['class' => Spacebar::class, 'event' => Spacebar::EVENT_INIT, 'callback' => [Events::class, 'addAdFrame']],
        ['class' => ProfileSidebar::class, 'event' => ProfileSidebar::EVENT_INIT, 'callback' => [Events::class, 'addAdFrame']],
        ['class' => AdminMenu::class, 'event' => AdminMenu::EVENT_INIT, 'callback' => [Events::class, 'onAdminMenuInit']]
    ]
];
?>
