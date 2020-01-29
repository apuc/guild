<?php


namespace console\controllers;


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
}