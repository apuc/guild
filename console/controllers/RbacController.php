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
}