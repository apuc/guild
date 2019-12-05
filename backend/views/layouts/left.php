<aside class="main-sidebar">
    <section class="sidebar">
        <?php

        $userStatuses = \common\models\Status::getStatusesArray(\common\models\UseStatus::USE_PROFILE);
        $menuItems = [['label' => 'Все', 'icon' => 'user', 'url' => ['/card/user-card']]];
        foreach ($userStatuses as $key => $status) {
            $menuItems[] = ['label' => $status, 'icon' => 'user', 'url' => ['/card/user-card?UserCardSearch[status]=' . $key]];
        }
        $projectStatuses = \common\models\Status::getStatusesArray(\common\models\UseStatus::USE_PROJECT);
        $projectItems = [['label' => 'Все', 'icon' => 'files-o', 'url' => ['/project/project']]];
        foreach ($projectStatuses as $key => $status) {
            $projectItems[] = ['label' => $status, 'icon' => 'user', 'url' => ['/project/project?ProjectSearch[status]=' . $key]];
        }
        ?>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => [
                    [
                        'label' => 'Настройки', 'icon' => 'gears', 'url' => '#',
                        'items' => [
                            ['label' => 'Статусы', 'icon' => 'anchor', 'url' => ['/settings/status'], 'active' => \Yii::$app->controller->id == 'status'],
                            ['label' => 'Доп. поля', 'icon' => 'file-text-o', 'url' => ['/settings/additional-fields'], 'active' => \Yii::$app->controller->id == 'additional-fields'],
                            ['label' => 'Должность', 'icon' => 'spotify', 'url' => ['/settings/position'], 'active' => \Yii::$app->controller->id == 'position'],
                            ['label' => 'Навыки', 'icon' => 'flask', 'url' => ['/settings/skill'], 'active' => \Yii::$app->controller->id == 'skill'],
                        ]
                    ],
                    [
                        'label' => 'Профили', 'icon' => 'users', 'url' => '#', 'active' => \Yii::$app->controller->id == 'user-card',
                        'items' => $menuItems,
                    ],
                    [
                        'label' => 'Проекты', 'icon' => 'files-o', 'url' => ['#'], 'active' => \Yii::$app->controller->id == 'project',
                        'items' => $projectItems,
                    ],
                    ['label' => 'Компании', 'icon' => 'files-o', 'url' => ['/company/company']],
                    [
                        'label' => 'Hh.ru', 'icon' => 'user-circle', 'url' => '#',
                        'items' => [
                            ['label' => 'Компании', 'icon' => 'building', 'url' => ['/hh/hh'], 'active' => \Yii::$app->controller->id == 'hh'],
                            ['label' => 'Вакансии', 'icon' => 'user-md', 'url' => ['/hh/hh-job'],  'active' => \Yii::$app->controller->id == 'hh-job'],
                        ],
                    ],
                    ['label' => 'Баланс', 'icon' => 'dollar', 'url' => ['/balance/balance'], 'active' => \Yii::$app->controller->id == 'balance'],
                    ['label' => 'Отпуска', 'icon' => 'plane', 'url' => ['/holiday/holiday'], 'active' => \Yii::$app->controller->id == 'holiday'],
                    ['label' => 'Доступы', 'icon' => '', 'url' => ['/accesses/accesses'], 'active' => \Yii::$app->controller->id == 'accesses'],
                    ['label' => 'Заметки', 'icon' => '', 'url' => ['/notes/notes'], 'active' => \Yii::$app->controller->id == 'notes'],

                    /*['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Some tools',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],*/
                ],
            ]
        ) ?>

    </section>

</aside>