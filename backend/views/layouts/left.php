<aside class="main-sidebar">
    <section class="sidebar">
        <?php

        $userStatuses = \common\models\Status::getStatusesArray(\common\models\UseStatus::USE_PROFILE);
        $menuItems = [['label' => 'Все', 'icon' => 'id-card', 'url' => ['/card/user-card'], 'active' => \Yii::$app->controller->id == 'user-card',]];
        foreach ($userStatuses as $key => $status) {
            $menuItems[] = ['label' => $status, 'icon' => 'id-card', 'url' => ['/card/user-card?UserCardSearch[status]=' . $key], 'active' => \Yii::$app->controller->id == 'user-card',];
        }

        $busynessArr = \common\models\UserCard::getBusyness();
        foreach ($busynessArr as $key => $busyness) {
            $menuItems[] = ['label' => $busyness, 'icon' => 'id-card', 'url' => ['/card/user-card?UserCardSearch[at_project]=' . $key], 'active' => \Yii::$app->controller->id == 'user-card'];
        }
        $projectStatuses = \common\models\Status::getStatusesArray(\common\models\UseStatus::USE_PROJECT);
        $projectItems = [['label' => 'Все', 'icon' => 'cubes', 'url' => ['/project/project'], 'active' => \Yii::$app->controller->id == 'project']];
        foreach ($projectStatuses as $key => $status) {
            $projectItems[] = ['label' => $status, 'icon' => 'user', 'url' => ['/project/project?ProjectSearch[status]=' . $key, 'active' => \Yii::$app->controller->id == 'project']];
        }
        $projectItems[] = ['label' => 'Сотрудники на проектах', 'icon' => 'users', 'url' => ['/project/project-user'], 'active' => \Yii::$app->controller->id == 'project-user'];
        $projectItems[] = ['label' => 'метки проектов', 'icon' => 'tags', 'url' => ['/project/project-mark'], 'active' => \Yii::$app->controller->id == 'project-mark'];
        ?>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => [
                    [
                        'label' => 'Настройки', 'icon' => 'gears', 'url' => '#',
                        'items' => [
                            ['label' => 'Статусы', 'icon' => 'anchor', 'url' => ['/settings/status'], 'active' => \Yii::$app->controller->id == 'status', 'visible' => Yii::$app->user->can('settings')],
                            ['label' => 'Доп. поля', 'icon' => 'file-text-o', 'url' => ['/settings/additional-fields'], 'active' => \Yii::$app->controller->id == 'additional-fields', 'visible' => Yii::$app->user->can('settings')],
                            ['label' => 'Должность', 'icon' => 'spotify', 'url' => ['/settings/position'], 'active' => \Yii::$app->controller->id == 'position', 'visible' => Yii::$app->user->can('settings')],
                            ['label' => 'Навыки', 'icon' => 'flask', 'url' => ['/settings/skill'], 'active' => \Yii::$app->controller->id == 'skill', 'visible' => Yii::$app->user->can('settings/skill')],
                            ['label' => 'Метки', 'icon' => 'tag', 'url' => ['/settings/mark'], 'active' => \Yii::$app->controller->id == 'mark', 'visible' => Yii::$app->user->can('settings/mark')],
                            ['label' => 'Шаблоны резюме', 'icon' => 'address-card ', 'url' => ['/card/resume-template'], 'active' => \Yii::$app->controller->id == 'resume-template', 'visible' => Yii::$app->user->can('card')],
                            ['label' => 'Шаблоны документов', 'icon' => 'file', 'url' => ['/document/document-template'], 'active' => \Yii::$app->controller->id == 'document-template', 'visible' => Yii::$app->user->can('document')],
                            ['label' => 'Поля документов', 'icon' => 'file-text', 'url' => ['/document/document-field'], 'active' => \Yii::$app->controller->id == 'document-field', 'visible' => Yii::$app->user->can('document')],
                            ['label' => 'Уровень знаний', 'icon' => 'code', 'url' => ['/knowledgelevel/knowledge-level'], 'active' => \Yii::$app->controller->id == 'knowledge-level', 'visible' => Yii::$app->user->can('knowledgelevel/knowledge-level')],
                            [
                                'label' => 'Роли', 'icon' => 'users', 'url' => '#',
                                'items' => [
                                    ['label' => 'Управление ролями', 'icon' => ' fa-sort-amount-asc', 'url' => ['/permit/access/role'], 'active' => \Yii::$app->controller->id == 'access'],
                                    ['label' => 'Правила доступа', 'icon' => 'list-alt', 'url' => ['/permit/access/permission'], 'active' => \Yii::$app->controller->id == 'access'],
                                ],
                                'visible' => Yii::$app->user->can('confidential_information')
                            ]
                        ],
                    ],
                    [
                        'label' => 'Профили', 'icon' => 'address-book-o', 'url' => '#',
                        'items' => $menuItems,
                        'visible' => Yii::$app->user->can('card')
                    ],
                    [
                        'label' => 'Сотрудники', 'icon' => 'users', 'url' => '#',
                        'items' => [
                            ['label' => 'Менеджеры', 'icon' => 'user-circle-o', 'url' => ['/employee/manager'], 'active' => \Yii::$app->controller->id == 'manager'],
                            ['label' => 'Работники', 'icon' => 'user', 'url' => ['/employee/manager-employee'], 'active' => \Yii::$app->controller->id == 'manager-employee'],
                        ],
                        'visible' => Yii::$app->user->can('employee')
                    ],
                    ['label' => 'Запросы', 'icon' => 'eye', 'url' => ['/request/request'], 'active' => \Yii::$app->controller->id == 'request', 'visible' => Yii::$app->user->can('request/request')],
                    ['label' => 'Документы', 'icon' => 'archive', 'url' => ['/document/document'], 'active' => \Yii::$app->controller->id == 'document', 'visible' => Yii::$app->user->can('document')],
                    [
                        'label' => 'Проекты', 'icon' => 'cubes', 'url' => ['#'],
                        'items' => $projectItems,
                        'visible' => Yii::$app->user->can('project')
                    ],
                    [
                        'label' => 'Задачи', 'icon' => 'tasks', 'url' => '#',
                        'items' => [
                            ['label' => 'Задачи', 'icon' => 'minus', 'url' => ['/task/task'], 'active' => \Yii::$app->controller->id == 'task'],
                            ['label' => 'Исполнители задачи', 'icon' => 'users', 'url' => ['/task/task-user'], 'active' => \Yii::$app->controller->id == 'task-user'],
                            ['label' => 'Категории задач', 'icon' => 'users', 'url' => ['/task/project-task-category'], 'active' => \Yii::$app->controller->id == 'project-task-category'],
                        ],
                        'visible' => Yii::$app->user->can('task')
                    ],
                    [
                        'label' => 'Компании', 'icon' => 'building', 'url' => '#',
                        'items' => [
                            ['label' => 'Компании', 'icon' => 'building-o', 'url' => ['/company/company'], 'active' => \Yii::$app->controller->id == 'company'],
                            ['label' => 'Менеджеры компаний', 'icon' => 'user-circle-o', 'url' => ['/company/company-manager'], 'active' => \Yii::$app->controller->id == 'company-manager'],
                        ],
                        'visible' => Yii::$app->user->can('company')
                    ],
                    [
                        'label' => 'Hh.ru', 'icon' => 'user-circle', 'url' => '#',
                        'items' => [
                            ['label' => 'Компании', 'icon' => 'building', 'url' => ['/hh/hh'], 'active' => \Yii::$app->controller->id == 'hh'],
                            ['label' => 'Вакансии', 'icon' => 'user-md', 'url' => ['/hh/hh-job'], 'active' => \Yii::$app->controller->id == 'hh-job'],
                        ],
                        'visible' => Yii::$app->user->can('hh')
                    ],
                    ['label' => 'Баланс', 'icon' => 'dollar', 'url' => ['/balance/balance'], 'active' => \Yii::$app->controller->id == 'balance', 'visible' => Yii::$app->user->can('balance')],
                    ['label' => 'Отпуска', 'icon' => 'plane', 'url' => ['/holiday/holiday'], 'active' => \Yii::$app->controller->id == 'holiday', 'visible' => Yii::$app->user->can('holiday')],
                    ['label' => 'Достижения', 'icon' => 'trophy', 'url' => ['/achievements/achievements'], 'active' => \Yii::$app->controller->id == 'achievements', 'visible' => Yii::$app->user->can('achievements')],
                    ['label' => 'Доступы', 'icon' => 'key', 'url' => ['/accesses/accesses'], 'active' => \Yii::$app->controller->id == 'accesses', 'visible' => Yii::$app->user->can('accesses')],
                    ['label' => 'Заметки', 'icon' => 'sticky-note', 'url' => ['/notes/notes'], 'active' => \Yii::$app->controller->id == 'notes', 'visible' => Yii::$app->user->can('notes')],
                    ['label' => 'Календарь ДР', 'icon' => 'calendar-check-o', 'url' => ['/calendar/calendar'], 'active' => \Yii::$app->controller->id == 'calendar', 'visible' => Yii::$app->user->can('calendar')],
                    ['label' => 'Отчеты', 'icon' => 'calendar', 'url' => ['/reports/reports'], 'active' => \Yii::$app->controller->id == 'reports', 'visible' => Yii::$app->user->can('reports')],
                    ['label' => 'Опции', 'icon' => 'list-alt', 'url' => ['/options/options'], 'active' => \Yii::$app->controller->id == 'options', 'visible' => Yii::$app->user->can('options')],
                    [
                        'label' => 'Запрос интервью (' . \common\models\InterviewRequest::getNewCount() . ')',
                        'icon' => 'list-alt',
                        'url' => ['/interview/interview'],
                        'active' => \Yii::$app->controller->id == 'interview',
                        'visible' => Yii::$app->user->can('interview'),
                        'badge' => '<span class="badge badge-info right">4</span>'
                    ],
                    [
                        'label' => 'Анкеты', 'icon' => 'book', 'url' => '#',
                        'items' => [
                            ['label' => 'Типы вопросов', 'icon' => 'pencil-square-o', 'url' => ['/questionnaire/question-type'], 'active' => \Yii::$app->controller->id == 'question-type'],
                            ['label' => 'Категории анкет', 'icon' => 'pencil-square', 'url' => ['/questionnaire/questionnaire-category'], 'active' => \Yii::$app->controller->id == 'questionnaire-category'],
                            ['label' => 'Список анкет', 'icon' => 'clipboard', 'url' => ['/questionnaire/questionnaire'], 'active' => \Yii::$app->controller->id == 'questionnaire'],
                            ['label' => 'Вопросы', 'icon' => 'question', 'url' => ['/questionnaire/question'], 'active' => \Yii::$app->controller->id == 'question'],
                            ['label' => 'Ответы', 'icon' => 'comment', 'url' => ['/questionnaire/answer'], 'active' => \Yii::$app->controller->id == 'answer'],
                            ['label' => 'Анкеты пользователей', 'icon' => 'drivers-license', 'url' => ['/questionnaire/user-questionnaire'], 'active' => \Yii::$app->controller->id == 'user-questionnaire'],
                            ['label' => 'Ответы пользователей', 'icon' => 'comments', 'url' => ['/questionnaire/user-response'], 'active' => \Yii::$app->controller->id == 'user-response'],
                        ],
                        'visible' => Yii::$app->user->can('questionnaire')
                    ],
                    ['label' => 'Тестовые задания', 'icon' => 'file-text-o', 'url' => ['/test/test-task'], 'active' => \Yii::$app->controller->id == 'options', 'visible' => Yii::$app->user->can('test')],


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