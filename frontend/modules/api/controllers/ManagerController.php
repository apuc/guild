<?php

namespace frontend\modules\api\controllers;

use common\models\Manager;
use common\models\ManagerEmployee;
use common\models\User;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class ManagerController extends \yii\rest\Controller
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator']['authMethods'] = [
            HttpBearerAuth::className(),
        ];

        return $behaviors;
    }

    public function verbs(): array
    {
        return [
            'get-manager' => ['get'],
            'get-employees-manager' => ['get'],
            'get-manager-list' => ['get'],
        ];
    }

    public function actionGetManagerList(): array
    {
        $managers = User::find()->select(['username','manager.id' , 'email'])
            ->joinWith('manager')->where(['NOT',['manager.user_id' => null]])->all();

        if(empty($managers)) {
            throw new NotFoundHttpException('Managers are not assigned');
        }

        return $managers;
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionGetEmployeesManager()
    {
        $manager_id = Yii::$app->request->get('manager_id');
        if(empty($manager_id) or !is_numeric($manager_id))
        {
            throw new NotFoundHttpException('Incorrect manager ID');
        }

        $users_list = User::find()->select(['user.id', 'user.username', 'user.email'])
            ->joinWith('managerEmployee')
            ->where(['manager_employee.manager_id' => $manager_id])
            ->all();

        if(empty($users_list)) {
            throw new NotFoundHttpException('Managers are not assigned or employees are not assigned to him');
        }

        return $users_list;
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionGetManager(): array
    {
        $manager_id = Yii::$app->request->get('manager_id');
        if(empty($manager_id) or !is_numeric($manager_id))
        {
            throw new NotFoundHttpException('Incorrect manager ID');
        }

        $manager = User::find()
            ->select(['user.id', 'user.username', 'user.email'])
            ->joinWith('manager')->where(['manager.id' => $manager_id])
            ->all();


        if(empty($manager)) {
            throw new NotFoundHttpException('There is no such manager');
        }

        return $manager;
    }
}