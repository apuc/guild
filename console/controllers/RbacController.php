<?php


namespace console\controllers;


use common\models\User;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $secure = $auth->createPermission('secure');
        $secure->description = 'Admin panel';
        $auth->add($secure);

        $front = $auth->createPermission('front');
        $front->description = 'Frontend';
        $auth->add($front);

        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $front);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $secure);
        $auth->addChild($admin, $user);

        $auth->assign($user, 2);
        $auth->assign($admin, 1);
    }

    /**
     * Add company manager role
     */
    public function actionCreateCompanyManagerRole()
    {
        $auth = Yii::$app->getAuthManager();

        $role = $auth->createRole('company_manager');
        $role->description = 'Менеджер компании контр агента';
        $auth->add($role);

        $this->stdout('Done!' . PHP_EOL);
    }

    public function actionCreateEditor()
    {
        $auth = Yii::$app->authManager;

        $confidentialInformation = $auth->createPermission('confidential_information');
        $confidentialInformation->description = 'Возможность видеть конфиденциальную информацию';
        $auth->add($confidentialInformation);

        $secure = $auth->getPermission('secure');

        $profileEditor = $auth->createRole('profileEditor');
        $auth->add($profileEditor);
        $auth->addChild($profileEditor, $secure);

        $admin = $auth->getRole('admin');
        $auth->addChild($admin, $confidentialInformation);
        $auth->addChild($admin, $profileEditor);

        $profileEditorUser = $this->createEditor();
        $auth->assign($profileEditor, $profileEditorUser->id);

    }

    private function createEditor()
    {
        if (!($user = User::findByUsername('profile_editor'))) {
            $user = new User();
            $user->username = 'profile_editor';
            $user->email = 'profile_editor@itguild.info';
            $user->setPassword('0023edsaqw');
            $user->generateAuthKey();
            $user->save(false);
        }

        return $user;
    }

    public function actionCreateDefaultAccessRules()
    {
        $auth = Yii::$app->authManager;
        $admin = $auth->getRole('admin');
        $profileEditor = $auth->getRole('profileEditor');

        if(!$auth->getPermission('test')) {
            $test = $auth->createPermission('test');
            $test->description = 'Модуль "Тестовые задания"';
            $auth->add($test);
            $auth->addChild($admin, $test);
        }

        if(!$auth->getPermission('questionnaire')) {
            $questionnaire = $auth->createPermission('questionnaire');
            $questionnaire->description = 'Модуль "Анкеты": Создание, редактирование анкет, категорий анкет, вопросов, проверка ответов пользователей';
            $auth->add($questionnaire);
            $auth->addChild($admin, $questionnaire);
        }

        if(!$auth->getPermission('interview')) {
            $interview = $auth->createPermission('interview');
            $interview->description = 'Модуль "Запрос интервью"';
            $auth->add($interview);
            $auth->addChild($admin, $interview);
        }

        if(!$auth->getPermission('options')) {
            $options = $auth->createPermission('options');
            $options->description = 'Модуль "Опции"';
            $auth->add($options);
            $auth->addChild($admin, $options);
        }

        if(!$auth->getPermission('reports')) {
            $reports = $auth->createPermission('reports');
            $reports->description = 'Модуль "Отчёты"';
            $auth->add($reports);
            $auth->addChild($admin, $reports);
        }
        if(!$auth->getPermission('calendar')) {
            $calendar = $auth->createPermission('calendar');
            $calendar->description = 'Модуль "Календарь ДР"';
            $auth->add($calendar);
            $auth->addChild($admin, $calendar);
        }

        if(!$auth->getPermission('notes')) {
            $notes = $auth->createPermission('notes');
            $notes->description = 'Модуль "Заметки"';
            $auth->add($notes);
            $auth->addChild($admin, $notes);
        }

        if(!$auth->getPermission('accesses')) {
            $accesses = $auth->createPermission('accesses');
            $accesses->description = 'Модуль "Доступы"';
            $auth->add($accesses);
            $auth->addChild($admin, $accesses);
        }

        if(!$auth->getPermission('achievements')) {
            $achievements = $auth->createPermission('achievements');
            $achievements->description = 'Модуль "Достижения"';
            $auth->add($achievements);
            $auth->addChild($admin, $achievements);
        }

        if(!$auth->getPermission('holiday')) {
            $holiday = $auth->createPermission('holiday');
            $holiday->description = 'Модуль "Отпуска"';
            $auth->add($holiday);
            $auth->addChild($admin, $holiday);
        }
        if(!$auth->getPermission('balance')) {
            $balance = $auth->createPermission('balance');
            $balance->description = 'Модуль "Баланс"';
            $auth->add($balance);
            $auth->addChild($admin, $balance);
        }

        if(!$auth->getPermission('hh')) {
            $hh = $auth->createPermission('hh');
            $hh->description = 'Модуль "Hh.ru"';
            $auth->add($hh);
            $auth->addChild($admin, $hh);
        }

        if(!$auth->getPermission('company')) {
            $company = $auth->createPermission('company');
            $company->description = 'Модуль "Компании"';
            $auth->add($company);
            $auth->addChild($admin, $company);
        }

        if(!$auth->getPermission('task')) {
            $task = $auth->createPermission('task');
            $task->description = 'Модуль "Задачи"';
            $auth->add($task);
            $auth->addChild($admin, $task);
        }

        if(!$auth->getPermission('project')) {
            $project = $auth->createPermission('project');
            $project->description = 'Модуль "Проекты"';
            $auth->add($project);
            $auth->addChild($admin, $project);
        }

        if(!$auth->getPermission('document')) {
            $documents = $auth->createPermission('document');
            $documents->description = 'Модуль "Документы": Создание, редактирование документов, их полей и шаблонов';
            $auth->add($documents);
            $auth->addChild($admin, $documents);
        }

        if(!$auth->getPermission('employee')) {
            $employee = $auth->createPermission('employee');
            $employee->description = 'Модуль "Сотрудники"';
            $auth->add($employee);
            $auth->addChild($admin, $employee);
        }

        if(!$auth->getPermission('card')) {
            $card = $auth->createPermission('card');
            $card->description = 'Модуль "Профили"';
            $auth->add($card);
            $auth->addChild($admin, $card);
            $auth->addChild($profileEditor, $card);
        }

        if(!$auth->getPermission('settings')) {
            $settings = $auth->createPermission('settings');
            $settings->description = 'Модуль "Настройки"';
            $auth->add($settings);
            $auth->addChild($admin, $settings);
        }

        if(!$auth->getPermission('settings/skill')) {
            $skills = $auth->createPermission('settings/skill');
            $skills->description = 'Навыки';
            $auth->add($skills);
            $auth->addChild($admin, $skills);
            $auth->addChild($profileEditor, $skills);
        }

        if(!$auth->getPermission('settings/mark')) {
            $mark = $auth->createPermission('settings/mark');
            $mark->description = 'Метки';
            $auth->add($mark);
            $auth->addChild($admin, $mark);
        }

        var_dump($auth->getPermission('settings/mark'));

    }
}