<?php

namespace humhub\modules\adsense;

return [
    'id' => 'adsense',
    'class' => 'humhub\modules\adsense\Module',
    'namespace' => 'humhub\modules\adsense',
    'events' => [
        [
            'class' => \humhub\modules\dashboard\widgets\Sidebar::class,
            'event' => \humhub\modules\dashboard\widgets\Sidebar::EVENT_INIT,
            'callback' => [
                'humhub\modules\adsense\Events',
                'addAdFrame'
            ]
        ],
        [
            'class' => \humhub\modules\directory\widgets\Sidebar::class,
            'event' => \humhub\modules\directory\widgets\Sidebar::EVENT_INIT,
            'callback' => [
                'humhub\modules\adsense\Events',
                'addAdFrame'
            ]
        ],
        [
            'class' => \humhub\modules\space\widgets\Sidebar::class,
            'event' => \humhub\modules\space\widgets\Sidebar::EVENT_INIT,
            'callback' => [
                'humhub\modules\adsense\Events',
                'addAdFrame'
            ]
        ],
        [
            'class' => \humhub\modules\user\widgets\ProfileSidebar::class,
            'event' => \humhub\modules\user\widgets\ProfileSidebar::EVENT_INIT,
            'callback' => [
                'humhub\modules\adsense\Events',
                'addAdFrame'
            ]
        ],
        [
            'class' => \humhub\modules\admin\widgets\AdminMenu::class,
            'event' => \humhub\modules\admin\widgets\AdminMenu::EVENT_INIT,
            'callback' => [
                'humhub\modules\adsense\Events',
                'onAdminMenuInit'
            ]
        ]
    ]
];
?>
